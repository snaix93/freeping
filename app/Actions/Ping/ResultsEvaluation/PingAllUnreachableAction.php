<?php

namespace App\Actions\Ping\ResultsEvaluation;

use App\Data\Events\MonitoringEventData;
use App\Enums\EventOriginator;
use App\Events\Monitoring\Problem;
use App\Models\PingResult;
use App\Models\Target;

class PingAllUnreachableAction
{
    public function __invoke(Target $target)
    {
        if ($target->isUnreachable()) {
            return;
        }

        $monitoringEvent = MonitoringEventData::create(EventOriginator::Ping(), [
            'connect'     => $target->connect,
            'type'        => 'Ping offline',
            'description' => "{$target->connect} offline from all ping locations",
            'meta'        =>
                $target->pingResults->mapWithKeys(fn(PingResult $pingResult) => [
                    $pingResult->node->short_name => $pingResult->status->description,
                ])->merge([
                    'lastCheckExecutedAt' => $target->lastCheckedAt(),
                ])->reverse()->all(),
        ]);

        $target->last_alert_sent_at = now();
        $target->number_of_alert_emails_sent++;

        $target->markAsDown()->save();

        Problem::dispatch($target->user, $monitoringEvent);
    }
}
