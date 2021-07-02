<?php

namespace App\Notifications\Pulse;

use App\Data\Omc\PulseHost;
use App\Models\User;
use App\Notifications\BaseNotification;
use App\Notifications\Concerns\HasNotificationType;
use App\Notifications\Concerns\PushoverMessage;
use App\Notifications\Contracts\RecoveryNotification;
use App\Support\Mail\RecoveredMailMessage;
use Illuminate\Support\HtmlString;

class PulseRecoveredNotification extends BaseNotification implements RecoveryNotification
{
    use HasNotificationType;

    public function __construct(public PulseHost $pulseHost) { }

    public function toMail($notifiable)
    {
        return (new RecoveredMailMessage)
            ->subject("[Recovery] {$this->title()}")
            ->line(new HtmlString("Freeping has detected that your server <code>{$this->pulseHost->hostname}</code> is sending pulses again."))
            ->line("Last pulse received at: {$this->pulseHost->lastPulseReceivedAt->toDateTimeString()} (UTC)")
            ->line("Last pulse received from: {$this->pulseHost->lastRemoteAddress}")
            ->line("Host description: {$this->pulseHost->description}")
            ->line("Host location: {$this->pulseHost->location}")
            ->action('Login to manage checks', $this->loginUrl($notifiable));
    }

    private function title()
    {
        return "Pulse recovered for {$this->pulseHost->hostname}";
    }

    public function toPushover(User $notifiable)
    {
        return PushoverMessage::create($this->title())->asAlert($this, $notifiable);
    }
}
