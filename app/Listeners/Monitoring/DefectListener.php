<?php

namespace App\Listeners\Monitoring;

use App\Events\Monitoring\Defect;
use App\Notifications\DefectNotification;
use Illuminate\Support\Facades\Log;

class DefectListener
{
    public function handle(Defect $defect)
    {
        Log::debug("Defect Event caught.", ['eventId' => $defect->defectEvent->defectId]);
        $defect->user->notify(new DefectNotification($defect->defectEvent));
    }
}
