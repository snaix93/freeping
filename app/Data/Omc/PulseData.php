<?php


namespace App\Data\Omc;


use App\Http\Requests\PulseRequest;
use Spatie\DataTransferObject\DataTransferObject;

class PulseData extends DataTransferObject
{
    public string $hostname;
    public string $userId;
    public ?string $userAgent;
    public ?string $location;
    public ?string $description;
    public string $remoteAddress;

    public static function fromStoreRequest(PulseRequest $request): self
    {
        return new self([
            'hostname'      => strtolower($request->input('hostname')),
            'description'   => (string)$request->input('description'),
            'location'      => (string)$request->input('location'),
            'userId'        => $request->getUserId(),
            'userAgent'     => $request->userAgent(),
            'remoteAddress' => (string)$request->ip() // @Todo: Look for X-Forwarded for
        ]);
    }
}
