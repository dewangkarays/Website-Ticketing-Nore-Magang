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
	//Kantor
	Route::group(['middleware' => ['role:1,10,20']], function() {
		Route::resource('setting', 'SettingController');
		Route::get('/changepass',  'UserController@changePass');
		Route::post('/changepass/{id}',  'UserController@changePassSubmit')->name('changepass');
		// Route::post('/changehandler',  'TaskController@changehandler')->name('changehandler');
		Route::resource('attachments', 'AttachmentController');
		// Route::resource('tasks', 'TaskController');
		Route::post('/updatestatus', 'TaskController@updatestatus')->name('updatestatus');
		Route::resource('payments', 'PaymentController');
		Route::post('payments/changestatus', 'PaymentController@changestatus')->name('payments.changestatus');
		Route::resource('pemasukans', 'PemasukanLainController');
		Route::post('/terimapayment', 'PaymentController@statuspayment')->name('terimapayment');
		Route::post('/tolakpayment', 'PaymentController@statuspayment')->name('tolakpayment');
		Route::get('payments/cetak/{id}',  'PaymentController@cetak')->name('cetak');
		Route::get('export_excel', 'PaymentController@export_excel');
		Route::resource('tagihans', 'TagihanController');
		// Route::get('tagihans/cetak/{id}',  'TagihanController@cetak')->name('cetak');
		Route::get('exporttagihan', 'TagihanController@export_excel');
		// Route::get('tagihans/lampiran/{id}',  'TagihanController@lampiran')->name('lampiran');
		Route::get('getweb/{id}',  'TagihanController@getweb');
		Route::get('getkadaluarsa/{nama_proyek}',  'TagihanController@getkadaluarsa');
		Route::get('getmasa_berlaku/{id}',  'TagihanController@getmasa_berlaku');
		// Route::post('tagihans/lampiran/{id}',  'TagihanController@lampiran')->name('lampiran');
		// Route::post('tagihans/lampirandestroy/{id}/{idm}', 'TagihanController@lampirandestroy')->name('lampirandestroy');
		Route::get('rekapdptagihan/lampiran/{id}',  'RekapDptagihanController@lampiran')->name('lampiran_rdp');
		Route::post('rekapdptagihan/lampiran/{id}',  'RekapDptagihanController@lampiran')->name('lampiran_rdp');
		Route::post('rekapdptagihan/lampirandestroy/{id}/{idm}', 'RekapDptagihanController@lampirandestroy')->name('lampirandestroy');

		Route::get('rekaptagihan/lampiran/{id}',  'RekapTagihanController@lampiran')->name('lampiran_rt');
		Route::post('rekaptagihan/lampiran/{id}',  'RekapTagihanController@lampiran')->name('lampiran_rt');
		Route::post('rekaptagihan/lampirandestroy/{id}/{idm}', 'RekapTagihanController@lampirandestroy')->name('lampirandestroy');
		Route::match(['get', 'post'], '/tagihanuser',  'TagihanController@tagihanuser')->name('tagihanuser');
		Route::resource('rekaptagihans','RekapTagihanController');
		Route::resource('rekapdptagihans','RekapDptagihanController');
		Route::get('createrekap', 'RekapTagihanController@createrekap')->name('createrekap');
		Route::get('cetakrekap/{id}',  'RekapTagihanController@cetakrekap')->name('cetakrekap');
		Route::get('cetakrekapdp/{id}',  'RekapDptagihanController@cetakrekap')->name('cetakrekapdp');
		Route::get('rekapinvalid/{id}', 'RekapTagihanController@invalid')->name('rekapinvalid');
		Route::get('rekapdpinvalid/{id}', 'RekapDptagihanController@invalid')->name('rekapdpinvalid');
		Route::get('/historytagihan',  'RekapTagihanController@history')->name('historytagihan');
		Route::get('/historydp',  'RekapDptagihanController@history')->name('historydp');
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
		// Route::get('/detailtagihan/{id}',  'TagihanController@detailTagihan');
		Route::get('/getrekaptagihan/{id}',  'RekapTagihanController@getRekapTagihan');
		Route::get('/detailrekaptagihan/{id}',  'RekapTagihanController@detailRekapTagihan');
		Route::get('/getradbox',  'RekapTagihanController@getRadBox');

		//TaskController
		Route::get('/tasks', 'TaskController@index')->name('tasks');
		Route::get('/tasks/create/', 'TaskController@create')->name('tasks.create');
		Route::post('/tasks/store', 'TaskController@store')->name('tasks.store');
		Route::get('/tasks/{id}/edit', 'TaskController@edit')->name('tasks.edit');
		Route::post('/tasks/{id}/update', 'TaskController@update')->name('tasks.update');
		Route::post('/tasks/{id}/destroy', 'TaskController@destroy')->name('tasks.destroy');
		Route::post('/changehandler',  'TaskController@changehandler')->name('changehandler');
		Route::post('/updatestatus', 'TaskController@updatestatus')->name('updatestatus');
		// Route::get('getdataproyek', 'TaskController@getdataproyek');

		Route::get('createtagihan/{id}',  'TagihanController@createtagihan')->name('createtagihan');
		Route::resource('users', 'UserController');
		Route::resource('members', 'MemberController');
		Route::resource('proyeks', 'ProyekController');
		Route::get('getproyek/{id}', 'TagihanController@getproyek');

		// url ajax serverside datatables
		Route::get('getkaryawans', 'UserController@getkaryawans');
		Route::get('getmembers', 'MemberController@getmembers');
		Route::get('getproyeks', 'ProyekController@getproyeks');
		Route::get('gettasks/{type}', 'TaskController@gettasks');
		Route::get('gettaskshistory', 'TaskController@gettaskshistory');
		Route::get('gettagihans', 'TagihanController@gettagihans');
		Route::get('getrekapdp/{status}', 'RekapDptagihanController@getrekapdp');
		Route::get('getrekap/{status}', 'RekapTagihanController@getrekap');
		Route::get('getpayments', 'PaymentController@getpayments');
		Route::get('getpengeluarans', 'PengeluaranController@getpengeluarans');
		Route::get('getpemasukans', 'PemasukanLainController@getpemasukans');

		// Routing Cuti
		Route::get('/cuti', 'CutiController@index')->name('cuti');
		Route::get('/history-cuti', 'CutiController@historycuti')->name('cuti.history');
		Route::get('/cuti/create', 'CutiController@create')->name('cuti.create');
		Route::post('/cuti/store', 'CutiController@store')->name('cuti.store');
		Route::get('/cuti/{id}', 'CutiController@show')->name('cuti.show');
		Route::get('/cuti/{id}/edit', 'CutiController@edit')->name('cuti.edit');
		Route::post('/cuti/{id}/update', 'CutiController@update')->name('cuti.update');
		Route::post('/cuti/{id}/delete', 'CutiController@destroy')->name('cuti.delete');
		Route::get('/cuti/{id}/invalid', 'CutiController@invalid')->name('cuti.invalid');
		Route::get('/cuti/{id}/cetaksuratcuti', 'CutiController@cetaksuratcuti')->name('cetaksuratcuti');
		Route::get('/getcuti/{status}', 'CutiController@getcuti')->name('getcuti');
		Route::get('/getverifikator', 'CutiController@getverifikator');

	});

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
	Route::group(['middleware' => ['role:1,10']], function() {
		Route::resource('laporankeuangan', 'LaporanKeuanganController');
		Route::match(['get', 'post'], '/laporankeuangan',  'LaporanKeuanganController@index')->name('filterKeuangan');
        Route::get('cetaklaporan/{filter}/{filterbulan}',  'LaporanKeuanganController@cetaklaporan')->name('cetaklaporan');
        Route::get('exportlaporan/{filter}/{filterbulan}',  'LaporanKeuanganController@exportlaporan')->name('exportlaporan');
		// Route::post('/laporankeuangan',  'LaporanKeuanganController@index')->name('filterbulan');
	});

	//customer
	Route::group(['middleware' => ['role:95']], function() {
		Route::get('/customer',  'AdminController@customer')->name('customer');
		Route::get('/tagihanclient','client\TagihanClient@index');
		Route::get('/tagihanaktif','client\TagihanClient@active');
		Route::get('/tagihanriwayat','client\TagihanClient@history');
		Route::resource('/paymentclients', 'client\PaymentClient');
		Route::get('/payment','client\PaymentClient@index');
		Route::get('/purchase','client\PaymentClient@create');
		Route::resource('/taskclients', 'client\TaskClient');
		Route::get('/taskclient','client\TaskClient@index');
		Route::get('/taskcreate','client\TaskClient@create');
		Route::get('/antrian','client\AntrianClient@index');
		Route::get('/settinguser','client\SettingClient@changesetting');
		Route::post('/settinguser/{id}','client\SettingClient@changesettingupdate')->name('settinguser');
		Route::get('/detailtagihan/{id}',  'TagihanController@detailTagihan');
	});

	// Route::group(['middleware' => ['role:95']], function() {
	// 	Route::get('/customer', 'AdminController@customer')->name('customer');
	// });
	// Route::get('gettasks/{type}', 'TaskController@gettasks');
});