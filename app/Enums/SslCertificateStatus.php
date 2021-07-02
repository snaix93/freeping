<?php


namespace App\Enums;


use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;
use Illuminate\Support\Arr;

/**
 * @method static static AwaitingResult()
 * @method static static Valid()
 * @method static static Expired()
 */
final class SslCertificateStatus extends Enum implements LocalizedEnum
{
    const AwaitingResult = 0;
    const Valid = 1;
    const Expired = 2;

    public static function asSelectArray(): array
    {
        return Arr::prepend(parent::asSelectArray(), __('All'), 0);
    }
}
