<?php

namespace App\Http\Livewire\Concerns;

use App\Actions\BuildTimePeriods;

trait HasTimePeriods
{
    public function getPeriodsProperty()
    {
        return resolve(BuildTimePeriods::class)();
    }
}
