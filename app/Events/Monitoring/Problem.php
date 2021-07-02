<?php

namespace App\Events\Monitoring;

use App\Data\Events\MonitoringEventData;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class Problem extends MonitoringEvent
{
    public function __construct(User|int $user, MonitoringEventData $monitoringEvent)
    {
        parent::__construct($user, $monitoringEvent);
        Log::debug("Problem Event Dispatched", [
            'eventId'    => $monitoringEvent->eventId,
            'originator' => $monitoringEvent->originator,
            'type'       => $monitoringEvent->type,
            'connect'    => $monitoringEvent->connect,
            'email'      => $this->user->email,
        ]);
    }
}
