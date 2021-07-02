<?php

namespace App\Support\CallbackProcessor\Processors\Ping;

use App\Support\CallbackProcessor\Contracts\Processor;
use App\Support\CallbackProcessor\Data\Payload;
use App\Support\CallbackProcessor\Data\PingPayloadResult;
use Illuminate\Support\Facades\DB;

class StorePingResults implements Processor
{
    public function handle(Payload $payload, $next): Payload
    {
        $payload->results->each(function (PingPayloadResult $result) use ($payload) {
            DB::insert(
                "REPLACE INTO ping_results (connect,node_id,status,reason,created_at,updated_at) VALUES(?,?,?,?,?,?)",
                [
                    $result->connect,
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
