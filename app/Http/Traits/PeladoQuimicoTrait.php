<?php

namespace App\Http\Traits;

use App\Http\Controllers\MateriaPrimaController;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

use App\Models\PeladoQuimico;

trait PeladoQuimicoTrait
{
    public function habilitados(Request $request)
    {
        $buscar = mb_strtoupper($request->buscar);
        return PeladoQuimico::with('lote:id,nombre,maduros')->select(
                    'id','lote_id','kilogramo','observacion','deleted_at',
                    DB::Raw("DATE_FORMAT(fecha_registro,'%d/%m/%Y') as fecha")
                )
                ->whereHas('lote',function($query) use($buscar){
                    $query->where(DB::Raw("upper(nombre)"),'like','%'.$buscar.'%');
                })
                ->paginate($request->pagina);
    }

    public function todos(Request $request)
    {
        $buscar = mb_strtoupper($request->buscar);
        return PeladoQuimico::with('lote:id,nombre,maduros')->select(
                        'id','lote_id','kilogramo','observacion','deleted_at',
                        DB::Raw("DATE_FORMAT(fecha_registro,'%d/%m/%Y') as fecha")
                    )
                    ->whereHas('lote',function($query) use($buscar){
                        $query->where(DB::Raw("upper(nombre)"),'like','%'.$buscar.'%');
                    })
                    ->withTrashed()->paginate($request->pagina);
    }

    public function eliminados(Request $request)
    {
        $buscar = mb_strtoupper($request->buscar);
        return PeladoQuimico::with('lote:id,nombre,maduros')->select(
                    'id','lote_id','kilogramo','observacion','deleted_at',
                    DB::Raw("DATE_FORMAT(fecha_registro,'%d/%m/%Y') as fecha")
                )
                ->whereHas('lote',function($query) use($buscar){
                    $query->where(DB::Raw("upper(nombre)"),'like','%'.$buscar.'%');
                })
                ->onlyTrashed()->paginate($request->pagina);
    }
    
    public function guardarPeladoQuimico(Request $request)
    {
        $reglas=[
            'lote_id' => 'required',
            'kilogramo' => 'required',
            'fecha_registro' => 'required'
         ];
        
        $mensaje = [
            'required' =>'* Campo Obligatorio'
        ];

        $this->validate($request,$reglas,$mensaje);

        if($request->estadoCrud == 'nuevo')
        {
            $peladoQuimico = new PeladoQuimico();
            $peladoQuimico->lote_id = $request->lote_id;
            $peladoQuimico->kilogramo = $request->kilogramo;
            $peladoQuimico->observacion = $request->observacion;
            $peladoQuimico->fecha_registro = $request->fecha_registro;
            $peladoQuimico->usuario_crea = Auth::user()->id;
            $peladoQuimico->save();

            return response()->json([
                'ok' => 1,
                'mensaje' => 'Pelado Químico Registrado Satisfactoriamente'
            ],200);
        }

        $peladoQuimico = PeladoQuimico::findOrFail($request->id);
        $peladoQuimico->lote_id = $request->lote_id;
        $peladoQuimico->kilogramo = $request->kilogramo;
        $peladoQuimico->observacion = $request->observacion;
        $peladoQuimico->fecha_registro = $request->fecha_registro;
        $peladoQuimico->usuario_modifica = Auth::user()->id;
        $peladoQuimico->save();

        return response()->json([
            'ok' => 1,
            'mensaje' => 'Pelado Químico Modificado Satisfactoriamente'
        ],200);

    }

}