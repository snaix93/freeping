<?php


namespace App\Caches;


class CacheKey
{
    public static function userByOmcToken(string $OmcToken): string
    {
        return md5(__FUNCTION__ . $OmcToken);
    }

    public static function captureAlerts(string $userId, string $captureId): string
    {
        return md5(__FUNCTION__ . $userId . $captureId);
    }

    public static function captureErrors(string $userId, string $captureId): string
    {
        return md5(__FUNCTION__ . $userId . $captureId);
    }

    public static function captureWarnings(string $userId, string $captureId): string
    {
        return md5(__FUNCTION__ . $userId . $captureId);
    }

    public static function captureSubmissionTimestamps(string $userId, string $captureId): string
    {
        return md5(__FUNCTION__ . $userId . $captureId);
    }

    public static function captureInfluxError(string $userId, string $captureId): string
    {
        return md5(__FUNCTION__ . $userId . $captureId);
    }

    public static function captureFieldTypeConflicts(string $userId, string $captureId, string $hostname): string
    {
        return md5(__FUNCTION__ . $userId . $captureId, $hostname);
    }
}
