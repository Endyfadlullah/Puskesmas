<?php

namespace App\Http\Controllers;

use App\Services\AudioService;
use Illuminate\Http\Request;

class AudioController extends Controller
{
    protected $audioService;

    public function __construct(AudioService $audioService)
    {
        $this->audioService = $audioService;
    }

    /**
     * Show audio management page
     */
    public function index()
    {
        return view('admin.audio.index');
    }

    /**
     * Get audio sequence for queue call
     */
    public function getQueueCallAudio(Request $request)
    {
        $request->validate([
            'poli_name' => 'required|string'
        ]);

        $poliName = $request->input('poli_name');
        $result = $this->audioService->getQueueCallAudio($poliName);

        return response()->json($result);
    }

    /**
     * Get available audio files
     */
    public function getAvailableAudioFiles()
    {
        $files = $this->audioService->getAvailableAudioFiles();
        
        return response()->json([
            'success' => true,
            'files' => $files
        ]);
    }

    /**
     * Test audio playback
     */
    public function testAudio(Request $request)
    {
        $request->validate([
            'poli_name' => 'required|string'
        ]);

        $poliName = $request->input('poli_name');
        $result = $this->audioService->getQueueCallAudio($poliName);

        return response()->json($result);
    }
}
