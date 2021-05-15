<?php

namespace App\Http\Traits;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;


use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;


trait PermissionRoleTrait
{
    public function mostrarModelos()
    {
        return  Permission::select(DB::Raw("DISTINCT( SUBSTRING_INDEX(SUBSTRING_INDEX(name, '.', 1), '.', -1)) as name"))
                            ->orderBy('name')->get();
    }

    public function mostrarRolePermisos(Request $request)
    {
        $this->validate($request, [ 'role_id' => 'required' ]);

        $request->modelo = $request->modelo.'%';

        $permissions = Permission::where('name','like',$request->modelo)->get();

        $role = Role::with('permissions')->where('id',$request->role_id)->get();

        return response()->json(['role' => $role,'permissions' => $permissions]);
    }

    public function guardarRolePermission(Request $request)
    {
        $role = Role::where('id',$request->role_id)->first();

        $role->syncPermissions($request->permission_name);

        return response()->json([
            'ok' => 1,
            'mensaje' => 'Permisos asignados satisfactoriamente'
        ]);
    }
}