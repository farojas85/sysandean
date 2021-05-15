<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Permission;

use Illuminate\Http\Request;
use App\Http\Traits\PermissionTrait;

class PermissionController extends Controller
{
    use PermissionTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $this->listar($request);
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
        return $this->guardarPermiso($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Permission  $Permission
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        return Permission::select('id','name','guard_name')->where('id',$request->id)->first();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Permission  $Permission
     * @return \Illuminate\Http\Response
     */
    public function edit(Permission $permission)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Permission  $Permission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Permission $permission)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Permission  $Permission
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $permission = Permission::where('id',$request->id)->first();
        $permission->delete();

        return response()->json([
            'ok' => 1,
            'mensaje' => 'El Permiso fue Eliminado Satisfactoriamente'
        ],200);
    }
}
