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
    Route::get('order/list', 'OrderController@getList');
    Route::get('order/detail', 'OrderController@getDetail');
    Route::post('order/create', 'OrderController@postCreate');
    Route::post('order/update', 'OrderController@postUpdate');
    Route::get('payment/autolist', 'PaymentController@getAutoCompleteList');
});

Route::get('/test.html','TestController@index');

Auth::routes();
