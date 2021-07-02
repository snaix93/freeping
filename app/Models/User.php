<?php

namespace App\Models;

use App\Caches\CacheKey;
use App\Enums\PushoverPriority;
use App\Models\Concerns\HasOptimusId;
use App\Models\QueryBuilders\UserQueryBuilder;
use App\Notifications\ResetPasswordNotification;
use App\Notifications\VerifyEmailNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use YlsIdeas\SubscribableNotifications\Contracts\CanUnsubscribe;
use YlsIdeas\SubscribableNotifications\Contracts\CheckSubscriptionStatusBeforeSendingNotifications;
use YlsIdeas\SubscribableNotifications\MailSubscriber;

/**
 * @mixin IdeHelperUser
 */
class User extends Authenticatable implements
    MustVerifyEmail,
    CanUnsubscribe,
    CheckSubscriptionStatusBeforeSendingNotifications
{
    use HasFactory, HasOptimusId, Notifiable, MailSubscriber,
        HasApiTokens, HasProfilePhoto;

    protected $guarded = [];

    protected $optimusConnection = 'user';

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    protected $casts = [
        'registration_track' => 'json',
        'email_verified_at'  => 'datetime',
    ];

    protected $appends = [
        'profile_photo_url',
    ];

    private ?string $currentOmcToken = null;

    public static function byOmcToken(string $omcToken): ?self
    {
        if (is_null($user = self::where(['omc_token' => $omcToken])->first())) {
            return null;
        }
        if ($user->omc_token === $omcToken) {
            return $user;
        }

        return null;
    }

    protected static function booted()
    {
        static::saving(function (User $user) {
            $user->report_time_utc = Carbon::createFromFormat('H:i', $user->report_time)
                ->tz($user->report_offset)
                ->format('H:i');

            // Update the OMC token in the cache
            if (! is_null($user->omc_token) && ! is_null(session('omc_token'))) {
                // Create a new cache entry for the new token
                cache([CacheKey::userByOmcToken($user->omc_token) => (int) $user->id], 3600);
                // Delete the old token from the cache
                Cache::forget(CacheKey::userByOmcToken(session('omc_token')));
                Log::debug('OMC Token Cache Reset',
                    ['user_id' => $user->id, 'old' => session('omc_token'), 'new' => $user->omc_token]);
                // Update the session
                session(['omc_token' => $user->omc_token]);
            }
        });

        static::creating(function (User $user) {
            $user->omc_token = nanoid();
        });

        static::deleting(function (User $user) {
            cache([CacheKey::userByOmcToken($user->omc_token) => null], 0);
        });
    }

    public function newEloquentBuilder($query): UserQueryBuilder
    {
        return new UserQueryBuilder($query);
    }

    public function recipients(): HasMany|Recipient
    {
        return $this->hasMany(Recipient::class);
    }

    public function pushoverRecipient(): HasOne|Pushover
    {
        return $this->hasOne(Pushover::class)->withDefault(function (Pushover $pushover) {
            $pushover->meta['priority'] = PushoverPriority::Normal();
        });
    }

    public function targets(): HasMany|Target
    {
        return $this->hasMany(Target::class);
    }

    public function webChecks(): HasMany|WebCheck
    {
        return $this->hasMany(WebCheck::class);
    }

    public function sslChecks(): HasMany|SslCheck
    {
        return $this->hasMany(SslCheck::class);
    }

    public function pulses(): HasMany|Pulse
    {
        return $this->hasMany(Pulse::class);
    }

    public function problems(): HasMany|Problem
    {
        return $this->hasMany(Problem::class);
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmailNotification);
    }

    public function routeNotificationForPushover()
    {
        return $this->pushoverRecipient->pushover_key;
    }

    public function enabledSslAlerts():bool{
        return 0 !== $this->ssl_alert_threshold;
    }
    public function enabledSslWarnings():bool{
        return 0 !== $this->ssl_warning_threshold;
    }
}
