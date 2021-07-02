<?php

namespace App\Support\CallbackProcessor\Processors\Scan;

use App\Support\CallbackProcessor\Contracts\Processor;
use App\Support\CallbackProcessor\Data\Payload;
use App\Support\CallbackProcessor\Data\ScanPayloadResult;
use Illuminate\Support\Facades\DB;

class StoreScanResults implements Processor
{
    public function handle(Payload $payload, $next): Payload
    {
        $payload->results->each(function (ScanPayloadResult $result) use ($payload) {
            DB::insert(
                "REPLACE INTO scan_results (connect,port,node_id,status,reason,created_at,updated_at) VALUES(?,?,?,?,?,?,?)",
                [
                    $result->connect,
                    $result->port,
                    $payload->nodeId,
                    $result->status,
                    $result->reason,
                    $payload->date,
                    $payload->date,
                ]);
        });

        return $next($payload);
    }
}
