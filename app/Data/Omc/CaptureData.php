<?php


namespace App\Data\Omc;


use App\Http\Requests\CaptureRequest;
use Carbon\Carbon;
use Spatie\DataTransferObject\DataTransferObject;

class CaptureData extends DataTransferObject
{
    public string $hostname;
    public int $userId;
    public ?string $userAgent;
    public string $remoteAddress;
    public ?array $alerts = null;
    public ?array $warnings = null;
    public ?array $measurements = null;
    public ?array $errors = null;
    public int $contentLength;
    public int $numMeasurements;
    public string $captureId;
    public Carbon $date;
    public bool $storeHistory = true;

    public static function fromStoreRequest(CaptureRequest $request): self
    {
        if ('json' === $request->getContentType()) {
            // Json data has a measurement object
            $measurements = $request->input('measurements');
        } else {
            // Form data is flat so we take everything except the following reserved keys as measurements.
            $measurements = array_diff_key($request->input(), [
                'alerts'   => 1,
                'warnings' => 1,
                'hostname' => 1,
                'id'       => 1,
            ]);
        }

        return new self([
            'userId'          => $request->getUserId(),
            'hostname'        => strtolower($request->input('hostname')),
            'captureId'       => (string)$request->input('id'),
            'userAgent'       => $request->userAgent(),
            'remoteAddress'   => (string)$request->ip(), // @Todo: Look for X-Forwarded for
            'contentLength'   => (int)$request->header('content-length', 0),
            'alerts'          => (array)$request->input('alerts'),
            'warnings'        => (array)$request->input('warnings'),
            'measurements'    => $measurements,
            'numMeasurements' => count($measurements),
            'date'            => Carbon::now(),
            'storeHistory'    => (bool)$request->input('store_history', true),
        ]);
    }
}
