<?php


namespace App\Events\Monitoring;


use App\Data\Events\DefectEventData;
use App\Data\Events\MonitoringEventData;
use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Defect
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public User $user;

    /**
     * DefectEvent constructor.
     * A defect is an internal error that stops the monitoring completely or partially.
     * Usually the user must resolve the defect manually.
     * @param User|int $user instance of a User Model or a user id
     * @param DefectEventData $defectEvent
     * @param int $throttling Skip processing repeated defects for N hours
     */
    public function __construct(User|int $user, public DefectEventData $defectEvent, public int $throttling = 8)
    {
        if (is_int($user)) {
            $this->user = User::whereId($user)->firstOrFail();
        } else {
            $this->user = $user;
        }
    }
}
