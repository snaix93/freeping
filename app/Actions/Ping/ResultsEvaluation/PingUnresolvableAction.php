<?php

namespace App\Actions\Ping\ResultsEvaluation;

use App\Models\Target;
use App\Notifications\Ping\TargetUnresolvableNotification;

class PingUnresolvableAction
{
    public function __invoke(Target $target)
    {
        $target->user->notify(new TargetUnresolvableNotification($target, $target->pingResults));
        $target->delete();
    }
}
