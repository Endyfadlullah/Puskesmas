<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class TTSService
{
    private $apiKey;
    private $baseUrl = 'https://texttospeech.googleapis.com/v1/text:synthesize';

    public function __construct()
    {
        $this->apiKey = config('services.google.tts_api_key');
    }

    /**
     * Generate TTS audio for queue call
     */
    public function generateQueueCall($poliName, $queueNumber)
    {
        try {
            // Create the text to be spoken
            $text = "Nomor antrian {$queueNumber}, silakan menuju ke {$poliName}";

            // Generate TTS audio
            $audioContent = $this->synthesizeSpeech($text);

            if ($audioContent) {
                // Save audio file
                $filename = "queue_call_{$queueNumber}_{$poliName}_" . time() . ".mp3";
                $filepath = "audio/queue_calls/" . $filename;

                Storage::disk('public')->put($filepath, base64_decode($audioContent));

                return [
                    'success' => true,
                    'audio_url' => asset('storage/' . $filepath),
                    'filename' => $filename
                ];
            }

            // Fallback: return browser TTS info
            return [
                'success' => true,
                'audio_url' => null,
                'filename' => null,
                'text' => $text,
                'use_browser_tts' => true
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Error generating TTS: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Synthesize speech using Google TTS API
     */
    private function synthesizeSpeech($text)
    {
        if (!$this->apiKey) {
            // Fallback: use browser's built-in TTS
            return null;
        }

        $requestData = [
            'input' => [
                'text' => $text
            ],
            'voice' => [
                'languageCode' => 'id-ID',
                'name' => 'id-ID-Wavenet-A', // More natural and fluent Indonesian female voice
                'ssmlGender' => 'FEMALE'
            ],
            'audioConfig' => [
                'audioEncoding' => 'MP3',
                'speakingRate' => 0.85, // Slightly faster for more natural flow
                'pitch' => 0,
                'volumeGainDb' => 0
            ]
        ];

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post($this->baseUrl . '?key=' . $this->apiKey, $requestData);

            if ($response->successful()) {
                $data = $response->json();
                return $data['audioContent'] ?? null;
            }

            return null;
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Create complete audio sequence for queue call
     */
    public function createCompleteAudioSequence($poliName, $queueNumber)
    {
        $audioFiles = [];

        // 1. Attention sound
        $attentionSound = asset('assets/music/call-to-attention-123107.mp3');
        $audioFiles[] = [
            'type' => 'attention',
            'url' => $attentionSound,
            'duration' => 2000 // 2 seconds
        ];

        // 2. TTS for poli name and number
        $ttsResult = $this->generateQueueCall($poliName, $queueNumber);
        if ($ttsResult['success']) {
            if ($ttsResult['use_browser_tts']) {
                // Use browser TTS
                $audioFiles[] = [
                    'type' => 'browser_tts',
                    'text' => $ttsResult['text'],
                    'duration' => 4000 // 4 seconds
                ];
            } else {
                // Use generated audio file
                $audioFiles[] = [
                    'type' => 'tts',
                    'url' => $ttsResult['audio_url'],
                    'duration' => 4000 // 4 seconds
                ];
            }
        }

        // 3. Final attention sound
        $audioFiles[] = [
            'type' => 'attention',
            'url' => $attentionSound,
            'duration' => 2000 // 2 seconds
        ];

        return $audioFiles;
    }
}
