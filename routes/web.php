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

Route::get('/', 'DashboardController@index');

Route::get('/logout', 'Auth\LoginController@logout');

Route::group(['prefix' => 'ajax'], function () {
    Route::get('form/apicallurl', 'FormController@getCallUrl');
    Route::post('order/create', 'OrderController@postCreate');
});

Route::get('/test.html','TestController@index');

Auth::routes();
