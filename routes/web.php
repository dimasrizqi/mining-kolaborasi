<?php

use Illuminate\Support\Facades\Route;

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
Route::resource('products','ProductController');


// login
Route::get('/login', 'otentikasi\OtentikasiController@index' )-> name('login') ;
Route::post('/login', 'otentikasi\OtentikasiController@login') -> name('login');
Route::get('/logout', 'otentikasi\OtentikasiController@logout') -> name('logout');
//midleware otentikasi
Route::group(['middleware' => 'auth'], function () {
    Route::get('/lihatuser', 'otentikasi\OtentikasiController@lihatuser' )-> name('lihat-user') ;
    Route::get('/tambahuser', 'otentikasi\OtentikasiController@tambah' )-> name('tambah-user') ;
    Route::post('/tambahuser/simpan', 'otentikasi\OtentikasiController@simpan') -> name('tambah-user-simpan');
    //profile user
    Route::get('/profile', 'otentikasi\OtentikasiController@profile' )-> name('profile') ;
    Route::post('/profile/simpan', 'otentikasi\OtentikasiController@profilesimpan') -> name('profile-user-simpan');
    //home
    Route::get('/home', 'homeController@index')->name('index');
    Route::get('/', 'homeController@index')->name('index');
    Route::delete('/userdel/{id}','datapelangganController@destroy')->name('userdel');
    Route::get('/reset/{id}','datapelangganController@resetpass')->name('resetpass');
    
    Route::post('/mining/kalkulasi/simpan', 'miningController@proses') -> name('mining.proses');
    Route::get('/mining/kalkulasi/{id}','miningController@kalkulasi')->name('mining.kalkulasi');
    Route::get('/mining/datadasar','miningController@datadasar')->name('mining.datadasar');
    Route::get('/mining/transaksimining','miningController@transaksimining')->name('mining.transaksimining');
    Route::resource('mining','miningController');
});