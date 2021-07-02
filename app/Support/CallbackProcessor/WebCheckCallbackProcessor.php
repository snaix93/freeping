<?php

namespace App\Support\CallbackProcessor;

use App\Support\CallbackProcessor\Data\WebCheckPayload;
use App\Support\CallbackProcessor\Processors\CloseBatchIfFinished;
use App\Support\CallbackProcessor\Processors\MarkNodeReceivedOnBatch;
use App\Support\CallbackProcessor\Processors\WebCheck\FireWebCheckBatchCompleteEventIfDone;
use App\Support\CallbackProcessor\Processors\WebCheck\FireWebCheckResultsReceivedEvent;
use App\Support\CallbackProcessor\Processors\WebCheck\StoreWebCheckResults;

final class WebCheckCallbackProcessor extends CallbackProcessor
{
    public function __construct(protected WebCheckPayload $payload) { }

    public function processors(): array
    {
        return [
            MarkNodeReceivedOnBatch::class,
            StoreWebCheckResults::class,
            FireWebCheckResultsReceivedEvent::class,
            CloseBatchIfFinished::class,
            FireWebCheckBatchCompleteEventIfDone::class,
        ];
    }
}
