<?php


namespace App\Data\Omc;


use Carbon\Carbon;
use Spatie\DataTransferObject\DataTransferObject;

class PulseHost extends DataTransferObject
{
    public string $hostname;
    public ?string $description = null;
    public ?string $location = null;
    public int $userId;
    public string $lastUserAgent;
    public string $lastRemoteAddress;
    public int $pulseThreshold;
    public Carbon $lastPulseReceivedAt;

    public static function fromPulseProcess(\stdClass $data)
    {
        return new self ([
            'hostname'            => (string)$data->hostname,
            'description'         => (string)$data->description,
            'location'            => (string)$data->location,
            'userId'              => (int)$data->user_id,
            'lastUserAgent'       => (string)$data->last_user_agent,
            'lastRemoteAddress'   => (string)$data->last_remote_address,
            'pulseThreshold'      => (int)$data->pulse_threshold,
            'lastPulseReceivedAt' => new Carbon($data->last_pulse_received_at),
        ]);
    }
}
