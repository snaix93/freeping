<?php

namespace App\Actions\Ping\ResultsEvaluation;

use App\Data\Events\MonitoringEventData;
use App\Enums\EventOriginator;
use App\Events\Monitoring\Problem;
use App\Models\PingResult;
use App\Models\Target;
use Illuminate\Support\Collection;

class PingMixedResultsAction
{
    public function __invoke(Target $target)
    {
        /** @var Collection $nodesPreviouslyDownForTarget */
        $nodesPreviouslyDownForTarget = $target->nodes_down;

        $target->last_warning_sent_at = now();
        $target->number_of_warning_emails_sent++;

        $target
            ->markAsPartiallyUnreachable()
            ->withNodesDown($target->pingResults->onlyUnreachable()->pluck('node_id'))
            ->save();

        $newAlive = $target->pingResults->getNewAlive($nodesPreviouslyDownForTarget);
        $newUnreachable = $target->pingResults->getNewUnreachable($nodesPreviouslyDownForTarget);

        if ($newAlive->merge($newUnreachable)->isNotEmpty()) {

            $unreachableCount = $target->pingResults->onlyUnreachable()->count();

            $monitoringEvent = MonitoringEventData::create(EventOriginator::Ping(), [
                'connect'     => $target->connect,
                'type'        => 'Ping partially offline',
                'description' => "{$target->connect} is unreachable in {$unreachableCount} of our check locations",
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
}
