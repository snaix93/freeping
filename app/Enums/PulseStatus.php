<?php /** @noinspection PhpUnused */

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

/**
 * @method static static Alive()
 * @method static static Lost()
 */
final class PulseStatus extends Enum implements LocalizedEnum
{
    const Alive = 1;
    const Lost  = 0;
}
