<?php

namespace App\Support\CallbackProcessor\Contracts;

use App\Support\CallbackProcessor\Data\Payload;

interface Processor
{
    public function handle(Payload $payload, $next);
}
