<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @mixin IdeHelperScanStats
 */
class ScanStats extends Model
{
    use HasFactory;

    public function node(): BelongsTo|Node
    {
        return $this->belongsTo(Node::class);
    }
}
