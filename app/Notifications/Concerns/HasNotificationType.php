<?php

namespace App\Notifications\Concerns;

use App\Notifications\Contracts\AlertNotification;
use App\Notifications\Contracts\RecoveryNotification;
use App\Notifications\Contracts\WarningNotification;
use App\Notifications\Contracts\DefectNotification;

trait HasNotificationType
{
    public function notificationType(): string
    {
        return match (true) {
            in_array(WarningNotification::class, class_implements($this)) => __('Warning'),
            in_array(AlertNotification::class, class_implements($this)) => __('Alert'),
            in_array(RecoveryNotification::class, class_implements($this)) => __('Recovery'),
            in_array(DefectNotification::class, class_implements($this)) => __('Defect'),
            default => '',
        };
    }

    public function notificationEmoji(): string
    {
        return match (true) {
            in_array(WarningNotification::class, class_implements($this)) => '⚠️',
            in_array(AlertNotification::class, class_implements($this)) => '💥',
            in_array(RecoveryNotification::class, class_implements($this)) => '✅',
            in_array(DefectNotification::class, class_implements($this)) => '🔹',
            default => '👋',
        };
    }
}
