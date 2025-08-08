<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TTSService;
use App\Models\Antrian;

class TTSController extends Controller
{
    private $ttsService;

    public function __construct()
    {
        $this->ttsService = new TTSService();
    }

    /**
     * Generate TTS for queue call
     */
    public function generateQueueCall(Request $request)
    {
        $request->validate([
            'poli_name' => 'required|string',
            'queue_number' => 'required|string'
        ]);

        try {
            $result = $this->ttsService->generateQueueCall(
                $request->poli_name,
                $request->queue_number
            );

            return response()->json($result);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error generating TTS: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get complete audio sequence for queue call
     */
    public function getAudioSequence(Request $request)
    {
        $request->validate([
            'poli_name' => 'required|string',
            'queue_number' => 'required|string'
        ]);

        try {
            $audioSequence = $this->ttsService->createCompleteAudioSequence(
                $request->poli_name,
                $request->queue_number
            );

            return response()->json([
                'success' => true,
                'audio_sequence' => $audioSequence
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error creating audio sequence: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Play audio sequence on display
     */
    public function playAudioSequence(Request $request)
    {
        $request->validate([
            'antrian_id' => 'required|exists:antrians,id'
        ]);

        try {
            $antrian = Antrian::with('poli')->findOrFail($request->antrian_id);
            
            $audioSequence = $this->ttsService->createCompleteAudioSequence(
                $antrian->poli->nama_poli,
                $antrian->no_antrian
            );

            return response()->json([
                'success' => true,
                'audio_sequence' => $audioSequence,
                'poli_name' => $antrian->poli->nama_poli,
                'queue_number' => $antrian->no_antrian
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error playing audio sequence: ' . $e->getMessage()
            ], 500);
        }
    }
}
