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
    return view('login');
});

//all
Route::get('/login',  'LoginController@index')->name('login');
Route::post('/login',  'LoginController@login');
Route::get('/logout',  'LoginController@logout');
Route::get('/del/{id}',  'AttachmentController@destroy');


Route::group(['middleware' => ['auth']], function() {
	Route::get('/changepass',  'UserController@changePass');
	Route::post('/changepass/{id}',  'UserController@changePassSubmit')->name('changepass');
	Route::post('/changehandler',  'TaskController@changehandler')->name('changehandler');
	Route::resource('attachments', 'AttachmentController');
	Route::resource('tasks', 'TaskController');
	Route::post('/updatestatus', 'TaskController@updatestatus')->name('updatestatus');
	Route::resource('payments', 'PaymentController');
	Route::resource('tagihans', 'TagihanController');
	Route::resource('pengeluarans', 'PengeluaranController');
	Route::get('/antrian',  'TaskController@antrian');
	Route::get('/history',  'TaskController@history')->name('history');
	Route::get('/getnotif',  'NotificationController@getNotif')->name('getnotif');
	Route::get('/clicknotif/{id}',  'NotificationController@clickNotif')->name('clicknotif');
	Route::get('/clearnotif',  'NotificationController@clearNotif')->name('clearnotif');
	Route::get('/notifikasi',  'NotificationController@index')->name('notifikasi');
	Route::get('/gettagihan/{id}',  'TagihanController@getTagihan');
	Route::get('/detailtagihan/{id}',  'TagihanController@detailTagihan');

	//admin
	Route::group(['middleware' => ['role:1']], function() {
		Route::get('/admin',  'AdminController@index')->name('admin');
		Route::match(['get', 'post'], '/statistiktask',  'TaskController@statistiktask')->name('stat_task');
		// Route::get('/getstatistik',  'TaskController@getstatistik')->name('getstat');
		Route::match(['get', 'post'], '/statistikpayment',  'PaymentController@statistikpayment')->name('stat_payment');
		
	});
	
	//karyawan
	Route::group(['middleware' => ['role:10']], function() {
		Route::get('/karyawan',  'AdminController@karyawan')->name('karyawan');
	});
	
	//admin && karyawan
	Route::group(['middleware' => ['role:1' OR 'role:10']], function() {
		Route::resource('users', 'UserController');
		Route::resource('laporankeuangan', 'LaporanKeuanganController');
		Route::match(['get', 'post'], '/laporankeuangan',  'LaporanKeuanganController@index')->name('filterKeuangan');
	});

	//customer
	//Route::group(['middleware' => ['role:80|90|99']], function() {
		Route::get('/customer',  'AdminController@customer')->name('customer');
	//});

});


