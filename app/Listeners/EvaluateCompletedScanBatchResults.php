<?php

namespace App\Listeners;

use App\Jobs\EvaluateScanResults;
use App\Support\CallbackProcessor\Events\Scan\ScanBatchComplete;

class EvaluateCompletedScanBatchResults
{
    public function handle(ScanBatchComplete $event)
    {
        EvaluateScanResults::dispatch($event->payload);
    }
}
