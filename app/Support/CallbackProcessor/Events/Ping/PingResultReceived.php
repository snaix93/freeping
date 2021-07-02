<?php

namespace App\Support\CallbackProcessor\Events\Ping;

use App\Support\CallbackProcessor\Data\PingPayload;
use App\Support\CallbackProcessor\Data\PingPayloadResult;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PingResultReceived
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public PingPayloadResult $pingPayloadResult,
        public PingPayload $payload,
    ) { }
}
