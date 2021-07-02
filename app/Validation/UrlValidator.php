<?php

namespace App\Validation;

class UrlValidator extends ConnectValidator
{
    public static function isValid($input): bool
    {
        $input = static::getInput($input);

        if (filter_var($input, FILTER_VALIDATE_URL)) {
            return true;
        }

        return false;
    }
}
