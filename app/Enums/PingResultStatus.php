<?php

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

/**
 * @method static static Unresolvable()
 * @method static static Unreachable()
 * @method static static Alive()
 */
final class PingResultStatus extends Enum implements LocalizedEnum
{
    const Unreachable  = 0;
    const Alive        = 1;
    const Unresolvable = 2;

    public static function getDescription($value): string
    {
        return match ($value) {
            self::Alive => '✅',
            self::Unreachable, self::Unresolvable => '❌',
        };
    }
}

