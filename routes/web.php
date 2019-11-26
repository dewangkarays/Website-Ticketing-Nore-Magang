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

Route::get('/login',  'LoginController@index')->name('login');
Route::post('/login',  'LoginController@login');
Route::get('/logout',  'LoginController@logout');
Route::get('/clearnotif',  'NotificationController@clearNotif');

//admin
Route::group(['middleware' => ['auth', 'role:1']], function() {
	Route::get('/admin',  'AdminController@index')->name('admin');
	Route::resource('users', 'UserController');
	Route::resource('tasks', 'TaskController');
	Route::resource('attachments', 'AttachmentController');
	Route::resource('payments', 'PaymentController');
});