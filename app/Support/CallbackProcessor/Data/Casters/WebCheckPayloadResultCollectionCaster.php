<?php

namespace App\Support\CallbackProcessor\Data\Casters;

use App\Support\CallbackProcessor\Collections\WebCheckPayloadResultCollection;
use App\Support\CallbackProcessor\Data\WebCheckPayloadResult;
use Exception;
use Spatie\DataTransferObject\Caster;

class WebCheckPayloadResultCollectionCaster implements Caster
{
    public function cast(mixed $value): mixed
    {
        if (! is_array($value)) {
            throw new Exception("Can only cast arrays to WebCheckPayloadResultCollection");
        }

        return WebCheckPayloadResultCollection::make($value)
            ->map(fn($result) => new WebCheckPayloadResult(
                id: $result['id'],
                url: $result['url'],
                totalTimeSpentInSeconds: $result['total_time_spent_s'],
                status: (int)$result['success'],
                reason: $result['error'] ?? null,
                failureCount: $result['num_failures'] ?? 0,
                inProgressIdentifier: $result['id'],
            ));
    }
}
