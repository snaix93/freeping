<?php

namespace App\Support\CallbackProcessor\Processors\Scan;

use App\Models\Batch;
use App\Support\CallbackProcessor\Contracts\Processor;
use App\Support\CallbackProcessor\Data\Payload;
use App\Support\CallbackProcessor\Events\BatchComplete;
use App\Support\CallbackProcessor\Events\Scan\ScanBatchComplete;

class FireScanBatchCompleteEventIfDone implements Processor
{
    public function handle(Payload $payload, $next)
    {
        if ($this->batchIsClosed($payload)) {
            BatchComplete::dispatch($payload);
            ScanBatchComplete::dispatch($payload);
        }

        return $next($payload);
    }

    private function batchIsClosed(Payload $payload): bool
    {
        return Batch::where('id', $payload->batchId)->doesntExist();
    }
}
