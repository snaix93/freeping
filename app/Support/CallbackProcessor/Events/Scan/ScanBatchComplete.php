<?php

namespace App\Support\CallbackProcessor\Events\Scan;

use App\Support\CallbackProcessor\Data\ScanPayload;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ScanBatchComplete
{
    use Dispatchable, SerializesModels;

    public function __construct(public ScanPayload $payload) { }
}
