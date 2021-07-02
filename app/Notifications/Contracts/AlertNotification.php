<?php

namespace App\Notifications\Contracts;

interface AlertNotification
{
    public function notificationType(): string;
    public function notificationEmoji(): string;
}
