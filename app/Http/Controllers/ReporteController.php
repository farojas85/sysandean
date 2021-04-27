<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lote;
class ReporteController extends Controller
{
    public function obtenerLote(Request $request)
    {
        if(!$request->lote)
        {
            return Lote::select('fecha_registro','maduros','pinton','verde','podrido','enanas')
                    ->first();
        } else {
            return Lote::select('fecha_registro','maduros','pinton','verde','podrido','enanas')
                    ->where('nombre','like',$request->nombre)
                    ->where('fecha_registro',$request->fecha)
                    ->first();
        }
    }
}
