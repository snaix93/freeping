<?php

namespace App\Support\CallbackProcessor\Events\WebCheck;

use App\Support\CallbackProcessor\Data\WebCheckPayload;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class WebCheckBatchComplete
{
    use Dispatchable, SerializesModels;

    public function __construct(public WebCheckPayload $payload) { }
}
