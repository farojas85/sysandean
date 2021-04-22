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
    public function destroy(Rectificado $rectificado)
    {
        //
    }
}
