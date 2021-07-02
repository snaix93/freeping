<?php

namespace App\Support\CallbackProcessor\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static Scan()
 * @method static static Ping()
 * @method static static WebCheck()
 */
final class JobType extends Enum
{
    const Scan     = 'scan';
    const Ping     = 'ping';
    const WebCheck = 'webcheck';
}
