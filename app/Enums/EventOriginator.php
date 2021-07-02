<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static Ping()
 * @method static static WebCheck()
 * @method static static PortCheck()
 * @method static static Pulse()
 * @method static static Capture()
 * @method static static SslCheck()
 */
final class EventOriginator extends Enum
{
    const Ping = 'Ping';
    const WebCheck = 'WebCheck';
    const PortCheck = 'PortCheck';
    const Pulse = 'Pulse';
    const Capture = 'Capture';
    const SslCheck = 'SslCheck';
}
