<?php

namespace App\Http\Traits;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

use Spatie\Permission\Models\Role;


trait RoleTrait
{

    public function todos(Request $request)
    {
        $buscar = mb_strtoupper($request->buscar);
        return Role::where(function($query) use($buscar){
                        $query->where(DB::Raw("upper(name)"),'like','%'.$buscar.'%');
                    })
                    ->paginate($request->pagina);
    }

    public function guardarRole(Request $request)
    {
        $reglas=[
            'name' => 'required',
         ];
        
        $mensaje = [
            'required' =>'* Campo Obligatorio'
        ];

        $this->validate($request,$reglas,$mensaje);

        if($request->estadoCrud == 'nuevo')
        {
            $role = new Role();
            $role->name = $request->name;
            $role->save();

            return response()->json([
                'ok' => 1,
                'mensaje' => 'El Rol ha sido Registrado Satisfactoriamente'
            ],200);
        }

        $role = Role::findOrFail($request->id);
        $role->name = $request->name;       
        $role->save();

        return response()->json([
            'ok' => 1,
            'mensaje' => 'El Rol fue Modificado Satisfactoriamente'
        ],200);
    }
}