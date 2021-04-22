<?php

namespace App\Http\Controllers;

use App\Models\Congelado;
use Illuminate\Http\Request;
use App\Http\Traits\CongeladoTrait;
class CongeladoController extends Controller
{
    use CongeladoTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('congelado.inicio');
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
        return $this->guardarCongelado($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Congelado  $congelado
     * @return \Illuminate\Http\Response
     */
    public function show(Congelado $congelado)
    {
        //
    }

    public function mostrar(Request $request)
    {
        $congelado = Congelado::with('lote:id,nombre')->findOrFail($request->id);
        return $congelado;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Congelado  $congelado
     * @return \Illuminate\Http\Response
     */
    public function edit(Congelado $congelado)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Congelado  $congelado
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Congelado $congelado)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Congelado  $congelado
     * @return \Illuminate\Http\Response
     */
    public function destroyPermanente(Request $request)
    {
        $congelado = Congelado::withTrashed()->where('id',$request->id)->first();

        //eliminamos al materiaPr$lote de la base de datos
        $congelado->forceDelete();

        return response()->json([
            'ok' => 1,
            'congelado' =>$congelado,
            'mensaje' => 'Registro de Congelado ha sido eliminado Satisfactoriamente'
        ]);
    }

    public function destroyTemporal(Request $request)
    {
       $congelado = Congelado::withTrashed()->where('id',$request->id)->first()->delete();

        return response()->json([
            'ok' => 1,
            'congelado' =>$congelado,
            'mensaje' => 'Registro de Congelado ha sido enviado a Papelera de Reciclaje'
        ]);
    }

    public function restaurar(Request $request) {
        $congelado = Congelado::onlyTrashed()
                         ->where('id',$request->id)->first()->restore();

         return response()->json([
             'ok' =>1,
             'congelado' =>$congelado,
             'mensaje' => 'Registro de Congelado ha sido restaurado Satisfactoriamente'
         ]);
    }

    
}
