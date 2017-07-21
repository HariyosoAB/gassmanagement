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

Route::get('/customer', function () {
    return view('pages/customer/create-order');
});

Route::get('login','userController@showlogin');
Route::post('login','userController@login');
Route::post('register','userController@register');

Route::get('logout','userController@logout');

Route::group(['middleware' => 'CustomerArea', 'prefix' => 'cust'],function(){
    Route::get('/create-order','customerController@orderForm');
    Route::post('/create-order','customerController@insertOrder');

});
