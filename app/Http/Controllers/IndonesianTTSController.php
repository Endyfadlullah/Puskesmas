<?php

namespace App\Http\Controllers;

use App\Services\IndonesianTTSService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class IndonesianTTSController extends Controller
{
    private $indonesianTTSService;

    public function __construct()
    {
        $this->indonesianTTSService = new IndonesianTTSService();
    }

    /**
     * Show Indonesian TTS settings page
     */
    public function index(): View
    {
        return view('admin.indonesian-tts.index');
    }

    /**
     * Generate TTS audio for queue call
     */
    public function generateQueueCall(Request $request): JsonResponse
    {
        $request->validate([
            'poli_name' => 'required|string',
            'queue_number' => 'required|string'
        ]);

        $poliName = $request->input('poli_name');
        $queueNumber = $request->input('queue_number');

        $result = $this->indonesianTTSService->generateQueueCall($poliName, $queueNumber);

        return response()->json($result);
    }

    /**
     * Create complete audio sequence for queue call
     */
    public function createAudioSequence(Request $request): JsonResponse
    {
        $request->validate([
            'poli_name' => 'required|string',
            'queue_number' => 'required|string'
        ]);

        $poliName = $request->input('poli_name');
        $queueNumber = $request->input('queue_number');

        $audioSequence = $this->indonesianTTSService->createCompleteAudioSequence($poliName, $queueNumber);

        return response()->json([
            'success' => true,
            'audio_sequence' => $audioSequence,
            'poli_name' => $poliName,
            'queue_number' => $queueNumber
        ]);
    }

    /**
     * Check Indonesian TTS status
     */
    public function checkStatus(): JsonResponse
    {
        $status = [
            'indonesian_tts_available' => $this->indonesianTTSService->isIndonesianTTSAvailable(),
            'coqui_tts_installed' => $this->indonesianTTSService->isCoquiTTSInstalled(),
            'model_files_exist' => file_exists(storage_path('app/tts/models/checkpoint.pth')) &&
                file_exists(storage_path('app/tts/models/config.json')),
            'available_speakers' => $this->indonesianTTSService->getAvailableSpeakers(),
            'installation_instructions' => $this->indonesianTTSService->installIndonesianTTS()
        ];

        return response()->json($status);
    }

    /**
     * Test Indonesian TTS with sample text
     */
    public function testTTS(Request $request): JsonResponse
    {
        $request->validate([
            'text' => 'required|string|max:500'
        ]);

        $text = $request->input('text');

        try {
            $result = $this->indonesianTTSService->generateWithIndonesianTTS($text, 'test', 'Test');

            return response()->json([
                'success' => true,
                'message' => 'TTS test berhasil',
                'audio_url' => $result['audio_url'] ?? null,
                'tts_type' => $result['tts_type'] ?? 'fallback'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'TTS test gagal: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Get installation instructions
     */
    public function getInstallationInstructions(): JsonResponse
    {
        $instructions = $this->indonesianTTSService->installIndonesianTTS();

        return response()->json([
            'success' => true,
            'instructions' => $instructions
        ]);
    }

    /**
     * Download Indonesian TTS model files
     */
    public function downloadModelFiles(): JsonResponse
    {
        $modelUrls = [
            'checkpoint.pth' => 'https://github.com/Wikidepia/indonesian-tts/releases/download/v1.2/checkpoint.pth',
            'config.json' => 'https://github.com/Wikidepia/indonesian-tts/releases/download/v1.2/config.json'
        ];

        $downloadInfo = [
            'title' => 'Download Indonesian TTS Model Files',
            'description' => 'Download file model yang diperlukan untuk Indonesian TTS',
            'files' => $modelUrls,
            'manual_steps' => [
                '1. Kunjungi: https://github.com/Wikidepia/indonesian-tts/releases',
                '2. Download file checkpoint.pth dan config.json',
                '3. Buat folder: ' . storage_path('app/tts/models/'),
                '4. Simpan file di folder tersebut',
                '5. Pastikan permission file dapat dibaca oleh web server'
            ]
        ];

        return response()->json([
            'success' => true,
            'download_info' => $downloadInfo
        ]);
    }
}
