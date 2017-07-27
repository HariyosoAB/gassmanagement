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
Route::get('/', 'userController@showlogin');
Route::get('tes', function(){
  $data['nav'] = "history-occ";
  $data['delay'] = "execute";
  return view('pages.occ.problem-tagging',$data);
});
Route::get('login','userController@showlogin');
Route::post('login','userController@login');
Route::post('register','userController@register');

Route::get('logout','userController@logout');

Route::group(['middleware' => 'CustomerArea', 'prefix' => 'cust'],function(){
    Route::get('/create-order','customerController@orderForm');
    Route::get('/order-edit/{id}','customerController@editForm');
    Route::post('/order-edit/{id}','customerController@editOrder');
    Route::post('/create-order','customerController@insertOrder');
    Route::get('/on-progress','customerController@onprogressTable');
    Route::get('/completed','customerController@completedTable');
    Route::post('/cancel/{id}','customerController@cancel');
});

Route::group(['middleware' => 'OccArea', 'prefix' => 'occ'],function(){
    Route::get('/wait-exec','occController@waitExec');
    Route::get('/preview-order','occController@previewOrder');
    Route::get('/on-progress','occController@onprogressTable');
    Route::get('/completed','occController@completedTable');
    Route::get('/canceled','occController@canceledTable');
    Route::get('/all-order','occController@allTable');

    Route::get('/allocate/{id}','occController@allocateForm');
    Route::post('/allocate/{id}','occController@allocateOrder');

    Route::get('/execute/{id}','occController@executeOrder');
    Route::get('/finish/{id}','occController@finishOrder');

    Route::post('/problem-tagging/{id}','occController@problemTag');


});
