<?php

namespace App\Support\CallbackProcessor\Events\WebCheck;

use App\Support\CallbackProcessor\Data\WebCheckPayload;
use App\Support\CallbackProcessor\Data\WebCheckPayloadResult;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class WebCheckResultReceived
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public WebCheckPayloadResult $webCheckPayloadResult,
        public WebCheckPayload $payload,
    ) { }
}
