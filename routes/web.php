<?php

use App\Models\FasilitasHotel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AkunController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\FasilitasHotelController;
use App\Http\Controllers\StaffController;

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

Route::group(['prefix' => 'dashboard/admin'], function () {
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
        });

    Route::controller(StaffController::class)
        ->prefix('staff')
        ->as('staff.')
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('showdata', 'dataTable')->name('dataTable');
            Route::match(['get','post'],'tambah', 'tambahStaff')->name('add');
            Route::match(['get','post'],'{idStaff}/ubah', 'ubahStaff')->name('edit');
            Route::delete('{id}/hapus', 'hapusStaff')->name('delete');
        });
});
