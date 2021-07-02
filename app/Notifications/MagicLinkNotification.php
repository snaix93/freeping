<?php

namespace App\Notifications;

use App\Support\Mail\MailMessage;

class MagicLinkNotification extends BaseNotification
{
    public function __construct(private string $magicLink) { }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function viaQueues()
    {
        return [
            'mail' => 'default',
        ];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->hideAd()
            ->from(config('mail.from.address'), "Login {$this->getAppName()}")
            ->subject('Your magic login link')
            ->line('You can login using this magic link for the next 5 minutes. If it expires you will have to generate another link.')
            ->action('Login using magic link', $this->magicLink);
    }
}
