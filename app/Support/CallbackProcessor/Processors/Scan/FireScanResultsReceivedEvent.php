<?php

namespace App\Support\CallbackProcessor\Processors\Scan;

use App\Support\CallbackProcessor\Contracts\Processor;
use App\Support\CallbackProcessor\Data\Payload;
use App\Support\CallbackProcessor\Data\ScanPayloadResult;
use App\Support\CallbackProcessor\Events\Scan\ScanResultReceived;

class FireScanResultsReceivedEvent implements Processor
{
    public function handle(Payload $payload, $next)
    {
        // TODO - dispatch results received as a batch set, rather than individually?
        $payload->results->each(function (ScanPayloadResult $scanPayloadResult) use ($payload) {
            ScanResultReceived::dispatch($scanPayloadResult, $payload);
        });

        return $next($payload);
    }
}
