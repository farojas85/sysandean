<?php

namespace App\Http\Controllers;

use App\Models\Envasado;
use Illuminate\Http\Request;

use App\http\Traits\EnvasadoTrait;

class EnvasadoController extends Controller
{
    use EnvasadoTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('envasado.inicio');
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
        return $this->guardarEnvasado($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Envasado  $envasado
     * @return \Illuminate\Http\Response
     */
    public function show(Envasado $envasado)
    {
        //
    }

    public function mostrar(Request $request)
    {
        $envasado = Envasado::with('lote:id,nombre')->findOrFail($request->id);
        return $envasado;
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Envasado  $envasado
     * @return \Illuminate\Http\Response
     */
    public function edit(Envasado $envasado)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Envasado  $envasado
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Envasado $envasado)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Envasado  $envasado
     * @return \Illuminate\Http\Response
     */
    public function destroyPermanente(Request $request)
    {
        $envasado = Envasado::withTrashed()->where('id',$request->id)->first();

        //eliminamos al materiaPr$lote de la base de datos
        $envasado->forceDelete();

        return response()->json([
            'ok' => 1,
            'envasado' =>$envasado,
            'mensaje' => 'Registro de Envasado ha sido eliminado Satisfactoriamente'
        ]);
    }

    public function destroyTemporal(Request $request)
    {
       $envasado = Envasado::withTrashed()->where('id',$request->id)->first()->delete();

        return response()->json([
            'ok' => 1,
            'envasado' =>$envasado,
            'mensaje' => 'Registro de Envasado ha sido enviado a Papelera de Reciclaje'
        ]);
    }

    public function restaurar(Request $request) {
        $envasado = Envasado::onlyTrashed()
                         ->where('id',$request->id)->first()->restore();

         return response()->json([
             'ok' =>1,
             'envasado' =>$envasado,
             'mensaje' => 'Registro de Envasado ha sido restaurado Satisfactoriamente'
         ]);
    }
}
