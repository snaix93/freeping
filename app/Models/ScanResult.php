<?php

namespace App\Models;

use App\Enums\ScanResultStatus;
use App\Models\Collections\ScanResultCollection;
use App\Models\QueryBuilders\ScanResultQueryBuilder;
use Awobaz\Compoships\Compoships;
use BenSampo\Enum\Traits\CastsEnums;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @mixin IdeHelperScanResult
 */
class ScanResult extends Model
{
    use HasFactory, Compoships, CastsEnums;

    protected $guarded = [];

    protected $with = ['node'];

    protected $casts = [
        'status' => ScanResultStatus::class,
    ];

    public function newCollection(array $models = [])
    {
        return new ScanResultCollection($models);
    }

    public function newEloquentBuilder($query): ScanResultQueryBuilder
    {
        return new ScanResultQueryBuilder($query);
    }

    public function isOpen(): bool
    {
        return $this->status->is(ScanResultStatus::Open());
    }

    public function isClosed(): bool
    {
        return $this->status->is(ScanResultStatus::Closed());
    }

    public function node(): BelongsTo|Node
    {
        return $this->belongsTo(Node::class);
    }

    public function getScanTimeAttribute()
    {
        return $this->created_at->format('H:i:s');
    }
}
