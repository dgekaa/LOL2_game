<?php

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

Route::prefix('admin')->group(function() {
    Route::get('/', 'AdminController@index');
});

Route::prefix('admin/simulations')->group(function() {
    Route::get('/', 'SimulationController@index');
    Route::get('/lol2', 'SimulationController@showLol2');
    Route::post('/lol2', 'SimulationController@executeSimulationLol2');
});
