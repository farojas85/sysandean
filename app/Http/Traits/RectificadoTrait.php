<?php

namespace App\Http\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Rectificado;

trait RectificadoTrait
{
    public function habilitados(Request $request)
    {
        $buscar = mb_strtoupper($request->buscar);
        return Rectificado::with('lote:id,nombre,maduros')->select(
                        'id','lote_id','kilogramo','observacion','deleted_at',
                        DB::Raw("DATE_FORMAT(fecha_registro,'%d/%m/%Y') as fecha")
                    )
                    ->whereHas('lote',function($query) use($buscar){
                        $query->where(DB::Raw("upper(nombre)"),'like','%'.$buscar.'%');
                    })
                ->paginate($request->pagina);
    }
}