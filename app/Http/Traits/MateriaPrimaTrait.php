<?php

namespace App\Http\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use App\Models\MateriaPrima;

trait MateriaPrimaTrait
{
    public function todos(Request $request)
    {
        $buscar = mb_strtoupper($request->buscar);
        return MateriaPrima::select(
                        'id','nombre','descripcion','deleted_at',
                        DB::Raw("DATE_FORMAT(created_at,'%d/%m/%Y') as fecha_creada"),
                        DB::Raw("DATE_FORMAT(updated_at,'%d/%m/%Y') as fecha_modificada")
                        )
                    ->where(function($query) use($buscar){
                        $query->where(DB::Raw("upper(nombre)"),'like','%'.$buscar.'%')
                            ->orWhere(DB::Raw("upper(descripcion)"),'like','%'.$buscar.'%');
                    })
                    ->withTrashed()->paginate($request->pagina);
    }
    public function habilitados(Request $request)
    {
        $buscar = mb_strtoupper($request->buscar);
        return MateriaPrima::select(
                    'id','nombre','descripcion','deleted_at',
                    DB::Raw("DATE_FORMAT(created_at,'%d/%m/%Y') as fecha_creada"),
                    DB::Raw("DATE_FORMAT(updated_at,'%d/%m/%Y') as fecha_modificada")
                    )
                ->where(function($query) use($buscar){
                    $query->where(DB::Raw("upper(nombre)"),'like','%'.$buscar.'%')
                        ->orWhere(DB::Raw("upper(descripcion)"),'like','%'.$buscar.'%');
                })
                ->paginate($request->pagina);
    }

    public function eliminados(Request $request)
    {
        $buscar = mb_strtoupper($request->buscar);
        return MateriaPrima::select(
                    'id','nombre','descripcion','deleted_at',
                    DB::Raw("DATE_FORMAT(created_at,'%d/%m/%Y') as fecha_creada"),
                    DB::Raw("DATE_FORMAT(updated_at,'%d/%m/%Y') as fecha_modificada")
                    )
                ->where(function($query) use($buscar){
                    $query->where(DB::Raw("upper(nombre)"),'like','%'.$buscar.'%')
                        ->orWhere(DB::Raw("upper(descripcion)"),'like','%'.$buscar.'%');
                })
                ->onlyTrashed()->paginate($request->pagina);
    }

    public function guardarMateriaPrima(Request $request)
    {
        $reglas=[
            'nombre' =>'required',
         ];
        
        $mensaje = [
            'required' =>'* Campo Obligatorio'
        ];

        $this->validate($request,$reglas,$mensaje);

        if($request->estadoCrud == 'nuevo')
        {
            $materiaPrima = new MateriaPrima;
            $materiaPrima->nombre= $request->nombre;
            $materiaPrima->descripcion= $request->descripcion;
            $materiaPrima->save();

            return response()->json([
                'ok'=> 1,
                'mensaje' => 'Materia Prima Registrada Satisfactoriamente' 
            ],200);
        } 
        
        $materiaPrima = MateriaPrima::findOrFail($request->id)->first();
        $materiaPrima->nombre= $request->nombre;
        $materiaPrima->descripcion= $request->descripcion;
        $materiaPrima->save();

        return response()->json([
            'ok'=> 1,
            'mensaje' => 'Datos de Materia Prima modificados Satisfactoriamente' 
        ],200);
    }
}