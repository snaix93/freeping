<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use YlsIdeas\SubscribableNotifications\Controllers\UnsubscribeController as UnsubscribeControllerPackage;

class UnsubscribeController extends UnsubscribeControllerPackage
{
    public function __invoke(Request $request, $subscriber, ?string $mailingList = null)
    {
        return parent::__invoke(
            $request,
            (new User)->decodeId($subscriber),
            $mailingList,
        );
    }
}
