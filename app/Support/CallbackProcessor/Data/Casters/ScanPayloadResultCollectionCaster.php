<?php

namespace App\Support\CallbackProcessor\Data\Casters;

use App\Enums\ScanResultStatus;
use App\Support\CallbackProcessor\Collections\ScanPayloadResultCollection;
use App\Support\CallbackProcessor\Data\ScanPayloadResult;
use Exception;
use Spatie\DataTransferObject\Caster;

class ScanPayloadResultCollectionCaster implements Caster
{
    public function cast(mixed $value): mixed
    {
        if (! is_array($value)) {
            throw new Exception("Can only cast arrays to ScanPayloadResultCollection");
        }

        return ScanPayloadResultCollection::make($value)->flatMap(function ($result) {
            return collect($result['ports'])->map(function (array $portResult, int $port) use ($result) {
                return new ScanPayloadResult(
                    connect: $result['target'],
                    port: $port,
                    status: ($portResult['state'] === 'open')
                    ? ScanResultStatus::Open
                    : ScanResultStatus::Closed,
                    reason: $portResult['reason'] ?? null,
                    failureCount: $portResult['num_failures'] ?? 0,
                    inProgressIdentifier: $result['target'],
                );
            });
        });
    }
}
