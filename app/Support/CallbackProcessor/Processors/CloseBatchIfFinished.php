<?php

namespace App\Support\CallbackProcessor\Processors;

use App\Models\Batch;
use App\Models\Node;
use App\Support\CallbackProcessor\Contracts\Processor;
use App\Support\CallbackProcessor\Data\Payload;
use App\Support\CallbackProcessor\Data\PingPayload;
use App\Support\CallbackProcessor\Data\ScanPayload;
use App\Support\CallbackProcessor\Data\WebCheckPayload;
use App\Support\CallbackProcessor\Enums\JobType;
use Illuminate\Support\Facades\DB;

class CloseBatchIfFinished implements Processor
{
    public function handle(Payload $payload, $next)
    {
        if ($this->batchHasFinished($payload)) {
            $this->closeBatch($payload);
        }

        return $next($payload);
    }

    private function batchHasFinished(
        PingPayload|ScanPayload|WebCheckPayload|Payload $payload
    ): bool
    {
        $nodesFinishedForBatchCount = $this->getFinishedCountForBatch($payload);
        $nodeCount = Node::count();

        logger("We have received {$payload->jobType} results from {$nodesFinishedForBatchCount} of {$nodeCount} nodes for batch {$payload->batchId}");

        if ($nodeCount === $nodesFinishedForBatchCount) {
            logger("BINGO! {$payload->jobType} batch {$payload->batchId} finished.");

            return true;
        }

        return false;
    }

    private function getFinishedCountForBatch(
        PingPayload|ScanPayload|WebCheckPayload|Payload $payload
    ): int
    {
        return Batch::where('id', $payload->batchId)
            ->finished()
            ->count();
    }

    private function closeBatch(PingPayload|ScanPayload|WebCheckPayload|Payload $payload)
    {
        Batch::where('id', $payload->batchId)->delete();

        $table = match (true) {
            $payload->jobType->is(JobType::Ping()) => 'ping_in_progress',
            $payload->jobType->is(JobType::Scan()) => 'scan_in_progress',
            $payload->jobType->is(JobType::WebCheck()) => 'web_check_in_progress',
        };

        DB::table($table)
            ->whereIn('identifier', $payload->results->pluck('inProgressIdentifier')->unique())
            ->delete();
    }
}
