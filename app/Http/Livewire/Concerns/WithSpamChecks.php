<?php

namespace App\Http\Livewire\Concerns;

use Lukeraymonddowning\Honey\Facades\Honey;
use Lukeraymonddowning\Honey\Traits\WithHoney;
use Lukeraymonddowning\Honey\Traits\WithRecaptcha;

trait WithSpamChecks
{
    use WithHoney, WithRecaptcha;

    public function spamGuard()
    {
        if (Honey::isEnabled() && ! $this->honeyPasses()) {
            Honey::fail();
        }
    }
}
