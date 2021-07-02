<?php

namespace App\Notifications;

use YlsIdeas\SubscribableNotifications\Contracts\AppliesToMailingList;
use YlsIdeas\SubscribableNotifications\Contracts\CheckNotifiableSubscriptionStatus;

class SubscribableNotification extends BaseNotification implements
    AppliesToMailingList,
    CheckNotifiableSubscriptionStatus
{
    public function checkMailSubscriptionStatus(): bool
    {
        return true;
    }

    public function usesMailingList(): string
    {
        if (property_exists($this, 'target')) {
            return (string) 'ping::'.$this->target->encodeId();
        }

        if (property_exists($this, 'webCheck')) {
            return (string) 'web-check::'.$this->webCheck->encodeId();
        }

        return '';
    }
}
