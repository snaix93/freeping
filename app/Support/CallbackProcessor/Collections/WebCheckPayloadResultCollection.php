<?php

namespace App\Support\CallbackProcessor\Collections;

use App\Support\CallbackProcessor\Data\WebCheckPayloadResult;
use Illuminate\Support\Collection;

class WebCheckPayloadResultCollection extends Collection
{
    public function offsetGet($key): WebCheckPayloadResult
    {
        return parent::offsetGet($key);
    }
}
