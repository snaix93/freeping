<?php

namespace App\Notifications\Contracts;

interface WarningNotification
{
    public function notificationType(): string;
    public function notificationEmoji(): string;
}
