<?php

namespace App\Http\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\Envasado;

trait EnvasadoTrait
{
    public function habilitados(Request $request)
    {
        $buscar = mb_strtoupper($request->buscar);
        return Envasado::with(
                        'lote:id,nombre,maduros',
                        'trabajador:id,nombres,apellidos',
                        'lote.pelado_quimicos',
                        'lote.congelados')
                    ->select(
                        'id','lote_id','kilogramo_envasado','observacion','trabajador_id','deleted_at',
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
        return Envasado::with(
                        'lote:id,nombre,maduros',
                        'trabajador:id,nombres,apellidos',
                        'lote.pelado_quimicos',
                        'lote.congelados')
                    ->select(
                        'id','lote_id','kilogramo_envasado','observacion','trabajador_id','deleted_at',
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
        return Envasado::with(
                        'lote:id,nombre,maduros',
                        'trabajador:id,nombres,apellidos',
                        'lote.pelado_quimicos',
                        'lote.congelados')
                    ->select(
                        'id','lote_id','kilogramo_envasado','observacion','trabajador_id','deleted_at',
                        DB::Raw("DATE_FORMAT(fecha_registro,'%d/%m/%Y') as fecha")
                    )
                    ->whereHas('lote',function($query) use($buscar){
                        $query->where(DB::Raw("upper(nombre)"),'like','%'.$buscar.'%');
                    })
                ->onlyTrashed()->paginate($request->pagina);
    }

    public function guardarEnvasado(Request $request)
    {
        
        $reglas=[
            'lote_id' => 'required',
            'kilogramo_envasado' => 'required',
            'fecha_registro' => 'required',
            'trabajador_id' => 'required'
         ];
        
        $mensaje = [
            'required' =>'* Campo Obligatorio'
        ];

        $this->validate($request,$reglas,$mensaje);

        if($request->estadoCrud == 'nuevo')
        {
            $envasado = new Envasado();
            $envasado->lote_id = $request->lote_id;
            $envasado->kilogramo_envasado = $request->kilogramo_envasado;
            $envasado->observacion = $request->observacion;
            $envasado->fecha_registro = $request->fecha_registro;
            $envasado->trabajador_id= $request->trabajador_id;
            $envasado->usuario_crea = Auth::user()->id;
            $envasado->save();

            return response()->json([
                'ok' => 1,
                'mensaje' => 'El Envasado ha sido Registrado Satisfactoriamente'
            ],200);
        }

        $envasado = Envasado::findOrFail($request->id);
        $envasado->lote_id = $request->lote_id;
        $envasado->kilogramo_envasado = $request->kilogramo_envasado;
        $envasado->observacion = $request->observacion;
        $envasado->fecha_registro = $request->fecha_registro;
        $envasado->trabajador_id= $request->trabajador_id;
        $envasado->usuario_modifica = Auth::user()->id;
        $envasado->save();

        return response()->json([
            'ok' => 1,
            'mensaje' => 'El Envasado ha sido Modificado Satisfactoriamente'
        ],200);
    }

    public function obtenerEnvasadoPorLote(Request $request)
    {
        return Envasado::with(
                    'lote:id,nombre,maduros',
                    'trabajador:id,nombres,apellidos',
                    'lote.pelado_quimicos',
                    'lote.congelados')
                ->select(
                    'id','lote_id','kilogramo_envasado','observacion','trabajador_id','deleted_at',
                    DB::Raw("DATE_FORMAT(fecha_registro,'%d/%m/%Y') as fecha")
                )
                ->where('lote_id',$request->lote)->paginate(5);
    }
}