<?php

namespace App\Http\Traits;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

use App\Models\User;



trait UserTrait
{
    public function habilitados(Request $request)
    {
        return User::select('id','nombre','usuario','email','deleted_at',
                        DB::Raw("case
                                    when estado = 0 then 'Inactivo'
                                    when estado = 1 then 'Activo'
                                end as estado_nombre"),
                        DB::Raw("case
                                when estado = 0 then 'badge bage-secondary'
                                when estado = 1 then 'badge badge-success'
                            end as estado_clase")
                        )
                    ->paginate($request->pagina);
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
                'password'=>'required'
            ];

        } else {
            $reglas=[
                'nombre' =>'required',
                'usuario' =>'required|unique:users,usuario',
                'email' =>'required|email|unique:users,email',
                'password'=>'required'
            ];
        }
        $mensaje = [
            'required' =>'* Campo Obligatorio',
            'unique' =>'Dato ya Existe',
            'email' => 'Correo Eléctronico no válido'
        ];

        $this->validate($request,$reglas,$mensaje);

        $user = null;
        if($request->estadoCrud == 'nuevo')
        {
            $user = User::create([
                'nombre' =>$request->nombre,
                'usuario' =>$request->usuario,
                'email' =>$request->email,
                'password' => Hash::make($request->password),
                'estado' => 1
            ]);
            
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
        
        return response()->json([
            'ok'=> 1,
            'mensaje' => 'Datos de Usuario modificados Satisfactoriamente' 
        ],200);

       
    }
}
