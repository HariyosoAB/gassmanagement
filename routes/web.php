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
Route::get('getnotif','userController@getNotif');
Route::get('editaccount/{id}','userController@formEditAccount');
Route::post('editaccount/{id}','userController@editAccount');

Route::get('logout','userController@logout');

Route::group(['middleware' => 'CustomerArea', 'prefix' => 'cust'],function(){
    Route::get('/create-order','customerController@orderForm');
    Route::get('/order-edit/{id}','customerController@editForm');
    Route::get('/order-detail/{id}','customerController@detailForm');
    Route::post('/order-edit/{id}','customerController@editOrder');
    Route::post('/create-order','customerController@insertOrder');
    Route::get('/on-progress','customerController@onprogressTable');
    Route::get('/completed','customerController@completedTable');
    Route::post('/cancel/{id}','customerController@cancel');
});

Route::group(['middleware' => 'OccArea', 'prefix' => 'occ'],function(){
    // Route::get('/wait-exec','occController@waitExec');
    Route::get('/preview-order','occController@previewOrder');
    // Route::get('/on-progress','occController@onprogressTable');
    // Route::get('/completed','occController@completedTable');
    // Route::get('/canceled','occController@canceledTable');
    // Route::get('/all-order','occController@allTable');
    // Route::get('/order-detail/{id}','occController@detail');

    Route::get('/allocate/{id}','occController@allocateForm');
    Route::post('/allocate/{id}','occController@allocateOrder');

    Route::get('/execute/{id}','occController@executeOrder');
    Route::get('/finish/{id}','occController@finishOrder');

    Route::post('/problem-tagging/{id}','occController@problemTag');
    Route::post('/delayorder/{id}','occController@delayOrder');

    Route::get('/checkallocation/{id}/{date}','occController@checkAllocation');
    Route::post('/cancel/{id}','occController@cancel');

    // Route::get('/allocation/{id}/{date}','occController@allocationajax');
    // Route::get('/allocation','occController@allocation');

    // Route::get('/probtag/{id}','occController@modalproblem');

    Route::post('/realloc/{id}','occController@reallocateOrder');
    Route::get('/checkused/{id}/{date}','occController@checkUsed');



//  CRUD AC
    Route::get('/actable','occController@actable');
    Route::post('/insert-ac','occController@insertAC');
    Route::get('/edit-ac/{id}','occController@formAC');
    Route::post('/edit-ac/{id}','occController@editAC');
    Route::get('/delete-ac/{id}','occController@deleteAC');
//  CRUD MANPOWER
    Route::get('/mantable','occController@manpowertable');
    Route::post('/insert-manpower','occController@insertManpower');
    Route::get('/edit-manpower/{id}','occController@formManpower');
    Route::post('/edit-manpower/{id}','occController@editManpower');
    Route::get('/delete-manpower/{id}','occController@deleteManpower');
//  CRUD ROOTCAUSE
    Route::get('/rootcausetable','occController@rootcausetable');
    Route::post('/insert-rootcause','occController@insertRootCause');
    Route::get('/edit-rootcause/{id}','occController@formRootCause');
    Route::post('/edit-rootcause/{id}','occController@editRootCause');
    Route::get('/delete-rootcause/{id}','occController@deleteRootCause');
//  CRUD AIRLINE
    Route::get('/airlinetable','occController@airlinetable');
    Route::post('/insert-airline','occController@insertAirline');
    Route::get('/edit-airline/{id}','occController@formAirline');
    Route::post('/edit-airline/{id}','occController@editAirline');
    Route::get('/delete-airline/{id}','occController@deleteAirline');
//  CRUD EQUIPMENT
    Route::get('/equipmenttable','occController@equipmenttable');
    Route::post('/insert-equipment','occController@insertEquipment');
    Route::post('/add-equipment/{id}','occController@addEquipment');
    Route::get('/many-equipment/{id}','occController@manyEquipment');
    Route::get('/edit-equipment/{id}','occController@formEquipment');
    Route::post('/edit-equipment/{id}','occController@editEquipment');
    Route::get('/edit-many/{id}','occController@formMany');
    Route::post('/edit-many/{id}','occController@editMany');
    Route::get('/delete-equipment/{id}','occController@deleteEquipment');
    Route::get('/delete-many/{id}','occController@deleteMany');

});

Route::group(['middleware' => 'omMiddleware', 'prefix' => 'occ'],function(){
    Route::get('/wait-exec','occController@waitExec');
    Route::get('/on-progress','occController@onprogressTable');
    Route::get('/completed','occController@completedTable');
    Route::get('/canceled','occController@canceledTable');
    Route::get('/all-order','occController@allTable');

    Route::get('/allocation/{id}/{date}','occController@allocationajax');
    Route::get('/allocation','occController@allocation');

    Route::get('/probtag/{id}','occController@modalproblem');

    Route::get('/order-detail/{id}','occController@detail');
    Route::get('/ajaxAllTable', 'occController@ajaxAllTable');
    Route::get('/ajaxCompleted', 'occController@ajaxCompleted');
});

Route::group(['middleware' => 'ManagementArea', 'prefix' => 'management'],function(){
    Route::get('/daily', function(){
        $data['nav'] = "report";
        return view('pages.management.input', $data);
    });
    Route::get('/weekly', function(){
        $data['nav'] = "report";
        return view('pages.management.input2', $data);
    });
    Route::get('/monthly', function(){
        $data['nav'] = "report";
        return view('pages.management.input3', $data);
    });
    Route::get('/pantau', 'managementController@pantau');
    Route::get('/order-detail/{id}','managementController@detail');
    Route::get('/export-day/{waktu}','managementController@export_day');
    Route::get('/export-week/{waktu}','managementController@export_week');
    Route::get('/export-month/{waktu}','managementController@export_month');
    Route::post('/graph1','managementController@graph1');
    Route::post('/graph2','managementController@graph2');
    Route::post('/graph3','managementController@graph3');

});
