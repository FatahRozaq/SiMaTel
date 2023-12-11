<?php

use App\Models\FasilitasHotel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AkunController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\ReservasiController;
use App\Http\Controllers\KamarHotelController;
use App\Http\Controllers\FasilitasHotelController;

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
    return view('welcome');
});

Auth::routes();

Route::group(['prefix' => 'dashboard/admin', 'middleware' => ['CheckRoles']], function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::group(['prefix' => 'profile'], function () {
        Route::get('/', [HomeController::class, 'profile'])->name('profile');
        Route::post('update', [HomeController::class, 'updateprofile'])->name('profile.update');
    });

    Route::controller(AkunController::class)
        ->prefix('akun')
        ->as('akun.')
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('showdata', 'dataTable')->name('dataTable');
            Route::match(['get','post'],'tambah', 'tambahAkun')->name('add');
            Route::match(['get','post'],'{id}/ubah', 'ubahAkun')->name('edit');
            Route::delete('{id}/hapus', 'hapusAkun')->name('delete');
    });
        
    Route::controller(PelangganController::class)
    ->prefix('pelanggan')
    ->as('pelanggan.')
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('showdata', 'dataTable')->name('dataTable');
        Route::match(['get','post'], 'tambah', 'tambahPelanggan')->name('add');
        Route::match(['get','post'], '{idPelanggan}/ubah', 'ubahPelanggan')->name('edit');
        Route::delete('{id}/hapus', 'hapusPelanggan')->name('delete');
        Route::get('export', 'export')->name('export');
        Route::post('import', 'import')->name('import');
    });

    Route::controller(FasilitasHotelController::class)
        ->prefix('fasilitas')
        ->as('fasilitas.')
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('showdata', 'dataTable')->name('dataTable');
            Route::match(['get','post'],'tambah', 'tambahFasilitas')->name('add');
            Route::match(['get','post'],'{idFasilitas}/ubah', 'ubahFasilitas')->name('edit');
            Route::delete('{id}/hapus', 'hapusAkun')->name('delete');
            Route::post('export-fasilitas', 'exportFasilitas')->name('export');
            Route::post('import-fasilitas', 'importFasilitas')->name('import');
            
        });

    Route::controller(StaffController::class)
        ->prefix('staff')
        ->as('staff.')
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('download', 'export')->name('dw');
            Route::post('import', 'imports')->name('imports');
            Route::post('showdata', 'dataTable')->name('dataTable');
            Route::match(['get','post'],'tambah', 'tambahStaff')->name('add');
            Route::match(['get','post'],'{idStaff}/ubah', 'ubahStaff')->name('edit');
            Route::delete('{id}/hapus', 'hapusStaff')->name('delete');
        });

    Route::controller(KamarHotelController::class)
        ->prefix('kamar')
        ->as('kamar.')
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('showdata', 'dataTable')->name('dataTable');
            Route::match(['get','post'],'tambah', 'tambahKamar')->name('add');
            Route::match(['get','post'],'{idKamar}/ubah', 'ubahKamar')->name('edit');
            Route::delete('{id}/hapus', 'hapusKamar')->name('delete');
            Route::post('export-kamar', 'exportKamar')->name('export');
            Route::post('import-kamar', 'importKamar')->name('import');
        });
});

Route::get('user/home', [HomeController::class, 'userHome'])->name('user.home');
Route::get('/userProfile', [HomeController::class, 'profile'])->name('user.profile');
Route::post('update', [HomeController::class, 'updateprofile'])->name('profile.update');
// Route::get('user/reservasi', [ReservasiController::class, 'index'])->name('user.reservasi');
// Route::match(['get', 'post'], 'user/buatReservasi', 'ReservasiController@buatReservasi')->name('user.reservasi.add');

Route::match(['get', 'post'], 'user/reservasi', [ReservasiController::class, 'index'])->name('user.reservasi');

