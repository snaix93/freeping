<?php

namespace App\Support\CallbackProcessor\Collections;

use App\Support\CallbackProcessor\Data\PingPayloadResult;
use Illuminate\Support\Collection;

class PingPayloadResultCollection extends Collection
{
    public function offsetGet($key): PingPayloadResult
    {
        return parent::offsetGet($key);
    }
}
