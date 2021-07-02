<?php /** @noinspection PhpMissingBreakStatementInspection */

namespace App\Notifications;

use App\Models\Recipient;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use NotificationChannels\Pushover\PushoverChannel;

class BaseNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function via($notifiable)
    {
        $via = collect();

        if ($this->shouldSendToEmail($notifiable)) {
            $via->push('mail');
        }

        if ($this->shouldSendToPushover($notifiable)) {
            $via->push(PushoverChannel::class);
        }

        return $via->all();
    }

    protected function getAppName(): string
    {
        return config('app.name');
    }

    protected function shouldSendToEmail($notifiable)
    {
        return true;
    }

    protected function shouldSendToPushover(User $notifiable): bool
    {
        if (! value($pushover = $notifiable->pushoverRecipient)->exists()) {
            return false;
        }

        return collect(Recipient::$notificationTypes)
            ->first(function ($notificationType, $notificationInterface) use ($pushover) {
                if (! in_array($notificationInterface, class_implements($this))) {
                    return false;
                }

                if (! $pushover->wantsNotificationOfType($notificationType)) {
                    return false;
                }

                return true;
            }, false);
    }

    public function loginUrl(User $user)
    {
        return route('login', [
            'email' => $user->email,
        ]);
    }

    public function viaQueues()
    {
        return [
            'mail'     => 'notification',
            'pushover' => 'notification',
        ];
    }
}
