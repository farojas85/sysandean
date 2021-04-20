<?php

namespace App\Http\Controllers;

use App\Models\Trabajador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\TipoDocumento;
use App\Http\Traits\TrabajadorTrait;

class TrabajadorController extends Controller
{
    use TrabajadorTrait;
    
    public function validarDocumento(Request $request)
    {
        $tipoDocumento = TipoDocumento::findOrFail($request->tipo_documento_id);

        $reglas=[
            'tipo_documento_id' =>'required',
            'numero_documento' =>'digits:'.$tipoDocumento->longitud
        ];

        $mensaje = [
            'required' =>'* Campo Obligatorio',
            'digits' =>'Ingrese Solo :digits dígitos'
        ];

        $this->validate($request,$reglas,$mensaje);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        return $this->guardarTrabajador($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Trabajador  $trabajador
     * @return \Illuminate\Http\Response
     */
    public function mostrar(Request $request)
    {
        return Trabajador::with('tipo_documento:id,nombre_corto,nombre_largo')
                            ->select('id','tipo_documento_id','numero_documento','nombres',
                            'apellidos','fecha_nacimiento','lugar_nacimiento','estado','deleted_at')
                            ->where('id',$request->id)->first();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Trabajador  $trabajador
     * @return \Illuminate\Http\Response
     */
    public function edit(Trabajador $trabajador)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Trabajador  $trabajador
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Trabajador $trabajador)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Trabajador  $trabajador
     * @return \Illuminate\Http\Response
     */
    public function destroyPermanente(Request $request)
    {
        $trabajador = Trabajador::withTrashed()->where('id',$request->id)->first();

        //eliminamos al usuario de la base de datos
        $trabajador->forceDelete();

        return response()->json([
            'ok' => 1,
            'trabajador' =>$trabajador,
            'mensaje' => 'Registro de Trabajador ha sido eliminado Satisfactoriamente'
        ]);
    }

    public function destroyTemporal(Request $request)
    {
       $trabajador = Trabajador::withTrashed()->where('id',$request->id)->first()->delete();

        return response()->json([
            'ok' => 1,
            'trabajador' =>$trabajador,
            'mensaje' => 'Registro de Trabajador ha sido enviado a Papelera de Reciclaje'
        ]);
    }

    public function restaurar(Request $request) {
        $trabajador = Trabajador::onlyTrashed()
                         ->where('id',$request->id)->first()->restore();

         return response()->json([
             'ok' =>1,
             'trabajador' =>$trabajador,
             'mensaje' => 'Registro de Trabajador ha sido restaurado Satisfactoriamente'
         ]);
    }

    public function listar()
    {
        return Trabajador::select('id',DB::Raw("concat(nombres,' ',apellidos) as nombres"))
                    ->get();
    }
}
