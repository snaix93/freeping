<?php

namespace App\Listeners;

use App\Jobs\EvaluatePingResults;
use App\Support\CallbackProcessor\Events\Ping\PingBatchComplete;

class EvaluateCompletedPingBatchResults
{
    public function handle(PingBatchComplete $event)
    {
        EvaluatePingResults::dispatch($event->payload);
    }
}
