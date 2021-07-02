<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Spatie\ShortSchedule\ShortSchedule;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        //
    ];

    protected function schedule(Schedule $schedule)
    {
        $schedule->command('ping:send-daily-report')->hourlyAt(1);
        $schedule->command('horizon:terminate')->hourly();
        $schedule->command('horizon:snapshot')->everyFiveMinutes();
        $schedule->command('clear-in-progress')->hourly();
        $schedule->command('ssl-checks:perform')->everyFourHours();

        if ($this->app->environment('staging', 'local')) {
            $schedule->command('telescope:prune')->daily();
        }
    }

    protected function shortSchedule(ShortSchedule $shortSchedule)
    {
        $shortSchedule
            ->command('ping:dispatch')
            ->everySeconds(10)
            ->withoutOverlapping();

        $shortSchedule
            ->command('scan:dispatch')
            ->everySeconds(10)
            ->withoutOverlapping();

        $shortSchedule
            ->command('web-check:dispatch')
            ->everySeconds(10)
            ->withoutOverlapping();

        $shortSchedule
            ->command('pulse:process')
            ->everySeconds(45)
            ->withoutOverlapping();
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
