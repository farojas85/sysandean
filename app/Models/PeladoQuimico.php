<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PeladoQuimico extends Model
{
    use HasFactory, SoftDeletes;
    /**
     * Get the lote that owns the PeladoQuimico
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function lote(): BelongsTo
    {
        return $this->belongsTo(Lote::class);
    }
}
