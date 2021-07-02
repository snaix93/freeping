<?php

namespace App\Data\Casters;

use Exception;
use Illuminate\Support\Str;
use Spatie\DataTransferObject\Caster;

class UpperCaseTrimCaster implements Caster
{
    public function cast(mixed $value): mixed
    {
        if (! is_string($value)) {
            throw new Exception("Must be a string input to cast to uppercase.");
        }

        return (string) Str::of($value)->trim()->upper();
    }
}
