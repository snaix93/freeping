<?php

namespace App\Support;

class Backdoor
{
    private const KEY = 'backdoor-open';

    public static function open()
    {
        session([static::KEY => true]);
    }

    public static function close()
    {
        session()->forget(static::KEY);
    }

    public static function isClosed(): bool
    {
        return ! static::isOpen();
    }

    public static function isOpen(): bool
    {
        return session()->has(static::KEY);
    }
}
