<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class SimpleTTSService
{
    private $pythonPath;
    private $scriptPath;

    public function __construct()
    {
        // Path ke Python executable
        $this->pythonPath = 'python'; // atau 'python3' tergantung sistem
        $this->scriptPath = storage_path('app/tts_scripts');
        
        // Buat direktori jika belum ada
        if (!file_exists($this->scriptPath)) {
            mkdir($this->scriptPath, 0755, true);
        }
    }

    /**
     * Generate TTS untuk nomor antrian
     */
    public function generateQueueNumberTTS($queueNumber, $serviceName = '')
    {
        try {
            // Text yang akan diucapkan
            $text = $this->formatQueueText($queueNumber, $serviceName);
            
            // Generate audio menggunakan Python script
            $audioPath = $this->generateAudioWithPython($text);
            
            if ($audioPath && file_exists($audioPath)) {
                return $audioPath;
            }
            
            // Fallback ke gTTS jika Python gagal
            return $this->generateAudioWithGTTS($text);
            
        } catch (\Exception $e) {
            Log::error('TTS Error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Format text untuk nomor antrian
     */
    private function formatQueueText($queueNumber, $serviceName)
    {
        $text = "Nomor antrian {$queueNumber}";
        
        if (!empty($serviceName)) {
            $text .= " untuk {$serviceName}";
        }
        
        $text .= ". Silakan menuju ke loket yang tersedia.";
        
        return $text;
    }

    /**
     * Generate audio menggunakan Python script dengan pyttsx3
     */
    private function generateAudioWithPython($text)
    {
        try {
            $scriptContent = $this->getPythonScript();
            $scriptFile = $this->scriptPath . '/tts_generator.py';
            
            // Tulis script ke file
            file_put_contents($scriptFile, $scriptContent);
            
            // Generate nama file audio
            $audioFileName = 'queue_' . time() . '_' . uniqid() . '.wav';
            $audioPath = $this->scriptPath . '/' . $audioFileName;
            
            // Eksekusi Python script
            $command = "{$this->pythonPath} \"{$scriptFile}\" \"{$text}\" \"{$audioPath}\"";
            
            $output = shell_exec($command . ' 2>&1');
            
            if (file_exists($audioPath)) {
                Log::info('TTS Audio generated successfully with Python: ' . $audioPath);
                return $audioPath;
            }
            
            Log::warning('Python TTS failed: ' . $output);
            return null;
            
        } catch (\Exception $e) {
            Log::error('Python TTS Error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Generate audio menggunakan gTTS (fallback)
     */
    private function generateAudioWithGTTS($text)
    {
        try {
            $scriptContent = $this->getGTTScript();
            $scriptFile = $this->scriptPath . '/gtts_generator.py';
            
            // Tulis script ke file
            file_put_contents($scriptFile, $scriptContent);
            
            // Generate nama file audio
            $audioFileName = 'queue_gtts_' . time() . '_' . uniqid() . '.mp3';
            $audioPath = $this->scriptPath . '/' . $audioFileName;
            
            // Eksekusi Python script
            $command = "{$this->pythonPath} \"{$scriptFile}\" \"{$text}\" \"{$audioPath}\"";
            
            $output = shell_exec($command . ' 2>&1');
            
            if (file_exists($audioPath)) {
                Log::info('TTS Audio generated successfully with gTTS: ' . $audioPath);
                return $audioPath;
            }
            
            Log::warning('gTTS failed: ' . $output);
            return null;
            
        } catch (\Exception $e) {
            Log::error('gTTS Error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Python script untuk pyttsx3
     */
    private function getPythonScript()
    {
        return 'import sys
import pyttsx3
import os

def generate_tts(text, output_path):
    try:
        # Inisialisasi TTS engine
        engine = pyttsx3.init()
        
        # Set properties untuk suara Indonesia (jika tersedia)
        voices = engine.getProperty("voices")
        
        # Cari suara yang cocok untuk bahasa Indonesia
        indonesian_voice = None
        for voice in voices:
            if "indonesia" in voice.name.lower() or "id" in voice.id.lower():
                indonesian_voice = voice
                break
        
        if indonesian_voice:
            engine.setProperty("voice", indonesian_voice.id)
        
        # Set rate dan volume
        engine.setProperty("rate", 150)  # Kecepatan bicara
        engine.setProperty("volume", 0.9)  # Volume
        
        # Generate audio
        engine.save_to_file(text, output_path)
        engine.runAndWait()
        
        return True
        
    except Exception as e:
        print(f"Error: {str(e)}")
        return False

if __name__ == "__main__":
    if len(sys.argv) != 3:
        print("Usage: python script.py <text> <output_path>")
        sys.exit(1)
    
    text = sys.argv[1]
    output_path = sys.argv[2]
    
    success = generate_tts(text, output_path)
    if success:
        print(f"Audio generated successfully: {output_path}")
    else:
        print("Failed to generate audio")
        sys.exit(1)';
    }

    /**
     * Python script untuk gTTS
     */
    private function getGTTScript()
    {
        return 'import sys
import os
from gtts import gTTS

def generate_gtts(text, output_path):
    try:
        # Generate TTS dengan bahasa Indonesia
        tts = gTTS(text=text, lang="id", slow=False)
        
        # Simpan ke file
        tts.save(output_path)
        
        return True
        
    except Exception as e:
        print(f"Error: {str(e)}")
        return False

if __name__ == "__main__":
    if len(sys.argv) != 3:
        print("Usage: python script.py <text> <output_path>")
        sys.exit(1)
    
    text = sys.argv[1]
    output_path = sys.argv[2]
    
    success = generate_gtts(text, output_path)
    if success:
        print(f"Audio generated successfully: {output_path}")
    else:
        print("Failed to generate audio")
        sys.exit(1)';
    }

    /**
     * Test TTS service
     */
    public function testTTS()
    {
        $testText = "Ini adalah test Text to Speech untuk sistem antrian Puskesmas.";
        $audioPath = $this->generateQueueNumberTTS("001", "Poli Umum");
        
        if ($audioPath) {
            return [
                'success' => true,
                'message' => 'TTS berhasil di-generate',
                'audio_path' => $audioPath,
                'file_size' => filesize($audioPath) . ' bytes'
            ];
        }
        
        return [
            'success' => false,
            'message' => 'TTS gagal di-generate'
        ];
    }

    /**
     * Clean up old audio files
     */
    public function cleanupOldFiles($maxAge = 3600) // 1 jam
    {
        try {
            $files = glob($this->scriptPath . '/*.{wav,mp3}', GLOB_BRACE);
            $currentTime = time();
            $deletedCount = 0;
            
            foreach ($files as $file) {
                if (is_file($file)) {
                    $fileAge = $currentTime - filemtime($file);
                    if ($fileAge > $maxAge) {
                        unlink($file);
                        $deletedCount++;
                    }
                }
            }
            
            Log::info("Cleaned up {$deletedCount} old TTS audio files");
            return $deletedCount;
            
        } catch (\Exception $e) {
            Log::error('Cleanup Error: ' . $e->getMessage());
            return 0;
        }
    }
}
