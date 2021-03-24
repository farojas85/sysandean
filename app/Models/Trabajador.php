<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
}
