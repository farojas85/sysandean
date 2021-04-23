<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Trabajador extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'trabajadores';

    protected $fillable=[
        'id','tipo_documento_id','numero_documento','nombres',
        'apellidos','fecha_nacimiento','lugar_nacimiento','estado'
    ];

    /**
     * Get the user that owns the Trabajador
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tipo_documento(): BelongsTo
    {
        return $this->belongsTo(TipoDocumento::class);
    }

    /**
     * Get all of the rectificados for the Trabajador
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function rectificados(): HasMany
    {
        return $this->hasMany(Rectificado::class);
    }

    /**
     * Get all of the plaqueados for the Trabajador
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function plaqueados(): HasMany
    {
        return $this->hasMany(Plaqueado::class);
    }

    /**
     * Get all of the congelados for the Trabajador
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function congelados(): HasMany
    {
        return $this->hasMany(Congelado::class);
    }

    /**
     * Get all of the envasados for the Trabajador
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function envasados(): HasMany
    {
        return $this->hasMany(Envasado::class);
    }
}
