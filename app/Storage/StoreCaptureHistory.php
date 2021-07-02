<?php


namespace App\Storage;


use App\Actions\Capture\HandleFieldTypeConflictAction;
use App\Exceptions\InfluxFieldTypeConflictException;
use App\Support\Capture\CaptureCache;
use Illuminate\Support\Facades\Log;
use InfluxDB2\Point;

class StoreCaptureHistory extends InfluxStorage
{
    public function __construct()
    {
        parent::__construct('captureHistory');
    }

    public function __invoke(CaptureCache $captureCache)
    {
        if (false === $captureCache->captureData->storeHistory) {
            return; // Stop here, because the user has indicated not storing a history.
        }
        if ($captureCache->hasFieldTypeConflicts()) {
            return; // Stop here, the user must resolve the conflict first
        }
        $measurement = $captureCache->captureData->captureId . ':' . $captureCache->captureData->userId;
        Log::debug('Writing to Influx', [$measurement]);
        $point = Point::measurement($measurement)->addTag('hostname', $captureCache->captureData->hostname);
        foreach ($captureCache->captureData->measurements as $key => $value) {
            // We convert all numbers to decimals to be less error prone.
            if (is_numeric($value)) $value = (float)$value;
            $point->addField($key, $value);
        }
        try {
            $this->write($point);
        } catch (InfluxFieldTypeConflictException $exception) {
            Log::debug('FieldTypeConflict', (array)$exception->getMessage());
            (new HandleFieldTypeConflictAction)($captureCache->captureData, $exception->getMessage());
            $captureCache->setHasFieldTypeConflicts(true);
        }
    }
}
