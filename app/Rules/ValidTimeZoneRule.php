<?php

namespace App\Rules;

use App\Actions\BuildTimezones;
use Illuminate\Contracts\Validation\Rule;

class ValidTimeZoneRule implements Rule
{
    public function passes($attribute, $value)
    {
        return (bool) collect(resolve(BuildTimezones::class)())
            ->pluck('value')
            ->first(fn($timezone) => $timezone === $value);
    }

    public function message()
    {
        return 'The timezone selected is invalid.';
    }
}
