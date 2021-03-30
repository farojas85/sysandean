<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Rectificado extends Model
{
    use HasFactory;

    /**
     * Get the lote that owns the Rectificado
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function lote(): BelongsTo
    {
        return $this->belongsTo(Lote::class);
    }
}
