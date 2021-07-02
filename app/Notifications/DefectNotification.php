<?php

namespace App\Notifications;

use App\Data\Events\DefectEventData;
use App\Notifications\Concerns\HasNotificationType;
use App\Support\Mail\DefectMailMessage;
use Illuminate\Support\HtmlString;

class DefectNotification extends BaseNotification implements Contracts\DefectNotification
{
    use HasNotificationType;

    public function __construct(private DefectEventData $defectEvent) { }

    public function toMail($notifiable)
    {
        $message = new DefectMailMessage();
        if ($this->defectEvent->userActionNeeded) {
            $message->subject("[NEED FOR ACTION] Your monitoring reports a defect");
        } else {
            $message->subject("Your monitoring reports a defect");
        }
        $message->line(new HtmlString("Freeping has detected a {$this->defectEvent->originator} defect for <code>{$this->defectEvent->connect}</code>."))
            ->line(new HtmlString("<pre>{$this->defectEvent->description}</pre>"))
            ->line('Check your scripts that sends the data or reset the configuration')
            ->line('Your monitoring is still functioning but no history is stored.')
            ->action('Login to manage checks', $this->loginUrl($notifiable));

        return $message;
    }
}
