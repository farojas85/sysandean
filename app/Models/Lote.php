<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lote extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Get the materia_prima that owns the Lote
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function materia_prima(): BelongsTo
    {
        return $this->belongsTo(MateriaPrima::class);
    }

    /**
     * Get all of the pelado_quimicos for the Lote
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pelado_quimicos(): HasMany
    {
        return $this->hasMany(PeladoQuimico::class);
    }

    /**
     * Get all of the rectificados for the Lote
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function rectificados(): HasMany
    {
        return $this->hasMany(Rectificado::class);
    }
}
