<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Rectificado;
use App\Models\Congelado;
use App\Models\Envasado;
use App\Models\Almacenado;

class ReporteResumenController extends Controller
{
    public function obtenerRankingRectificado()
    {
        $rectificado = Rectificado::with('trabajador','lote')
                            ->select('trabajador_id',
                                DB::Raw('SUM(kilogramo_rectificado) as kilogramo'))
                            ->groupBy('trabajador_id')->get();
        
        $series = [];
        $labels = [];
        if($rectificado)
        {
            foreach($rectificado as $recti)
            {
                array_push($series,$recti->kilogramo);
                array_push($labels,$recti->trabajador->nombres." ".$recti->trabajador->apellidos);
            }
        }
        return response()->json([
            'series'=> $series ,
            'labels' => $labels
        ]);
    }

    public function obtenerRankingCongelado()
    {
        $congelados = Congelado::with('trabajador','lote')
                            ->select('trabajador_id',
                                DB::Raw('SUM(kilogramo_congelado) as kilogramo'))
                            ->groupBy('trabajador_id')->get();
        
        $series = [];
        $labels = [];
        if($congelados)
        {
            foreach($congelados as $conge)
            {
                array_push($series,$conge->kilogramo);
                array_push($labels,$conge->trabajador->nombres." ".$conge->trabajador->apellidos);
            }
        }
        return response()->json([
            'series'=> $series ,
            'labels' => $labels
        ]);
    }

    public function obtenerRankingEnvasado()
    {
        $Envasados = Envasado::with('trabajador','lote')
                            ->select('trabajador_id',
                                DB::Raw('SUM(kilogramo_envasado) as kilogramo'))
                            ->groupBy('trabajador_id')->get();
        
        $series = [];
        $labels = [];
        if($Envasados)
        {
            foreach($Envasados as $envas)
            {
                array_push($series,$envas->kilogramo);
                array_push($labels,$envas->trabajador->nombres." ".$envas->trabajador->apellidos);
            }
        }
        return response()->json([
            'series'=> $series ,
            'labels' => $labels
        ]);
    }

    public function obtenerRankingAlmacenado()
    {
        $almacenados = Almacenado::with('trabajador','lote')
                            ->select('trabajador_id',
                                DB::Raw('SUM(cajas*peso_caja) as kilogramo'))
                            ->groupBy('trabajador_id')->get();
        
        $series = [];
        $labels = [];
        if($almacenados)
        {
            foreach($almacenados as $almacen)
            {
                array_push($series,$almacen->kilogramo);
                array_push($labels,$almacen->trabajador->nombres." ".$almacen->trabajador->apellidos);
            }
        }
        return response()->json([
            'series'=> $series ,
            'labels' => $labels
        ]);
    }
}
