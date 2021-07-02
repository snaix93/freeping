<?php

namespace App\Models;

use App\Enums\WebCheckResultStatus;
use App\Models\Collections\WebCheckResultCollection;
use App\Models\QueryBuilders\WebCheckResultQueryBuilder;
use BenSampo\Enum\Traits\CastsEnums;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @mixin IdeHelperWebCheckResult
 */
class WebCheckResult extends Model
{
    use HasFactory, CastsEnums;

    protected $guarded = [];

    protected $casts = [
        'status' => WebCheckResultStatus::class,
    ];

    protected $with = ['node'];

    public function newCollection(array $models = [])
    {
        return new WebCheckResultCollection($models);
    }

    public function newEloquentBuilder($query): WebCheckResultQueryBuilder
    {
        return new WebCheckResultQueryBuilder($query);
    }

    public function isSuccessful(): bool
    {
        return $this->status->is(WebCheckResultStatus::Success());
    }

    public function isFailed(): bool
    {
        return $this->status->is(WebCheckResultStatus::Fail());
    }

    public function node(): BelongsTo|Node
    {
        return $this->belongsTo(Node::class);
    }

    public function getCheckTimeAttribute()
    {
        return $this->created_at->format('H:i:s');
    }
}
