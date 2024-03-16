<?php

use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\DepartemenController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\ConfigurasiCotroller;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
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

//LOGIN UNTUK KARYAWAN
Route::middleware(['guest:tbl_karyawan'])->group(function(){
    Route::get('/', function () {
        return view('auth.login');
    })->name('login');
    Route::POST('/prosesLogin', [AuthController::class, 'prosesLogin']);
});

// LOGIN UNTUK ADMIN
Route::middleware(['guest:user'])->group(function(){
    Route::get('/panel', function () {
        return view('auth.loginadmin');
    })->name('loginadmin');
  Route::POST('/prosesloginadmin', [AuthController::class, 'prosesloginadmin']);
});


Route::middleware(['auth:tbl_karyawan'])->group(function(){
Route::get('dashboard', [DashboardController::class, 'index']);
Route::get('/prosesLogout', [AuthController::class, 'prosesLogout']);
Route::get('/Absensi/create', [AbsensiController::class, 'create']);
Route::POST('/Absensi/store', [AbsensiController::class, 'store']);
// EDIT PROFILE ABSENSI
Route::get('/editprofile', [AbsensiController::class, 'editprofile']);
Route::POST('/Absensi/{kode_karyawan}/updateProfile', [AbsensiController::class, 'updateProfile']);
//HISTORI ABSENSI
Route::get('/Absensi/history', [AbsensiController::class, 'history']);
Route::POST('/gethistori', [AbsensiController::class, 'gethistori']);
//UNTU IZIN ABSENSI
Route::get('/Absensi/izin', [AbsensiController::class, 'izin']);
Route::get('/Absensi/buatizin', [AbsensiController::class, 'buatizin']);
Route::POST('/Absensi/storeizin', [AbsensiController::class, 'storeizin']);
Route::POST('/Absensi/cekpengajuanizin', [AbsensiController::class, 'cekpengajuanizin']);

});


Route::middleware(['auth:user'])->group(function(){
   // Route::get('/', [AuthController::class, 'prosesLogoutadmin']);
   // Route::get('/prosesLogoutadmin', [AuthController::class, 'prosesLogoutadmin']);
    Route::get('/prosesLogoutadmin', [AuthController::class, 'prosesLogoutadmin']);
    Route::get('/panel/dashboardadmin', [DashboardController::class, 'dashboardadmin']);
    
    //UNTUK KARYAWAN
    Route::get('/karyawan', [KaryawanController::class, 'index']);
    Route::POST('/karyawan/store', [KaryawanController::class, 'store']);
    Route::POST('/karyawan/edit', [KaryawanController::class, 'edit']);
    Route::POST('/karyawan/{kode_karyawan}/update', [KaryawanController::class, 'update']);
    Route::POST('/karyawan/{kode_karyawan}/delete', [KaryawanController::class, 'delete']);
    
    //UNTUK DEPARTEMEN
     Route::get('/departemen', [DepartemenController::class, 'index']);
     Route::POST('/departemen/store', [DepartemenController::class, 'store']);
     Route::POST('/departemen/edit', [DepartemenController::class, 'edit']);
     Route::POST('/departemen/{kode_deprt}/update', [DepartemenController::class, 'update']);
     Route::POST('/departemen/{kode_deprt}/delete', [DepartemenController::class, 'delete']);
    
    //  monitoring presnsi
    Route::get('/absensi/monitoring', [AbsensiController::class, 'monitoring']);
    Route::POST('/getabsensi', [AbsensiController::class, 'getabsensi']);
    Route::POST('/tampilkanpeta', [AbsensiController::class, 'tampilkanpeta']);
    Route::get('/absensi/laporan', [AbsensiController::class, 'laporan']);
    Route::POST('/absensi/cetaklaporan', [AbsensiController::class, 'cetaklaporan']);
    Route::get('/absensi/rekap', [AbsensiController::class, 'rekap']);
    Route::POST('/absensi/cetakrekap', [AbsensiController::class, 'cetakrekap']);
    Route::get('/absensi/pengajuanizin', [AbsensiController::class, 'pengajuanizin']);
    Route::POST('/absensi/approvedizinsakit', [AbsensiController::class, 'approvedizinsakit']);
    Route::get('/absensi/{id}/batalizinsakit', [AbsensiController::class, 'batalizinsakit']);
    
    // KONFIGURASI LOKASI KANTOR  
    Route::get('/konfigurasi/lokasikantor', [ConfigurasiCotroller::class, 'lokasikantor']);
    Route::POST('/konfigurasi/updatelokasi', [ConfigurasiCotroller::class, 'updatelokasi']);
    
});
