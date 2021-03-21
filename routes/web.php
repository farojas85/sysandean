<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SistemaController;
use App\Http\Controllers\UserController;

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
});

Route::group(['middleware' => 'auth'], function(){
    Route::get('usuario-habilitados', [UserController::class,'obtenerHabilitados'])->name('usuario.habilitados');
    Route::get('usuario-tabla',[UserController::class,'mostrarTable'])->name('usuario.mostrar-tabla');
});

