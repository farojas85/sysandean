<?php

namespace App\Http\Traits;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;


use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;


trait PermissionTrait
{

    public function listar(Request $request)
    {
        $buscar = mb_strtoupper($request->buscar);
        return Permission::where(function($query) use($buscar){
                        $query->where(DB::Raw("upper(name)"),'like','%'.$buscar.'%');
                    })
                    ->paginate($request->pagina);
    }

    public function guardarPermiso(Request $request)
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
            $permission = new Permission();
            $permission->name = $request->name;
            $permission->save();

            return response()->json([
                'ok' => 1,
                'mensaje' => 'El Permiso ha sido Registrado Satisfactoriamente'
            ],200);
        }

        $permission = Permission::findOrFail($request->id);
        $permission->name = $request->name;       
        $permission->save();

        return response()->json([
            'ok' => 1,
            'mensaje' => 'El Permiso fue Modificado Satisfactoriamente'
        ],200);
    }
}