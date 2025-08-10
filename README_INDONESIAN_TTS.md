# Indonesian TTS Integration Guide

## Overview

Repository ini mengintegrasikan [Indonesian TTS](https://github.com/Wikidepia/indonesian-tts) yang menggunakan Coqui TTS untuk menghasilkan suara Indonesia yang lebih natural dan akurat. Indonesian TTS ini cocok untuk sistem antrian Puskesmas karena:

- **Suara Natural**: Menggunakan model yang dilatih khusus untuk bahasa Indonesia
- **Pengucapan Akurat**: Menggunakan g2p-id untuk konversi grapheme ke phoneme
- **Multiple Speakers**: Tersedia 80+ speaker dengan berbagai karakteristik suara
- **Offline Capability**: Dapat berjalan tanpa internet setelah model diinstall

## Fitur Utama

### 1. Indonesian Pronunciation
- Konversi otomatis nomor antrian ke pengucapan Indonesia
- Contoh: "U5" → "U Lima", "A10" → "A Sepuluh"
- Mendukung angka 0-100 dengan pengucapan yang benar

### 2. Multiple TTS Options
- **Indonesian TTS** (Prioritas): Menggunakan model Coqui TTS Indonesia
- **Google TTS** (Fallback): Menggunakan Google Cloud TTS API
- **Browser TTS** (Fallback): Menggunakan Web Speech API browser

### 3. Audio Sequence Management
- Urutan audio: Attention Sound → TTS → Attention Sound
- Queue management untuk mencegah overlap
- Cross-page communication untuk admin → display

## Instalasi

### Prerequisites

1. **Python 3.8+**
2. **pip** (Python package manager)
3. **Laravel 8+** dengan PHP 8.0+

### Step 1: Install Coqui TTS

```bash
# Install Coqui TTS
pip install TTS

# Verify installation
tts --version
```

### Step 2: Download Model Files

1. Kunjungi [Indonesian TTS Releases](https://github.com/Wikidepia/indonesian-tts/releases)
2. Download file:
   - `checkpoint.pth` (model file)
   - `config.json` (configuration file)
3. Buat folder: `storage/app/tts/models/`
4. Simpan file di folder tersebut

### Step 3: Install g2p-id (Optional)

```bash
# Install g2p-id for better pronunciation
pip install g2p-id

# Verify installation
g2p-id --help
```

### Step 4: Test Installation

```bash
# Test TTS with sample text
tts --text "Halo dunia" \
    --model_path storage/app/tts/models/checkpoint.pth \
    --config_path storage/app/tts/models/config.json \
    --speaker_idx wibowo \
    --out_path test.wav
```

## Konfigurasi

### Environment Variables

Tambahkan ke file `.env`:

```env
# Indonesian TTS Configuration
INDONESIAN_TTS_ENABLED=true
INDONESIAN_TTS_MODEL_PATH=storage/app/tts/models/checkpoint.pth
INDONESIAN_TTS_CONFIG_PATH=storage/app/tts/models/config.json
INDONESIAN_TTS_DEFAULT_SPEAKER=wibowo

# Google TTS (Fallback)
GOOGLE_TTS_API_KEY=your_google_tts_api_key
```

### File Structure

```
storage/
├── app/
│   └── tts/
│       ├── models/
│       │   ├── checkpoint.pth
│       │   └── config.json
│       └── g2p-id
└── public/
    └── audio/
        └── queue_calls/
            └── indonesian_tts_*.wav
```

## Penggunaan

### 1. Admin Panel

Akses halaman Indonesian TTS Settings:
```
/admin/indonesian-tts
```

Fitur yang tersedia:
- Status monitoring (Indonesian TTS, Coqui TTS, Model Files, Speakers)
- Test TTS dengan text custom
- Installation instructions
- Download model files

### 2. API Endpoints

```php
// Generate TTS audio
POST /admin/indonesian-tts/generate
{
    "poli_name": "Poli Umum",
    "queue_number": "U5"
}

// Create complete audio sequence
POST /admin/indonesian-tts/audio-sequence
{
    "poli_name": "Poli Umum", 
    "queue_number": "U5"
}

// Check status
GET /admin/indonesian-tts/status

// Test TTS
POST /admin/indonesian-tts/test
{
    "text": "Nomor antrian U Lima, silakan menuju ke Poli Umum"
}
```

### 3. Service Usage

```php
use App\Services\IndonesianTTSService;

$ttsService = new IndonesianTTSService();

// Generate TTS
$result = $ttsService->generateQueueCall('Poli Umum', 'U5');

// Create audio sequence
$sequence = $ttsService->createCompleteAudioSequence('Poli Umum', 'U5');

// Check status
$isAvailable = $ttsService->isIndonesianTTSAvailable();
$speakers = $ttsService->getAvailableSpeakers();
```

## Available Speakers

Model Indonesian TTS menyediakan 80+ speaker dengan karakteristik berbeda:

### Male Speakers
- `wibowo`: Suara pria natural, cocok untuk announcement
- `ardi`: Suara pria formal
- `budi`: Suara pria ramah

### Female Speakers  
- `gadis`: Suara wanita natural, cocok untuk announcement
- `sari`: Suara wanita formal
- `rini`: Suara wanita ramah

### Regional Speakers
- `javanese_*`: Speaker dengan aksen Jawa
- `sundanese_*`: Speaker dengan aksen Sunda

## Troubleshooting

### Common Issues

1. **"tts command not found"**
   ```bash
   # Reinstall TTS
   pip uninstall TTS
   pip install TTS
   ```

2. **"Model files not found"**
   ```bash
   # Check file permissions
   ls -la storage/app/tts/models/
   chmod 644 storage/app/tts/models/*
   ```

3. **"Permission denied"**
   ```bash
   # Fix directory permissions
   chmod -R 755 storage/app/tts/
   chown -R www-data:www-data storage/app/tts/
   ```

4. **"Audio generation failed"**
   ```bash
   # Check Python environment
   which python
   which tts
   
   # Test with simple command
   tts --text "test" --model_path storage/app/tts/models/checkpoint.pth --config_path storage/app/tts/models/config.json --out_path test.wav
   ```

### Debug Mode

Aktifkan debug mode di `.env`:

```env
APP_DEBUG=true
LOG_LEVEL=debug
```

Cek log Laravel:
```bash
tail -f storage/logs/laravel.log
```

## Performance Optimization

### 1. Model Caching
```php
// Cache model loading
$ttsService = app(IndonesianTTSService::class);
```

### 2. Audio File Management
```bash
# Clean old audio files (older than 7 days)
find storage/app/public/audio/queue_calls/ -name "*.wav" -mtime +7 -delete
```

### 3. Memory Management
```php
// Limit concurrent TTS processes
$maxProcesses = 3;
```

## Security Considerations

1. **File Permissions**: Pastikan model files tidak dapat diakses publik
2. **Input Validation**: Validasi input text untuk mencegah injection
3. **Rate Limiting**: Batasi jumlah request TTS per menit
4. **Audio Sanitization**: Bersihkan nama file audio

## Monitoring

### Health Checks

```php
// Check TTS health
$health = [
    'indonesian_tts' => $ttsService->isIndonesianTTSAvailable(),
    'coqui_tts' => $ttsService->isCoquiTTSInstalled(),
    'model_files' => file_exists($modelPath),
    'speakers' => count($ttsService->getAvailableSpeakers())
];
```

### Metrics

- TTS generation success rate
- Audio file size and duration
- Speaker usage statistics
- Error rates and types

## Migration from Google TTS

Jika ingin migrasi dari Google TTS ke Indonesian TTS:

1. **Backup existing TTS configuration**
2. **Install Indonesian TTS** (ikuti guide di atas)
3. **Update service configuration**:
   ```php
   // In TTSService.php
   public function generateQueueCall($poliName, $queueNumber)
   {
       // Try Indonesian TTS first
       $indonesianTTS = new IndonesianTTSService();
       if ($indonesianTTS->isIndonesianTTSAvailable()) {
           return $indonesianTTS->generateQueueCall($poliName, $queueNumber);
       }
       
       // Fallback to Google TTS
       return parent::generateQueueCall($poliName, $queueNumber);
   }
   ```
4. **Test thoroughly** dengan berbagai nomor antrian
5. **Monitor performance** dan error rates

## Support

Untuk bantuan lebih lanjut:

1. **Documentation**: [Indonesian TTS GitHub](https://github.com/Wikidepia/indonesian-tts)
2. **Issues**: Buat issue di repository project ini
3. **Community**: Coqui TTS Discord/Forum

## License

Indonesian TTS model memiliki lisensi terpisah. Pastikan untuk membaca dan mematuhi lisensi yang berlaku sebelum menggunakan untuk tujuan komersial.

---

**Note**: Indonesian TTS memerlukan resource yang cukup (RAM, CPU) untuk berjalan optimal. Pastikan server memiliki spesifikasi yang memadai.
