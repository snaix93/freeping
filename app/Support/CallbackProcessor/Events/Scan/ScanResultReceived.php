<?php

namespace App\Support\CallbackProcessor\Events\Scan;

use App\Support\CallbackProcessor\Data\ScanPayload;
use App\Support\CallbackProcessor\Data\ScanPayloadResult;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ScanResultReceived
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public ScanPayloadResult $scanPayloadResult,
        public ScanPayload $payload,
    ) { }
}
