<?php

namespace App\Notifications;

use NotificationChannels\Pushover\PushoverChannel;
use NotificationChannels\Pushover\PushoverMessage;

class PushoverActivatedNotification extends BaseNotification
{
    public function via($notifiable)
    {
        return [PushoverChannel::class];
    }

    public function toPushover($notifiable)
    {
        return PushoverMessage::create(__('You have successfully activated Pushover.'))
            ->title(config('app.name'))
            ->sound('incoming');
    }
}
