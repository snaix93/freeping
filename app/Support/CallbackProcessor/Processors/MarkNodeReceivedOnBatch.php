<?php

namespace App\Support\CallbackProcessor\Processors;

use App\Models\Batch;
use App\Support\CallbackProcessor\Contracts\Processor;
use App\Support\CallbackProcessor\Data\Payload;

class MarkNodeReceivedOnBatch implements Processor
{
    public function handle(Payload $payload, $next)
    {
        Batch::where('id', $payload->batchId)
            ->where('node_id', $payload->nodeId)
            ->update([
                'finished_at'      => now(),
                'results_received' => $payload->results->count(),
            ]);

        return $next($payload);
    }
}
