<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

class FlushRedis extends Command
{
    protected $signature = 'flush:redis';

    public function handle()
    {
        Redis::command('flushdb');

        $this->info('Redis cache flushed completely.');

        return 0;
    }
}
