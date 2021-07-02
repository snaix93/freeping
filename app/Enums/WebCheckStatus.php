<?php /** @noinspection PhpUnused */

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;
use Illuminate\Support\Arr;

/**
 * @method static static AwaitingResult()
 * @method static static Successful()
 * @method static static Failed()
 * @method static static PartiallyFailed()
 */
final class WebCheckStatus extends Enum implements LocalizedEnum
{
    const AwaitingResult  = 0;
    const Successful      = 1;
    const Failed          = 2;
    const PartiallyFailed = 3;

    public static function asSelectArray(): array
    {
        return Arr::prepend(parent::asSelectArray(), __('All'), 0);
    }
}
