<?php

namespace App\Http\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\Lote;

trait LoteTrait
{

    public function todos(Request $request)
    {
        $buscar = mb_strtoupper($request->buscar);
        return Lote::with('materia_prima:id,nombre')->select(
                        'id','materia_prima_id','kilogramo','descripcion','nombre','deleted_at',
                        DB::Raw("DATE_FORMAT(fecha_registro,'%d/%m/%Y') as fecha"),
                        'maduros','pinton','verde','podrido','enanas',
                        DB::Raw("maduros/kilogramo*100 as maduros_lote"),
                        DB::Raw("pinton/kilogramo*100 as pinton_lote"),
                        DB::Raw("verde/kilogramo*100 as verde_lote"),
                        DB::Raw("podrido/kilogramo*100 as podrido_lote"),
                        DB::Raw("enanas/kilogramo*100 as enanas_lote")
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
        return Lote::with('materia_prima:id,nombre')->select(
                    'id','materia_prima_id','kilogramo','descripcion','nombre','deleted_at',
                    DB::Raw("DATE_FORMAT(fecha_registro,'%d/%m/%Y') as fecha"),
                    'maduros','pinton','verde','podrido','enanas',
                    DB::Raw("maduros/kilogramo*100 as maduros_lote"),
                    DB::Raw("pinton/kilogramo*100 as pinton_lote"),
                    DB::Raw("verde/kilogramo*100 as verde_lote"),
                    DB::Raw("podrido/kilogramo*100 as podrido_lote"),
                    DB::Raw("enanas/kilogramo*100 as enanas_lote")
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
        return Lote::with('materia_prima:id,nombre')->select(
                    'id','materia_prima_id','kilogramo','descripcion','nombre','deleted_at',
                    DB::Raw("DATE_FORMAT(fecha_registro,'%d/%m/%Y') as fecha"),
                    'maduros','pinton','verde','podrido','enanas',
                    DB::Raw("maduros/kilogramo*100 as maduros_lote"),
                    DB::Raw("pinton/kilogramo*100 as pinton_lote"),
                    DB::Raw("verde/kilogramo*100 as verde_lote"),
                    DB::Raw("podrido/kilogramo*100 as podrido_lote"),
                    DB::Raw("enanas/kilogramo*100 as enanas_lote")
                )
                ->where(function($query) use($buscar){
                    $query->where(DB::Raw("upper(nombre)"),'like','%'.$buscar.'%')
                        ->orWhere(DB::Raw("upper(descripcion)"),'like','%'.$buscar.'%');
                })
                ->onlyTrashed()->paginate($request->pagina);
    }


    public function guardarLote(Request $request)
    {
        $reglas=[
            'nombre' =>'required',
            'materia_prima_id' => 'required',
            'kilogramo' => 'required',
            'fecha_registro' => 'required',
            'maduros' => 'required',
            'pinton' => 'required',
            'verde' => 'required',
            'podrido' => 'required',
            'enanas' => 'required'
         ];
        
        $mensaje = [
            'required' =>'* Campo Obligatorio'
        ];

        $this->validate($request,$reglas,$mensaje);

        $suma = $request->maduros + $request->pinton + $request->verde;
        $suma += $request->podrido + $request->enanas;

        if($suma != $request->kilogramo)
        {
            return response()->json([
                'errors' => [
                    'maduros' => '*',
                    'pinton' => '*',
                    'verde' => '*',
                    'podrido' => '*',
                    'enanas' => '*',
                    'coincide' => 'La suma debe coincidir con Kilogramo'
                ]
                ],422);
        }

        if($request->estadoCrud == 'nuevo')
        {
            $lote = new Lote;
            $lote->nombre = $request->nombre;
            $lote->materia_prima_id = $request->materia_prima_id;
            $lote->kilogramo = $request->kilogramo;
            $lote->descripcion = $request->descripcion;
            $lote->fecha_registro = $request->fecha_registro;
            $lote->maduros = $request->maduros;
            $lote->pinton = $request->pinton;
            $lote->verde = $request->verde;
            $lote->podrido = $request->podrido;
            $lote->enanas = $request->enanas;
            $lote->usuario_crea = Auth::user()->id;
            $lote->save();

            return response()->json([
                'ok' => 1,
                'mensaje' => 'Lote Registrado Satisfactoriamente'
            ],200);
        }

        $lote = Lote::findOrFail($request->id);
        $lote->nombre = $request->nombre;
        $lote->materia_prima_id = $request->materia_prima_id;
        $lote->kilogramo = $request->kilogramo;
        $lote->descripcion = $request->descripcion;
        $lote->fecha_registro = $request->fecha_registro;
        $lote->maduros = $request->maduros;
        $lote->pinton = $request->pinton;
        $lote->verde = $request->verde;
        $lote->podrido = $request->podrido;
        $lote->enanas = $request->enanas;
        $lote->usuario_modifica = Auth::user()->id;
        $lote->save();
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Lote Modificado Satisfactoriamente'
        ],200);

    }
}

