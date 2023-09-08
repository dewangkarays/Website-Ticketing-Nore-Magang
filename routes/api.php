<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardApiController;
use App\Models\Klien;


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
Route::get('/check-ulang-tahun',  'Api\GlobalApiController@getTodayUlangTahun');

//check token
Route::get('/check-token',  'Api\GlobalApiController@cektoken');

Route::group(['middleware' => ['auth:api','cors:api']], function() {
    
	Route::resource('tasks', 'Api\TaskApiController');
	Route::resource('payments', 'Api\PaymentApiController');
    Route::get('/antrian',  'Api\TaskApiController@antrian');
    Route::get('/getcustomer',  'Api\GlobalApiController@getCustomer');
    Route::get('/getkaryawan',  'Api\GlobalApiController@getKaryawan');
    Route::get('/getattachment/{id}',  'Api\GlobalApiController@getAttachment');
    // Get presensi

    Route::get('/userinfo',  'Api\QrcodeApiController@userinfo');
    Route::get('/getpresensi',  'Api\QrcodeApiController@getpresensi');
    Route::get('/createpresensi',  'Api\QrcodeApiController@create');
    Route::get('/statuspresensi',  'Api\QrcodeApiController@statuspresensi');
    Route::post('/storepresensi',  'Api\QrcodeApiController@store');
    Route::post('/storepresensiqr',  'Api\QrcodeApiController@storeqr');

    // Cuti
    // Route::get('/cuti', 'Api\CutiApiController@index'); //
    Route::get('/getcuti', 'Api\CutiApiController@create');
    // Route::get('/api/cuti', 'Api\CutiApiController@index');
    Route::post('/storecuti', 'Api\CutiApiController@store');
    Route::get('/get-verifikator/{id}', 'Api\CutiApiController@getverifikator');
    Route::get('/cuti/{status}', 'Api\CutiApiController@getcuti');
    Route::get('/statuscuti', 'Api\CutiApiController@statuscuti');

    Route::get('/logout',  'Api\LoginApiController@logout');
});

//Dashboard 
Route::group(['middleware' => ['cors:api']], function() {
    Route::get('/leads', 'Api\DashboardApiController@index');
    Route::get('/marketing', 'Api\DashboardApiController@getMarketingData');
});
