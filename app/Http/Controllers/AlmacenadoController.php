<?php

namespace App\Http\Controllers;

use App\Models\Almacenado;
use Illuminate\Http\Request;

use App\Http\Traits\AlmacenadoTrait;

class AlmacenadoController extends Controller
{
    use AlmacenadoTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('almacenado.inicio');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $this->guardarAlmacenado($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Almacenado  $almacenado
     * @return \Illuminate\Http\Response
     */
    public function show(Almacenado $almacenado)
    {
        //
    }

    public function mostrar(Request $request)
    {
        $almacenado = Almacenado::with('lote:id,nombre')->findOrFail($request->id);
        return $almacenado;
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Almacenado  $almacenado
     * @return \Illuminate\Http\Response
     */
    public function edit(Almacenado $almacenado)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Almacenado  $almacenado
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Almacenado $almacenado)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Almacenado  $almacenado
     * @return \Illuminate\Http\Response
     */
    public function destroyPermanente(Request $request)
    {
        $almacenado = Almacenado::withTrashed()->where('id',$request->id)->first();

        //eliminamos al materiaPr$lote de la base de datos
        $almacenado->forceDelete();

        return response()->json([
            'ok' => 1,
            'almacenado' =>$almacenado,
            'mensaje' => 'Registro de Almacenado ha sido eliminado Satisfactoriamente'
        ]);
    }

    public function destroyTemporal(Request $request)
    {
       $almacenado = Almacenado::withTrashed()->where('id',$request->id)->first()->delete();

        return response()->json([
            'ok' => 1,
            'almacenado' =>$almacenado,
            'mensaje' => 'Registro de Almacenado ha sido enviado a Papelera de Reciclaje'
        ]);
    }

    public function restaurar(Request $request) {
        $almacenado = Almacenado::onlyTrashed()
                         ->where('id',$request->id)->first()->restore();

         return response()->json([
             'ok' =>1,
             'almacenado' =>$almacenado,
             'mensaje' => 'Registro de Envasado ha sido restaurado Satisfactoriamente'
         ]);
    }
}
