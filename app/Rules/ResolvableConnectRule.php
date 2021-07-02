<?php

namespace App\Rules;

use App\Support\Ping;
use Illuminate\Contracts\Validation\Rule;

class ResolvableConnectRule implements Rule
{
    public function passes($attribute, $value)
    {
        return Ping::check($value)->isResolvable();
    }

    public function message()
    {
        return 'Provided IP/FQDN/URL (:input) is unresolvable.';
    }
}
