<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Process;

class IndonesianTTSService
{
    private $modelPath;
    private $configPath;
    private $g2pPath;
    private $outputPath;

    public function __construct()
    {
        // Path untuk model dan konfigurasi Indonesian TTS
        $this->modelPath = storage_path('app/tts/models/checkpoint.pth');
        $this->configPath = storage_path('app/tts/models/config.json');
        $this->g2pPath = storage_path('app/tts/g2p-id');
        $this->outputPath = storage_path('app/public/audio/queue_calls');

        // Buat direktori jika belum ada
        if (!file_exists($this->outputPath)) {
            mkdir($this->outputPath, 0755, true);
        }
    }

    /**
     * Generate TTS audio using Indonesian TTS model
     */
    public function generateQueueCall($poliName, $queueNumber)
    {
        try {
            // Convert queue number to Indonesian pronunciation
            $indonesianQueueNumber = $this->convertQueueNumberToIndonesian($queueNumber);

            // Create the text to be spoken
            $text = "Nomor antrian {$indonesianQueueNumber}, silakan menuju ke {$poliName}";

            // Check if Indonesian TTS model is available
            if ($this->isIndonesianTTSAvailable()) {
                return $this->generateWithIndonesianTTS($text, $queueNumber, $poliName);
            } else {
                // Fallback to Google TTS or browser TTS
                return $this->generateWithFallbackTTS($text);
            }

        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Error generating Indonesian TTS: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Generate TTS using Indonesian TTS model
     */
    public function generateWithIndonesianTTS($text, $queueNumber, $poliName)
    {
        try {
            // Generate filename
            $filename = "indonesian_tts_{$queueNumber}_{$poliName}_" . time() . ".wav";
            $filepath = $this->outputPath . '/' . $filename;

            // Prepare text for TTS (convert to phonemes if g2p-id is available)
            $phonemeText = $this->convertToPhonemes($text);

            // Run Coqui TTS command
            $command = $this->buildTTSCmd($phonemeText, $filepath);

            $result = Process::run($command);

            if ($result->successful()) {
                return [
                    'success' => true,
                    'audio_url' => asset('storage/audio/queue_calls/' . $filename),
                    'filename' => $filename,
                    'tts_type' => 'indonesian_tts'
                ];
            } else {
                throw new \Exception('TTS generation failed: ' . $result->errorOutput());
            }

        } catch (\Exception $e) {
            // Fallback to other TTS methods
            return $this->generateWithFallbackTTS($text);
        }
    }

    /**
     * Build TTS command for Coqui TTS
     */
    private function buildTTSCmd($text, $outputPath)
    {
        $speaker = 'wibowo'; // Default speaker, can be made configurable

        return [
            'tts',
            '--text',
            $text,
            '--model_path',
            $this->modelPath,
            '--config_path',
            $this->configPath,
            '--speaker_idx',
            $speaker,
            '--out_path',
            $outputPath
        ];
    }

    /**
     * Convert text to phonemes using g2p-id
     */
    private function convertToPhonemes($text)
    {
        // If g2p-id is available, use it to convert to phonemes
        if (file_exists($this->g2pPath)) {
            try {
                $result = Process::run([$this->g2pPath, $text]);
                if ($result->successful()) {
                    return trim($result->output());
                }
            } catch (\Exception $e) {
                // If g2p conversion fails, return original text
                return $text;
            }
        }

        // Return original text if g2p-id is not available
        return $text;
    }

    /**
     * Check if Indonesian TTS model is available
     */
    public function isIndonesianTTSAvailable()
    {
        return file_exists($this->modelPath) &&
            file_exists($this->configPath) &&
            $this->isCoquiTTSInstalled();
    }

    /**
     * Check if Coqui TTS is installed
     */
    public function isCoquiTTSInstalled()
    {
        try {
            $result = Process::run(['tts', '--version']);
            return $result->successful();
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Fallback to Google TTS or browser TTS
     */
    private function generateWithFallbackTTS($text)
    {
        // Use existing TTSService as fallback
        $ttsService = new TTSService();

        // Extract poli name and queue number from text for fallback
        preg_match('/Nomor antrian (.+), silakan menuju ke ruang  (.+)/', $text, $matches);
        $queueNumber = $matches[1] ?? '';
        $poliName = $matches[2] ?? '';

        return $ttsService->generateQueueCall($poliName, $queueNumber);
    }

    /**
     * Convert alphanumeric queue number to Indonesian pronunciation
     * Example: "U5" becomes "U Lima", "A10" becomes "A Sepuluh"
     */
    private function convertQueueNumberToIndonesian($queueNumber)
    {
        // Indonesian number words
        $indonesianNumbers = [
            '0' => 'Nol',
            '1' => 'Satu',
            '2' => 'Dua',
            '3' => 'Tiga',
            '4' => 'Empat',
            '5' => 'Lima',
            '6' => 'Enam',
            '7' => 'Tujuh',
            '8' => 'Delapan',
            '9' => 'Sembilan',
            '10' => 'Sepuluh',
            '11' => 'Sebelas',
            '12' => 'Dua Belas',
            '13' => 'Tiga Belas',
            '14' => 'Empat Belas',
            '15' => 'Lima Belas',
            '16' => 'Enam Belas',
            '17' => 'Tujuh Belas',
            '18' => 'Delapan Belas',
            '19' => 'Sembilan Belas',
            '20' => 'Dua Puluh',
            '30' => 'Tiga Puluh',
            '40' => 'Empat Puluh',
            '50' => 'Lima Puluh',
            '60' => 'Enam Puluh',
            '70' => 'Tujuh Puluh',
            '80' => 'Delapan Puluh',
            '90' => 'Sembilan Puluh',
            '100' => 'Seratus'
        ];

        // If it's a pure number, convert it
        if (is_numeric($queueNumber)) {
            $number = (int) $queueNumber;
            if (isset($indonesianNumbers[$number])) {
                return $indonesianNumbers[$number];
            } else {
                // For numbers > 100, build the pronunciation
                if ($number < 100) {
                    $tens = floor($number / 10) * 10;
                    $ones = $number % 10;
                    if ($ones == 0) {
                        return $indonesianNumbers[$tens];
                    } else {
                        return $indonesianNumbers[$tens] . ' ' . $indonesianNumbers[$ones];
                    }
                } else {
                    return $number; // Fallback for large numbers
                }
            }
        }

        // For alphanumeric (like "U5", "A10"), convert the numeric part
        $letters = '';
        $numbers = '';

        // Split into letters and numbers
        for ($i = 0; $i < strlen($queueNumber); $i++) {
            $char = $queueNumber[$i];
            if (is_numeric($char)) {
                $numbers .= $char;
            } else {
                $letters .= $char;
            }
        }

        // If we have both letters and numbers
        if ($letters && $numbers) {
            $numberValue = (int) $numbers;
            if (isset($indonesianNumbers[$numberValue])) {
                return $letters . ' ' . $indonesianNumbers[$numberValue];
            } else {
                // For numbers > 100, build the pronunciation
                if ($numberValue < 100) {
                    $tens = floor($numberValue / 10) * 10;
                    $ones = $numberValue % 10;
                    if ($ones == 0) {
                        return $letters . ' ' . $indonesianNumbers[$tens];
                    } else {
                        return $letters . ' ' . $indonesianNumbers[$tens] . ' ' . $indonesianNumbers[$ones];
                    }
                } else {
                    return $queueNumber; // Fallback for large numbers
                }
            }
        }

        // If no conversion needed, return as is
        return $queueNumber;
    }

    /**
     * Create complete audio sequence for queue call
     */
    public function createCompleteAudioSequence($poliName, $queueNumber)
    {
        $audioFiles = [];

        // 1. Attention sound (4 seconds - actual file duration)
        $attentionSound = asset('assets/music/call-to-attention-123107.mp3');
        $audioFiles[] = [
            'type' => 'attention',
            'url' => $attentionSound,
            'duration' => 4000 // 4 seconds - actual file duration
        ];

        // 2. TTS for poli name and number (no final attention sound)
        $ttsResult = $this->generateQueueCall($poliName, $queueNumber);
        if ($ttsResult['success']) {
            if (isset($ttsResult['use_browser_tts']) && $ttsResult['use_browser_tts']) {
                // Use browser TTS
                $audioFiles[] = [
                    'type' => 'browser_tts',
                    'text' => $ttsResult['text'],
                    'duration' => 8000 // 8 seconds - longer for natural speech
                ];
            } else {
                // Use generated audio file
                $audioFiles[] = [
                    'type' => 'tts',
                    'url' => $ttsResult['audio_url'],
                    'duration' => 8000 // 8 seconds - longer for natural speech
                ];
            }
        }

        return $audioFiles;
    }

    /**
     * Get available speakers from Indonesian TTS model
     */
    public function getAvailableSpeakers()
    {
        if (!$this->isIndonesianTTSAvailable()) {
            return [];
        }

        try {
            $result = Process::run([
                'tts',
                '--model_path',
                $this->modelPath,
                '--config_path',
                $this->configPath,
                '--list_speaker_idxs'
            ]);

            if ($result->successful()) {
                $output = $result->output();
                // Parse speaker list from output
                $speakers = [];
                $lines = explode("\n", $output);
                foreach ($lines as $line) {
                    if (preg_match('/^(\d+):\s*(.+)$/', $line, $matches)) {
                        $speakers[$matches[1]] = trim($matches[2]);
                    }
                }
                return $speakers;
            }
        } catch (\Exception $e) {
            // Return default speakers if listing fails
            return [
                'wibowo' => 'Wibowo (Male)',
                'ardi' => 'Ardi (Male)',
                'gadis' => 'Gadis (Female)'
            ];
        }

        return [];
    }

    /**
     * Install Indonesian TTS model
     */
    public function installIndonesianTTS()
    {
        $instructions = [
            'title' => 'Instalasi Indonesian TTS',
            'steps' => [
                '1. Install Coqui TTS:',
                '   pip install TTS',
                '',
                '2. Download model dari GitHub:',
                '   - Kunjungi: https://github.com/Wikidepia/indonesian-tts/releases',
                '   - Download file checkpoint.pth dan config.json',
                '   - Simpan di: ' . storage_path('app/tts/models/'),
                '',
                '3. Install g2p-id (opsional):',
                '   pip install g2p-id',
                '',
                '4. Test instalasi:',
                '   tts --version',
                '',
                '5. Test model:',
                '   tts --text "Halo dunia" --model_path ' . $this->modelPath . ' --config_path ' . $this->configPath . ' --out_path test.wav'
            ]
        ];

        return $instructions;
    }
}
