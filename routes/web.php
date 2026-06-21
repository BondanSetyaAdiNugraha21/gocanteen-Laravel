<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StandController;
use App\Http\Controllers\MenuMhsController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PesananAdminController;
use App\Http\Controllers\Admin\MahasiswaAdminController;
use App\Http\Controllers\Admin\PenjualAdminController;
use App\Http\Controllers\Admin\StokController;
use App\Http\Controllers\Admin\MejaAdminController;
use App\Http\Controllers\Admin\StandAdminController;
use App\Http\Controllers\Admin\LaporanAdminController;
use App\Http\Controllers\Penjual\PesananPenjualController;
use App\Http\Controllers\Penjual\MenuPenjualController;
use App\Http\Controllers\Penjual\StokPenjualController;
use App\Http\Controllers\Penjual\LaporanPenjualController;
use App\Http\Controllers\Penjual\DashboardPenjualController;

// Auth
Route::get('/', [AuthController::class, 'index']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout']);

// Mahasiswa
Route::get('/stand', [StandController::class, 'index']);
Route::get('/menu/{stand_id}', [MenuMhsController::class, 'index']);
Route::post('/pesanan/proses', [PesananController::class, 'proses']);
Route::get('/riwayat', [PesananController::class, 'riwayat']);
Route::get('/pesanan/meja', [PesananController::class, 'getMeja']);
Route::get('/review/{pesanan_id}', [ReviewController::class, 'create']);
Route::post('/review/{pesanan_id}', [ReviewController::class, 'store']);
Route::get('/review/menu/{menu_id}', [ReviewController::class, 'menuReviews']);

// Penjual
Route::prefix('penjual')->group(function () {
    Route::get('/dashboard', [DashboardPenjualController::class, 'index']);
    Route::get('/pesanan', [PesananPenjualController::class, 'index']);
    Route::post('/pesanan/{pesanan}/status', [PesananPenjualController::class, 'updateStatus']);
    Route::get('/menu', [MenuPenjualController::class, 'index']);
    Route::get('/menu/create', [MenuPenjualController::class, 'create']);
    Route::post('/menu', [MenuPenjualController::class, 'store']);
    Route::get('/menu/{menu}/edit', [MenuPenjualController::class, 'edit']);
    Route::put('/menu/{menu}', [MenuPenjualController::class, 'update']);
    Route::delete('/menu/{menu}', [MenuPenjualController::class, 'destroy']);
    Route::get('/stok', [StokPenjualController::class, 'index']);
    Route::post('/stok/{menu}', [StokPenjualController::class, 'update']);
    Route::get('/laporan', [LaporanPenjualController::class, 'index']);
});

// Admin
Route::prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/pesanan', [PesananAdminController::class, 'index']);
    Route::post('/pesanan/{pesanan}/status', [PesananAdminController::class, 'updateStatus']);
    Route::delete('/pesanan/{pesanan}', [PesananAdminController::class, 'destroy']);
    Route::get('/mahasiswa', [MahasiswaAdminController::class, 'index']);
    Route::get('/mahasiswa/create', [MahasiswaAdminController::class, 'create']);
    Route::post('/mahasiswa', [MahasiswaAdminController::class, 'store']);
    Route::get('/mahasiswa/{mahasiswa}/edit', [MahasiswaAdminController::class, 'edit']);
    Route::put('/mahasiswa/{mahasiswa}', [MahasiswaAdminController::class, 'update']);
    Route::delete('/mahasiswa/{mahasiswa}', [MahasiswaAdminController::class, 'destroy']);
    Route::get('/stok', [StokController::class, 'index']);
    Route::post('/stok/{menu}', [StokController::class, 'update']);
    Route::get('/meja', [MejaAdminController::class, 'index']);
    Route::post('/meja', [MejaAdminController::class, 'store']);
    Route::post('/meja/{meja}/toggle', [MejaAdminController::class, 'toggleStatus']);
    Route::delete('/meja/{meja}', [MejaAdminController::class, 'destroy']);
    Route::get('/laporan', [LaporanAdminController::class, 'index']);
    Route::get('/stand', [StandAdminController::class, 'index']);
    Route::get('/stand/create', [StandAdminController::class, 'create']);
    Route::post('/stand', [StandAdminController::class, 'store']);
    Route::get('/stand/{stand}/edit', [StandAdminController::class, 'edit']);
    Route::put('/stand/{stand}', [StandAdminController::class, 'update']);
    Route::delete('/stand/{stand}', [StandAdminController::class, 'destroy']);
    Route::get('/penjual', [PenjualAdminController::class, 'index']);
    Route::get('/penjual/create', [PenjualAdminController::class, 'create']);
    Route::post('/penjual', [PenjualAdminController::class, 'store']);
    Route::get('/penjual/{user}/edit', [PenjualAdminController::class, 'edit']);
    Route::put('/penjual/{user}', [PenjualAdminController::class, 'update']);
    Route::delete('/penjual/{user}', [PenjualAdminController::class, 'destroy']);
});