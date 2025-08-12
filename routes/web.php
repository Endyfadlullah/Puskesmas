<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DisplayController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TTSController;
use App\Http\Controllers\IndonesianTTSController;

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
    Route::get('/admin/users/create', [AdminController::class, 'createUser'])->name('admin.users.create');
    Route::post('/admin/users', [AdminController::class, 'storeUser'])->name('admin.users.store');
    Route::get('/admin/users/{user}', [AdminController::class, 'showUser'])->name('admin.users.show');
    Route::put('/admin/users/{user}', [AdminController::class, 'updateUser'])->name('admin.users.update');
    Route::post('/admin/users/{user}/reset-password', [AdminController::class, 'resetUserPassword'])->name('admin.users.reset-password');

    // Laporan Routes
    Route::get('/admin/laporan', [AdminController::class, 'laporan'])->name('admin.laporan.index');
    Route::get('/admin/laporan/export-pdf', [AdminController::class, 'exportPDF'])->name('admin.laporan.export-pdf');
    Route::get('/admin/laporan/export-excel', [AdminController::class, 'exportExcel'])->name('admin.laporan.export-excel');

    // Antrian Routes
    Route::get('/admin/antrian/tambah', [AdminController::class, 'tambahAntrian'])->name('admin.antrian.tambah');
    Route::post('/admin/antrian/cari-user', [AdminController::class, 'cariUser'])->name('admin.antrian.cari-user');
    Route::post('/admin/antrian/store', [AdminController::class, 'storeAntrianAdmin'])->name('admin.antrian.store');
    Route::get('/admin/antrian/{antrian}/cetak', [AdminController::class, 'cetakAntrian'])->name('admin.antrian.cetak');

    // Simple TTS Routes (Windows Compatible)
    Route::get('/admin/tts', [TTSController::class, 'index'])->name('admin.tts.index');
    Route::post('/admin/tts/generate', [TTSController::class, 'generateQueueTTS'])->name('admin.tts.generate');
    Route::post('/admin/tts/play', [TTSController::class, 'playTTS'])->name('admin.tts.play');
    Route::get('/admin/tts/play', [TTSController::class, 'playTTS'])->name('admin.tts.play.get');
    Route::get('/admin/tts/test', [TTSController::class, 'testTTS'])->name('admin.tts.test');
    Route::get('/admin/tts/voices', [TTSController::class, 'getVoices'])->name('admin.tts.voices');
    Route::post('/admin/tts/cleanup', [TTSController::class, 'cleanupFiles'])->name('admin.tts.cleanup');
    Route::get('/admin/tts/status', [TTSController::class, 'getStatus'])->name('admin.tts.status');

    // Indonesian TTS Routes
    Route::post('/admin/indonesian-tts/generate', [IndonesianTTSController::class, 'generateQueueCall'])->name('admin.indonesian-tts.generate');
    Route::post('/admin/indonesian-tts/audio-sequence', [IndonesianTTSController::class, 'createAudioSequence'])->name('admin.indonesian-tts.audio-sequence');
    Route::get('/admin/indonesian-tts/status', [IndonesianTTSController::class, 'checkStatus'])->name('admin.indonesian-tts.status');
    Route::post('/admin/indonesian-tts/test', [IndonesianTTSController::class, 'testTTS'])->name('admin.indonesian-tts.test');
    Route::get('/admin/indonesian-tts/install', [IndonesianTTSController::class, 'getInstallationInstructions'])->name('admin.indonesian-tts.install');
    Route::get('/admin/indonesian-tts/download', [IndonesianTTSController::class, 'downloadModelFiles'])->name('admin.indonesian-tts.download');
    Route::get('/admin/indonesian-tts', [IndonesianTTSController::class, 'index'])->name('admin.indonesian-tts.index');
});

// Public TTS Routes (for display)
Route::post('/tts/play-sequence', [TTSController::class, 'playAudioSequence'])->name('tts.play-sequence');

// Public TTS route for display page
Route::get('/tts/audio/{filename}', [TTSController::class, 'playPublicAudio'])->name('tts.audio.public');

// Test TTS route (public)
Route::get('/tts/test-public', [TTSController::class, 'testPublicTTS'])->name('tts.test.public');

// API Routes for display
Route::get('/api/check-new-calls', [DisplayController::class, 'checkNewCalls'])->name('api.check-new-calls');
Route::get('/api/display-data', [DisplayController::class, 'getDisplayData'])->name('api.display-data');

