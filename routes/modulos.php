<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\MateriaPrimaController;
use App\Http\Controllers\LoteController;
use App\Http\Controllers\PeladoQuimicoController;
use App\Http\Controllers\RectificadoController;
use App\Http\Controllers\TrabajadorController;
use App\Http\Controllers\PlaqueadoController;
use App\Http\Controllers\CongeladoController;
use App\Http\Controllers\EnvasadoController;
use App\Http\Controllers\AlmacenadoController;
use App\Http\Controllers\ReporteController;

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
    Route::get('lote-listar',[LoteController::class,'listar'])->name('lote.listar');
    Route::get('lote-listar-fecha',[LoteController::class,'listarFechaPorLote'])->name('lote.listar-fecha');
    Route::get('lote-listar-datos',[LoteController::class,'ListarDatosLotes'])->name('lote.listar-datos');

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
    Route::get('trabajador-listar',[TrabajadorController::class,'listar'])->name('trabajador.listar');
    Route::get('rectificado-todos', [RectificadoController::class,'todos'])->name('rectificado.todos');
    Route::get('rectificado-habilitados', [RectificadoController::class,'habilitados'])->name('rectificado.habilitados');
    Route::get('rectificado-eliminados', [RectificadoController::class,'eliminados'])->name('rectificado.eliminados');
    Route::get('rectificado-mostrar', [RectificadoController::class,'mostrar'])->name('rectificado.mostrar');
    Route::get('rectificado-tabla',[RectificadoController::class,'mostrarTable'])->name('rectificado.mostrar-tabla');
    Route::post('rectificado-eliminar-temporal',[RectificadoController::class,'destroyTemporal'])->name('rectificado.eliminar-temporal');
    Route::post('rectificado-eliminar-permanente',[RectificadoController::class,'destroyPermanente'])->name('rectificado.eliminar-permanente');
    Route::post('rectificado-restaurar',[RectificadoController::class,'restaurar'])->name('rectificado.restaurar');
    Route::get('rectificado-por-lote',[RectificadoController::class,'obtenerRectificadoPorLote'])->name('rectificado.por-lote');

    //PLAQUEADOS
    Route::get('plaqueado-todos', [PlaqueadoController::class,'todos'])->name('plaqueado.todos');
    Route::get('plaqueado-habilitados', [PlaqueadoController::class,'habilitados'])->name('plaqueado.habilitados');
    Route::get('plaqueado-eliminados', [PlaqueadoController::class,'eliminados'])->name('plaqueado.eliminados');
    Route::get('plaqueado-mostrar', [PlaqueadoController::class,'mostrar'])->name('plaqueado.mostrar');
    Route::get('plaqueado-tabla',[PlaqueadoController::class,'mostrarTable'])->name('plaqueado.mostrar-tabla');
    Route::post('plaqueado-eliminar-temporal',[PlaqueadoController::class,'destroyTemporal'])->name('plaqueado.eliminar-temporal');
    Route::post('plaqueado-eliminar-permanente',[PlaqueadoController::class,'destroyPermanente'])->name('plaqueado.eliminar-permanente');
    Route::post('plaqueado-restaurar',[PlaqueadoController::class,'restaurar'])->name('plaqueado.restaurar');
    Route::get('plaqueado-por-lote',[PlaqueadoController::class,'obtenerPlaqueadoPorLote'])->name('plaqueado.por-lote');

    //CONGELADOS
    Route::get('congelado-todos', [CongeladoController::class,'todos'])->name('congelado.todos');
    Route::get('congelado-habilitados', [CongeladoController::class,'habilitados'])->name('congelado.habilitados');
    Route::get('congelado-eliminados', [CongeladoController::class,'eliminados'])->name('congelado.eliminados');
    Route::get('congelado-mostrar', [CongeladoController::class,'mostrar'])->name('congelado.mostrar');
    Route::get('congelado-tabla',[CongeladoController::class,'mostrarTable'])->name('congelado.mostrar-tabla');
    Route::post('congelado-eliminar-temporal',[CongeladoController::class,'destroyTemporal'])->name('congelado.eliminar-temporal');
    Route::post('congelado-eliminar-permanente',[CongeladoController::class,'destroyPermanente'])->name('congelado.eliminar-permanente');
    Route::post('congelado-restaurar',[CongeladoController::class,'restaurar'])->name('congelado.restaurar');
    Route::get('congelado-por-lote',[CongeladoController::class,'obtenerCongeladoPorLote'])->name('congelado.por-lote');

    //ENVASADOS
    Route::get('envasado-todos', [EnvasadoController::class,'todos'])->name('envasado.todos');
    Route::get('envasado-habilitados', [EnvasadoController::class,'habilitados'])->name('envasado.habilitados');
    Route::get('envasado-eliminados', [EnvasadoController::class,'eliminados'])->name('envasado.eliminados');
    Route::get('envasado-mostrar', [EnvasadoController::class,'mostrar'])->name('envasado.mostrar');
    Route::get('envasado-tabla',[EnvasadoController::class,'mostrarTable'])->name('envasado.mostrar-tabla');
    Route::post('envasado-eliminar-temporal',[EnvasadoController::class,'destroyTemporal'])->name('envasado.eliminar-temporal');
    Route::post('envasado-eliminar-permanente',[EnvasadoController::class,'destroyPermanente'])->name('envasado.eliminar-permanente');
    Route::post('envasado-restaurar',[EnvasadoController::class,'restaurar'])->name('envasado.restaurar');
    Route::get('envasado-por-lote',[EnvasadoController::class,'obtenerEnvasadoPorLote'])->name('envasado.por-lote');
    //ALMACENADO
    Route::get('almacenado-todos', [AlmacenadoController::class,'todos'])->name('almacenado.todos');
    Route::get('almacenado-habilitados', [AlmacenadoController::class,'habilitados'])->name('almacenado.habilitados');
    Route::get('almacenado-eliminados', [AlmacenadoController::class,'eliminados'])->name('almacenado.eliminados');
    Route::get('almacenado-mostrar', [AlmacenadoController::class,'mostrar'])->name('almacenado.mostrar');
    Route::get('almacenado-tabla',[AlmacenadoController::class,'mostrarTable'])->name('almacenado.mostrar-tabla');
    Route::post('almacenado-eliminar-temporal',[AlmacenadoController::class,'destroyTemporal'])->name('almacenado.eliminar-temporal');
    Route::post('almacenado-eliminar-permanente',[AlmacenadoController::class,'destroyPermanente'])->name('almacenado.eliminar-permanente');
    Route::post('almacenado-restaurar',[AlmacenadoController::class,'restaurar'])->name('almacenado.restaurar');
    Route::get('almacenado-por-lote',[AlmacenadoController::class,'obtenerAlmacenadoPorLote'])->name('almacenado.por-lote');

    Route::get('reporte-lotes',[ReporteController::class,'obtenerLote'])->name('reporte-lotes.lotes');
});