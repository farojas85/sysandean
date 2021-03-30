<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\MateriaPrimaController;
use App\Http\Controllers\LoteController;
use App\Http\Controllers\PeladoQuimicoController;
use App\Http\Controllers\RectificadoController;

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

    //LOTES
    Route::get('materia-prima-buscar',[LoteController::class,'buscarMateriaPrima'])->name('materia-prima-buscar.buscar-materia');
    Route::get('lote-todos', [LoteController::class,'todos'])->name('lote.todos');
    Route::get('lote-habilitados', [LoteController::class,'habilitados'])->name('lote.habilitados');
    Route::get('lote-eliminados', [LoteController::class,'eliminados'])->name('lote.eliminados');
    Route::get('lote-mostrar', [LoteController::class,'mostrar'])->name('lote.mostrar');
    Route::get('lote-tabla',[LoteController::class,'mostrarTable'])->name('lote.mostrar-tabla');
    Route::post('lote-eliminar-temporal',[LoteController::class,'destroyTemporal'])->name('lote.eliminar-temporal');
    Route::post('lote-eliminar-permanente',[LoteController::class,'destroyPermanente'])->name('lote.eliminar-permanente');
    Route::post('lote-restaurar',[LoteController::class,'restaurar'])->name('lote.restaurar');

    //PELADOS QUÍMICOS
    Route::get('lote-buscar',[PeladoQuimicoController::class,'buscarLote'])->name('pelado-quimico-buscar.buscar-lote');
    Route::get('pelado-quimico-todos', [PeladoQuimicoController::class,'todos'])->name('pelado-quimico.todos');
    Route::get('pelado-quimico-habilitados', [PeladoQuimicoController::class,'habilitados'])->name('pelado-quimico.habilitados');
    Route::get('pelado-quimico-eliminados', [PeladoQuimicoController::class,'eliminados'])->name('pelado-quimico.eliminados');
    Route::get('pelado-quimico-mostrar', [PeladoQuimicoController::class,'mostrar'])->name('pelado-quimico.mostrar');
    Route::get('pelado-quimico-tabla',[PeladoQuimicoController::class,'mostrarTable'])->name('pelado-quimico.mostrar-tabla');
    Route::post('pelado-quimico-eliminar-temporal',[PeladoQuimicoController::class,'destroyTemporal'])->name('pelado-quimico.eliminar-temporal');
    Route::post('pelado-quimico-eliminar-permanente',[PeladoQuimicoController::class,'destroyPermanente'])->name('pelado-quimico.eliminar-permanente');
    Route::post('pelado-quimico-restaurar',[PeladoQuimicoController::class,'restaurar'])->name('pelado-quimico.restaurar');

    //RECTIFICADOS
    Route::get('lote-buscar',[RectificadoController::class,'buscarLote'])->name('rectificado-buscar.buscar-lote');
    Route::get('rectificado-todos', [RectificadoController::class,'todos'])->name('rectificado.todos');
    Route::get('rectificado-habilitados', [RectificadoController::class,'habilitados'])->name('rectificado.habilitados');
    Route::get('rectificado-eliminados', [RectificadoController::class,'eliminados'])->name('rectificado.eliminados');
    Route::get('rectificado-mostrar', [RectificadoController::class,'mostrar'])->name('rectificado.mostrar');
    Route::get('rectificado-tabla',[RectificadoController::class,'mostrarTable'])->name('rectificado.mostrar-tabla');
    Route::post('rectificado-eliminar-temporal',[RectificadoController::class,'destroyTemporal'])->name('rectificado.eliminar-temporal');
    Route::post('rectificado-eliminar-permanente',[RectificadoController::class,'destroyPermanente'])->name('rectificado.eliminar-permanente');
    Route::post('rectificado-restaurar',[RectificadoController::class,'restaurar'])->name('rectificado.restaurar');
});