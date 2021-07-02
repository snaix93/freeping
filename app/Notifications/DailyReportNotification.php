<?php

namespace App\Notifications;

use App\Collections\ReportDataCollection;
use App\Support\Mail\MailMessage;
use Illuminate\Support\HtmlString;

class DailyReportNotification extends BaseNotification
{
    public function __construct(private ReportDataCollection $reportDataCollection) { }

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
        $yesterday = now()->subDay()->format('jS F Y');

        return (new MailMessage)
            ->from(config('mail.from.address'), "{$this->getAppName()} Daily Report")
            ->level('report')
            ->subject("Your Daily {$this->getAppName()} Report")
            ->line(new HtmlString("<strong>Report for: {$yesterday}</strong>"))
            ->line("The following table shows the uptime percentage of your monitored hosts in relation to the total number of ping checks we performed.")
            ->addTable($this->reportDataCollection->formatStatsAsMarkdownTable())
            ->action('Login to create more checks', $this->loginUrl($notifiable));
    }
}
