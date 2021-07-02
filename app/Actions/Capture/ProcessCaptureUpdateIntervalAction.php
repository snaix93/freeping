<?php


namespace App\Actions\Capture;


use App\Models\Capture;
use App\Support\Capture\CaptureCache;
use Illuminate\Support\Facades\Log;

/**
 * Class ProcessCaptureUpdateIntervalAction
 * Auto-compute the update interval base on the timestamps of the last X submission
 * @package App\Actions\Capture
 */
class ProcessCaptureUpdateIntervalAction
{
    public function __invoke(CaptureCache $captureCache, Capture $capture): void
    {
        $timestamps = $captureCache->getSubmissionTimestamp();
        if (count($timestamps) != 10) {
            return; // End here. We act only on the tenths submission
        }
        foreach ($timestamps as $index => $timestamp) {
            if ($index === 0) {
                $previous = $timestamp;
                continue;
            }
            $intervals[] = $previous - $timestamp;
            $previous = $timestamp;
        }
        $updateInterval = (int)round(array_sum($intervals) / count($intervals), 0);
        Log::debug('Auto-computed an update interval', ['capture' => $captureCache->captureData->captureId, 'interval' => $updateInterval]);
        $capture::where([
            'user_id'         => $captureCache->captureData->userId,
            'capture_id'      => $captureCache->captureData->captureId,
            'update_interval' => null, //Only update those captures where the update_interval is not set yet.
        ])->update(['update_interval' => $updateInterval]);
    }
}
