<?php

namespace App\Http\Controllers;

use App\Models\MateriaPrima;
use Illuminate\Http\Request;
use App\Http\Traits\MateriaPrimaTrait;

class MateriaPrimaController extends Controller
{
    use MateriaPrimaTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('materia-prima.inicio');
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
        return $this->guardarMateriaPrima($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MateriaPrima  $materiaPrima
     * @return \Illuminate\Http\Response
     */
    public function show(MateriaPrima $materiaPrima)
    {
        //
    }

    public function mostrar(Request $request)
    {
        $materiaPrima = MateriaPrima::findOrFail($request->id);
        return $materiaPrima;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MateriaPrima  $materiaPrima
     * @return \Illuminate\Http\Response
     */
    public function edit(MateriaPrima $materiaPrima)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MateriaPrima  $materiaPrima
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MateriaPrima $materiaPrima)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MateriaPrima  $materiaPrima
     * @return \Illuminate\Http\Response
     */
    public function destroy(MateriaPrima $materiaPrima)
    {
        //
    }

    public function destroyPermanente(Request $request)
    {
        $materiaPrima = MateriaPrima::withTrashed()->where('id',$request->id)->first();

        //eliminamos al materiaPr$materiaPrima de la base de datos
        $materiaPrima->forceDelete();

        return response()->json([
            'ok' => 1,
            'materiaPrima' =>$materiaPrima,
            'mensaje' => 'Registro de Materia Prima ha sido eliminado Satisfactoriamente'
        ]);
    }

    public function destroyTemporal(Request $request)
    {
       $materiaPrima = MateriaPrima::withTrashed()->where('id',$request->id)->first()->delete();

        return response()->json([
            'ok' => 1,
            'materiaPrima' =>$materiaPrima,
            'mensaje' => 'Registro de Materia Prima ha sido enviado a Papelera de Reciclaje'
        ]);
    }

    public function restaurar(Request $request) {
        $materiaPrima = MateriaPrima::onlyTrashed()
                         ->where('id',$request->id)->first()->restore();

         return response()->json([
             'ok' =>1,
             'materiaPrima' =>$materiaPrima,
             'mensaje' => 'Registro de Materia Prima ha sido restaurado Satisfactoriamente'
         ]);
    }
}
