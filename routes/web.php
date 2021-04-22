<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MateriaPrimaController;
use App\Http\Controllers\SistemaController;
use App\Http\Controllers\TrabajadorController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoteController;
use App\Http\Controllers\PeladoQuimicoController;
use App\Http\Controllers\PlaqueadoController;
use App\Http\Controllers\RectificadoController;
use App\Http\Controllers\CongeladoController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::group(['prefix' => 'sistema', 'middleware' => 'auth'], function(){
    Route::get('/', [SistemaController::class,'index']);
});

Route::group(['middleware' => 'auth'], function() {
    Route::resource('user', UserController::class);
    Route::resource('trabajador', TrabajadorController::class);
    Route::resource('materia-prima', MateriaPrimaController::class);
    Route::resource('lote', LoteController::class);
    Route::resource('pelado-quimico', PeladoQuimicoController::class);
    Route::resource('rectificado', RectificadoController::class);
    Route::resource('plaqueado', PlaqueadoController::class);
    Route::resource('congelado', CongeladoController::class);
});

