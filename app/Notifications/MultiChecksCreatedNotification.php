<?php /** @noinspection PhpUndefinedMethodInspection */

namespace App\Notifications;

use App\Models\Target;
use App\Models\User;
use App\Support\Mail\MailMessage;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Support\Collection;
use Illuminate\Support\HtmlString;

class MultiChecksCreatedNotification extends BaseNotification
{
    public function __construct(
        public Target $target,
        public Collection $webChecks,
    ) { }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail(User $notifiable)
    {
        $mail = (new MailMessage)->hideAd();

        if (! $notifiable->hasVerifiedEmail()) {
            $mail
                ->subject("Verify email to activate your {$this->getAppName()} checks")
                ->line(new HtmlString("Your new checks on {$this->getAppName()} were successfully added but you must first <strong>verify your email before they'll activate</strong>."))
                ->action('Verify email address', $this->verificationUrl($notifiable))
                ->line("For your records, these are the checks you just created on {$this->getAppName()}:")
                ->line($this->buildOutputForCreatedChecks());
        } else {
            $mail
                ->subject("New checks added on {$this->getAppName()}")
                ->line("Your new checks on {$this->getAppName()} were successfully added!")
                ->line('If you want to create more checks you can login to your dashboard or add more from the homepage.')
                ->action('Login to create more checks', $this->loginUrl($notifiable))
                ->line("For your records, these are the checks you just created on {$this->getAppName()}:")
                ->line($this->buildOutputForCreatedChecks());
        }

        return $mail;
    }

    protected function verificationUrl(User $notifiable)
    {
        return call_user_func(VerifyEmail::$createUrlCallback, $notifiable);
    }

    private function buildOutputForCreatedChecks(): HtmlString
    {
        $checks = collect([
            'Ping'          => $this->target->connect,
            'Port check(s)' => function () {
                if ($this->target->ports->isEmpty()) {
                    return false;
                }

                return $this->target->ports->map->portWithService()->join(', ');
            },
            'Web check(s)'  => function () {
                if ($this->webChecks->isEmpty()) {
                    return false;
                }

                return $this->webChecks->map->url_host->join(', ');
            },
        ])
            ->filter(fn($check) => value($check))
            ->reduce(fn($result, $value, $key) => with($result,
                fn(&$result) => $result .= sprintf("<li>%s: %s</li>", $key, value($value)))
            );

        return new HtmlString("<div class='panel'>
            <div class='panel-content'>
                <ul>{$checks}</ul>
            </div>
        </div>");
    }
}
