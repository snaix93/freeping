<?php

namespace App\Actions;

use App\Actions\Target\CreateTargetAction;
use App\Actions\WebCheck\CreateWebChecksAction;
use App\Collections\WebCheckDataCollection;
use App\Data\Pinger\CreateTargetData;
use App\Models\User;
use App\Notifications\MultiChecksCreatedNotification;
use Illuminate\Support\Facades\DB;

class CreateMultiChecksAction
{
    public function __construct(
        private CreateTargetAction $createTargetAction,
        private CreateWebChecksAction $createWebChecksAction,
    ) { }

    public function __invoke(
        User $user,
        CreateTargetData $targetData,
        WebCheckDataCollection $webCheckDataCollection
    ): void {
        [$target, $webChecks] = DB::transaction(
            fn() => $this->createChecks($user, $targetData, $webCheckDataCollection)
        );

        $user->notify(new MultiChecksCreatedNotification($target, $webChecks));
    }

    private function createChecks(
        User $user,
        CreateTargetData $targetData,
        WebCheckDataCollection $webCheckDataCollection
    ): array {
        $target = ($this->createTargetAction)($user, $targetData);
        $webChecks = ($this->createWebChecksAction)($user, $webCheckDataCollection);

        return [$target, $webChecks];
    }
}
