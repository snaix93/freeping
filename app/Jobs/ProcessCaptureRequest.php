<?php

namespace App\Jobs;

use App\Actions\Capture\ProcessCaptureProblemsAction;
use App\Actions\Capture\ProcessCaptureUpdateIntervalAction;
use App\Data\Omc\CaptureData;
use App\Models\Capture;
use App\Storage\StoreCaptureHistory;
use App\Support\Capture\CaptureCache;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProcessCaptureRequest implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(private CaptureData $captureData)
    {
    }

    public function handle(Capture $capture)
    {
        Log::debug("Processing Capture request", [$this->captureData->hostname, $this->captureData->captureId]);
        $captureCache = new CaptureCache($this->captureData);
        // Process all problems (alerts and warnings) included in the capture data. Sends problem notifications and recoveries
        (new ProcessCaptureProblemsAction)($captureCache);
        // Store the latest errors, warnings and alerts in the cache
        $captureCache->store();
        // Process the update interval
        (new ProcessCaptureUpdateIntervalAction)($captureCache, $capture);
        // Update only the latest data of the capture in the database, no history is stored to MySQL
        $capture::store($this->captureData);
        // Store the measurements history in Influx (Historical data storage)
        (new StoreCaptureHistory)($captureCache);
    }
}
