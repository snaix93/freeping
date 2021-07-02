<?php

namespace App\Notifications;

use App\Data\Events\MonitoringEventData;
use App\Models\User;
use App\Notifications\Concerns\HasNotificationType;
use App\Notifications\Concerns\PushoverMessage;
use App\Support\Formatter;
use App\Support\Mail\AlertMailMessage;
use App\Support\Mail\MailMessage;
use App\Support\Mail\WarningMailMessage;
use Illuminate\Support\HtmlString;

class ProblemNotification extends BaseNotification implements Contracts\AlertNotification
{
    use HasNotificationType;

    public function __construct(private MonitoringEventData $monitoringEvent) { }

    public function toMail($notifiable)
    {
        if ('warning' == strtolower($this->monitoringEvent->severity)) {
            $message = new WarningMailMessage;
        } else {
            $message = new AlertMailMessage;
        }

        return $message->subject("[{$this->monitoringEvent->severity}] {$this->title()}")
            ->line(new HtmlString("Freeping has detected a {$this->monitoringEvent->originator} issue for <code>{$this->monitoringEvent->connect}</code>."))
            ->line("The problem: '{$this->monitoringEvent->description}' is reported.")
            ->when(! is_null($this->monitoringEvent->checkDefinition), function (MailMessage $mail) {
                $mail->line(Formatter::fromArray($this->monitoringEvent->checkDefinition)
                    ->toBlackBoxHtmlString());
            })
            ->addTable(Formatter::fromArray($this->monitoringEvent->meta)->toMarkdown())
            ->when(! is_null($this->monitoringEvent->measurements), function ($mail) {
                $mail->line(Formatter::fromArray($this->monitoringEvent->measurements)
                    ->addCaption('Latest measurements')
                    ->addClass('measurements')
                    ->withEmojis()
                    ->toHtmlString()
                );
            })
            ->line('Once the issue has resolved we will send you a recovery message.')
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
            ->asAlert($this, $notifiable);
    }
}
