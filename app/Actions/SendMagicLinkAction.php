<?php

namespace App\Actions;

use App\Models\User;
use App\Notifications\MagicLinkNotification;
use Leeovery\MagicLink\Facades\MagicLink;

class SendMagicLinkAction
{
    public function __invoke(User $user)
    {
        $user->notify(new MagicLinkNotification(
            MagicLink::forUser($user)
                ->redirectsTo(route('pingers'))
                ->generate()
        ));
    }
}
