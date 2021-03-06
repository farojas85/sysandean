<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Lote;
use App\Models\MateriaPrima;
use App\Http\Traits\LoteTrait;

class LoteController extends Controller
{
    use LoteTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('lote.inicio');
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
        return $this->guardarLote($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Lote  $lote
     * @return \Illuminate\Http\Response
     */
    public function show(Lote $lote)
    {
        //
    }

    public function mostrar(Request $request)
    {
        $lote = Lote::with('materia_prima')->findOrFail($request->id);
        return $lote;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Lote  $lote
     * @return \Illuminate\Http\Response
     */
    public function edit(Lote $lote)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Lote  $lote
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Lote $lote)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Lote  $lote
     * @return \Illuminate\Http\Response
     */
    public function destroy(Lote $lote)
    {
        //
    }

    public function buscarMateriaPrima(Request $request)
    {
        $busqueda = mb_strtoupper($request->buscar_materia);

        return MateriaPrima::select('id','nombre')
                ->where(DB::Raw("upper(nombre)"),'like','%'.$busqueda.'%')
                ->orWhere(DB::Raw("upper(descripcion)"),'like','%'.$busqueda.'%')
                ->paginate(5);
    }

    public function destroyPermanente(Request $request)
    {
        $lote = Lote::withTrashed()->where('id',$request->id)->first();

        //eliminamos al materiaPr$lote de la base de datos
        $lote->forceDelete();

        return response()->json([
            'ok' => 1,
            'lote' =>$lote,
            'mensaje' => 'Registro de Lote ha sido eliminado Satisfactoriamente'
        ]);
    }

    public function destroyTemporal(Request $request)
    {
       $lote = lote::withTrashed()->where('id',$request->id)->first()->delete();

        return response()->json([
            'ok' => 1,
            'lote' =>$lote,
            'mensaje' => 'Registro de Lote ha sido enviado a Papelera de Reciclaje'
        ]);
    }

    public function restaurar(Request $request) {
        $lote = Lote::onlyTrashed()
                         ->where('id',$request->id)->first()->restore();

         return response()->json([
             'ok' =>1,
             'lote' =>$lote,
             'mensaje' => 'Registro de Lote ha sido restaurado Satisfactoriamente'
         ]);
    }
}
