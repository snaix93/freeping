<?php

namespace App\Support\CallbackProcessor\Data\Casters;

use App\Enums\PingResultStatus;
use App\Support\CallbackProcessor\Collections\PingPayloadResultCollection;
use App\Support\CallbackProcessor\Data\PingPayloadResult;
use Exception;
use Spatie\DataTransferObject\Caster;

class PingPayloadResultCollectionCaster implements Caster
{
    public function cast(mixed $value): mixed
    {
        if (! is_array($value)) {
            throw new Exception("Can only cast arrays to PingPayloadResultCollection");
        }

        return PingPayloadResultCollection::make($value)
            ->map(fn($result) => new PingPayloadResult(
                connect: $result['target'],
                status: $result['success'] ?? PingResultStatus::Unresolvable,
                reason: $result['error'] ?? null,
                failureCount: $result['num_failures'] ?? 0,
                inProgressIdentifier: $result['target'],
            ));
    }
}
