<?php

namespace App\Listeners;

use App\Actions\Ping\SendPingResultToInfluxAction;
use App\Support\CallbackProcessor\Events\Ping\PingResultReceived;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendPingResultToInflux implements ShouldQueue
{
    public $queue = 'logging';

    public function __construct(public SendPingResultToInfluxAction $toInfluxAction) { }

    public function handle(PingResultReceived $event)
    {
        ($this->toInfluxAction)($event->pingPayloadResult, $event->payload);
    }
}
