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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/index', 'PageController@index');

Route::group(['namespace' => 'Api'], function () {
    Route::get('startGame', 'BridgeController@startGame');
    Route::get('add-credit', 'BridgeController@addCreadit');

    Route::get('api-v2/action', 'GameControllerV2@action');
});
