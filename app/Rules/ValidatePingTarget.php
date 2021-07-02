<?php

namespace App\Rules;

use App\Validation\FqdnValidator;
use App\Validation\IpValidator;
use Illuminate\Contracts\Validation\Rule;

class ValidatePingTarget implements Rule
{
    public function passes($attribute, $value)
    {
        if (IpValidator::isValid($value)) {
            return true;
        }

        if (FqdnValidator::isValid($value)) {
            return true;
        }

        return false;
    }

    public function message()
    {
        return 'Provided IP/FQDN (:input) is invalid.';
    }
}
