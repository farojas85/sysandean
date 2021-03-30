<?php

namespace App\Http\Controllers;

use App\Models\PeladoQuimico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Traits\PeladoQuimicoTrait;
use App\Models\Lote;

class PeladoQuimicoController extends Controller
{
    use PeladoQuimicoTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pelado-quimico.inicio');
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
        return $this->guardarPeladoQuimico($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PeladoQuimico  $peladoQuimico
     * @return \Illuminate\Http\Response
     */
    public function show(PeladoQuimico $peladoQuimico)
    {
        //
    }

    public function mostrar(Request $request)
    {
        $peladoQuimico = PeladoQuimico::with('lote:id,nombre')->findOrFail($request->id);
        return $peladoQuimico;
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PeladoQuimico  $peladoQuimico
     * @return \Illuminate\Http\Response
     */
    public function edit(PeladoQuimico $peladoQuimico)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PeladoQuimico  $peladoQuimico
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PeladoQuimico $peladoQuimico)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PeladoQuimico  $peladoQuimico
     * @return \Illuminate\Http\Response
     */
    public function destroyPermanente(Request $request)
    {
        $peladoQuimico = PeladoQuimico::withTrashed()->where('id',$request->id)->first();

        //eliminamos al materiaPr$lote de la base de datos
        $peladoQuimico->forceDelete();

        return response()->json([
            'ok' => 1,
            'peladoQuimico' =>$peladoQuimico,
            'mensaje' => 'Registro de Pelado Químico ha sido eliminado Satisfactoriamente'
        ]);
    }

    public function destroyTemporal(Request $request)
    {
       $peladoQuimico = PeladoQuimico::withTrashed()->where('id',$request->id)->first()->delete();

        return response()->json([
            'ok' => 1,
            'peladoQuimico' =>$peladoQuimico,
            'mensaje' => 'Registro de pelado Químico ha sido enviado a Papelera de Reciclaje'
        ]);
    }

    public function restaurar(Request $request) {
        $peladoQuimico = PeladoQuimico::onlyTrashed()
                         ->where('id',$request->id)->first()->restore();

         return response()->json([
             'ok' =>1,
             'peladoQuimico' =>$peladoQuimico,
             'mensaje' => 'Registro de Pelado Químico ha sido restaurado Satisfactoriamente'
         ]);
    }

    public function buscarLote(Request $request)
    {
        $busqueda = mb_strtoupper($request->buscar_lote);

        return Lote::select('id','nombre')
                ->where(DB::Raw("upper(nombre)"),'like','%'.$busqueda.'%')
                ->orWhere(DB::Raw("upper(descripcion)"),'like','%'.$busqueda.'%')
                ->paginate(5);
    }


}
