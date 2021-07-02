<?php

namespace App\Data\Events;

use App\Enums\EventOriginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Spatie\DataTransferObject\DataTransferObject;

class MonitoringEventData extends DataTransferObject
{
    public string $eventId;

    public string $originator;

    public string $connect; // The host or URL the event belongs to

    public string $severity; // Alert or Warning

    public string $type;

    public string $description; // What has happened

    public array $meta;

    public ?array $measurements;

    public ?array $checkDefinition;

    public static function create(EventOriginator $originator, array $input): self
    {
        return new self([
            'eventId'         => str_pad(Arr::get($input, 'eventId', Str::uuid()), 36, '0'),
            'originator'      => $originator->key,
            'connect'         => $input['connect'],
            'type'            => Arr::get($input, 'type', 'Problem'),
            'severity'        => Arr::get($input, 'severity', 'Alert'),
            'description'     => Arr::get($input, 'description', 'unknown'),
            'meta'            => Arr::get($input, 'meta', []),
            'measurements'    => Arr::get($input, 'measurements'),
            'checkDefinition' => Arr::get($input, 'checkDefinition'),
        ]);
    }
}
