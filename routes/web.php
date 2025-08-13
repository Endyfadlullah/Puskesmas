<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DisplayController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AudioController;

// Landing Page
Route::get('/', [LandingController::class, 'index'])->name('landing');

// Display Page (Public)
Route::get('/display', [DisplayController::class, 'index'])->name('display');

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Forgot Password Routes
Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('forgot-password');
Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::get('/reset-password', [AuthController::class, 'showResetPassword'])->name('reset-password');
Route::post('/reset-password', [AuthController::class, 'resetPassword']);

// Protected Routes (User)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/dashboard/add-queue', [DashboardController::class, 'addQueue'])->name('dashboard.add-queue');
    Route::put('/dashboard/update-profile', [DashboardController::class, 'updateProfile'])->name('dashboard.update-profile');

    // User Antrian Routes
    Route::post('/user/antrian/batal', [DashboardController::class, 'batalAntrian'])->name('user.batal-antrian');
    Route::get('/user/antrian/{antrian}/cetak', [DashboardController::class, 'cetakAntrian'])->name('user.antrian.cetak');

    // Placeholder routes for future features
    Route::get('/antrian/create', function () {
        return redirect('/dashboard');
    })->name('antrian.create');
    Route::get('/antrian', function () {
        return redirect('/dashboard');
    })->name('antrian.index');
    Route::get('/panggilan', function () {
        return redirect('/dashboard');
    })->name('panggilan.index');
    Route::get('/laporan', function () {
        return redirect('/dashboard');
    })->name('laporan.index');
});

// Protected Routes (Admin)
Route::middleware('auth:admin')->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    
    // Per-poli pages
    Route::get('/admin/poli/umum', [AdminController::class, 'poliUmum'])->name('admin.poli.umum');
    Route::get('/admin/poli/gigi', [AdminController::class, 'poliGigi'])->name('admin.poli.gigi');
    Route::get('/admin/poli/jiwa', [AdminController::class, 'poliJiwa'])->name('admin.poli.jiwa');
    Route::get('/admin/poli/tradisional', [AdminController::class, 'poliTradisional'])->name('admin.poli.tradisional');
    
    // Antrian management routes
    Route::post('/admin/panggil-antrian', [AdminController::class, 'panggilAntrian'])->name('admin.panggil-antrian');
    Route::post('/admin/selesai-antrian', [AdminController::class, 'selesaiAntrian'])->name('admin.selesai-antrian');
    Route::post('/admin/antrian/batal', [AdminController::class, 'batalAntrian'])->name('admin.batal-antrian');
    Route::post('/admin/panggil-antrian/{antrian}', [AdminController::class, 'panggilAntrianById'])->name('admin.panggil-antrian-id');
    Route::post('/admin/play-audio', [AdminController::class, 'playQueueCallAudio'])->name('admin.play-audio');
    Route::post('/admin/panggil-selanjutnya', [AdminController::class, 'panggilSelanjutnya'])->name('admin.panggil-selanjutnya');
    
    // Audio management
    Route::get('/admin/audio', [AudioController::class, 'index'])->name('admin.audio.index');

    // User Management Routes
    Route::get('/admin/users', [AdminController::class, 'manageUsers'])->name('admin.users.index');
    Route::get('/admin/users/create', [AdminController::class, 'createUser'])->name('admin.users.create');
    Route::post('/admin/users', [AdminController::class, 'storeUser'])->name('admin.users.store');
    Route::get('/admin/users/{user}', [AdminController::class, 'showUser'])->name('admin.users.show');
    Route::put('/admin/users/{user}', [AdminController::class, 'updateUser'])->name('admin.users.update');
    Route::post('/admin/users/{user}/reset-password', [AdminController::class, 'resetUserPassword'])->name('admin.users.reset-password');

    // Laporan Routes
    Route::get('/admin/laporan', [AdminController::class, 'laporan'])->name('admin.laporan.index');
    Route::get('/admin/laporan/pdf', [AdminController::class, 'exportPDF'])->name('admin.laporan.pdf');
    Route::get('/admin/laporan/export-pdf', [AdminController::class, 'exportPDF'])->name('admin.laporan.export-pdf');
    Route::get('/admin/laporan/export-excel', [AdminController::class, 'exportExcel'])->name('admin.laporan.export-excel');

    // Antrian Routes
    Route::get('/admin/antrian/tambah', [AdminController::class, 'tambahAntrian'])->name('admin.antrian.tambah');
    Route::post('/admin/antrian/cari-user', [AdminController::class, 'cariUser'])->name('admin.antrian.cari-user');
    Route::post('/admin/antrian/store', [AdminController::class, 'storeAntrianAdmin'])->name('admin.antrian.store');
    Route::get('/admin/antrian/{antrian}/cetak', [AdminController::class, 'cetakAntrian'])->name('admin.antrian.cetak');

    Route::post('/admin/cek-status-antrian-sebelumnya', [AdminController::class, 'cekStatusAntrianSebelumnya'])->name('admin.cek-status-antrian-sebelumnya');
});

// Audio Routes
Route::post('/audio/queue-call', [AudioController::class, 'getQueueCallAudio'])->name('audio.queue-call');
Route::get('/audio/files', [AudioController::class, 'getAvailableAudioFiles'])->name('audio.files');
Route::post('/audio/test', [AudioController::class, 'testAudio'])->name('audio.test');

// API Routes for display
Route::get('/api/check-new-calls', [DisplayController::class, 'checkNewCalls'])->name('api.check-new-calls');
Route::get('/api/display-data', [DisplayController::class, 'getDisplayData'])->name('api.display-data');
