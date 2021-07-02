<?php

namespace App\Console\Commands;

use App\Actions\SendDailyReportAction;
use App\Models\User;
use Illuminate\Console\Command;

class SendDailyReport extends Command
{
    protected $signature = 'ping:send-daily-report 
                            {--F|force-now-for-user= : The ID or email of a user to send the report to now}';

    public function handle()
    {
        $forceNow = false;

        if ($user = $this->option('force-now-for-user')) {
            $user = User::where('id', $user)->orWhere('email', $user)->firstOrFail();
            $forceNow = true;
        }

        resolve(SendDailyReportAction::class)($user, $forceNow);

        return 0;
    }
}
