<?php

namespace App\Collections;

use App\Data\WebCheck\WebCheckData;
use Illuminate\Support\Collection;

class WebCheckDataCollection extends Collection
{
    public function offsetGet($key): WebCheckData
    {
        return parent::offsetGet($key);
    }
}
