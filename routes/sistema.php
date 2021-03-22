<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;

Route::group(['middleware' => 'auth'], function(){
    //ROLES
    Route::get('role-lista',[RoleController::class,'listar'])->name('role.lista');
    //USUARIOS
    Route::get('usuario-todos', [UserController::class,'todos'])->name('usuario.todos');
    Route::get('usuario-habilitados', [UserController::class,'habilitados'])->name('usuario.habilitados');
    Route::get('usuario-eliminados', [UserController::class,'eliminados'])->name('usuario.eliminados');
    Route::get('usuario-mostrar', [UserController::class,'mostrar'])->name('usuario.mostrar');
    Route::get('usuario-tabla',[UserController::class,'mostrarTable'])->name('usuario.mostrar-tabla');
    Route::post('usuario-eliminar-temporal',[UserController::class,'destroyTemporal'])->name('usuario.eliminar-temporal');
    Route::post('usuario-eliminar-permanente',[UserController::class,'destroyPermanente'])->name('usuario.eliminar-permanente');
    Route::post('usuario-restaurar',[UserController::class,'restaurar'])->name('usuario.restaurar');
});
