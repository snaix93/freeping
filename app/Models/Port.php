<?php

namespace App\Models;

use App\Enums\PortStatus;
use App\Models\Contracts\Checkable;
use App\Support\PortService;
use Awobaz\Compoships\Compoships;
use Awobaz\Compoships\Database\Eloquent\Relations\HasMany;
use BenSampo\Enum\Traits\CastsEnums;
use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @mixin IdeHelperPort
 */
class Port extends Model implements Checkable
{
    use HasFactory, CastsEnums, Compoships;

    protected $guarded = [];

    protected $casts = [
        'port'                 => 'int',
        'number_of_recoveries' => 'int',
        'number_of_alerts'     => 'int',
        'number_of_warnings'   => 'int',
        'status'               => PortStatus::class,
        'nodes_down'           => AsCollection::class,
    ];

    protected $attributes = [
        'status' => PortStatus::AwaitingResult,
    ];

    protected $dates = [
        'last_recovery_at',
        'last_alert_at',
        'last_warning_at',
    ];

    public function target(): BelongsTo|Target
    {
        return $this->belongsTo(Target::class);
    }

    public function scanResults(): HasMany|ScanResult
    {
        return $this->hasMany(ScanResult::class, ['port', 'connect'], ['port', 'connect']);
    }

    public function lastCheckedAt(): ?string
    {
        return $this->scanResults()->latest()->first()->created_at->format('D, M j Y, H:i T');
    }

    public function isAwaitingResults(): bool
    {
        return $this->status->is(PortStatus::AwaitingResult());
    }

    public function isOpen(): bool
    {
        return $this->status->is(PortStatus::Open());
    }

    public function isClosed(): bool
    {
        return $this->status->is(PortStatus::Closed());
    }

    public function isPartiallyClosed()
    {
        return $this->status->is(PortStatus::PartiallyClosed());
    }

    public function markAsOpen()
    {
        return $this->fill([
            'status'     => PortStatus::Open(),
            'nodes_down' => null,
        ]);
    }

    public function markAsClosed()
    {
        return $this->fill([
            'status'     => PortStatus::Closed(),
            'nodes_down' => null,
        ]);
    }

    public function markAsPartiallyClosed()
    {
        return $this->fill([
            'status'     => PortStatus::PartiallyClosed(),
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

    public function portWithService(): string
    {
        return (string) PortService::forPort($this->port);
    }

    public function getCheckDefinition(): array
    {
        return [

        ];
    }
}
