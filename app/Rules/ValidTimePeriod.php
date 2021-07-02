<?php

namespace App\Rules;

use App\Actions\BuildTimePeriods;
use Illuminate\Contracts\Validation\Rule;

class ValidTimePeriod implements Rule
{
    public function passes($attribute, $value)
    {
        return (bool) collect(resolve(BuildTimePeriods::class)())
            ->pluck('value')
            ->first(fn($period) => $period === $value);
    }

    public function message()
    {
        return 'The time period selected is invalid.';
    }
}
