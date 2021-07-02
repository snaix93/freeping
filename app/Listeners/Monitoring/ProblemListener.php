<?php

namespace App\Listeners\Monitoring;

use App\Actions\Problem\CreateProblemAction;
use App\Events\Monitoring\Problem;
use App\Notifications\ProblemNotification;
use App\Storage\EventHistoryStorage;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class ProblemListener implements ShouldQueue
{
    public function handle(Problem $event)
    {
        // Log::debug("Problem Event caught", ['eventId' => $event->monitoringEvent->eventId]);
        /**
         * Hand over to the user notification
         */
        $event->user->notify(new ProblemNotification($event->monitoringEvent));
        /**
         * Store the event history to influx
         */
        (new EventHistoryStorage($event->user->id))->storeProblem($event->monitoringEvent);
        /**
         * Store the event as problem
         */
        (new CreateProblemAction)($event->user->id, $event->monitoringEvent);
    }
}
