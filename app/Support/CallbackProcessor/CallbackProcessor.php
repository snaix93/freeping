<?php

namespace App\Support\CallbackProcessor;

use Illuminate\Pipeline\Pipeline;

abstract class CallbackProcessor
{
    public function process()
    {
        resolve(Pipeline::class)
            ->send($this->payload)
            ->through($this->processors())
            ->thenReturn();
    }

    abstract public function processors(): array;
}
