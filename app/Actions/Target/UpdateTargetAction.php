<?php

namespace App\Actions\Target;

use App\Data\Pinger\UpdatePingerData;
use App\Models\Target;
use Illuminate\Support\Facades\DB;

class UpdateTargetAction
{
    public function __invoke(UpdatePingerData $updateTargetData): Target
    {
        return DB::transaction(function () use ($updateTargetData) {
            $updateTargetData->target->ports()->createMany(
                collect($updateTargetData->ports)->map(fn(int $port) => [
                    'connect' => $updateTargetData->target->connect,
                    'port'    => $port,
                    'user_id' => $updateTargetData->user->id,
                ])
            );

            return $updateTargetData->target->refresh();
        });
    }
}
