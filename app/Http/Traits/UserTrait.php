<?php

namespace App\Http\Traits;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;


use App\Models\User;
use Spatie\Permission\Models\Role;


trait UserTrait
{
    public function todos(Request $request)
    {
        $buscar = mb_strtoupper($request->buscar);
        return User::with('roles')
                    ->select('id','nombre','usuario','email','deleted_at',
                        DB::Raw("case
                                    when estado = 0 then 'Inactivo'
                                    when estado = 1 then 'Activo'
                                end as estado_nombre"),
                        DB::Raw("case
                                when estado = 0 then 'badge bage-secondary'
                                when estado = 1 then 'badge badge-success'
                            end as estado_clase")
                        )
                    ->where(function($query) use($buscar){
                        $query->where(DB::Raw("upper(nombre)"),'like','%'.$buscar.'%')
                            ->orWhere(DB::Raw("upper(usuario)"),'like','%'.$buscar.'%');
                    })
                    ->withTrashed()->paginate($request->pagina);
    }
    public function habilitados(Request $request)
    {
        $buscar = mb_strtoupper($request->buscar);
        return User::with('roles')
                    ->select('id','nombre','usuario','email','deleted_at',
                        DB::Raw("case
                                    when estado = 0 then 'Inactivo'
                                    when estado = 1 then 'Activo'
                                end as estado_nombre"),
                        DB::Raw("case
                                when estado = 0 then 'badge bage-secondary'
                                when estado = 1 then 'badge badge-success'
                            end as estado_clase")
                        )
                    ->where(function($query) use($buscar){
                        $query->where(DB::Raw("upper(nombre)"),'like','%'.$buscar.'%')
                            ->orWhere(DB::Raw("upper(usuario)"),'like','%'.$buscar.'%');
                    })
                    ->paginate($request->pagina);
    }

    public function eliminados(Request $request)
    {
        $buscar = mb_strtoupper($request->buscar);
        return User::with('roles')
                    ->select('id','nombre','usuario','email','deleted_at',
                        DB::Raw("case
                                    when estado = 0 then 'Inactivo'
                                    when estado = 1 then 'Activo'
                                end as estado_nombre"),
                        DB::Raw("case
                                when estado = 0 then 'badge bage-secondary'
                                when estado = 1 then 'badge badge-success'
                            end as estado_clase")
                        )
                    ->where(function($query) use($buscar){
                        $query->where(DB::Raw("upper(nombre)"),'like','%'.$buscar.'%')
                            ->orWhere(DB::Raw("upper(usuario)"),'like','%'.$buscar.'%');
                    })
                    ->onlyTrashed()->paginate($request->pagina);
    }

    public function guardarUsuario(Request $request)
    {
        $reglas = [];

        if($request->estadoCrud == 'nuevo')
        {
            $reglas=[
                'nombre' =>'required',
                'usuario' =>'required|unique:users',
                'email' =>'required|email|unique:users',
                'password'=>'required',
                'role_id' =>'required'
            ];

        } else {
            $reglas=[
                'nombre' =>'required',
                'usuario' =>'required|unique:users,id',
                'email' =>'required|email|unique:users,id',
                'role_id' => 'required'
            ];
        }
        
        $mensaje = [
            'required' =>'* Campo Obligatorio',
            'unique' =>'Dato ya Existe',
            'email' => 'Correo Eléctronico no válido'
        ];

        $this->validate($request,$reglas,$mensaje);

        $user = null;

        $role = Role::findOrFail($request->role_id);

        if($request->estadoCrud == 'nuevo')
        {
            $user = User::create([
                'nombre' =>$request->nombre,
                'usuario' =>$request->usuario,
                'email' =>$request->email,
                'password' => Hash::make($request->password),
                'estado' => 1
            ]);

            $user->syncRoles($role->name);
            
            return response()->json([
                'ok'=> 1,
                'mensaje' => 'Usuario Registrado Satisfactoriamente' 
            ],200);
        } 

        $user = User::findOrFail($request->id);
        $user->nombre = $request->nombre;
        $user->usuario = $request->usuario;
        $user->email = $request->email;
        $user->estado = $request->estado;
        $user->save();

        if(!$user->hasRole($role->name))
        {
            $user->syncRoles($role->name);
        }
        
        return response()->json([
            'ok'=> 1,
            'mensaje' => 'Datos de Usuario modificados Satisfactoriamente' 
        ],200);
    }
}
