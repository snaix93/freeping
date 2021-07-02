<?php

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

/**
 * @method static static Fail()
 * @method static static Success()
 */
final class WebCheckResultStatus extends Enum implements LocalizedEnum
{
    const Fail    = 0;
    const Success = 1;

    public static function getDescription($value): string
    {
        return match ($value) {
            self::Success => '✅',
            self::Fail => '❌',
        };
    }
}

