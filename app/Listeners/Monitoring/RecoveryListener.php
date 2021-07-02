<?php

namespace App\Listeners\Monitoring;

use App\Actions\Problem\RemoveProblemAction;
use App\Events\Monitoring\Recovery;
use App\Notifications\RecoveryNotification;
use App\Storage\EventHistoryStorage;
use Illuminate\Support\Facades\Log;

class RecoveryListener
{
    public function handle(Recovery $event)
    {
        Log::debug("Recovery Event caught.", ['eventId' => $event->monitoringEvent->eventId]);
        $event->user->notify(new RecoveryNotification($event->monitoringEvent));
        (new RemoveProblemAction)($event->user->id, $event->monitoringEvent);
        (new EventHistoryStorage($event->user->id))->storeRecovery($event->monitoringEvent);
    }
}
