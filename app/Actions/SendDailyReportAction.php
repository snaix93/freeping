<?php

namespace App\Actions;

use App\Models\User;
use App\Notifications\DailyReportNotification;
use Illuminate\Database\Eloquent\Builder;

class SendDailyReportAction
{
    public function __invoke(?User $user = null, bool $shouldSendNow = false)
    {
        User::query()
            ->verified()
            ->when($user, fn(Builder $query) => $query->where('id', $user->id))
            ->unless($user, fn(User|Builder $query) => $query->didntJoinToday())
            ->unless($shouldSendNow, function (Builder $query) {
                return $query->where('report_time_utc', now()->utc()->floorHour()->format('H:i'));
            })
            ->whereHas('targets')
            ->whereHas('targets.pingStats')
            ->each(function (User $user) {
                $user->notify(new DailyReportNotification(
                    resolve(BuildReportDataAction::class)($user)
                ));
            });
    }
}
