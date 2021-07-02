<?php

namespace App\Actions\Scan;

use App\Enums\ScanResultStatus;
use App\Support\CallbackProcessor\Data\ScanPayload;
use App\Support\CallbackProcessor\Data\ScanPayloadResult;
use Illuminate\Support\Facades\DB;

class LogScanStatisticsAction
{
    public function __invoke(ScanPayloadResult $scanPayloadResult, ScanPayload $payload): bool
    {
        $query = $scanPayloadResult->status->is(ScanResultStatus::Open())
            ? $this->getSuccessQuery()
            : $this->getFailureQuery();

        return DB::insert($query, [
            $scanPayloadResult->connect,
            $scanPayloadResult->port,
            $payload->nodeId,
        ]);
    }

    private function getSuccessQuery()
    {
        return "INSERT INTO scan_stats
                    (connect, port, node_id, successes, failures, datestamp, hour, created_at, updated_at)
                    VALUES
                    (?, ?, ?, 1, 0, CURDATE(), HOUR(NOW()), NOW(), NOW())
                    ON DUPLICATE KEY UPDATE
                    successes=successes+1,updated_at = NOW()";
    }

    private function getFailureQuery()
    {
        return "INSERT INTO scan_stats
                    (connect, port, node_id, successes, failures, datestamp, hour, created_at, updated_at)
                    VALUES
                    (?, ?, ?, 0, 1, CURDATE(), HOUR(NOW()), NOW(), NOW())
                    ON DUPLICATE KEY UPDATE
                    failures=failures+1,updated_at = NOW()";
    }
}
