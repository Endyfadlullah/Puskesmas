# Fitur TTS (Text-to-Speech) untuk Sistem Antrian Puskesmas

## Overview

Fitur TTS telah ditambahkan ke sistem antrian puskesmas untuk memanggil antrian secara otomatis dengan suara. Ketika admin menekan tombol "Panggil", sistem akan memainkan urutan audio berikut:

1. **Attention Sound** - Bunyi perhatian
2. **TTS Announcement** - "Nomor antrian X, silakan menuju ke [nama poli]"
3. **Attention Sound** - Bunyi perhatian lagi

## Cara Kerja

### 1. Admin Panel

-   Admin membuka halaman poli (Umum, Gigi, Jiwa, Tradisional)
-   Klik tombol "Panggil" pada antrian yang menunggu
-   Sistem akan:
    -   Update status antrian menjadi "dipanggil"
    -   Generate audio TTS sequence
    -   Kirim pesan ke halaman display (jika terbuka)
    -   Mainkan audio di browser admin sebagai fallback

### 2. Display Page

-   Halaman display akan menerima pesan TTS
-   Audio sequence akan diputar secara otomatis
-   Urutan: Attention Sound → TTS → Attention Sound

## Komponen yang Ditambahkan

### 1. Service

-   `app/Services/TTSService.php` - Service untuk mengelola TTS

### 2. Controller

-   `app/Http/Controllers/TTSController.php` - Controller untuk endpoint TTS

### 3. Routes

```php
// Admin TTS Routes
Route::post('/admin/tts/generate', [TTSController::class, 'generateQueueCall']);
Route::post('/admin/tts/audio-sequence', [TTSController::class, 'getAudioSequence']);
Route::post('/admin/tts/play-sequence', [TTSController::class, 'playAudioSequence']);

// Public TTS Routes
Route::post('/tts/play-sequence', [TTSController::class, 'playAudioSequence']);
```

### 4. JavaScript

-   TTS Audio Player class di halaman display
-   Browser TTS fallback di halaman admin

## Konfigurasi

### 1. Google TTS API (Opsional)

Untuk kualitas TTS yang lebih baik, Anda bisa menggunakan Google TTS API:

1. Dapatkan API Key dari Google Cloud Console
2. Tambahkan ke file `.env`:

```env
GOOGLE_TTS_API_KEY=your_api_key_here
```

### 2. Browser TTS (Default)

Jika Google TTS API tidak tersedia, sistem akan menggunakan browser's built-in Speech Synthesis API.

## Testing

### 1. Tanpa Google TTS API

1. Biarkan `GOOGLE_TTS_API_KEY` kosong di `.env`
2. Sistem akan menggunakan browser TTS
3. Buka halaman admin dan klik "Panggil"
4. Audio akan diputar di browser

### 2. Dengan Google TTS API

1. Set `GOOGLE_TTS_API_KEY` di `.env`
2. Sistem akan generate file audio MP3
3. File disimpan di `public/storage/audio/queue_calls/`

## File Audio

### 1. Attention Sound

-   Lokasi: `public/assets/music/call-to-attention-123107.mp3`
-   Digunakan di awal dan akhir sequence

### 2. TTS Audio Files

-   Lokasi: `public/storage/audio/queue_calls/`
-   Format: `queue_call_{number}_{poli}_{timestamp}.mp3`
-   Dibuat otomatis saat menggunakan Google TTS API

## Troubleshooting

### 1. Audio tidak diputar

-   Periksa console browser untuk error
-   Pastikan file attention sound ada
-   Periksa permission folder storage

### 2. TTS tidak berfungsi

-   Pastikan browser mendukung Speech Synthesis
-   Periksa CSRF token untuk request AJAX
-   Coba refresh halaman

### 3. Google TTS API error

-   Periksa API key valid
-   Pastikan Cloud Text-to-Speech API aktif
-   Cek quota dan billing

## Fitur Tambahan

### 1. Audio Queue

-   Multiple panggilan akan di-queue
-   Tidak ada overlap audio

### 2. Cross-page Communication

-   Admin page bisa kirim pesan ke display page
-   Menggunakan `postMessage` API

### 3. Fallback System

-   Google TTS → Browser TTS → Silent
-   Memastikan sistem tetap berfungsi

## Keamanan

### 1. CSRF Protection

-   Semua request TTS dilindungi CSRF token
-   Validasi input untuk mencegah injection

### 2. File Storage

-   Audio files disimpan di public storage
-   Nama file menggunakan timestamp untuk uniqueness

## Performance

### 1. Audio Caching

-   Browser akan cache audio files
-   Mengurangi bandwidth usage

### 2. Async Processing

-   TTS generation tidak blocking
-   Audio playback asynchronous

## Monitoring

### 1. Console Logs

-   Error dan warning di console browser
-   Debug info untuk troubleshooting

### 2. Network Tab

-   Monitor request ke TTS endpoints
-   Check audio file downloads

## Future Enhancements

### 1. Multiple Languages

-   Support untuk bahasa lain
-   Configurable voice settings

### 2. Custom Audio

-   Upload custom attention sounds
-   Per-poli audio customization

### 3. Volume Control

-   User-adjustable volume
-   Per-device audio settings

### 4. Audio Analytics

-   Track audio playback success
-   Monitor TTS usage statistics
