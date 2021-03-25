<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MateriaPrima extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = ['id','nombre','descripcion'];

    /**
     * Get all of the lotes for the MateriaPrima
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function lotes(): HasMany
    {
        return $this->hasMany(Lote::class,);
    }
}
