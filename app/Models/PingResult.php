<?php

namespace App\Models;

use App\Enums\PingResultStatus;
use App\Models\Collections\PingResultCollection;
use App\Models\QueryBuilders\PingResultQueryBuilder;
use BenSampo\Enum\Traits\CastsEnums;
use Database\Factories\PingResultFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\PingResult
 *
 * @property int                   $id
 * @property string                $connect
 * @property string                $node_id
 * @property PingResultStatus|null $status
 * @property string|null           $reason
 * @property Carbon|null           $created_at
 * @property Carbon|null           $updated_at
 * @property-read mixed            $ping_time
 * @property-read Node             $node
 * @method static PingResultCollection|static[] all($columns = ['*'])
 * @method static PingResultFactory factory(...$parameters)
 * @method static PingResultCollection|static[] get($columns = ['*'])
 * @method static Builder|PingResult newModelQuery()
 * @method static Builder|PingResult newQuery()
 * @method static Builder|PingResult query()
 * @method static Builder|PingResult whereConnect($value)
 * @method static Builder|PingResult whereCreatedAt($value)
 * @method static Builder|PingResult whereId($value)
 * @method static Builder|PingResult whereNodeId($value)
 * @method static Builder|PingResult whereReason($value)
 * @method static Builder|PingResult whereStatus($value)
 * @method static Builder|PingResult whereUpdatedAt($value)
 * @method static Builder|PingResult withOrderedNodes()
 * @mixin Eloquent
 * @mixin IdeHelperPingResult
 */
class PingResult extends Model
{
    use HasFactory, CastsEnums;

    protected $guarded = [];

    protected $casts = [
        'status' => PingResultStatus::class,
    ];

    protected $with = ['node'];

    public function newCollection(array $models = [])
    {
        return new PingResultCollection($models);
    }

    public function newEloquentBuilder($query): PingResultQueryBuilder
    {
        return new PingResultQueryBuilder($query);
    }

    public function isAlive(): bool
    {
        return $this->status->is(PingResultStatus::Alive());
    }

    public function isUnreachable(): bool
    {
        return $this->status->is(PingResultStatus::Unreachable());
    }

    public function isUnresolvable(): bool
    {
        return $this->status->is(PingResultStatus::Unresolvable());
    }

    /**
     * @return BelongsTo|Node
     */
    public function node()
    {
        return $this->belongsTo(Node::class);
    }

    public function getPingTimeAttribute()
    {
        return $this->created_at->format('H:i:s');
    }
}
