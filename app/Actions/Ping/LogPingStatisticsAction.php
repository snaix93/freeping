<?php

namespace App\Actions\Ping;

use App\Enums\PingResultStatus;
use App\Support\CallbackProcessor\Data\PingPayload;
use App\Support\CallbackProcessor\Data\PingPayloadResult;
use Illuminate\Support\Facades\DB;

class LogPingStatisticsAction
{
    public function __invoke(PingPayloadResult $result, PingPayload $payload): bool
    {
        $query = match (true) {
            $result->status->is(PingResultStatus::Alive()) => $this->getSuccessQuery(),
            is_null($result->reason) => $this->getFailureQuery(),
            default => $this->getErrorQuery(),
        };

        return DB::insert($query, [$result->connect, $payload->nodeId]);
    }

    private function getSuccessQuery(): string
    {
        return "INSERT INTO ping_stats
                    (connect, node_id, successes, failures, errors, datestamp, hour, created_at, updated_at)
                    VALUES
                    (?, ?, 1, 0, 0, CURDATE(), HOUR(NOW()), NOW(), NOW())
                    ON DUPLICATE KEY UPDATE
                    successes=successes+1,updated_at = NOW()";
    }

    private function getFailureQuery(): string
    {
        return "INSERT INTO ping_stats
                    (connect, node_id, successes, failures, errors, datestamp, hour, created_at, updated_at)
                    VALUES
                    (?, ?, 0, 1, 0, CURDATE(), HOUR(NOW()), NOW(), NOW())
                    ON DUPLICATE KEY UPDATE
                    failures=failures+1,updated_at = NOW()";
    }

    private function getErrorQuery(): string
    {
        return "INSERT INTO ping_stats
                    (connect, node_id, successes, failures, errors, datestamp, hour, created_at, updated_at)
                    VALUES
                    (?, ?, 0, 0, 1, CURDATE(), HOUR(NOW()), NOW(), NOW())
                    ON DUPLICATE KEY UPDATE
                    errors=errors+1,updated_at = NOW()";
    }
}
