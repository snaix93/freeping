<?php

namespace App\Actions\Problem;

use App\Data\Events\MonitoringEventData;
use App\Models\Problem;

class CreateProblemAction
{
    public function __invoke(int $userId, MonitoringEventData $monitoringEvent): void
    {
        Problem::create([
            'user_id'          => $userId,
            'event_id'         => $monitoringEvent->eventId,
            'originator'       => $monitoringEvent->originator,
            'severity'         => $monitoringEvent->severity,
            'connect'          => $monitoringEvent->connect,
            'description'      => $monitoringEvent->description,
            'meta'             => $monitoringEvent->meta,
            'check_definition' => $monitoringEvent->checkDefinition,
        ]);
    }
}
