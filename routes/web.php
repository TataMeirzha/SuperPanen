<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\AdminPanenController;
use App\Http\Controllers\AlatPertanianController;
use App\Http\Controllers\PermintaanSewaController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\NotifikasiController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MitraController;

Route::get('/', function () { return view('landing'); });

// Auth
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Super Admin
Route::middleware(['auth', 'role:superadmin'])->prefix('superadmin')->group(function () {
    Route::get('/dashboard', [SuperAdminController::class, 'dashboard']);
    Route::get('/users', [SuperAdminController::class, 'users']);
    Route::post('/users/{id}/toggle', [SuperAdminController::class, 'toggleUser']);
    Route::delete('/users/{id}', [SuperAdminController::class, 'deleteUser']);
    Route::get('/admin-panen', [SuperAdminController::class, 'adminPanen']);
    Route::get('/admin-panen/create', [SuperAdminController::class, 'createAdminPanen']);
    Route::post('/admin-panen/store', [SuperAdminController::class, 'storeAdminPanen']);
    Route::delete('/admin-panen/{id}', [SuperAdminController::class, 'deleteAdminPanen']);
    Route::get('/laporan', [LaporanController::class, 'adminIndex']);
    Route::post('/laporan/{id}/balas', [LaporanController::class, 'balas']);
});

// Admin Panen
Route::middleware(['auth', 'role:admin_panen'])->prefix('admin-panen')->group(function () {
    Route::get('/dashboard', [AdminPanenController::class, 'dashboard']);
    Route::get('/pra-panen', [AdminPanenController::class, 'praPanen']);
    Route::get('/pasca-panen', [AdminPanenController::class, 'pascaPanen']);
    Route::delete('/pra-panen/{id}', [AdminPanenController::class, 'deletePraPanen']);
    Route::delete('/pasca-panen/{id}', [AdminPanenController::class, 'deletePascaPanen']);
});

// Mitra
Route::middleware(['auth', 'role:mitra'])->prefix('mitra')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'mitraDashboard']);
    Route::get('/alat', [AlatPertanianController::class, 'index']);
    Route::get('/alat/create', [AlatPertanianController::class, 'create']);
    Route::post('/alat/store', [AlatPertanianController::class, 'store']);
    Route::get('/alat/edit/{id}', [AlatPertanianController::class, 'edit']);
    Route::put('/alat/update/{id}', [AlatPertanianController::class, 'update']);
    Route::delete('/alat/{id}', [AlatPertanianController::class, 'destroy']);
    Route::get('/permintaan-sewa', [PermintaanSewaController::class, 'mitraIndex']);
    Route::post('/permintaan-sewa/{id}/status', [PermintaanSewaController::class, 'updateStatus']);
    Route::get('/laporan', [LaporanController::class, 'index']);
    Route::get('/laporan/create', [LaporanController::class, 'create']);
    Route::post('/laporan/store', [LaporanController::class, 'store']);
});

// User
Route::middleware(['auth', 'role:user'])->prefix('user')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'userDashboard']);
    Route::get('/pra-panen', [UserController::class, 'praPanenIndex']);
    Route::get('/pra-panen/create', [UserController::class, 'praPanenCreate']);
    Route::post('/pra-panen/store', [UserController::class, 'praPanenStore']);
    Route::get('/pasca-panen', [UserController::class, 'pascaPanenIndex']);
    Route::get('/pasca-panen/create/{pra_panen_id}', [UserController::class, 'pascaPanenCreate']);
    Route::post('/pasca-panen/store', [UserController::class, 'pascaPanenStore']);
    Route::get('/alat', [AlatPertanianController::class, 'cariAlat']);
    Route::get('/permintaan-sewa', [PermintaanSewaController::class, 'userIndex']);
    Route::post('/permintaan-sewa/store', [PermintaanSewaController::class, 'store']);
    Route::get('/laporan', [LaporanController::class, 'index']);
    Route::get('/laporan/create', [LaporanController::class, 'create']);
    Route::post('/laporan/store', [LaporanController::class, 'store']);
});

// Semua role yang sudah login
Route::middleware('auth')->group(function () {
    Route::get('/notifikasi', [NotifikasiController::class, 'index']);
    Route::get('/notifikasi/{id}/baca', [NotifikasiController::class, 'baca']);
    Route::post('/notifikasi/baca-semua', [NotifikasiController::class, 'bacaSemua']);
    Route::get('/alat-pertanian-gabungan', [AlatPertanianController::class, 'gabungan'])->name('alat-pertanian.gabungan');
});