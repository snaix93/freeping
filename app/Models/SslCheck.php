<?php

namespace App\Models;

use App\Enums\SslCertificateStatus;
use App\Events\SslCheck\SslCheckCreated;
use App\Models\Concerns\HasOptimusId;
use App\Models\Contracts\Checkable;
use BenSampo\Enum\Traits\CastsEnums;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

/**
 * @mixin IdeHelperSslCheck
 */
class SslCheck extends Model implements Checkable
{
    use CastsEnums, HasFactory, HasOptimusId;

    protected $optimusConnection = 'ssl-check';

    protected $guarded = [];

    protected $dispatchesEvents = [
        'created' => SslCheckCreated::class,
    ];

    protected $casts = [
        'certificate_status'     => SslCertificateStatus::class,
        'last_check_received_at' => 'datetime',
        'certificate_expires_at' => 'datetime',
        'alerted_at'             => 'datetime',
        'warned_at'              => 'datetime',
    ];

    protected static function booted()
    {
        static::creating(function (SslCheck $sslCheck) {
            $sslCheck->uuid = Str::uuid();
        });
    }


    public function user(): BelongsTo|User
    {
        return $this->belongsTo(User::class);
    }


    public function webCheck(): BelongsTo|SslCheck
    {
        return $this->belongsTo(SslCheck::class);
    }

    public function hasActiveAlert(): bool
    {
        return !is_null($this->alerted_at);
    }

    public function hasActiveWarning(): bool
    {
        return !is_null($this->warned_at);
    }

    public function getCheckDefinition(): array
    {
        return [
            'Host' => $this->host,
            'Port' => $this->port,
        ];
    }
}
