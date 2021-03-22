<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\User;
use App\Http\Traits\UserTrait;

class UserController extends Controller
{
    use UserTrait;
    
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
    public function show(Request $request)
    {
        $user = User::with('roles')->where('id',$request->id)->first();

        $roles = $user->roles;
        $user->role_id = $roles[0]->id;

        return $user;
    }

    public function mostrar(Request $request)
    {
        $user = User::with('roles')->select('id','nombre','usuario','email','estado')
                    ->where('id',$request->id)->first();

        $roles = $user->roles;
        $user->role_id = '';
        if(count($roles)>0)
        {
            $user->role_id = $roles[0]->id;
        }

        return $user;
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
    public function destroyPermanente(Request $request)
    {
        $usuario = User::withTrashed()->where('id',$request->id)->first();

        
        //Quitamos todos los Roles del usuario
        $usuario->syncRoles();

        //eliminamos al usuario de la base de datos
        $usuario->forceDelete();

        return response()->json([
            'ok' => 1,
            'usuario' =>$usuario,
            'mensaje' => 'Registro de Usuario ha sido eliminado Satisfactoriamente'
        ]);
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
    public function destroyTemporal(Request $request)
    {
       $usuario = User::withTrashed()->where('id',$request->id)->first()->delete();

        return response()->json([
            'ok' => 1,
            'usuario' =>$usuario,
            'mensaje' => 'Registro de Usuario ha sido enviado a Papelera de Reciclaje'
        ]);
    }

    public function restaurar(Request $request) {
        $usuario = User::onlyTrashed()
                         ->where('id',$request->id)->first()->restore();

         return response()->json([
             'ok' =>1,
             'usuario' =>$usuario,
             'mensaje' => 'Registro de Usuario ha sido restaurado Satisfactoriamente'
         ]);
    }
}
