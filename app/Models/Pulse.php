<?php

namespace App\Models;

use App\Data\Omc\PulseData;
use App\Enums\PulseStatus;
use App\Models\Concerns\HasOptimusId;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

/**
 * @mixin IdeHelperPulse
 */
class Pulse extends Model
{
    use HasFactory, HasOptimusId;

    protected $optimusConnection = 'pulse';

    protected $guarded = [];

    protected $casts = [
        'status' => PulseStatus::class,
    ];

    protected $dates = [
        'last_pulse_received_at',
        'alerted_at',
    ];

    public static function store(PulseData $pulseData)
    {
        DB::insert(
            "INSERT INTO pulses (user_id,hostname,description,location,status,last_user_agent,last_remote_address,created_at,last_pulse_received_at)
                    VALUES(:userId, :hostname, :description, :location, :status, :userAgent, :remoteAddress, NOW(), NOW())
                    ON DUPLICATE KEY UPDATE last_pulse_received_at=NOW(), description=:Udescription, location=:Ulocation,last_user_agent=:UuserAgent,last_remote_address=:UremoteAddress",
            [
                'userId'         => $pulseData->userId,
                'hostname'       => $pulseData->hostname,
                'description'    => $pulseData->description,
                'Udescription'   => $pulseData->description,
                'location'       => $pulseData->location,
                'Ulocation'      => $pulseData->location,
                'status'         => PulseStatus::Alive(),
                'userAgent'      => $pulseData->userAgent,
                'UuserAgent'     => $pulseData->userAgent,
                'remoteAddress'  => $pulseData->remoteAddress,
                'UremoteAddress' => $pulseData->remoteAddress,
            ]);
    }

    public function user(): BelongsTo|User
    {
        return $this->belongsTo(User::class);
    }

    public function markAlerted(string $eventId): void
    {
        $this->update([
            'alerted_at' => Carbon::now(),
            'status'     => PulseStatus::Lost(),
            'event_id'   => $eventId,
        ]);
    }

    public function unmarkAlerted()
    {
        $this->update([
            'alerted_at' => null,
            'status'     => PulseStatus::Alive(),
            'event_id'   => null,
        ]);
    }
}
