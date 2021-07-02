<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @mixin IdeHelperProblem
 */
class Problem extends Model
{
    use HasFactory;

    public $casts = [
        'meta'             => 'json',
        'check_definition' => 'json',
    ];

    protected $guarded = [];

    public function user(): BelongsTo|User
    {
        return $this->belongsTo(User::class);
    }
}
