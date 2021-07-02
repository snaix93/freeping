<?php

namespace App\Notifications;

use App\Data\Events\MonitoringEventData;
use App\Models\User;
use App\Notifications\Concerns\HasNotificationType;
use App\Notifications\Concerns\PushoverMessage;
use App\Support\Formatter;
use App\Support\Mail\MailMessage;
use App\Support\Mail\RecoveredMailMessage;
use Illuminate\Support\HtmlString;

class RecoveryNotification extends BaseNotification implements Contracts\RecoveryNotification
{
    use HasNotificationType;

    public function __construct(private MonitoringEventData $monitoringEvent) { }

    public function toMail($notifiable)
    {
        return (new RecoveredMailMessage)
            ->subject("[{$this->notificationType()}] {$this->title()}")
            ->line(new HtmlString("The {$this->monitoringEvent->originator} issue for <code>{$this->monitoringEvent->connect}</code> has recovered."))
            ->line("The problem: '{$this->monitoringEvent->description}' is no longer active.")
            ->when(! is_null($this->monitoringEvent->checkDefinition), function (MailMessage $mail) {
                $mail->line(Formatter::fromArray($this->monitoringEvent->checkDefinition)
                    ->toBlackBoxHtmlString());
            })
            ->addTable(Formatter::fromArray($this->monitoringEvent->meta)->toMarkdown())
            ->when(! is_null($this->monitoringEvent->measurements), function (MailMessage $mail) {
                $mail->line(
                    Formatter::fromArray($this->monitoringEvent->measurements)
                        ->addCaption('Latest measurements')
                        ->addClass('measurements')
                        ->withEmojis()
                        ->toHtmlString()
                );
            })
            ->action('Login to manage checks', $this->loginUrl($notifiable));
    }

    private function title()
    {
        return "{$this->monitoringEvent->type} for {$this->monitoringEvent->connect}";
    }

    public function toPushover(User $notifiable)
    {
        return PushoverMessage::create($this->title())
            ->withUnit($this->monitoringEvent->connect)
            ->asRecovery($this, $notifiable);
    }
}
