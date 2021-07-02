<?php


namespace App\Events\Monitoring;


use App\Data\Events\MonitoringEventData;
use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

abstract class MonitoringEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public User $user;

    /**
     * MonitoringEvent constructor.
     * @param User|int $user instance of a User Model or a user id
     * @param MonitoringEventData $monitoringEvent
     */
    public function __construct(User|int $user, public MonitoringEventData $monitoringEvent)
    {
        if(is_int($user)) {
            $this->user = User::whereId($user)->firstOrFail();
        }
        else {
            $this->user = $user;
        }
    }
}
