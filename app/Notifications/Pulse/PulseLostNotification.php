<?php

namespace App\Notifications\Pulse;

use App\Data\Omc\PulseHost;
use App\Models\User;
use App\Notifications\BaseNotification;
use App\Notifications\Concerns\HasNotificationType;
use App\Notifications\Concerns\PushoverMessage;
use App\Notifications\Contracts\AlertNotification;
use App\Support\Mail\AlertMailMessage;
use Illuminate\Support\HtmlString;

class PulseLostNotification extends BaseNotification implements AlertNotification
{
    use HasNotificationType;

    public function __construct(public PulseHost $pulseHost) { }

    public function toMail($notifiable)
    {
        return (new AlertMailMessage)
            ->subject("[Alert] {$this->title()}")
            ->line(new HtmlString("Freeping has detected that your server <code>{$this->pulseHost->hostname}</code> has not sent a pulse for more then {$this->pulseHost->lastPulseReceivedAt->diffInMinutes()} minutes."))
            ->line("Last pulse received at: {$this->pulseHost->lastPulseReceivedAt->toDateTimeString()} (UTC)")
            ->line("Last pulse received from: {$this->pulseHost->lastRemoteAddress}")
            ->line("Host description: {$this->pulseHost->description}")
            ->line("Host location: {$this->pulseHost->location}")
            ->line('Once the pulse of your server comes back online we will send you a recovery message.')
            ->action('Login to manage checks', $this->loginUrl($notifiable));
    }

    private function title()
    {
        return "Pulse lost for {$this->pulseHost->hostname}";
    }

    public function toPushover(User $notifiable)
    {
        return PushoverMessage::create($this->title())
            ->withUnit($this->pulseHost->hostname)
            ->asAlert($this, $notifiable);
    }
}
