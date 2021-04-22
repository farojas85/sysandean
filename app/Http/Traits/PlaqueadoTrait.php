<?php

namespace App\Http\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\Plaqueado;

trait PlaqueadoTrait
{
    public function habilitados(Request $request)
    {
        $buscar = mb_strtoupper($request->buscar);
        return Plaqueado::with(
                        'lote:id,nombre,maduros',
                        'trabajador:id,nombres,apellidos',
                        'lote.rectificados')
                    ->select(
                        'id','lote_id','kilogramo_plaqueado','observacion','trabajador_id','deleted_at',
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
        return Plaqueado::with(
                        'lote:id,nombre,maduros',
                        'trabajador:id,nombres,apellidos',
                        'lote.restificados')
                    ->select(
                        'id','lote_id','kilogramo_plaqueado','observacion','trabajador_id','deleted_at',
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
        return Plaqueado::with(
                        'lote:id,nombre,maduros',
                        'trabajador:id,nombres,apellidos',
                        'lote.rectificados')
                    ->select(
                        'id','lote_id','kilogramo_plaqueado','observacion','trabajador_id','deleted_at',
                        DB::Raw("DATE_FORMAT(fecha_registro,'%d/%m/%Y') as fecha")
                    )
                    ->whereHas('lote',function($query) use($buscar){
                        $query->where(DB::Raw("upper(nombre)"),'like','%'.$buscar.'%');
                    })
                ->onlyTrashed()->paginate($request->pagina);
    }

    public function guardarPlaqueado(Request $request)
    {
        
        $reglas=[
            'lote_id' => 'required',
            'kilogramo_plaqueado' => 'required',
            'fecha_registro' => 'required',
            'trabajador_id' => 'required'
         ];
        
        $mensaje = [
            'required' =>'* Campo Obligatorio'
        ];

        $this->validate($request,$reglas,$mensaje);

        if($request->estadoCrud == 'nuevo')
        {
            $plaqueado = new Plaqueado();
            $plaqueado->lote_id = $request->lote_id;
            $plaqueado->kilogramo_plaqueado = $request->kilogramo_plaqueado;
            $plaqueado->observacion = $request->observacion;
            $plaqueado->fecha_registro = $request->fecha_registro;
            $plaqueado->trabajador_id= $request->trabajador_id;
            $plaqueado->usuario_crea = Auth::user()->id;
            $plaqueado->save();

            return response()->json([
                'ok' => 1,
                'mensaje' => 'Plaqueado Registrado Satisfactoriamente'
            ],200);
        }

        $plaqueado = Plaqueado::findOrFail($request->id);
        $plaqueado->lote_id = $request->lote_id;
        $plaqueado->kilogramo_plaqueado = $request->kilogramo_plaqueado;
        $plaqueado->observacion = $request->observacion;
        $plaqueado->fecha_registro = $request->fecha_registro;
        $plaqueado->trabajador_id= $request->trabajador_id;
        $plaqueado->usuario_modifica = Auth::user()->id;
        $plaqueado->save();

        return response()->json([
            'ok' => 1,
            'mensaje' => 'Plaqueado Modificado Satisfactoriamente'
        ],200);
    }

    public function obtenerPlaqueadoPorLote(Request $request)
    {
        return Plaqueado::with(
                    'lote:id,nombre,maduros',
                    'trabajador:id,nombres,apellidos',
                    'lote.rectificados')
                ->select(
                    'id','lote_id','kilogramo_plaqueado','observacion','trabajador_id','deleted_at',
                    DB::Raw("DATE_FORMAT(fecha_registro,'%d/%m/%Y') as fecha")
                )
                ->where('lote_id',$request->lote)->paginate(5);
    }
}