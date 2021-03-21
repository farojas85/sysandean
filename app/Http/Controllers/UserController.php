<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\User;
use App\Http\Traits\UserTrait;

class UserController extends Controller
{
    use UserTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function ObtenerHabilitados(Request $request)
    {
        return $this->habilitados($request);
    }

    public function index()
    {
        return view('sistema.usuario.index');
    }

    public function create()
    {
        return view('sistema.usuario.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       return $this->guardarUsuario($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //return User
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }

    public function mostarTabla()
    {
        $usuarios = User::select('id','nombre','usuario','email','deleted_at',
                            DB::Raw("case
                                        when estado = 0 then 'Inactivo'
                                        when estado = 1 then 'Activo'
                                    end as estado_nombre"),
                            DB::Raw("case
                                    when estado = 0 then 'badge bage-secondary'
                                    when estado = 1 then 'badge badge-success'
                                end as estado_clase")
                            )
                        ->paginate(5);
        
        return view('sistema.usuario.tabla',compact('usuarios'));
    }
}
