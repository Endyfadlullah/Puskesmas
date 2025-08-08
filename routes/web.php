<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DisplayController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TTSController;

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
    Route::post('/admin/panggil-antrian', [AdminController::class, 'panggilAntrian'])->name('admin.panggil-antrian');
    Route::post('/admin/selesai-antrian', [AdminController::class, 'selesaiAntrian'])->name('admin.selesai-antrian');
    Route::post('/admin/antrian/batal', [AdminController::class, 'batalAntrian'])->name('admin.batal-antrian');
    Route::post('/admin/panggil-antrian/{antrian}', [AdminController::class, 'panggilAntrianById'])->name('admin.panggil-antrian-id');

    // User Management Routes
    Route::get('/admin/users', [AdminController::class, 'manageUsers'])->name('admin.users.index');
    Route::get('/admin/users/{user}', [AdminController::class, 'showUser'])->name('admin.users.show');
    Route::put('/admin/users/{user}', [AdminController::class, 'updateUser'])->name('admin.users.update');
    Route::post('/admin/users/{user}/reset-password', [AdminController::class, 'resetUserPassword'])->name('admin.users.reset-password');

    // Laporan Routes
    Route::get('/admin/laporan', [AdminController::class, 'laporan'])->name('admin.laporan.index');
    Route::get('/admin/laporan/export-pdf', [AdminController::class, 'exportPDF'])->name('admin.laporan.export-pdf');
    Route::get('/admin/laporan/export-excel', [AdminController::class, 'exportExcel'])->name('admin.laporan.export-excel');

    // Antrian Routes
    Route::get('/admin/antrian/{antrian}/cetak', [AdminController::class, 'cetakAntrian'])->name('admin.antrian.cetak');

    // TTS Routes
    Route::post('/admin/tts/generate', [TTSController::class, 'generateQueueCall'])->name('admin.tts.generate');
    Route::post('/admin/tts/audio-sequence', [TTSController::class, 'getAudioSequence'])->name('admin.tts.audio-sequence');
    Route::post('/admin/tts/play-sequence', [TTSController::class, 'playAudioSequence'])->name('admin.tts.play-sequence');
});

// Public TTS Routes (for display)
Route::post('/tts/play-sequence', [TTSController::class, 'playAudioSequence'])->name('tts.play-sequence');

