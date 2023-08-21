<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('plataforma')->group(function () {
    Route::post('/registrar', 'App\Http\Controllers\AuthController@registrar');
    Route::post('/login', 'App\Http\Controllers\AuthController@login');
    Route::post('/logout/{id_usuario}', 'App\Http\Controllers\AuthController@logout');
    Route::get('/usuario/{id_usuario}/sesion/{id_sesion}', 'App\Http\Controllers\UsuarioController@obtenerUsuario');

    Route::post('resetear-contrasenia', 'App\Http\Controllers\ResetContraseniaController@resetContrasenia');

    Route::put('/actualizar', 'App\Http\Controllers\UsuarioController@actualizarUsuario');
    Route::get('/datos-graficas', 'App\Http\Controllers\GraficasController@generarDatosGraficas');
});




