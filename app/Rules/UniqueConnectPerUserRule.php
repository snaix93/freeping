<?php

namespace App\Rules;

use App\Models\User;
use App\Support\UrlParser;
use App\Validation\UrlValidator;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Str;

class UniqueConnectPerUserRule implements Rule
{
    public function __construct(private $email = null) { }

    public function passes($attribute, $value)
    {
        if (is_null($this->email)) {
            return true;
        }

        if (UrlValidator::isValid($value)) {
            $value = UrlParser::for($value)->host();
        }

        if ($user = User::whereEmail((string) Str::of($this->email)->lower())->first()) {
            return $user->targets()
                ->whereConnect($value)
                ->doesntExist();
        }

        return true;
    }

    public function message()
    {
        return 'You already have a pinger for this address.';
    }
}
