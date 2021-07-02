<?php

namespace App\Models;

use App\Models\QueryBuilders\BatchQueryBuilder;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\Batch
 *
 * @property string      $id
 * @property string      $node_id
 * @property int         $checks_dispatched Number of checks sent to pinger node
 * @property int         $results_received  Number of check results received from check node
 * @property string|null $finished_at       datetime when a pinger nodes has sent back results
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Batch newModelQuery()
 * @method static Builder|Batch newQuery()
 * @method static Builder|Batch query()
 * @method static Builder|Batch whereChecksDispatched($value)
 * @method static Builder|Batch whereCreatedAt($value)
 * @method static Builder|Batch whereFinishedAt($value)
 * @method static Builder|Batch whereId($value)
 * @method static Builder|Batch whereNodeId($value)
 * @method static Builder|Batch whereResultsReceived($value)
 * @method static Builder|Batch whereUpdatedAt($value)
 * @mixin Eloquent
 * @method static Builder|Batch finished()
 * @mixin IdeHelperBatch
 */
class Batch extends Model
{
    public $incrementing = false;

    protected $guarded = [];

    public function newEloquentBuilder($query): BatchQueryBuilder
    {
        return new BatchQueryBuilder($query);
    }
}
