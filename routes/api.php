<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login',  'Api\LoginApiController@login');

// discord integration
Route::post('/hadir',  'Api\GlobalApiController@hadir');
Route::post('/izin/{id}',  'Api\GlobalApiController@izin');
Route::post('/wfh/{id}',  'Api\GlobalApiController@wfh');

Route::get('/check-presensi',  'Api\GlobalApiController@getUserBelumPresensi');

Route::group(['middleware' => ['auth:api']], function() {
	Route::resource('tasks', 'Api\TaskApiController');
	Route::resource('payments', 'Api\PaymentApiController');
    Route::get('/antrian',  'Api\TaskApiController@antrian');
    Route::get('/getcustomer',  'Api\GlobalApiController@getCustomer');
    Route::get('/getkaryawan',  'Api\GlobalApiController@getKaryawan');
    Route::get('/getattachment/{id}',  'Api\GlobalApiController@getAttachment');
    
    Route::get('/logout',  'Api\LoginApiController@logout');
});
