<?php /** @noinspection PhpUnused */

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;
use Illuminate\Support\Arr;

/**
 * @method static static AwaitingResult()
 * @method static static Open()
 * @method static static Closed()
 * @method static static PartiallyClosed()
 * @method static static Unmonitored()
 */
final class PortStatus extends Enum implements LocalizedEnum
{
    const AwaitingResult  = 0;
    const Open            = 1;
    const Closed          = 2;
    const PartiallyClosed = 3;
    const Unmonitored     = 4;

    public static function asSelectArray(): array
    {
        return Arr::prepend(parent::asSelectArray(), __('All'), 0);
    }
}
