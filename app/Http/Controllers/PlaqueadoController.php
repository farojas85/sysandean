<?php

namespace App\Http\Controllers;

use App\Models\Plaqueado;
use Illuminate\Http\Request;

use App\Http\Traits\PlaqueadoTrait;
class PlaqueadoController extends Controller
{
    use PlaqueadoTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('plaqueado.inicio');
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
        return $this->guardarPlaqueado($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Plaqueado  $plaqueado
     * @return \Illuminate\Http\Response
     */
    public function show(Plaqueado $plaqueado)
    {
        //
    }

    public function mostrar(Request $request)
    {
        $plaqueado = Plaqueado::with('lote:id,nombre')->findOrFail($request->id);
        return $plaqueado;
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Plaqueado  $plaqueado
     * @return \Illuminate\Http\Response
     */
    public function edit(Plaqueado $plaqueado)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Plaqueado  $plaqueado
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Plaqueado $plaqueado)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Plaqueado  $plaqueado
     * @return \Illuminate\Http\Response
     */
    public function destroyPermanente(Request $request)
    {
        $plaqueado = Plaqueado::withTrashed()->where('id',$request->id)->first();

        //eliminamos al materiaPr$lote de la base de datos
        $plaqueado->forceDelete();

        return response()->json([
            'ok' => 1,
            'plaqueado' =>$plaqueado,
            'mensaje' => 'Registro de Plaqueado ha sido eliminado Satisfactoriamente'
        ]);
    }

    public function destroyTemporal(Request $request)
    {
       $plaqueado = Plaqueado::withTrashed()->where('id',$request->id)->first()->delete();

        return response()->json([
            'ok' => 1,
            'plaqueado' =>$plaqueado,
            'mensaje' => 'Registro de Plaqueado ha sido enviado a Papelera de Reciclaje'
        ]);
    }

    public function restaurar(Request $request) {
        $plaqueado = Plaqueado::onlyTrashed()
                         ->where('id',$request->id)->first()->restore();

         return response()->json([
             'ok' =>1,
             'plaqueado' =>$plaqueado,
             'mensaje' => 'Registro de Plaqueado ha sido restaurado Satisfactoriamente'
         ]);
    }

}
