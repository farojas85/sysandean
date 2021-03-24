<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\MateriaPrimaController;

Route::group(['middleware' => 'auth'], function(){
    //MATERIA PRIMA
    Route::get('materia-prima-todos', [MateriaPrimaController::class,'todos'])->name('materia-prima.todos');
    Route::get('materia-prima-habilitados', [MateriaPrimaController::class,'habilitados'])->name('materia-prima.habilitados');
    Route::get('materia-prima-eliminados', [MateriaPrimaController::class,'eliminados'])->name('materia-prima.eliminados');
    Route::get('materia-prima-mostrar', [MateriaPrimaController::class,'mostrar'])->name('materia-prima.mostrar');
    Route::get('materia-prima-tabla',[MateriaPrimaController::class,'mostrarTable'])->name('materia-prima.mostrar-tabla');
    Route::post('materia-prima-eliminar-temporal',[MateriaPrimaController::class,'destroyTemporal'])->name('materia-prima.eliminar-temporal');
    Route::post('materia-prima-eliminar-permanente',[MateriaPrimaController::class,'destroyPermanente'])->name('materia-prima.eliminar-permanente');
    Route::post('materia-prima-restaurar',[MateriaPrimaController::class,'restaurar'])->name('materia-prima.restaurar');
});