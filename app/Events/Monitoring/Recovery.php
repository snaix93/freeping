<?php

namespace App\Events\Monitoring;

use App\Data\Events\MonitoringEventData;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class Recovery extends MonitoringEvent
{
    public function __construct(User|int $user, MonitoringEventData $monitoringEvent)
    {
        parent::__construct($user, $monitoringEvent);
        Log::debug("Recovery Event Dispatched", [
            'originator' => $monitoringEvent->originator,
            'type'       => $monitoringEvent->type,
            'email'      => $this->user->email,
        ]);
    }
}
