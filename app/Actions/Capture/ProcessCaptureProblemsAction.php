<?php


namespace App\Actions\Capture;


use App\Data\Events\MonitoringEventData;
use App\Data\ItemComparison;
use App\Data\Omc\CaptureData;
use App\Enums\EventOriginator;
use App\Events\Monitoring\Problem;
use App\Events\Monitoring\Recovery;
use App\Support\Capture\CaptureCache;
use Illuminate\Support\Facades\Log;

/**
 * Class ProcessCaptureProblem.
 * Takes the existing problems and computes new and resolved problems.
 * Fires problems or recovery notifications.
 * @package App\Actions\Capture
 */
class ProcessCaptureProblemsAction
{
    private CaptureData $captureData;

    public function __invoke(CaptureCache $captureCache): void
    {
        $captureData = $captureCache->captureData;
        $this->captureData = $captureData;
        // Fetch the latest problems (warnings and alerts) from the cache and look for changes
        foreach ($captureCache->problemsDiff() as $severity => $problems) {
            // Process all new problems (alerts and warnings)
            /** @var $problems ItemComparison */
            collect($problems->new)->each(function ($message, $key) use ($severity, $captureData) {
                Log::debug('New Problem', [$severity, $message]);
                $problemEvent = MonitoringEventData::create(EventOriginator::Capture(), [
                    'eventId'      => $this->eventId($severity, $message),
                    'connect'      => $captureData->hostname,
                    'severity'     => $severity,
                    'type'         => 'Capture ' . $captureData->captureId,
                    'description'  => sprintf('%s [Capture: %s]', $message, $captureData->captureId),
                    'meta'         => [
                        'message'         => $message,
                        'when'            => $captureData->date->diffForHumans(),
                        'problemReceived' => $captureData->date,
                    ],
                    'measurements' => $captureData->measurements,
                ]);
                event(new Problem($captureData->userId, $problemEvent));
            });
            // Process all problems (alerts and warnings) that no longer exist
            collect($problems->gone)->each(function ($message, $key) use ($severity, $captureData) {
                Log::debug('Recovery', [$severity, $message]);
                $recoveryEvent = MonitoringEventData::create(EventOriginator::Capture(), [
                    'eventId'      => $this->eventId($severity, $message),
                    'connect'      => $captureData->hostname,
                    'severity'     => $severity,
                    'type'         => 'Capture ' . $captureData->captureId,
                    'description'  => sprintf('%s [Capture: %s]', $message, $captureData->captureId),
                    'meta'         => [
                        'message'          => $message,
                        'when'             => $captureData->date->diffForHumans(),
                        'problemRecovered' => $captureData->date,
                    ],
                    'measurements' => $captureData->measurements,
                ]);
                event(new Recovery($captureData->userId, $recoveryEvent));
            });
        }
    }

    private function eventId(string $severity, string $message): string
    {
        return md5(
            $this->captureData->hostname .
            $this->captureData->userId .
            $this->captureData->captureId .
            $severity .
            $message
        );
    }
}
