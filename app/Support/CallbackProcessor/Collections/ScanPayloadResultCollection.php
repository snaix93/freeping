<?php

namespace App\Support\CallbackProcessor\Collections;

use App\Support\CallbackProcessor\Data\ScanPayloadResult;
use Illuminate\Support\Collection;

class ScanPayloadResultCollection extends Collection
{
    public function offsetGet($key): ScanPayloadResult
    {
        return parent::offsetGet($key);
    }
}
