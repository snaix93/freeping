<?php

namespace App\Support\CallbackProcessor\Events\Ping;

use App\Support\CallbackProcessor\Data\PingPayload;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PingBatchComplete
{
    use Dispatchable, SerializesModels;

    public function __construct(public PingPayload $payload) { }
}
