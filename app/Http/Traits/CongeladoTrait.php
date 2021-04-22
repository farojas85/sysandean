<?php

namespace App\Http\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\Congelado;

trait CongeladoTrait
{
    public function habilitados(Request $request)
    {
        $buscar = mb_strtoupper($request->buscar);
        return Congelado::with(
                        'lote:id,nombre,maduros',
                        'trabajador:id,nombres,apellidos',
                        'lote.pelado_quimicos',
                        'lote.plaqueados')
                    ->select(
                        'id','lote_id','kilogramo_congelado','observacion','trabajador_id','deleted_at',
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
        return Congelado::with(
                        'lote:id,nombre,maduros',
                        'trabajador:id,nombres,apellidos',
                        'lote.pelado_quimicos',
                        'lote.plaqueados')
                    ->select(
                        'id','lote_id','kilogramo_congelado','observacion','trabajador_id','deleted_at',
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
        return Congelado::with(
                        'lote:id,nombre,maduros',
                        'trabajador:id,nombres,apellidos',
                        'lote.pelado_quimicos',
                        'lote.plaqueados')
                    ->select(
                        'id','lote_id','kilogramo_congelado','observacion','trabajador_id','deleted_at',
                        DB::Raw("DATE_FORMAT(fecha_registro,'%d/%m/%Y') as fecha")
                    )
                    ->whereHas('lote',function($query) use($buscar){
                        $query->where(DB::Raw("upper(nombre)"),'like','%'.$buscar.'%');
                    })
                ->onlyTrashed()->paginate($request->pagina);
    }

    public function guardarCongelado(Request $request)
    {
        
        $reglas=[
            'lote_id' => 'required',
            'kilogramo_congelado' => 'required',
            'fecha_registro' => 'required',
            'trabajador_id' => 'required'
         ];
        
        $mensaje = [
            'required' =>'* Campo Obligatorio'
        ];

        $this->validate($request,$reglas,$mensaje);

        if($request->estadoCrud == 'nuevo')
        {
            $congelado = new Congelado();
            $congelado->lote_id = $request->lote_id;
            $congelado->kilogramo_congelado = $request->kilogramo_congelado;
            $congelado->observacion = $request->observacion;
            $congelado->fecha_registro = $request->fecha_registro;
            $congelado->trabajador_id= $request->trabajador_id;
            $congelado->usuario_crea = Auth::user()->id;
            $congelado->save();

            return response()->json([
                'ok' => 1,
                'mensaje' => 'Congelado Registrado Satisfactoriamente'
            ],200);
        }

        $congelado = Congelado::findOrFail($request->id);
        $congelado->lote_id = $request->lote_id;
        $congelado->kilogramo_congelado = $request->kilogramo_congelado;
        $congelado->observacion = $request->observacion;
        $congelado->fecha_registro = $request->fecha_registro;
        $congelado->trabajador_id= $request->trabajador_id;
        $congelado->usuario_modifica = Auth::user()->id;
        $congelado->save();

        return response()->json([
            'ok' => 1,
            'mensaje' => 'Congelado Modificado Satisfactoriamente'
        ],200);
    }

    public function obtenerCongeladoPorLote(Request $request)
    {
        return Congelado::with(
                    'lote:id,nombre,maduros',
                    'trabajador:id,nombres,apellidos',
                    'lote.pelado_quimicos',
                    'lote.plaqueados')
                ->select(
                    'id','lote_id','kilogramo_congelado','observacion','trabajador_id','deleted_at',
                    DB::Raw("DATE_FORMAT(fecha_registro,'%d/%m/%Y') as fecha")
                )
                ->where('lote_id',$request->lote)->paginate(5);
    }
}