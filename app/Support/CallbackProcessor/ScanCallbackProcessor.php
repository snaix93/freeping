<?php

namespace App\Support\CallbackProcessor;

use App\Support\CallbackProcessor\Data\ScanPayload;
use App\Support\CallbackProcessor\Processors\CloseBatchIfFinished;
use App\Support\CallbackProcessor\Processors\MarkNodeReceivedOnBatch;
use App\Support\CallbackProcessor\Processors\Scan\FireScanBatchCompleteEventIfDone;
use App\Support\CallbackProcessor\Processors\Scan\FireScanResultsReceivedEvent;
use App\Support\CallbackProcessor\Processors\Scan\StoreScanResults;

final class ScanCallbackProcessor extends CallbackProcessor
{
    public function __construct(protected ScanPayload $payload) { }

    public function processors(): array
    {
        return [
            MarkNodeReceivedOnBatch::class,
            StoreScanResults::class,
            FireScanResultsReceivedEvent::class,
            CloseBatchIfFinished::class,
            FireScanBatchCompleteEventIfDone::class,
        ];
    }
}
