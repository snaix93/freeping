<?php

namespace App\Notifications\Ping;

use App\Models\Collections\PingResultCollection;
use App\Models\Target;
use App\Models\User;
use App\Notifications\BaseNotification;
use App\Notifications\Concerns\HasNotificationType;
use App\Notifications\Concerns\PushoverMessage;
use App\Notifications\Contracts\AlertNotification;
use App\Support\Mail\AlertMailMessage;

class TargetUnresolvableNotification extends BaseNotification implements AlertNotification
{
    use HasNotificationType;

    public string $connect;

    public string $reason;

    public function __construct(Target $target, PingResultCollection $pingResults)
    {
        $this->connect = $target->connect;
        $this->reason = $pingResults->onlyUnresolvable()->first()->reason;
    }

    public function toMail($notifiable)
    {
        return (new AlertMailMessage)
            ->subject("[{$this->notificationType()}] {$this->title()}")
            ->line("Your pinger for '{$this->connect}' has become unresolvable with an error message of \"{$this->reason}\".")
            ->line('As this host is unresolvable, we will no longer send pings to it, and as such your monitoring for it has ended.')
            ->line('Please feel free to re-add it if things change or if you feel this was an error.')
            ->action('Login to manage checks', $this->loginUrl($notifiable));
    }

    private function title()
    {
        return "Seems {$this->connect} has become unresolvable";
    }

    public function toPushover(User $notifiable)
    {
        return PushoverMessage::create($this->title())->asAlert($this, $notifiable);
    }
}
