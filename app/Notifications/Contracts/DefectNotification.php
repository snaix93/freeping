<?php

namespace App\Notifications\Contracts;

interface DefectNotification
{
    public function notificationType(): string;
    public function notificationEmoji(): string;
}
