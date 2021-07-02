<?php

namespace App\Listeners;

use App\Actions\Scan\LogScanStatisticsAction;
use App\Support\CallbackProcessor\Events\Scan\ScanResultReceived;
use Illuminate\Contracts\Queue\ShouldQueue;

class LogScanStatistics implements ShouldQueue
{
    public $queue = 'logging';

    public function __construct(public LogScanStatisticsAction $logScanStatisticsAction) { }

    public function handle(ScanResultReceived $event)
    {
        ($this->logScanStatisticsAction)($event->scanPayloadResult, $event->payload);
    }
}
