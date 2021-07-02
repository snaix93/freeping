<?php

namespace App\Actions\Ping\ResultsEvaluation;

use App\Data\Events\MonitoringEventData;
use App\Enums\EventOriginator;
use App\Events\Monitoring\Problem;
use App\Models\PingResult;
use App\Models\Target;

class PingPartiallyUpAction
{
    public function __invoke(Target $target)
    {
        $target->last_warning_sent_at = now();
        $target->number_of_warning_emails_sent++;

        $target
            ->markAsPartiallyUnreachable()
            ->withNodesDown($target->pingResults->onlyUnreachable()->pluck('node_id'))
            ->save();

        $unreachableCount = $target->pingResults->onlyUnreachable()->count();
        $is = $unreachableCount === 1 ? 'is' : 'are';

        $monitoringEvent = MonitoringEventData::create(EventOriginator::Ping(), [
            'connect'     => $target->connect,
            'type'        => 'Ping partially down',
            'description' => "{$target->connect} has partially recovered but {$unreachableCount} of our check locations {$is} still reporting an unreachable status",
            'severity'    => 'Warning',
            'meta'        =>
                $target->pingResults->mapWithKeys(fn(PingResult $pingResult) => [
                    $pingResult->node->short_name => $pingResult->status->description,
                ])->merge([
                    'lastCheckExecutedAt' => $target->lastCheckedAt(),
                ])->reverse()->all(),
        ]);

        Problem::dispatch($target->user, $monitoringEvent);
    }
}
