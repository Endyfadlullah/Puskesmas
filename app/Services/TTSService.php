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
     * Generate TTS audio for queue call
     */
    public function generateQueueCall($poliName, $queueNumber)
    {
        try {
            // Convert queue number to Indonesian pronunciation
            $indonesianQueueNumber = $this->convertQueueNumberToIndonesian($queueNumber);

            // Create the text to be spoken
            $text = "antrian selanjutnya poli {$poliName} nomor {$indonesianQueueNumber}";

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
            if ($ttsResult['use_browser_tts']) {
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
}
