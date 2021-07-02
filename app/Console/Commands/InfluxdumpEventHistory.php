<?php

namespace App\Console\Commands;

use App\Storage\EventHistoryStorage;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;

class InfluxdumpEventHistory extends Command
{
    protected $signature = 'influxdump:event-history {user_id}';

    protected $description = 'Dump the event history of a user';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $events = new EventHistoryStorage($this->argument('user_id'));
        foreach ($events->getEvents() as $event) {
            print_r($event);
        }
    }
}
