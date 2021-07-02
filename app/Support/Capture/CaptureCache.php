<?php


namespace App\Support\Capture;


use App\Caches\CacheKey;
use App\Data\ItemComparison;
use App\Data\Omc\CaptureData;
use App\Support\Items;
use Illuminate\Support\Facades\Cache;

class CaptureCache
{
    public ?int $avgUpdateInterval = null; // Seconds

    public function __construct(public CaptureData $captureData)
    {

    }

    public function hasFieldTypeConflicts(): bool
    {
        return Cache::get(CacheKey::captureFieldTypeConflicts(
            $this->captureData->userId,
            $this->captureData->captureId,
            $this->captureData->hostname
        ), false);
    }

    public function store(): void
    {
        $this->storeProblems();
        $this->updateSubmissionTimestamps();
    }

    public function alertsDiff(): ItemComparison
    {
        return Items::compare(
            $this->captureData->alerts,
            Cache::get(CacheKey::captureAlerts($this->captureData->userId, $this->captureData->captureId), [])
        );
    }

    public function warningsDiff(): ItemComparison
    {
        return Items::compare(
            $this->captureData->warnings,
            Cache::get(CacheKey::captureWarnings($this->captureData->userId, $this->captureData->captureId), [])
        );
    }

    public function problemsDiff(): array
    {
        return [
            'alert'   => $this->alertsDiff(),
            'warning' => $this->warningsDiff(),
        ];
    }

    public function getSubmissionTimestamp(): array
    {
        $cacheKey = CacheKey::captureSubmissionTimestamps($this->captureData->userId, $this->captureData->captureId);

        return Cache::get($cacheKey, []);
    }

    public function storeInfluxError(string $message): void
    {
        Cache::put(CacheKey::captureInfluxError($this->captureData->userId, $this->captureData->captureId), $message);
    }

    public function setHasFieldTypeConflicts(bool $value): void
    {
        Cache::put(CacheKey::captureFieldTypeConflicts(
            $this->captureData->userId,
            $this->captureData->captureId,
            $this->captureData->hostname
        ), true);
    }

    private function storeProblems(): void
    {
        Cache::put(
            CacheKey::captureAlerts($this->captureData->userId, $this->captureData->captureId),
            $this->captureData->alerts
        );
        Cache::put(
            CacheKey::captureWarnings($this->captureData->userId, $this->captureData->captureId),
            $this->captureData->warnings
        );
        Cache::put(
            CacheKey::captureErrors($this->captureData->userId, $this->captureData->captureId),
            $this->captureData->errors
        );
    }

    /**
     * Maintain the last 11 timestamps of when a capture has sent data in the cache.
     * This allows auto-computing the usual update interval.
     */
    private function updateSubmissionTimestamps(): void
    {
        $cacheKey = CacheKey::captureSubmissionTimestamps($this->captureData->userId, $this->captureData->captureId);
        $timestamps = Cache::get($cacheKey, []);
        $timestamps[] = time();
        rsort($timestamps, SORT_NUMERIC);
        $timestamps = array_slice($timestamps, 0, 11);
        Cache::put($cacheKey, $timestamps);
    }
}
