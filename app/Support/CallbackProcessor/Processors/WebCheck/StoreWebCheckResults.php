<?php

namespace App\Support\CallbackProcessor\Processors\WebCheck;

use App\Support\CallbackProcessor\Contracts\Processor;
use App\Support\CallbackProcessor\Data\Payload;
use App\Support\CallbackProcessor\Data\WebCheckPayloadResult;
use Illuminate\Support\Facades\DB;

class StoreWebCheckResults implements Processor
{
    public function handle(Payload $payload, $next): Payload
    {
        $payload->results->each(function (WebCheckPayloadResult $result) use ($payload) {
            DB::insert(
                "REPLACE INTO web_check_results (uuid,node_id,status,reason,created_at,updated_at) VALUES(?,?,?,?,?,?)",
                [
                    $result->id,
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
