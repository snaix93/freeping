<?php

namespace App\Models;

use App\Enums\RecipientMediaType;
use App\Models\Concerns\HasMeta;
use App\Models\Concerns\HasTraitsWithCasts;
use App\Notifications\Contracts\AlertNotification;
use App\Notifications\Contracts\RecoveryNotification;
use App\Notifications\Contracts\WarningNotification;
use Assert\Assert;
use BenSampo\Enum\Traits\CastsEnums;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Parental\HasChildren;

/**
 * @mixin IdeHelperRecipient
 */
class Recipient extends Model
{
    use HasFactory, CastsEnums, HasChildren, HasTraitsWithCasts, HasMeta;

    public static $notificationTypes = [
        AlertNotification::class    => 'alerts',
        WarningNotification::class  => 'warnings',
        RecoveryNotification::class => 'recoveries',
    ];

    protected $guarded = [];

    protected $dates = [
        'verified_at',
    ];

    protected $casts = [
        'alerts'     => 'bool',
        'warnings'   => 'bool',
        'recoveries' => 'bool',
    ];

    protected $childTypes = [
        RecipientMediaType::Pushover => Pushover::class,
    ];

    public function wantsNotificationOfType(string $notificationType): bool
    {
        Assert::that($notificationType)->string()->inArray(static::$notificationTypes);

        if ($this->$notificationType) {
            return true;
        }

        return false;
    }
}
