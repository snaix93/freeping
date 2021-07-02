<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ClearInProgress extends Command
{
    protected $signature = 'clear-in-progress';

    public function handle()
    {
        DB::table('batches')->truncate();
        DB::table('ping_in_progress')->truncate();
        DB::table('scan_in_progress')->truncate();
        DB::table('web_check_in_progress')->truncate();
    }
}
