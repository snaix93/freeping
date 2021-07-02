<?php

namespace App\Models;

use App\Enums\WebCheckStatus;
use App\Events\WebCheck\WebCheckCreated;
use App\Events\WebCheck\WebCheckDeleted;
use App\Events\WebCheck\WebCheckUpdated;
use App\Models\Collections\WebCheckResultCollection;
use App\Models\Concerns\HasOptimusId;
use App\Models\Contracts\Checkable;
use BenSampo\Enum\Traits\CastsEnums;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;

/**
 * @mixin IdeHelperWebCheck
 */
class WebCheck extends Model implements Checkable
{
    use HasFactory, CastsEnums, HasOptimusId;

    protected $optimusConnection = 'web-check';

    protected $guarded = [];

    protected $casts = [
        'number_of_recoveries' => 'int',
        'number_of_alerts'     => 'int',
        'number_of_warnings'   => 'int',
        'search_html_source'   => 'bool',
        'status'               => WebCheckStatus::class,
        'nodes_down'           => AsCollection::class,
        'headers'              => AsArrayObject::class,
    ];

    protected $attributes = [
        'status' => WebCheckStatus::AwaitingResult,
    ];

    protected $dates = [
        'last_recovery_at',
        'last_alert_at',
        'last_warning_at',
    ];

    protected $dispatchesEvents = [
        'created' => WebCheckCreated::class,
        'updated' => WebCheckUpdated::class,
        'deleted' => WebCheckDeleted::class,
    ];

    protected static function booted()
    {
        static::creating(function (WebCheck $webCheck) {
            $webCheck->uuid = Str::uuid();
        });
    }

    public function user(): BelongsTo|User
    {
        return $this->belongsTo(User::class);
    }

    public function sslChecks(): HasOne|SslCheck
    {
        return $this->hasOne(SslCheck::class);
    }

    public function webCheckStats(): HasMany|PingStats
    {
        return $this->hasMany(WebCheckStats::class, 'uuid', 'uuid');
    }

    public function isAwaitingResults(): bool
    {
        return $this->status->is(WebCheckStatus::AwaitingResult());
    }

    public function isSuccessful()
    {
        return $this->status->is(WebCheckStatus::Successful());
    }

    public function isFailed()
    {
        return $this->status->is(WebCheckStatus::Failed());
    }

    public function isPartiallyFailed()
    {
        return $this->status->is(WebCheckStatus::PartiallyFailed());
    }

    public function markAsSuccessful()
    {
        return $this->fill([
            'status'     => WebCheckStatus::Successful(),
            'nodes_down' => null,
        ]);
    }

    public function markAsFailed()
    {
        return $this->fill([
            'status'     => WebCheckStatus::Failed(),
            'nodes_down' => null,
        ]);
    }

    public function withNodesDown($nodeIds)
    {
        if (is_null($this->nodes_down)) {
            $this->nodes_down = collect();
        }

        $this->nodes_down->push(...$nodeIds);

        return $this;
    }

    public function markAsPartiallyFailed()
    {
        return $this->fill([
            'status'     => WebCheckStatus::PartiallyFailed(),
            'nodes_down' => null,
        ]);
    }

    public function lastCheckedAt(): ?string
    {
        return $this->webCheckResults()->latest()->first()?->created_at?->format('D, M j Y, H:i T');
    }

    public function webCheckResults(): HasMany|WebCheckResult
    {
        return $this->hasMany(WebCheckResult::class, 'uuid', 'uuid');
    }

    public function getUrlHostAttribute(): string
    {
        $parts = parse_url($this->url);

        return $parts['scheme'].'://'.$parts['host'];
    }

    public function getCheckSettingsAsHtmlString(): HtmlString
    {
        $consoleLine = "<p class='console__line'><span class='console__title'>%s</span><span class='console__body'>%s</span></p>";

        $lines = collect([
            'URL'              => $this->url,
            'Method'           => $this->method,
            'Expected Status'  => "HTTP {$this->expected_http_status}",
            'Expected Pattern' => fn() => $this->expected_pattern ?: false,
            'Search Source'    => function () {
                if (is_null($this->search_html_source)) {
                    return false;
                }

                return $this->search_html_source ? 'yes' : 'no';
            },
        ])
            ->filter(fn($value) => value($value))
            ->reduce(fn($result, $value, $key) => with($result,
                fn(&$result) => $result .= sprintf($consoleLine, $key, value($value))), ''
            );

        return new HtmlString('<div class="console">'.$lines.'<a href="'.route('web-checks').'" class="console__edit-button">edit</a></div>');
    }

    public function getCheckDefinition(): array
    {
        return [
            'URL'              => $this->url,
            'Method'           => $this->method,
            'Expected Status'  => $this->expected_http_status,
            'Expected Pattern' => $this->expected_pattern ?: null,
            'Search Source'    => $this->search_html_source ? 'Yes' : 'No',
        ];
    }
}
