<?php

namespace App\Data\Casters;

use Exception;
use Illuminate\Support\Str;
use Spatie\DataTransferObject\Caster;

class LowerCaseTrimCaster implements Caster
{
    public function cast(mixed $value): mixed
    {
        if (! is_string($value)) {
            throw new Exception("Must be a string input to cast to lowercase.");
        }

        return (string) Str::of($value)->trim()->lower();
    }
}
