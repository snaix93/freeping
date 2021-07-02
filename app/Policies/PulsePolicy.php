<?php

namespace App\Policies;

use App\Models\Pulse;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PulsePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, Pulse $pulse)
    {
        return $pulse->user_id === $user->id;
    }

    public function create(User $user)
    {
        return true;
    }

    public function update(User $user, Pulse $pulse)
    {
        return $pulse->user_id === $user->id;
    }

    public function delete(User $user, Pulse $pulse)
    {
        return $pulse->user_id === $user->id;
    }
}
