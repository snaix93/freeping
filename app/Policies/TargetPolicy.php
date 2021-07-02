<?php

namespace App\Policies;

use App\Models\Target;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TargetPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, Target $target)
    {
        return $target->user_id === $user->id;
    }

    public function create(User $user)
    {
        return true;
    }

    public function update(User $user, Target $target)
    {
        return $target->user_id === $user->id;
    }

    public function delete(User $user, Target $target)
    {
        return $target->user_id === $user->id;
    }
}
