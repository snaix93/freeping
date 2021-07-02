<?php

namespace App\Data\User;

class UpdateUserData
{
    public function __construct(public string $timezone, public string $time) { }
}
