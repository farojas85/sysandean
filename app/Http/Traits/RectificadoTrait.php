<?php

namespace App\Http\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\Rectificado;

trait RectificadoTrait
{
    public function habilitados(Request $request)
    {
        $buscar = mb_strtoupper($request->buscar);
        return Rectificado::with(
                        'lote:id,nombre,maduros',
                        'trabajador:id,nombres,apellidos',
                        'lote.pelado_quimicos')
                    ->select(
                        'id','lote_id','kilogramo_rectificado','observacion','trabajador_id','deleted_at',
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
        return Rectificado::with(
                        'lote:id,nombre,maduros',
                        'trabajador:id,nombres,apellidos',
                        'lote.pelado_quimicos')
                    ->select(
                        'id','lote_id','kilogramo_rectificado','observacion','trabajador_id','deleted_at',
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
        return Rectificado::with(
                        'lote:id,nombre,maduros',
                        'trabajador:id,nombres,apellidos',
                        'lote.pelado_quimicos')
                    ->select(
                        'id','lote_id','kilogramo_rectificado','observacion','trabajador_id','deleted_at',
                        DB::Raw("DATE_FORMAT(fecha_registro,'%d/%m/%Y') as fecha")
                    )
                    ->whereHas('lote',function($query) use($buscar){
                        $query->where(DB::Raw("upper(nombre)"),'like','%'.$buscar.'%');
                    })
                ->onlyTrashed()->paginate($request->pagina);
    }

    public function guardarRectificado(Request $request)
    {
        
        $reglas=[
            'lote_id' => 'required',
            'kilogramo_rectificado' => 'required',
            'fecha_registro' => 'required',
            'trabajador_id' => 'required'
         ];
        
        $mensaje = [
            'required' =>'* Campo Obligatorio'
        ];

        $this->validate($request,$reglas,$mensaje);

        if($request->estadoCrud == 'nuevo')
        {
            $rectificado = new Rectificado();
            $rectificado->lote_id = $request->lote_id;
            $rectificado->kilogramo_rectificado = $request->kilogramo_rectificado;
            $rectificado->observacion = $request->observacion;
            $rectificado->fecha_registro = $request->fecha_registro;
            $rectificado->trabajador_id= $request->trabajador_id;
            $rectificado->usuario_crea = Auth::user()->id;
            $rectificado->save();

            return response()->json([
                'ok' => 1,
                'mensaje' => 'Pelado Químico Registrado Satisfactoriamente'
            ],200);
        }

        $rectificado = Rectificado::findOrFail($request->id);
        $rectificado->lote_id = $request->lote_id;
        $rectificado->kilogramo_rectificado = $request->kilogramo_rectificado;
        $rectificado->observacion = $request->observacion;
        $rectificado->fecha_registro = $request->fecha_registro;
        $rectificado->trabajador_id= $request->trabajador_id;
        $rectificado->usuario_modifica = Auth::user()->id;
        $rectificado->save();

        return response()->json([
            'ok' => 1,
            'mensaje' => 'Pelado Químico Modificado Satisfactoriamente'
        ],200);
    }

    public function obtenerRectificadoPorLote(Request $request)
    {
        return Rectificado::with(
                    'lote:id,nombre,maduros',
                    'trabajador:id,nombres,apellidos',
                    'lote.pelado_quimicos')
                ->select(
                    'id','lote_id','kilogramo_rectificado','observacion','trabajador_id','deleted_at',
                    DB::Raw("DATE_FORMAT(fecha_registro,'%d/%m/%Y') as fecha")
                )
                ->where('lote_id',$request->lote)->paginate(5);
    }
}