<?php

namespace App\Http\Livewire\Concerns;

use App\Actions\BuildTimezones;

trait HasTimezones
{
    public function getTimezonesProperty()
    {
        return resolve(BuildTimezones::class)();
    }
}
