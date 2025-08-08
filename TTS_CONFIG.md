# Konfigurasi TTS (Text-to-Speech)

## Setup Google Text-to-Speech API

Untuk menggunakan fitur TTS, Anda perlu mengatur Google Text-to-Speech API:

### 1. Dapatkan API Key
1. Kunjungi [Google Cloud Console](https://console.cloud.google.com/)
2. Buat project baru atau pilih project yang ada
3. Aktifkan Cloud Text-to-Speech API
4. Buat credentials (API Key)
5. Salin API Key

### 2. Tambahkan ke .env
Tambahkan baris berikut ke file `.env`:

```env
GOOGLE_TTS_API_KEY=your_google_tts_api_key_here
```

### 3. Fitur TTS

Fitur TTS akan memainkan urutan audio berikut:
1. **Attention Sound** - `call-to-attention-123107.mp3`
2. **TTS Poli** - "Nomor antrian X, silakan menuju ke [nama poli]"
3. **TTS Nomor** - "Nomor antrian X"
4. **Attention Sound** - `call-to-attention-123107.mp3`

### 4. Fallback TTS

Jika Google TTS API tidak tersedia, sistem akan menggunakan:
- Browser's built-in Speech Synthesis API
- File audio attention sound yang sudah ada

### 5. Cara Kerja

1. Admin klik button "Panggil" di halaman admin
2. Sistem mengupdate status antrian menjadi "dipanggil"
3. Sistem generate audio TTS sequence
4. Audio diputar di halaman display
5. Jika display page tidak terbuka, audio diputar di browser admin

### 6. File Audio

File audio TTS akan disimpan di:
```
public/storage/audio/queue_calls/
```

### 7. Testing

Untuk testing tanpa Google TTS API:
1. Biarkan `GOOGLE_TTS_API_KEY` kosong di .env
2. Sistem akan menggunakan browser TTS sebagai fallback
3. Audio attention sound tetap akan diputar

### 8. Troubleshooting

Jika TTS tidak berfungsi:
1. Periksa console browser untuk error
2. Pastikan file audio attention sound ada di `public/assets/music/`
3. Periksa permission folder `public/storage/audio/queue_calls/`
4. Pastikan CSRF token valid untuk request AJAX
