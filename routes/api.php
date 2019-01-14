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

Route::group(['middleware' => 'api','prefix' => 'auth'], function ($router) {
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
});
Route::group(['middleware' => 'api'], function ($router){
    Route::get('profile/{id}', 'ProfileController@getProfile');
    Route::put('profile/{id}', 'ProfileController@updateProfile');
    Route::post('profile/avatar', 'ProfileController@updateAvatar');
    Route::get('profile/show/{id}', 'ProfileController@showProfile');
});
Route::group(['middleware' => 'api', 'namespace' => 'Admin'], function ($router){
    Route::get('periode', 'PeriodeController@getPeriode');
    Route::post('periode/', 'PeriodeController@createPeriode');
    Route::get('periode/edit/{id}', 'PeriodeController@editPeriode');
    Route::put('periode/edit/{id}', 'PeriodeController@updatePeriode');
    Route::delete('periode/{id}', 'PeriodeController@deletePeriode');

    Route::get('ketua/tambah-ketua', 'KetuaController@getPeriode');
    Route::post('ketua/tambah-ketua/','KetuaController@createKetua');
    Route::get('ketua','KetuaController@getKetua');
    Route::delete('ketua/{id}' ,'KetuaController@deleteKetua');
    Route::get('ketua/show/{id}', 'KetuaController@showKetua');
    Route::get('ketua/{id}', 'KetuaController@editKetua');
    Route::put('ketua/{id}', 'KetuaController@updateKetua');
});

Route::group(['middleware' => 'api', 'namespace' => 'Ketua'], function ($router){
    Route::get('pengurus', 'PengurusController@getPengurus');
    Route::post('pengurus/tambah-pengurus/', 'PengurusController@createPengurus');
    Route::get('pengurus/show/{id}', 'PengurusController@showPengurus');
    Route::get('pengurus/{id}', 'PengurusController@editPengurus');
    Route::put('pengurus/{id}', 'PengurusController@updatePengurus');
    Route::delete('pengurus/{id}', 'PengurusController@deletePengurus');

    Route::get('rapat','RapatController@getRapat');
    Route::get('rapat/{id}', 'RapatController@showRapat');

    Route::get('keuangan', 'KeuanganController@getKeuangan');
    Route::get('surat', 'LetterController@getLetter');
    Route::get('surat/show/{id}', 'LetterController@showLetter');

    Route::get('anggota', 'MemberController@getData');

    Route::get('event', 'EventController@getEvent');
    Route::get('event/{id}', 'EventController@showEvent');

    Route::get('anggota/show/{id}', 'MemberController@saveExcel');

    Route::get('inventaris', 'InventarisController@getInventaris');
    Route::get('inventaris/show/{id}', 'InventarisController@showInventaris');

    Route::get('absen', 'AbsenController@getData');
    Route::get('absen/show/{id}', 'AbsenController@showAbsen');
    Route::get('absen/lihat-absen/{id}', 'AbsenController@lihatAbsen');
}); 

Route::group(['middleware' => 'api', 'namespace' => 'Wakil'], function ($router){
    Route::get('rapat','RapatController@getRapat');
    Route::get('rapat/{id}', 'RapatController@showRapat');

    Route::get('event', 'EventController@getEvent');
    Route::get('event/{id}', 'EventController@showEvent');

    Route::get('keuangan', 'KeuanganController@getKeuangan');
    Route::get('surat', 'LetterController@getLetter');
    Route::get('surat/show/{id}', 'LetterController@showLetter');

    Route::get('anggota', 'MemberController@getData');
});

Route::group(['middleware' => 'api', 'namespace' => 'Sekretaris'], function ($router){
    Route::post('anggota/tambah-anggota', 'MemberController@createMember');
    Route::get('anggota', 'MemberController@getMember');
    Route::get('anggota/edit/{id}', 'MemberController@editMember');
    Route::put('anggota/edit/{id}', 'MemberController@updateMember');
    Route::delete('anggota/{id}', 'MemberController@deleteMember');

    Route::post('surat/tambah-surat/', 'LetterController@createLetter');

    Route::get('surat-masuk','LetterController@getSuratMasuk');
    Route::get('surat-masuk/edit/{id}','LetterController@editSuratMasuk');
    Route::put('surat-masuk/edit/{id}', 'LetterController@updateSuratMasuk');
    Route::post('surat-masuk/{id}', 'LetterController@ubahSuratMasuk');
    Route::get('surat-masuk/show/{id}','LetterController@showSuratMasuk');

    Route::get('surat-keluar','LetterController@getSuratKeluar');
    Route::get('surat-keluar/download/{id}', 'LetterController@downloadSuratKeluar');
    Route::get('surat-keluar/edit/{id}', 'LetterController@editSuratKeluar');
    Route::put('surat-keluar/edit/{id}', 'LetterController@updateSuratKeluar');
    Route::post('surat-keluar/{id}', 'LetterController@ubahSuratKeluar');
    Route::get('surat-keluar/show/{id}', 'LetterController@showSuratKeluar');

    Route::delete('surat/{id}', 'LetterController@deleteSurat');
    
    Route::get('absen/tambah/{id}', 'AbsenController@getAbsenT');
    Route::post('absen/tambah/{id}', 'AbsenController@createAbsenT');
    Route::delete('absen/tambah/{id}', 'AbsenController@deleteAbsenT');

    Route::get('absen', 'AbsenController@getAbsen');
    Route::post('absen/', 'AbsenController@createAbsen');
    Route::get('absen/show/{id}', 'AbsenController@showAbsen');
    Route::get('absen/edit/{id}', 'AbsenController@editAbsen');
    Route::put('absen/edit/{id}', 'AbsenController@updateAbsen');
    Route::delete('absen/{id}', 'AbsenController@deleteAbsen');

    Route::get('rapat','RapatController@getRapat');
    Route::post('rapat/', 'RapatController@createRapat');
    Route::get('rapat/{id}', 'RapatController@showRapat');
    Route::get('rapat/edit/{id}', 'RapatController@editRapat');
    Route::put('rapat/edit/{id}', 'RapatController@updateRapat');
    Route::delete('rapat/{id}', 'RapatController@deleteRapat');

    Route::get('event', 'EventController@getEvent');
    Route::post('event/', 'EventController@createEvent');
    Route::get('event/{id}', 'EventController@showEvent');
    Route::get('event/edit/{id}', 'EventController@editEvent');
    Route::put('event/edit/{id}', 'EventController@updateEvent');
    Route::delete('event/{id}', 'EventController@deleteEvent');

    Route::get('inventaris', 'InventarisController@getInventaris');
    Route::post('inventaris/tambah-inventaris/', 'InventarisController@createInventaris');
    Route::get('inventaris/show/{id}', 'InventarisController@showInventaris');
    Route::get('inventaris/edit/{id}', 'InventarisController@editInventaris');
    Route::put('inventaris/edit/{id}', 'InventarisController@updateInventaris');
    Route::delete('inventaris/{id}', 'InventarisController@deleteInventaris');
});

Route::group(['middleware' => 'api', 'namespace' => 'Bendahara'], function ($router){
    Route::get('keuangan', 'KeuanganController@getKeuangan');
    Route::post('keuangan/tambah-keuangan', 'KeuanganController@createKeuangan');
    Route::get('keuangan/edit/{id}', 'KeuanganController@editKeuangan');
    Route::put('keuangan/edit/{id}', 'KeuanganController@updateKeuangan');
    Route::delete('keuangan/{id}', 'KeuanganController@deleteKeuangan');

    Route::get('keuangan/result', 'KeuanganController@getResult');
    Route::post('keuangan/tambah-saldo', 'KeuanganController@createSaldo');
});
