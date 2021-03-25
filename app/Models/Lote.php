<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
}
