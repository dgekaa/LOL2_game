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
    Route::get('/{alias}', 'SimulationController@show');
    Route::post('/{alias}', 'SimulationController@showResult');
});

Route::prefix('admin/percent-manager')->group(function() {
    Route::get('/', 'PercentManagerController@index');
    Route::get('/{alias}', 'PercentManagerController@edit');
    Route::post('/{alias}', 'PercentManagerController@update');
});

Route::prefix('admin/statistics')->group(function() {
    Route::get('/', 'StatisticsController@index');
    Route::get('/{alias}', 'StatisticsController@show');
});
