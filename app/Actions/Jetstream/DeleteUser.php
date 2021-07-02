<?php

namespace App\Actions\Jetstream;

use App\Actions\StopAllChecksForUserAction;
use Laravel\Jetstream\Contracts\DeletesUsers;

class DeleteUser implements DeletesUsers
{
    public function delete($user)
    {
        $user->deleteProfilePhoto();
        $user->tokens->each->delete();
        resolve(StopAllChecksForUserAction::class)($user);
    }
}
