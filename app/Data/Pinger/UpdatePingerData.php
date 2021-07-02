<?php

namespace App\Data\Pinger;

use App\Models\Target;
use App\Models\User;

class UpdatePingerData
{
    public function __construct(
        public Target $target,
        public User $user,
        /** @var int[] */
        public array $ports,
    ) { }
}
