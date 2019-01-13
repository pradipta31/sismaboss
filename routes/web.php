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
