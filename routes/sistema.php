<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TrabajadorController;
use App\Http\Controllers\TipoDocumentoController;


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
    //TIPO DOCUMENTOS
    Route::get('tipo-documento-lista',[TipoDocumentoController::class,'listar'])->name('tipo-documento.lista');
    //TRABAJADORES
    Route::get('trabajador-todos', [TrabajadorController::class,'todos'])->name('trabajador.todos');
    Route::get('trabajador-habilitados', [TrabajadorController::class,'habilitados'])->name('trabajador.habilitados');
    Route::get('trabajador-eliminados', [TrabajadorController::class,'eliminados'])->name('trabajador.eliminados');
    Route::get('trabajador-validar-documento',[TrabajadorController::class,'validarDocumento'])->name('trabajador.validar-documento');
    Route::get('trabajador-mostrar', [TrabajadorController::class,'mostrar'])->name('trabajador.mostrar');
    Route::post('trabajador-eliminar-temporal',[TrabajadorController::class,'destroyTemporal'])->name('trabajador.eliminar-temporal');
    Route::post('trabajador-eliminar-permanente',[TrabajadorController::class,'destroyPermanente'])->name('trabajador.eliminar-permanente');
    Route::post('trabajador-restaurar',[TrabajadorController::class,'restaurar'])->name('trabajador.restaurar');
});
