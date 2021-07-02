<?php

namespace App\Actions\WebCheck;

use App\Enums\WebCheckResultStatus;
use App\Support\CallbackProcessor\Data\WebCheckPayload;
use App\Support\CallbackProcessor\Data\WebCheckPayloadResult;
use Illuminate\Support\Facades\DB;

class LogWebCheckStatisticsAction
{
    public function __invoke(
        WebCheckPayloadResult $webCheckPayloadResult,
        WebCheckPayload $payload
    ): bool {
        $query = $webCheckPayloadResult->status->is(WebCheckResultStatus::Success())
            ? $this->getSuccessQuery()
            : $this->getErrorQuery();

        return DB::insert($query, [
            $webCheckPayloadResult->id,
            $payload->nodeId,
        ]);
    }

    private function getSuccessQuery()
    {
        return "INSERT INTO web_check_stats
                    (uuid, node_id, successes, errors, datestamp, hour, created_at, updated_at)
                    VALUES
                    (?, ?, 1, 0, CURDATE(), HOUR(NOW()), NOW(), NOW())
                    ON DUPLICATE KEY UPDATE
                    successes=successes+1,updated_at = NOW()";
    }

    private function getErrorQuery()
    {
        return "INSERT INTO web_check_stats
                     (uuid, node_id, successes, errors, datestamp, hour, created_at, updated_at)
                    VALUES
                     (?, ?, 0, 1, CURDATE(), HOUR(NOW()), NOW(), NOW())
                    ON DUPLICATE KEY UPDATE
                    errors=errors+1,updated_at = NOW()";
    }
}
