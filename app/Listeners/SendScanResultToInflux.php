<?php

namespace App\Listeners;

use App\Actions\Scan\SendScanResultToInfluxAction;
use App\Support\CallbackProcessor\Events\Scan\ScanResultReceived;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendScanResultToInflux implements ShouldQueue
{
    public $queue = 'logging';

    public function __construct(public SendScanResultToInfluxAction $toInfluxAction) { }

    public function handle(ScanResultReceived $event)
    {
        ($this->toInfluxAction)($event->scanPayloadResult, $event->payload);
    }
}
