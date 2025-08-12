<?php

namespace App\Services;

class AudioService
{
    /**
     * Get audio sequence for queue call
     */
    public function getQueueCallAudio($poliName)
    {
        // Normalize poli name for file matching
        $normalizedPoliName = $this->normalizePoliName($poliName);
        
        // Check if audio file exists for this poli
        $poliAudioFile = "assets/music/tts/antrian selanjutnya. poli {$normalizedPoliName}.mp3";
        
        if (!file_exists(public_path($poliAudioFile))) {
            // Fallback to default audio
            $poliAudioFile = "assets/music/tts/antrian selanjutnya. poli umum.mp3";
        }

        return [
            'success' => true,
            'audio_sequence' => [
                [
                    'type' => 'audio_file',
                    'url' => asset('assets/music/announcement.mp3'),
                    'duration' => 4000 // 4 seconds
                ],
                [
                    'type' => 'delay',
                    'duration' => 1000 // 1 second delay between announcement and antrian
                ],
                [
                    'type' => 'audio_file', 
                    'url' => asset($poliAudioFile),
                    'duration' => 4000 // 4 seconds
                ]
            ]
        ];
    }

    /**
     * Normalize poli name to match audio file names
     */
    private function normalizePoliName($poliName)
    {
        $poliName = strtolower(trim($poliName));
        
        // Map poli names to match audio files
        $poliMap = [
            'umum' => 'umum',
            'gigi' => 'gigi', 
            'kesehatan jiwa' => 'jiwa',
            'jiwa' => 'jiwa',
            'kesehatan tradisional' => 'Tradisional',
            'tradisional' => 'Tradisional'
        ];

        return $poliMap[$poliName] ?? 'umum';
    }

    /**
     * Get all available audio files
     */
    public function getAvailableAudioFiles()
    {
        $audioDir = public_path('assets/music/tts');
        $files = [];
        
        if (is_dir($audioDir)) {
            $audioFiles = glob($audioDir . '/*.mp3');
            foreach ($audioFiles as $file) {
                $files[] = basename($file);
            }
        }
        
        return $files;
    }
}
