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
	Route::resource('setting', 'SettingController');
	Route::get('/changepass',  'UserController@changePass');
	Route::post('/changepass/{id}',  'UserController@changePassSubmit')->name('changepass');
	Route::post('/changehandler',  'TaskController@changehandler')->name('changehandler');
	Route::resource('attachments', 'AttachmentController');
	Route::resource('tasks', 'TaskController');
	Route::post('/updatestatus', 'TaskController@updatestatus')->name('updatestatus');
	Route::resource('payments', 'PaymentController');
	Route::post('/terimapayment', 'PaymentController@statuspayment')->name('terimapayment');
	Route::post('/tolakpayment', 'PaymentController@statuspayment')->name('tolakpayment');
	Route::get('payments/cetak/{id}',  'PaymentController@cetak')->name('cetak');
	Route::get('export_excel', 'PaymentController@export_excel');
	Route::resource('tagihans', 'TagihanController');
	Route::get('tagihans/cetak/{id}',  'TagihanController@cetak')->name('cetak');
	Route::get('exporttagihan', 'TagihanController@export_excel');
	Route::get('tagihans/lampiran/{id}',  'TagihanController@lampiran')->name('lampiran');
	Route::get('getweb/{id}',  'TagihanController@getweb');
	Route::get('getkadaluarsa/{nama_proyek}',  'TagihanController@getkadaluarsa');
	Route::post('tagihans/lampiran/{id}',  'TagihanController@lampiran')->name('lampiran');
	Route::post('tagihans/lampirandestroy/{id}/{idm}', 'TagihanController@lampirandestroy')->name('lampirandestroy');
	Route::match(['get', 'post'], '/tagihanuser',  'TagihanController@tagihanuser')->name('tagihanuser');
	Route::get('/bayaruser/{id}', 'TagihanController@bayaruser')->name('bayaruser');
	Route::resource('pengeluarans', 'PengeluaranController');
	Route::get('export_excel_pengeluaran', 'PengeluaranController@export_excel_pengeluaran');
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

	//keuangan
	Route::group(['middleware' => ['role:20']], function() {
		Route::get('/keuangan',  'AdminController@keuangan')->name('keuangan');
	});
	
	//admin && karyawan
	Route::group(['middleware' => ['role:1' OR 'role:10']], function() {
		Route::resource('laporankeuangan', 'LaporanKeuanganController');
		Route::match(['get', 'post'], '/laporankeuangan',  'LaporanKeuanganController@index')->name('filterKeuangan');
		// Route::post('/laporankeuangan',  'LaporanKeuanganController@index')->name('filterbulan');
	});
	
	Route::group(['middleware' => ['role:1' OR 'role:10' OR 'role:20']], function() {
		Route::get('createtagihan/{id}',  'TagihanController@createtagihan')->name('createtagihan');
		Route::resource('users', 'UserController');
		Route::resource('members', 'MemberController');
		Route::resource('proyeks', 'ProyekController');
		Route::get('getproyek/{id}', 'TagihanController@getproyek');
	});

	//customer
	Route::group(['middleware' => ['role:80' OR 'role:90' OR 'role:99']], function() {
		Route::get('/customer',  'AdminController@customer')->name('customer');
		Route::get('/tagihanclient','client\TagihanClient@index');
		Route::get('/tagihanaktif','client\TagihanClient@active');
		Route::get('/tagihanriwayat','client\TagihanClient@history');
		Route::resource('/paymentclients', 'client\PaymentClient');
		Route::get('/payment','client\PaymentClient@index');
		Route::get('/purchase','client\PaymentClient@create');
		// Route::get('/purchase/{id}','client\PaymentClient@create');
		// Route::view('/dashboard','/client/layout');
		Route::resource('/taskclients', 'client\TaskClient');
		Route::get('/taskclient','client\TaskClient@index');
		Route::get('/taskcreate','client\TaskClient@create');
		// Route::post('/taskclient','client\TaskClient@store');
		Route::get('/antrian','client\AntrianClient@index');
	});
});