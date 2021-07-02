<?php

namespace App\Actions\Scan\ResultsEvaluation;

use App\Collections\ReportablePortsCollection;
use App\Data\Events\MonitoringEventData;
use App\Enums\EventOriginator;
use App\Events\Monitoring\Problem;
use App\Events\Monitoring\Recovery;
use App\Models\Node;
use App\Models\Port;
use App\Models\ScanResult;
use App\Models\Target;
use App\Notifications\Scan\PortsAllOfflineNotification;
use App\Notifications\Scan\PortsPartiallyOfflineNotification;
use App\Notifications\Scan\PortsRecoveredNotification;
use App\Support\Mail\MarkdownTableBuilder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class EvaluateScanResultsAction
{
    private Target $target;

    private ?ReportablePortsCollection $reportablePorts = null;

    private bool $markAsReportable = false;

    public function __invoke(Collection $connects)
    {
        Target::query()
            // We only report on scans where the target is alive because the
            // user would have been notified of a "down" target. We don't
            // need to tell them about "down" ports too.
            ->alive()
            ->whereIn('connect', $connects)
            ->with('user', 'ports', 'ports.scanResults')
            ->lazyById()
            ->each(function (Target $target) {
                $this->init($target);

                DB::transaction(function () {
                    /** @noinspection PhpUndefinedMethodInspection */
                    $this->target->ports->each(function (Port $port) {
                        $this->evaluateResults($port);
                    });
                });

                if ($this->shouldSendNotification()) {
                    $this->send();
                }
            });
    }

    private function init(Target $target)
    {
        $this->target = $target;
        $this->markAsReportable = false;
        $this->reportablePorts = ReportablePortsCollection::make();
    }

    private function evaluateResults(Port $port)
    {
        $this->reportablePorts->addPort($port);

        switch (true) {
            case $port->scanResults->allOpen():
                $this->handleAllResultsOpen($port);
                break;
            case $port->scanResults->allClosed():
                $this->handleAllResultsClosed($port);
                break;
            case $port->isOpen():
            case $port->isClosed():
            case $port->isAwaitingResults():
                $this->handleNewPartial($port);
                break;
            default:
                $this->handleChangedPartial($port);
                break;
        }
    }

    private function handleAllResultsOpen(Port $port)
    {
        if ($port->isOpen()) {
            return;
        }

        if (! $port->isAwaitingResults()) {
            $this->markAsReportable = true;
            $port->last_recovery_at = now();
            $port->number_of_recoveries++;
        }

        $port->markAsOpen()->save();
    }

    private function handleAllResultsClosed(Port $port)
    {
        if ($port->isClosed()) {
            return;
        }

        $this->markAsReportable = true;
        $port->last_alert_at = now();
        $port->number_of_alerts++;

        $port->markAsClosed()->save();
    }

    private function handleNewPartial(Port $port)
    {
        $port->last_warning_at = now();
        $port->number_of_warnings++;

        $port
            ->markAsPartiallyClosed()
            ->withNodesDown($port->scanResults->onlyClosed()->pluck('node_id'))
            ->save();

        $this->markAsReportable = true;
    }

    private function handleChangedPartial(Port $port)
    {
        /** @var Collection $nodesPreviouslyClosed */
        $nodesPreviouslyClosed = $port->nodes_down;

        $newOpen = $port->scanResults->getNewOpen($nodesPreviouslyClosed);
        $newClosed = $port->scanResults->getNewClosed($nodesPreviouslyClosed);

        if ($newOpen->merge($newClosed)->isNotEmpty()) {
            $port->last_warning_at = now();
            $port->number_of_warnings++;

            $port
                ->markAsPartiallyClosed()
                ->withNodesDown($port->scanResults->onlyClosed()->pluck('node_id'))
                ->save();

            $this->markAsReportable = true;
        }
    }

    private function shouldSendNotification(): bool
    {
        return $this->markAsReportable && $this->reportablePorts->isNotEmpty();
    }

    private function send()
    {
        [$openPorts, $other] = $this->target->ports
            ->partition(fn(Port $port) => $port->isOpen());

        [$closedPorts, $partialPorts] = $other
            ->partition(fn(Port $port) => $port->isClosed());

        /** @var Problem|Recovery $event */
        switch (true) {
            case $openPorts->isNotEmpty() && $closedPorts->merge($partialPorts)->isEmpty():
                // All ports are open...
                $event = Recovery::class;
                $severity = 'Alert';
                $description = "Some or all monitored TCP ports for {$this->target->connect} offline.";
                $type = 'TCP ports open';
                break;

            case $closedPorts->isNotEmpty() && $openPorts->merge($partialPorts)->isEmpty():
                // All ports are offline...
                $event = Problem::class;
                $severity = 'Alert';
                $description = "All monitored TCP ports for {$this->target->connect} offline.";
                $type = 'TCP ports closed';
                break;

            default:
                // Some ports open, some closed...
                $event = Problem::class;
                $severity = 'Warning';
                $description = "Some monitored TCP ports for {$this->target->connect} experiencing issues.";
                $type = 'Some TCP ports closed';
                break;
        }

        $nodeNames = Node::toBase()
            ->get('short_name')
            ->pluck('short_name')
            ->sort()
            ->toArray();

        $monitoringEvent = MonitoringEventData::create(EventOriginator::PortCheck(), [
            'connect'     => $this->target->connect,
            'type'        => $type,
            'description' => $description,
            'severity'    => $severity,
            'meta'        => [
                'header' => ['Port', ...$nodeNames],
                'align'  => [
                    MarkdownTableBuilder::LEFT,
                    ...array_fill(0, count($nodeNames), MarkdownTableBuilder::CENTER),
                ],
                'values' => $this->reportablePorts->reduce(fn($value, Port $port) => $value->push([
                    $port->portWithService(),
                    ...$port->scanResults
                        ->sortBy('node.short_name')
                        ->map(fn(ScanResult $scanResult) => $scanResult->status->description)
                        ->all(),
                ]), collect())->all(),
            ],
        ]);

        event(new $event($this->target->user, $monitoringEvent));
    }
}
