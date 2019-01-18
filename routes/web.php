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
    return view('app');
});

Route::get('ketua/anggota/{periode_id}', 'Ketua\MemberController@download');
Route::get('ketua/keuangan/{periode_id}', 'Ketua\KeuanganController@download');

Route::get('sekretaris/anggota/{periode_id}', 'Sekretaris\MemberController@download');
Route::get('sekretaris/absen/{periode_id}', 'Sekretaris\AbsenController@download');
Route::get('bendahara/keuangan/{periode_id}', 'Bendahara\KeuanganController@download');
