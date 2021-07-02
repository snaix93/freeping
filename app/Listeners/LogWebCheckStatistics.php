<?php

namespace App\Listeners;

use App\Actions\WebCheck\LogWebCheckStatisticsAction;
use App\Support\CallbackProcessor\Events\WebCheck\WebCheckResultReceived;
use Illuminate\Contracts\Queue\ShouldQueue;

class LogWebCheckStatistics implements ShouldQueue
{
    public $queue = 'logging';

    public function __construct(public LogWebCheckStatisticsAction $logWebCheckStatisticsAction) { }

    public function handle(WebCheckResultReceived $event)
    {
        ($this->logWebCheckStatisticsAction)($event->webCheckPayloadResult, $event->payload);
    }
}
