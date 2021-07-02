<?php

namespace App\Actions\Target;

use App\Data\Pinger\CreateTargetData;
use App\Models\Target;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class CreateTargetAction
{
    public function __invoke(User $user, CreateTargetData $createTargetData): Target
    {
        /** @var Target $target */
        return DB::transaction(function () use ($user, $createTargetData) {
            /** @var CreateTargetData $createTargetData */
            return tap($user->targets()->create([
                'connect' => $createTargetData->pingTarget,
            ]), fn(Target $target) => $target->ports()->createMany(
                collect($createTargetData->ports)->map(fn(int $port) => [
                    'connect' => $createTargetData->pingTarget,
                    'port'    => $port,
                    'user_id' => $user->id,
                ])
            ));
        });
    }
}
