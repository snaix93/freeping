<?php

namespace App\Policies;

use App\Models\User;
use App\Models\WebCheck;
use Illuminate\Auth\Access\HandlesAuthorization;

class WebCheckPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, WebCheck $webCheck)
    {
        return $webCheck->user_id === $user->id;
    }

    public function create(User $user)
    {
        return true;
    }

    public function update(User $user, WebCheck $webCheck)
    {
        return $webCheck->user_id === $user->id;
    }

    public function delete(User $user, WebCheck $webCheck)
    {
        return $webCheck->user_id === $user->id;
    }
}
