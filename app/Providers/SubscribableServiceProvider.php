<?php

namespace App\Providers;

use App\Actions\StopAllChecksForUserAction;
use App\Actions\StopCheckFromEmailAction;
use App\Actions\Target\ConfirmCheckExistsForUserAction;
use App\Http\Controllers\UnsubscribeController;
use Illuminate\Support\Str;
use YlsIdeas\SubscribableNotifications\SubscribableApplicationServiceProvider;
use YlsIdeas\SubscribableNotifications\Subscriber;

class SubscribableServiceProvider extends SubscribableApplicationServiceProvider
{
    /**
     * @var bool
     */
    protected $loadRoutes = true;

    public function register()
    {
        $this->booting(function () {
            resolve(Subscriber::class)->hander = UnsubscribeController::class;
        });
    }

    /**
     * @return callable|string
     */
    public function onUnsubscribeFromMailingList()
    {
        return StopCheckFromEmailAction::class.'@__invoke';
    }

    /**
     * @return callable|string
     */
    public function onUnsubscribeFromAllMailingLists()
    {
        return StopAllChecksForUserAction::class.'@__invoke';
    }

    /**
     * @return callable|string
     */
    public function onCompletion()
    {
        return function ($user, $mailingList) {
            $uri = '/?unsubscribed=true';

            if ($type = Str::before($mailingList, '::')) {
                $uri .= "&check={$type}";
            }

            return response()->redirectTo($uri);
        };
    }

    /**
     * @return callable|string
     */
    public function onCheckSubscriptionStatusOfMailingList()
    {
        return function ($user) {
            return true;
        };
        //return ConfirmCheckExistsForUserAction::class.'@__invoke';
    }

    /**
     * @return callable|string
     */
    public function onCheckSubscriptionStatusOfAllMailingLists()
    {
        return function ($user) {
            return true;
        };
    }
}
