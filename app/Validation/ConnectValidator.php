<?php

namespace App\Validation;

use Illuminate\Support\Str;

abstract class ConnectValidator
{
    public static function isInvalid($input): bool
    {
        return ! static::isValid($input);
    }

    abstract static public function isValid($input): bool;

    protected static function getInput($input): string
    {
        return Str::of($input)->lower()->trim();
    }
}
