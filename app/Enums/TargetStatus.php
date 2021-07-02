<?php /** @noinspection PhpUnused */

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;
use Illuminate\Support\Arr;

/**
 * @method static static AwaitingResult()
 * @method static static Online()
 * @method static static Unreachable()
 * @method static static PartiallyUnreachable()
 */
final class TargetStatus extends Enum implements LocalizedEnum
{
    const AwaitingResult       = 0;
    const Online               = 1;
    const Unreachable          = 2;
    const PartiallyUnreachable = 3;

    public static function asSelectArray(): array
    {
        return Arr::prepend(parent::asSelectArray(), __('All'), 0);
    }
}
