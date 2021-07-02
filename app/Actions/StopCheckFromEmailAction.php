<?php

namespace App\Actions;

use App\Models\User;

class StopCheckFromEmailAction
{
    public function __invoke(User $user, ?string $mailingList = null)
    {
        $entity = resolve_mailing_list_entity($mailingList);
        $entity?->delete();

        if ($user->refresh()->targets()->doesntExist()
            && $user->refresh()->webChecks()->doesntExist()) {
            $user->delete();
        }
    }
}
