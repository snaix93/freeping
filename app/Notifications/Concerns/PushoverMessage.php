<?php

namespace App\Notifications\Concerns;

use App\Enums\PushoverPriority;
use App\Models\User;
use Illuminate\Notifications\Notification;
use NotificationChannels\Pushover\PushoverMessage as PushoverMessageBase;

class PushoverMessage extends PushoverMessageBase
{
    /**
     * Unit (Host or Target) the message refers to
     */
    private ?string $unit;

    public function __construct($content = '')
    {
        parent::__construct($content);
        $this->unit = config('app.name');
    }

    public function asAlert(Notification $notification, User $user)
    {
        $pushoverMessage = $this->withBasics($notification, $user);

        if ($user->pushoverRecipient->priority->is(PushoverPriority::Emergency())) {
            $pushoverMessage->emergencyPriority(30, 60 * 5);
        } else {
            $pushoverMessage->priority($user->pushoverRecipient->priority->value);
        }

        return $pushoverMessage;
    }

    private function withBasics($notification, User $user)
    {
        return $this
            ->title("{$notification->notificationEmoji()} [{$notification->notificationType()}] ".$this->unit)
            ->url($notification->loginUrl($user), __('Login to manage your checks'))
            ->sound('incoming');
    }

    public function asRecovery(Notification $notification, User $user)
    {
        return $this->withBasics($notification, $user);
    }

    public function asWarning(Notification $notification, User $user)
    {
        return $this->withBasics($notification, $user);
    }

    public function withUnit(string $unit)
    {
        $this->unit = 'on '.$unit;

        return $this;
    }
}
