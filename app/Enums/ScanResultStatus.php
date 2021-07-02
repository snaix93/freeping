<?php

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

/**
 * @method static static Closed()
 * @method static static Open()
 */
final class ScanResultStatus extends Enum implements LocalizedEnum
{
    const Closed = 0;
    const Open   = 1;

    public static function getDescription($value): string
    {
        return match ($value) {
            self::Open => '✅',
            self::Closed => '❌',
        };
    }
}

