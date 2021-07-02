<?php

namespace App\Models;

use App\Enums\PortStatus;
use App\Enums\TargetStatus;
use App\Models\Collections\PingResultCollection;
use App\Models\Collections\ScanResultCollection;
use App\Models\Concerns\HasOptimusId;
use App\Models\Contracts\Checkable;
use App\Models\QueryBuilders\TargetQueryBuilder;
use BenSampo\Enum\Traits\CastsEnums;
use Database\Factories\TargetFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * @mixin IdeHelperTarget
 */
class Target extends Model implements Checkable
{
    use HasFactory, CastsEnums, HasOptimusId;

    protected $optimusConnection = 'target';

    protected $guarded = [];

    protected $casts = [
        'number_of_recovery_emails_sent' => 'int',
        'number_of_alert_emails_sent'    => 'int',
        'number_of_warning_emails_sent'  => 'int',
        'status'                         => TargetStatus::class,
        'nodes_down'                     => AsCollection::class,
    ];

    protected $attributes = [
        'status' => TargetStatus::AwaitingResult,
    ];

    protected $dates = [
        'last_recovery_sent_at',
        'last_alert_sent_at',
        'last_warning_sent_at',
    ];

    public function newEloquentBuilder($query): TargetQueryBuilder
    {
        return new TargetQueryBuilder($query);
    }

    public function user(): BelongsTo|User
    {
        return $this->belongsTo(User::class);
    }

    public function pingStats(): HasMany|PingStats
    {
        return $this->hasMany(PingStats::class, 'connect', 'connect');
    }

    public function scanStats(): HasMany|ScanStats
    {
        return $this->hasMany(ScanStats::class, 'connect', 'connect');
    }

    public function ports(): HasMany|Port
    {
        return $this->hasMany(Port::class);
    }

    public function isAwaitingResults(): bool
    {
        return $this->status->is(TargetStatus::AwaitingResult());
    }

    public function isOnline(): bool
    {
        return $this->status->is(TargetStatus::Online());
    }

    public function isUnreachable(): bool
    {
        return $this->status->is(TargetStatus::Unreachable());
    }

    public function isPartiallyUnreachable()
    {
        return $this->status->is(TargetStatus::PartiallyUnreachable());
    }

    public function markAsUp()
    {
        return $this->fill([
            'status'     => TargetStatus::Online(),
            'nodes_down' => null,
        ]);
    }

    public function markAsDown()
    {
        return $this->fill([
            'status'     => TargetStatus::Unreachable(),
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

    public function markAsPartiallyUnreachable()
    {
        return $this->fill([
            'status'     => TargetStatus::PartiallyUnreachable(),
            'nodes_down' => null,
        ]);
    }

    public function lastCheckedAt(): ?string
    {
        return $this->pingResults()->latest()->first()->created_at->format('D, M j Y, H:i T');
    }

    public function pingResults(): HasMany|PingResult
    {
        return $this->hasMany(PingResult::class, 'connect', 'connect');
    }

    public function combinedPortStatusForNodeId($nodeId): ?PortStatus
    {
        if ($this->ports->isEmpty()) {
            return null;
        }

        if ($this->pingResults->whereNodeId($nodeId)->allUnreachable()) {
            return PortStatus::Unmonitored();
        }

        $scanResults = ScanResultCollection::make(
            $this->ports->flatMap->scanResults
        )->whereNodeId($nodeId);

        if ($scanResults->isEmpty()) {
            return PortStatus::AwaitingResult();
        }

        if ($scanResults->every->isOpen()) {
            return PortStatus::Open();
        }

        if ($scanResults->every->isClosed()) {
            return PortStatus::Closed();
        }

        return PortStatus::PartiallyClosed();
    }

    public function getCheckDefinition(): array
    {
        return [

        ];
    }
}
