<?php

namespace App\Notifications\Contracts;

interface RecoveryNotification
{
    public function notificationType(): string;
    public function notificationEmoji(): string;
}
