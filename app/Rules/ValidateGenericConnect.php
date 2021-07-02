<?php

namespace App\Rules;

use App\Validation\FqdnValidator;
use App\Validation\IpValidator;
use App\Validation\UrlValidator;
use Illuminate\Contracts\Validation\Rule;

class ValidateGenericConnect implements Rule
{
    public function passes($attribute, $value)
    {
        if (IpValidator::isValid($value)) {
            return true;
        }

        if (FqdnValidator::isValid($value)) {
            return true;
        }

        if (UrlValidator::isValid($value)) {
            return true;
        }

        return false;
    }

    public function message()
    {
        return 'Provided address (:input) is invalid.';
    }
}
