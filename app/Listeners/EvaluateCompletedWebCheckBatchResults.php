<?php

namespace App\Listeners;

use App\Jobs\EvaluateWebCheckResults;
use App\Support\CallbackProcessor\Events\WebCheck\WebCheckBatchComplete;

class EvaluateCompletedWebCheckBatchResults
{
    public function handle(WebCheckBatchComplete $event)
    {
        EvaluateWebCheckResults::dispatch($event->payload);
    }
}
