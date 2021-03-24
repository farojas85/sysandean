<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class TipoDocumento extends Model
{
    use HasFactory;

    protected $fillable = [
        'id','tipo','nombre_corto','nombre_largo','longitud'
    ];

    /**
     * Get all of the comments for the TipoDocumento
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function trabajadores(): HasMany
    {
        return $this->hasMany(Trabajador::class);
    }
}
