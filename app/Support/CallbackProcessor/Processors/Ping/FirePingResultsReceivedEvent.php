<?php

namespace App\Support\CallbackProcessor\Processors\Ping;

use App\Support\CallbackProcessor\Contracts\Processor;
use App\Support\CallbackProcessor\Data\Payload;
use App\Support\CallbackProcessor\Data\PingPayloadResult;
use App\Support\CallbackProcessor\Events\Ping\PingResultReceived;

class FirePingResultsReceivedEvent implements Processor
{
    public function handle(Payload $payload, $next)
    {
        // TODO - dispatch results received as a batch set, rather than individually?
        $payload->results->each(function (PingPayloadResult $pingPayloadResult) use ($payload) {
            PingResultReceived::dispatch($pingPayloadResult, $payload);
        });

        return $next($payload);
    }
}
