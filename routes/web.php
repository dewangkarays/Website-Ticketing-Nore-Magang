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


Route::group(['middleware' => ['auth']], function() {
	Route::get('/clearnotif',  'NotificationController@clearNotif');
	Route::get('/changepass',  'UserController@changePass');
	Route::post('/changepass/{id}',  'UserController@changePassSubmit')->name('changepass');
	Route::resource('tasks', 'TaskController');
	Route::resource('attachments', 'AttachmentController');

	//admin
	Route::group(['middleware' => ['role:1']], function() {
		Route::get('/admin',  'AdminController@index')->name('admin');
	});

	//karyawan
	Route::group(['middleware' => ['role:10']], function() {
		Route::get('/karyawan',  'AdminController@karyawan')->name('karyawan');
	});

	//admin && karyawan
	Route::group(['middleware' => ['role:1' OR 'role:10']], function() {
		Route::resource('users', 'UserController');
		Route::resource('payments', 'PaymentController');
	});

	//customer
	Route::group(['middleware' => ['role:99']], function() {
		Route::get('/customer',  'AdminController@customer')->name('customer');
	});

});


