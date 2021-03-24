<?php

namespace App\Http\Traits;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

use App\Models\Trabajador;

trait TrabajadorTrait
{
    public function todos(Request $request)
    {
        $buscar = mb_strtoupper($request->buscar);
        return Trabajador::with('tipo_documento:id,nombre_corto')
                    ->select(
                        'id','tipo_documento_id','numero_documento',
                        'nombres','apellidos','fecha_nacimiento','lugar_nacimiento','deleted_at',
                        DB::Raw("case
                                    when estado = 0 then 'Inactivo'
                                    when estado = 1 then 'Activo'
                                end as estado_nombre"),
                        DB::Raw("case
                                when estado = 0 then 'badge bage-secondary'
                                when estado = 1 then 'badge badge-success'
                            end as estado_clase")
                        )
                    ->where(function($query) use($buscar){
                        $query->where(DB::Raw("upper(nombres)"),'like','%'.$buscar.'%')
                            ->orWhere(DB::Raw("upper(apellidos)"),'like','%'.$buscar.'%');
                    })
                    ->withTrashed()->paginate($request->pagina);
    }
    public function habilitados(Request $request)
    {
        $buscar = mb_strtoupper($request->buscar);
        return Trabajador::with('tipo_documento:id,nombre_corto')
                ->select(
                    'id','tipo_documento_id','numero_documento',
                    'nombres','apellidos','fecha_nacimiento','lugar_nacimiento','deleted_at',
                    DB::Raw("case
                                when estado = 0 then 'Inactivo'
                                when estado = 1 then 'Activo'
                            end as estado_nombre"),
                    DB::Raw("case
                            when estado = 0 then 'badge bage-secondary'
                            when estado = 1 then 'badge badge-success'
                        end as estado_clase")
                    )
                ->where(function($query) use($buscar){
                    $query->where(DB::Raw("upper(nombres)"),'like','%'.$buscar.'%')
                        ->orWhere(DB::Raw("upper(apellidos)"),'like','%'.$buscar.'%');
                })
                ->paginate($request->pagina);
    }

    public function eliminados(Request $request)
    {
        $buscar = mb_strtoupper($request->buscar);
        return Trabajador::with('tipo_documento:id,nombre_corto')
                ->select(
                    'id','tipo_documento_id','numero_documento',
                    'nombres','apellidos','fecha_nacimiento','lugar_nacimiento','deleted_at',
                    DB::Raw("case
                                when estado = 0 then 'Inactivo'
                                when estado = 1 then 'Activo'
                            end as estado_nombre"),
                    DB::Raw("case
                            when estado = 0 then 'badge bage-secondary'
                            when estado = 1 then 'badge badge-success'
                        end as estado_clase")
                    )
                ->where(function($query) use($buscar){
                    $query->where(DB::Raw("upper(nombres)"),'like','%'.$buscar.'%')
                        ->orWhere(DB::Raw("upper(apellidos)"),'like','%'.$buscar.'%');
                })
                ->onlyTrashed()->paginate($request->pagina);
    }

    public function guardarTrabajador(Request $request)
    {
        $reglas = [];

        if($request->estadoCrud == 'nuevo')
        {
            $reglas=[
                'tipo_documento_id' =>'required',
                'numero_documento' =>'required|unique:trabajadores',
                'nombres' =>'required|string|max:191',
                'apellidos' =>'required|string|max:191'
            ];

        } else {
            $reglas=[
                'tipo_documento_id' =>'required',
                'numero_documento' =>'required|unique:trabajadores,id',
                'nombres' =>'required|string|max:191',
                'apellidos' =>'required|string|max:191'
            ];
        }
        
        $mensaje = [
            'required' =>'* Campo Obligatorio',
            'unique' =>'Dato ya Existe',
            'max' => 'Ingrese máximo :max caracteres'
        ];

        $this->validate($request,$reglas,$mensaje);

        $trabajador = null;


        if($request->estadoCrud == 'nuevo')
        {
            $trabajador = Trabajador::create([
                'tipo_documento_id' => $request->tipo_documento_id,
                'numero_documento' => $request->numero_documento,
                'nombres' =>$request->nombres,
                'apellidos' =>$request->apellidos,
                'fecha_nacimiento' =>$request->fecha_nacimiento,
                'lugar_nacimiento' =>$request->lugar_nacimiento,
                'estado' => 1
            ]);
            
            return response()->json([
                'ok'=> 1,
                'mensaje' => 'Trabajador Registrado Satisfactoriamente' 
            ],200);
        } 

        $trabajador = Trabajador::findOrFail($request->id);

        $trabajador->tipo_documento_id = $request->tipo_documento_id;
        $trabajador->numero_documento = $request->numero_documento;
        $trabajador->nombres = $request->nombres;
        $trabajador->apellidos = $request->apellidos;
        $trabajador->fecha_nacimiento = $request->fecha_nacimiento;
        $trabajador->lugar_nacimiento = $request->lugar_nacimiento;
        $trabajador->estado = $request->estado;
        $trabajador->save();
        
        return response()->json([
            'ok'=> 1,
            'mensaje' => 'Datos del Trabajador modificados Satisfactoriamente' 
        ],200);
    }
}