<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static Normal()
 * @method static static High()
 * @method static static Emergency()
 */
final class PushoverPriority extends Enum
{
    const Normal    = 0;
    const High      = 1;
    const Emergency = 2;
}
