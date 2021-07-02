<?php

namespace App\Data\User;

use Illuminate\Support\Str;

class CreateUserData
{
    public function __construct(
        public string $email,
        public string $timezone,
        public string $time,
        public ?string $password = null,
    ) {
        $this->email = Str::lower($this->email);
    }
}
