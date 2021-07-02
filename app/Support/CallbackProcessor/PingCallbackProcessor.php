<?php

namespace App\Support\CallbackProcessor;

use App\Support\CallbackProcessor\Data\PingPayload;
use App\Support\CallbackProcessor\Processors\CloseBatchIfFinished;
use App\Support\CallbackProcessor\Processors\MarkNodeReceivedOnBatch;
use App\Support\CallbackProcessor\Processors\Ping\FirePingBatchCompleteEventIfDone;
use App\Support\CallbackProcessor\Processors\Ping\FirePingResultsReceivedEvent;
use App\Support\CallbackProcessor\Processors\Ping\StorePingResults;

final class PingCallbackProcessor extends CallbackProcessor
{
    public function __construct(protected PingPayload $payload) { }

    public function processors(): array
    {
        return [
            MarkNodeReceivedOnBatch::class,
            FirePingResultsReceivedEvent::class,
            StorePingResults::class,
            CloseBatchIfFinished::class,
            FirePingBatchCompleteEventIfDone::class,
        ];
    }
}
