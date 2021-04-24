<?php

namespace App\Http\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\Almacenado;

trait AlmacenadoTrait
{
    public function habilitados(Request $request)
    {
        $buscar = mb_strtoupper($request->buscar);
        return Almacenado::with(
                        'lote:id,nombre,maduros',
                        'trabajador:id,nombres,apellidos',
                        'lote.pelado_quimicos',
                        'lote.envasados')
                    ->select(
                        'id','lote_id','cajas','peso_caja','observacion','trabajador_id','deleted_at',
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
        return Almacenado::with(
                        'lote:id,nombre,maduros',
                        'trabajador:id,nombres,apellidos',
                        'lote.pelado_quimicos',
                        'lote.envasados')
                    ->select(
                        'id','lote_id','cajas','observacion','trabajador_id','deleted_at',
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
        return Almacenado::with(
                        'lote:id,nombre,maduros',
                        'trabajador:id,nombres,apellidos',
                        'lote.pelado_quimicos',
                        'lote.envasados')
                    ->select(
                        'id','lote_id','cajas','observacion','trabajador_id','deleted_at',
                        DB::Raw("DATE_FORMAT(fecha_registro,'%d/%m/%Y') as fecha")
                    )
                    ->whereHas('lote',function($query) use($buscar){
                        $query->where(DB::Raw("upper(nombre)"),'like','%'.$buscar.'%');
                    })
                ->onlyTrashed()->paginate($request->pagina);
    }

    public function guardarAlmacenado(Request $request)
    {
        
        $reglas=[
            'lote_id' => 'required',
            'cajas' => 'required',
            'peso_caja' => 'required',
            'fecha_registro' => 'required',
            'trabajador_id' => 'required'
         ];
        
        $mensaje = [
            'required' =>'* Campo Obligatorio'
        ];

        $this->validate($request,$reglas,$mensaje);

        if($request->estadoCrud == 'nuevo')
        {
            $almacenado = new Almacenado();
            $almacenado->lote_id = $request->lote_id;
            $almacenado->cajas = $request->cajas;
            $almacenado->peso_caja = $request->peso_caja;
            $almacenado->observacion = $request->observacion;
            $almacenado->fecha_registro = $request->fecha_registro;
            $almacenado->trabajador_id= $request->trabajador_id;
            $almacenado->usuario_crea = Auth::user()->id;
            $almacenado->save();

            return response()->json([
                'ok' => 1,
                'mensaje' => 'El Almacenado ha sido Registrado Satisfactoriamente'
            ],200);
        }

        $almacenado = Almacenado::findOrFail($request->id);
        $almacenado->lote_id = $request->lote_id;
        $almacenado->cajas = $request->cajas;
        $almacenado->peso_caja = $request->peso_caja;
        $almacenado->observacion = $request->observacion;
        $almacenado->fecha_registro = $request->fecha_registro;
        $almacenado->trabajador_id= $request->trabajador_id;
        $almacenado->usuario_modifica = Auth::user()->id;
        $almacenado->save();

        return response()->json([
            'ok' => 1,
            'mensaje' => 'El Almacenado ha sido Modificado Satisfactoriamente'
        ],200);
    }

    public function obtenerAlmacenadoPorLote(Request $request)
    {
        return Almacenado::with(
                    'lote:id,nombre,maduros',
                    'trabajador:id,nombres,apellidos',
                    'lote.pelado_quimicos',
                    'lote.envasados')
                ->select(
                    'id','lote_id','cajas','observacion','peso_caja','trabajador_id','deleted_at',
                    DB::Raw("DATE_FORMAT(fecha_registro,'%d/%m/%Y') as fecha")
                )
                ->where('lote_id',$request->lote)->paginate($request->pagina);
    }
}