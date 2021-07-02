<?php


namespace App\Data\Events;


use App\Enums\EventOriginator;
use Illuminate\Support\Arr;
use Spatie\DataTransferObject\DataTransferObject;

class DefectEventData extends DataTransferObject
{

    public bool $userActionNeeded = false;
    public string $description;
    public EventOriginator $originator;
    public ?string $userAction = null;
    public ?string $defectId = null;
    public string $connect;

    public static function create(EventOriginator $originator, array $input): self
    {
        return new self([
            'originator'       => $originator,
            'userActionNeeded' => Arr::get($input, 'userActionNeeded', false),
            'description'      => $input['description'],
            'userAction'       => 'fix it',
            'connect'          => $input['connect'],
        ]);
    }
}
