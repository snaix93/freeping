<?php

namespace App\Actions;

use App\Models\User;

class StopAllChecksForUserAction
{
    public function __invoke(User $user)
    {
        $user->targets->each->delete();
        $user->webChecks->each->delete();
        $user->sslChecks->each->delete();
        $user->delete();
    }
}
