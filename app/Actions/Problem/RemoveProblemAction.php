<?php

namespace App\Actions\Problem;

use App\Data\Events\MonitoringEventData;
use App\Models\Problem;

class RemoveProblemAction
{
    public function __invoke(int $userId, MonitoringEventData $monitoringEvent): void
    {
        Problem::whereEventId($monitoringEvent->eventId)->delete();
    }
}
