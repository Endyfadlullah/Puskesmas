<?php

namespace App\Http\Controllers;

use App\Services\SimpleTTSService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class TTSController extends Controller
{
    protected $ttsService;

    public function __construct(SimpleTTSService $ttsService)
    {
        $this->ttsService = $ttsService;
    }

    /**
     * Show TTS management page
     */
    public function index()
    {
        return view('admin.tts.index');
    }

    /**
     * Generate TTS untuk nomor antrian
     */
    public function generateQueueTTS(Request $request)
    {
        $request->validate([
            'queue_number' => 'required|string',
            'service_name' => 'nullable|string'
        ]);

        try {
            $queueNumber = $request->input('queue_number');
            $serviceName = $request->input('service_name', '');

            // Generate TTS audio
            $audioPath = $this->ttsService->generateQueueNumberTTS($queueNumber, $serviceName);

            if (!$audioPath) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal generate TTS audio'
                ], 500);
            }

            // Get file info
            $fileName = basename($audioPath);
            $fileSize = filesize($audioPath);
            $fileType = pathinfo($audioPath, PATHINFO_EXTENSION) === 'wav' ? 'audio/wav' : 'audio/mpeg';

            return response()->json([
                'success' => true,
                'message' => 'TTS audio berhasil di-generate',
                'data' => [
                    'file_name' => $fileName,
                    'file_path' => $audioPath,
                    'file_size' => $fileSize,
                    'file_type' => $fileType,
                    'queue_number' => $queueNumber,
                    'service_name' => $serviceName
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Play TTS audio
     */
    public function playTTS(Request $request)
    {
        // Handle both GET and POST requests
        $filePath = $request->input('file_path') ?? $request->input('file');

        if (!$filePath) {
            return response()->json([
                'success' => false,
                'message' => 'File parameter tidak ditemukan'
            ], 400);
        }

        try {
            // If only filename is provided, construct full path
            if (!file_exists($filePath)) {
                $scriptPath = storage_path('app/tts_scripts');
                $fullPath = $scriptPath . '/' . $filePath;

                if (!file_exists($fullPath)) {
                    return response()->json([
                        'success' => false,
                        'message' => 'File audio tidak ditemukan: ' . $filePath
                    ], 404);
                }

                $filePath = $fullPath;
            }

            // Get file info
            $fileName = basename($filePath);
            $fileSize = filesize($filePath);
            $fileType = pathinfo($filePath, PATHINFO_EXTENSION) === 'wav' ? 'audio/wav' : 'audio/mpeg';

            // Return audio file for streaming
            return response()->file($filePath, [
                'Content-Type' => $fileType,
                'Content-Disposition' => 'inline; filename="' . $fileName . '"'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Test TTS service
     */
    public function testTTS()
    {
        try {
            $result = $this->ttsService->testTTS();

            return response()->json($result);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Test TTS service for public access
     */
    public function testPublicTTS()
    {
        try {
            $result = $this->ttsService->testTTS();

            if ($result['success']) {
                // Return a simple HTML page with audio player
                $audioUrl = '/tts/audio/' . basename($result['audio_path']);

                return response()->view('tts.test-public', [
                    'audioUrl' => $audioUrl,
                    'result' => $result
                ]);
            } else {
                return response()->json($result, 500);
            }

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get available TTS voices
     */
    public function getVoices()
    {
        try {
            // Buat script Python untuk mendapatkan daftar suara
            $scriptContent = 'import pyttsx3

def get_voices():
    try:
        engine = pyttsx3.init()
        voices = engine.getProperty("voices")
        
        voice_list = []
        for i, voice in enumerate(voices):
            voice_info = {
                "id": voice.id,
                "name": voice.name,
                "languages": voice.languages,
                "gender": voice.gender,
                "age": voice.age
            }
            voice_list.append(voice_info)
        
        print("VOICES_START")
        for voice in voice_list:
            print(f"{voice[\'id\']}|{voice[\'name\']}|{voice[\'languages\']}|{voice[\'gender\']}|{voice[\'age\']}")
        print("VOICES_END")
        
    except Exception as e:
        print(f"Error: {str(e)}")

if __name__ == "__main__":
    get_voices()';

            $scriptFile = storage_path('app/tts_scripts/get_voices.py');
            file_put_contents($scriptFile, $scriptContent);

            // Eksekusi script
            $command = "python \"{$scriptFile}\" 2>&1";
            $output = shell_exec($command);

            // Parse output
            $voices = [];
            if (preg_match('/VOICES_START(.*?)VOICES_END/s', $output, $matches)) {
                $lines = explode("\n", trim($matches[1]));
                foreach ($lines as $line) {
                    if (trim($line)) {
                        $parts = explode('|', $line);
                        if (count($parts) >= 5) {
                            $voices[] = [
                                'id' => $parts[0],
                                'name' => $parts[1],
                                'languages' => $parts[2],
                                'gender' => $parts[3],
                                'age' => $parts[4]
                            ];
                        }
                    }
                }
            }

            return response()->json([
                'success' => true,
                'voices' => $voices,
                'total' => count($voices)
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Clean up old TTS files
     */
    public function cleanupFiles(Request $request)
    {
        try {
            $maxAge = $request->input('max_age', 3600); // Default 1 jam
            $deletedCount = $this->ttsService->cleanupOldFiles($maxAge);

            return response()->json([
                'success' => true,
                'message' => "Berhasil menghapus {$deletedCount} file lama",
                'deleted_count' => $deletedCount
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get TTS status
     */
    public function getStatus()
    {
        try {
            $status = [
                'python' => false,
                'pyttsx3' => false,
                'gtts' => false,
                'audio_files' => 0,
                'last_cleanup' => null
            ];

            // Check Python
            $pythonCheck = shell_exec('python --version 2>&1');
            $status['python'] = !empty($pythonCheck) && strpos($pythonCheck, 'Python') !== false;

            // Check pyttsx3
            if ($status['python']) {
                $pyttsx3Check = shell_exec('python -c "import pyttsx3; print(\'OK\')" 2>&1');
                $status['pyttsx3'] = $pyttsx3Check === 'OK';
            }

            // Check gTTS
            if ($status['python']) {
                $gttsCheck = shell_exec('python -c "from gtts import gTTS; print(\'OK\')" 2>&1');
                $status['gtts'] = $gttsCheck === 'OK';
            }

            // Check audio files
            $scriptPath = storage_path('app/tts_scripts');
            if (file_exists($scriptPath)) {
                $audioFiles = glob($scriptPath . '/*.{wav,mp3}', GLOB_BRACE);
                $status['audio_files'] = count($audioFiles);
            }

            // Get last cleanup time
            $status['last_cleanup'] = now()->subHours(1)->format('Y-m-d H:i:s');

            return response()->json([
                'success' => true,
                'status' => $status
            ]);

        } catch (\Exception $e) {
            Log::error('TTS Status Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error checking TTS status: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Play TTS audio for public access (display page)
     */
    public function playPublicAudio($filename)
    {
        try {
            // Validate filename
            if (empty($filename) || !preg_match('/^[a-zA-Z0-9_-]+\.(wav|mp3)$/', $filename)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid filename'
                ], 400);
            }

            $scriptPath = storage_path('app/tts_scripts');
            $filePath = $scriptPath . '/' . $filename;

            if (!file_exists($filePath)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Audio file not found: ' . $filename
                ], 404);
            }

            // Get file info
            $fileSize = filesize($filePath);
            $fileType = pathinfo($filePath, PATHINFO_EXTENSION) === 'wav' ? 'audio/wav' : 'audio/mpeg';

            // Return audio file for streaming
            return response()->file($filePath, [
                'Content-Type' => $fileType,
                'Content-Disposition' => 'inline; filename="' . $filename . '"',
                'Cache-Control' => 'public, max-age=3600' // Cache for 1 hour
            ]);

        } catch (\Exception $e) {
            Log::error('Public TTS Audio Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error playing audio: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Play audio sequence for display page (legacy support)
     */
    public function playAudioSequence(Request $request)
    {
        try {
            $request->validate([
                'poli_name' => 'required|string',
                'queue_number' => 'required|string'
            ]);

            $poliName = $request->input('poli_name');
            $queueNumber = $request->input('queue_number');

            // Generate TTS audio using our new service
            $audioPath = $this->ttsService->generateQueueNumberTTS($queueNumber, $poliName);

            if (!$audioPath || !file_exists($audioPath)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to generate TTS audio'
                ], 500);
            }

            // Return audio sequence format that display page expects
            return response()->json([
                'success' => true,
                'audio_sequence' => [
                    [
                        'type' => 'audio_file',
                        'url' => '/tts/audio/' . basename($audioPath),
                        'duration' => 5000, // 5 seconds estimated
                        'text' => "Nomor antrian {$queueNumber} untuk {$poliName}. Silakan menuju ke loket yang tersedia."
                    ]
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('TTS Audio Sequence Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error generating audio sequence: ' . $e->getMessage()
            ], 500);
        }
    }
}
