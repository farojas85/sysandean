<?php

namespace App\Http\Controllers;

use App\Models\Rectificado;
use Illuminate\Http\Request;
use App\Http\Traits\RectificadoTrait;

class RectificadoController extends Controller
{
    use RectificadoTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('rectificado.inicio');
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
        return $this->guardarRectificado($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Rectificado  $rectificado
     * @return \Illuminate\Http\Response
     */
    public function show(Rectificado $rectificado)
    {
        //
    }

    public function mostrar(Request $request)
    {
        $rectificado = Rectificado::with('lote:id,nombre')->findOrFail($request->id);
        return $rectificado;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Rectificado  $rectificado
     * @return \Illuminate\Http\Response
     */
    public function edit(Rectificado $rectificado)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Rectificado  $rectificado
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Rectificado $rectificado)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Rectificado  $rectificado
     * @return \Illuminate\Http\Response
     */
    public function destroyPermanente(Request $request)
    {
        $rectificado = Rectificado::withTrashed()->where('id',$request->id)->first();

        //eliminamos al materiaPr$lote de la base de datos
        $rectificado->forceDelete();

        return response()->json([
            'ok' => 1,
            'rectificado' =>$rectificado,
            'mensaje' => 'Registro de Rectificado ha sido eliminado Satisfactoriamente'
        ]);
    }

    public function destroyTemporal(Request $request)
    {
       $rectificado = Rectificado::withTrashed()->where('id',$request->id)->first()->delete();

        return response()->json([
            'ok' => 1,
            'rectificado' =>$rectificado,
            'mensaje' => 'Registro de Rectificado ha sido enviado a Papelera de Reciclaje'
        ]);
    }

    public function restaurar(Request $request) {
        $rectificado = Rectificado::onlyTrashed()
                         ->where('id',$request->id)->first()->restore();

         return response()->json([
             'ok' =>1,
             'rectificado' =>$rectificado,
             'mensaje' => 'Registro de Rectificado ha sido restaurado Satisfactoriamente'
         ]);
    }
}
