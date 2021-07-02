<?php

namespace App\Actions\Target;

use App\Models\User;

class ConfirmCheckExistsForUserAction
{
    public function __invoke(User $user, string $mailingList): bool
    {
        if (is_null($entity = resolve_mailing_list_entity($mailingList))) {
            return false;
        }

        return $user->id === $entity->user_id;
    }
}
