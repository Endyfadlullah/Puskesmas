# TTS Voice Configuration untuk Bahasa Indonesia

## Google Cloud Text-to-Speech API

### Suara Indonesia yang Tersedia

Google TTS API menyediakan beberapa opsi suara untuk bahasa Indonesia:

#### 1. **Wavenet Voices (Lebih Natural)**
- `id-ID-Wavenet-A` - Suara wanita Indonesia yang natural dan fasih ⭐ **DIGUNAKAN SAAT INI**
- `id-ID-Wavenet-B` - Suara pria Indonesia yang natural
- `id-ID-Wavenet-C` - Suara wanita Indonesia alternatif
- `id-ID-Wavenet-D` - Suara pria Indonesia alternatif

#### 2. **Standard Voices (Lebih Cepat)**
- `id-ID-Standard-A` - Suara wanita Indonesia standar
- `id-ID-Standard-B` - Suara pria Indonesia standar
- `id-ID-Standard-C` - Suara wanita Indonesia alternatif
- `id-ID-Standard-D` - Suara pria Indonesia alternatif

### Konfigurasi Saat Ini

```php
'voice' => [
    'languageCode' => 'id-ID',
    'name' => 'id-ID-Wavenet-A', // Suara wanita Indonesia yang natural
    'ssmlGender' => 'FEMALE'
],
'audioConfig' => [
    'audioEncoding' => 'MP3',
    'speakingRate' => 0.85, // Sedikit lebih cepat untuk alur yang natural
    'pitch' => 0,
    'volumeGainDb' => 0
]
```

### Keunggulan Wavenet vs Standard

**Wavenet Voices:**
- ✅ Suara lebih natural dan manusiawi
- ✅ Intonasi yang lebih baik
- ✅ Pengucapan yang lebih akurat
- ⚠️ Lebih lambat dalam generate
- ⚠️ Lebih mahal (2x lipat)

**Standard Voices:**
- ✅ Lebih cepat dalam generate
- ✅ Lebih murah
- ⚠️ Suara lebih robotik
- ⚠️ Intonasi kurang natural

## Browser Speech Synthesis API

### Konfigurasi Saat Ini

```javascript
utterance.lang = 'id-ID';
utterance.rate = 0.85; // Sedikit lebih cepat untuk alur yang natural
utterance.volume = 1.0;

// Mencoba memilih suara wanita Indonesia jika tersedia
const voices = speechSynthesis.getVoices();
const indonesianVoice = voices.find(voice => 
    voice.lang === 'id-ID' && 
    voice.name.toLowerCase().includes('female')
) || voices.find(voice => voice.lang === 'id-ID');

if (indonesianVoice) {
    utterance.voice = indonesianVoice;
}
```

### Suara Browser yang Tersedia

Browser TTS bergantung pada sistem operasi:

**Windows:**
- Microsoft Zira Desktop (English, tapi bisa digunakan)
- Microsoft David Desktop (English, tapi bisa digunakan)

**macOS:**
- Siri (Female)
- Tom (Male)

**Linux:**
- Festival voices
- eSpeak voices

## Cara Mengubah Suara

### 1. Mengubah Google TTS Voice

Edit file `app/Services/TTSService.php`:

```php
'voice' => [
    'languageCode' => 'id-ID',
    'name' => 'id-ID-Wavenet-B', // Ganti dengan suara yang diinginkan
    'ssmlGender' => 'FEMALE'
],
```

### 2. Mengubah Browser TTS Voice

Edit file `resources/views/display/index.blade.php` dan `resources/views/admin/poli/index.blade.php`:

```javascript
// Untuk memilih suara tertentu
const voices = speechSynthesis.getVoices();
const specificVoice = voices.find(voice => voice.name === 'Nama Suara Spesifik');
if (specificVoice) {
    utterance.voice = specificVoice;
}
```

## Testing Suara

### 1. Test Google TTS

```bash
# Pastikan API key sudah diset
echo "GOOGLE_TTS_API_KEY=your_api_key_here" >> .env

# Test via artisan command (buat sendiri)
php artisan tts:test "Nomor antrian 001, silakan menuju ke Poli Umum"
```

### 2. Test Browser TTS

Buka browser console dan jalankan:

```javascript
// Test browser TTS
const utterance = new SpeechSynthesisUtterance("Nomor antrian 001, silakan menuju ke Poli Umum");
utterance.lang = 'id-ID';
utterance.rate = 0.85;
speechSynthesis.speak(utterance);

// Lihat suara yang tersedia
speechSynthesis.getVoices().forEach(voice => {
    console.log(`${voice.name} - ${voice.lang}`);
});
```

## Rekomendasi

1. **Untuk Produksi:** Gunakan `id-ID-Wavenet-A` (suara wanita natural)
2. **Untuk Testing:** Gunakan `id-ID-Standard-A` (lebih cepat dan murah)
3. **Fallback:** Browser TTS dengan konfigurasi yang sudah dioptimalkan

## Troubleshooting

### Suara Google TTS Tidak Berfungsi
1. Periksa API key di `.env`
2. Pastikan billing Google Cloud aktif
3. Periksa quota API

### Suara Browser TTS Tidak Berfungsi
1. Periksa browser support untuk `speechSynthesis`
2. Pastikan sistem operasi memiliki TTS engine
3. Coba browser berbeda (Chrome, Firefox, Safari)

### Suara Terdengar Robotik
1. Gunakan Wavenet voices untuk Google TTS
2. Sesuaikan `speakingRate` (0.8 - 1.0)
3. Pastikan teks menggunakan bahasa Indonesia yang benar
