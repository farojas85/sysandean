<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
class Rectificado extends Model
{
    use HasFactory,SoftDeletes;

    /**
     * Get the lote that owns the Rectificado
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function lote(): BelongsTo
    {
        return $this->belongsTo(Lote::class);
    }

    /**
     * Get the trabajador that owns the Rectificado
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function trabajador(): BelongsTo
    {
        return $this->belongsTo(Trabajador::class);
    }
    
}
