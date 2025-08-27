<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\MahasiswaController as AdminMahasiswaController;
use App\Http\Controllers\Admin\DosenController as AdminDosenController;
use App\Http\Controllers\Admin\PengajuanController as AdminPengajuanController;

// Redirect default
Route::get('/', function () {
    return redirect()->route('login');
});

// ==============================
// AUTH ROUTES
// ==============================
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ==============================
// MAHASISWA ROUTES
// ==============================
Route::middleware(['auth', 'role:mahasiswa'])->group(function () {
    Route::get('/dashboard', [MahasiswaController::class, 'dashboard'])->name('dashboard');

    Route::prefix('pengajuan')->group(function () {
        Route::get('/ajukan', [MahasiswaController::class, 'createPengajuan'])->name('pengajuan.ajukan');
        Route::post('/store', [MahasiswaController::class, 'storePengajuan'])->name('pengajuan.store');
        Route::get('/status', [MahasiswaController::class, 'statusPengajuan'])->name('pengajuan.status');
        Route::get('/pengajuan/lihat-file/{id}', [MahasiswaController::class, 'lihatFile'])->name('pengajuan.lihat-file.mahasiswa');
        Route::get('/profile', [MahasiswaController::class, 'editProfile'])->name('mahasiswa.profile');
        Route::post('/profile', [MahasiswaController::class, 'updateProfile'])->name('mahasiswa.profile.update');
    });
});

// Dosen routes
Route::middleware(['auth', 'role:dosen'])->group(function () {
    Route::get('/dashboard/dosen', [DosenController::class, 'dashboard'])->name('dashboard.dosen');

    Route::get('/pengajuan/data', [DosenController::class, 'dataPengajuan'])->name('pengajuan.data');
    Route::post('/pengajuan/status/{id}', [DosenController::class, 'updateStatus'])->name('pengajuan.updateStatus');
    Route::get('/pengajuan/lihat-file/{id}', [DosenController::class, 'lihatFile'])->name('pengajuan.lihat-file.dosen'); // <--- beda nama
    Route::get('/pengajuan/history', [DosenController::class, 'riwayat'])->name('pengajuan.history');
    Route::get('/profile', [DosenController::class, 'editProfile'])->name('dosen.profile');
    Route::post('/profile', [DosenController::class, 'updateProfile'])->name('dosen.profile.update');
});

// ==============================
// ADMIN ROUTES
// ==============================
Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {

    // Dashboard Admin
    Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // Mahasiswa CRUD
    Route::resource('mahasiswa', AdminMahasiswaController::class);

    // Dosen CRUD
    Route::resource('dosen', AdminDosenController::class);

    // Pengajuan Admin (view semua & approve/reject/edit/update/delete)
    Route::get('pengajuan', [AdminPengajuanController::class, 'index'])->name('admin.pengajuan.index');
    Route::post('pengajuan/{id}/approve', [AdminPengajuanController::class, 'approve'])->name('admin.pengajuan.approve');
    Route::post('pengajuan/{id}/reject', [AdminPengajuanController::class, 'reject'])->name('admin.pengajuan.reject');
    Route::get('pengajuan/edit/{id}', [AdminPengajuanController::class, 'edit'])->name('admin.pengajuan.edit');
    Route::put('pengajuan/update/{id}', [AdminPengajuanController::class, 'update'])->name('admin.pengajuan.update');
    Route::delete('pengajuan/delete/{id}', [AdminPengajuanController::class, 'destroy'])->name('admin.pengajuan.destroy');

    // Profile Admin
    Route::get('profile', [AdminController::class, 'editProfile'])->name('admin.profile');
    Route::post('profile', [AdminController::class, 'updateProfile'])->name('admin.profile.update');
});



