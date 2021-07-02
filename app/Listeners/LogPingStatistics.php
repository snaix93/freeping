<?php

namespace App\Listeners;

use App\Actions\Ping\LogPingStatisticsAction;
use App\Support\CallbackProcessor\Events\Ping\PingResultReceived;
use Illuminate\Contracts\Queue\ShouldQueue;

class LogPingStatistics implements ShouldQueue
{
    public $queue = 'logging';

    public function __construct(public LogPingStatisticsAction $logPingStatisticsAction) { }

    public function handle(PingResultReceived $event)
    {
        ($this->logPingStatisticsAction)($event->pingPayloadResult, $event->payload);
    }
}
