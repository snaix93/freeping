<?php

namespace App\Rules;

use App\Models\User;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Str;

class UniquePingTargetPerUserRule implements Rule
{
    public function __construct(private $email = null) {}

    public function passes($attribute, $value)
    {
        if ($user = User::whereEmail((string) Str::of($this->email)->lower())->first()) {
            return $user->targets()
                ->whereConnect($value)
                ->doesntExist();
        }

        return true;
    }

    public function message()
    {
        return 'You already have a pinger for this IP/FQDN.';
    }
}
