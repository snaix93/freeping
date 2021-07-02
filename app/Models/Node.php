<?php

namespace App\Models;

use Database\Factories\NodeFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\Node
 *
 * @property string      $id
 * @property string      $name
 * @property string      $request_token
 * @property string      $callback_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Node newModelQuery()
 * @method static Builder|Node newQuery()
 * @method static Builder|Node query()
 * @method static Builder|Node whereCallbackToken($value)
 * @method static Builder|Node whereCreatedAt($value)
 * @method static Builder|Node whereId($value)
 * @method static Builder|Node whereName($value)
 * @method static Builder|Node whereRequestToken($value)
 * @method static Builder|Node whereUpdatedAt($value)
 * @mixin Eloquent
 * @property string      $url
 * @method static Builder|Node whereUrl($value)
 * @property string      $short_name
 * @method static Builder|Node whereShortName($value)
 * @property string|null $country
 * @method static NodeFactory factory(...$parameters)
 * @method static Builder|Node whereCountry($value)
 * @mixin IdeHelperNode
 */
class Node extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $guarded = [];
}
