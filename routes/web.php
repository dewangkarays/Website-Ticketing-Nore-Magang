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
	Route::get('/clearnotif',  'NotificationController@clearNotif');
	Route::get('/changepass',  'UserController@changePass');
	Route::post('/changepass/{id}',  'UserController@changePassSubmit')->name('changepass');
	Route::resource('attachments', 'AttachmentController');
	Route::resource('tasks', 'TaskController');
	Route::resource('payments', 'PaymentController');
	Route::get('/antrian',  'TaskController@antrian');
	Route::get('/history',  'TaskController@history');

	//admin
	Route::group(['middleware' => ['role:1']], function() {
		Route::get('/admin',  'AdminController@index')->name('admin');
		Route::resource('users', 'UserController');
	});

	//karyawan
	Route::group(['middleware' => ['role:10']], function() {
		Route::get('/karyawan',  'AdminController@karyawan')->name('karyawan');
	});

	//admin && karyawan
	Route::group(['middleware' => ['role:1' OR 'role:10']], function() {
	});

	//customer
	//Route::group(['middleware' => ['role:80|90|99']], function() {
		Route::get('/customer',  'AdminController@customer')->name('customer');
	//});

});


