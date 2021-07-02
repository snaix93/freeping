<?php


namespace App\Actions\Capture;


use App\Data\Events\DefectEventData;
use App\Data\Omc\CaptureData;
use App\Enums\EventOriginator;
use App\Events\Monitoring\Defect;
use App\Models\Capture;

class HandleFieldTypeConflictAction
{
    public function __invoke(CaptureData $captureData, string $errorMessage)
    {
        $errorMessage = str_replace(
            [' on measurement ', 'dropped=1', 'failure writing points to database: partial write:', ':' . $captureData->userId],
            [' on capture ', '', '', ''],
            $errorMessage);
        (new Capture())::where([
            'user_id'    => $captureData->userId,
            'capture_id' => $captureData->captureId,
            'hostname'   => $captureData->hostname,
        ])->update(['last_defects' => (array)$errorMessage]);
        event(new Defect($captureData->userId,
            DefectEventData::create(EventOriginator::Capture(),
                [
                    'id'          => md5($captureData->userId . $captureData->hostname . $captureData->captureId),
                    'title'       => 'Field type conflict',
                    'description' => $errorMessage,
                    'connect'     => $captureData->hostname,
                    'meta'        => [
                        'hostname' => $captureData->hostname,
                        'capture'  => $captureData->captureId,
                    ],
                ]
            )
        ));
    }
}
