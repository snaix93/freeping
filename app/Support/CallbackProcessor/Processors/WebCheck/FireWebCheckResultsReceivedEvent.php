<?php

namespace App\Support\CallbackProcessor\Processors\WebCheck;

use App\Support\CallbackProcessor\Contracts\Processor;
use App\Support\CallbackProcessor\Data\Payload;
use App\Support\CallbackProcessor\Data\WebCheckPayloadResult;
use App\Support\CallbackProcessor\Events\WebCheck\WebCheckResultReceived;

class FireWebCheckResultsReceivedEvent implements Processor
{
    public function handle(Payload $payload, $next)
    {
        // TODO - dispatch results received as a batch set, rather than individually?
        $payload->results->each(function (WebCheckPayloadResult $webCheckPayloadResult) use ($payload) {
            WebCheckResultReceived::dispatch($webCheckPayloadResult, $payload);
        });

        return $next($payload);
    }
}
