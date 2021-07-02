<?php

namespace App\Support\CallbackProcessor\Events;

use App\Support\CallbackProcessor\Data\Payload;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BatchComplete
{
    use Dispatchable, SerializesModels;

    public function __construct(public Payload $payload) { }
}
