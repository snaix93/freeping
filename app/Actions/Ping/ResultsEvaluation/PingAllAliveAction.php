<?php

namespace App\Actions\Ping\ResultsEvaluation;

use App\Data\Events\MonitoringEventData;
use App\Enums\EventOriginator;
use App\Events\Monitoring\Recovery;
use App\Models\PingResult;
use App\Models\Target;

class PingAllAliveAction
{
    public function __invoke(Target $target)
    {
        if ($target->isOnline()) {
            return;
        }

        if (! $target->isAwaitingResults()) {

            $monitoringEvent = MonitoringEventData::create(EventOriginator::Ping(), [
                'connect'     => $target->connect,
                'type'        => 'Ping alive',
                'description' => "{$target->connect} has recovered",
                'meta'        =>
                    $target->pingResults->mapWithKeys(fn(PingResult $pingResult) => [
                        $pingResult->node->short_name => $pingResult->status->description,
                    ])->merge([
                        'lastCheckExecutedAt' => $target->lastCheckedAt(),
                    ])->reverse()->all(),
            ]);

            $target->last_recovery_sent_at = now();
            $target->number_of_recovery_emails_sent++;

            Recovery::dispatch($target->user, $monitoringEvent);
        }

        $target->markAsUp()->save();
    }
}
