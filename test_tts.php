<?php
/**
 * Test file untuk fitur TTS
 * Jalankan dengan: php test_tts.php
 */

require_once 'vendor/autoload.php';

use App\Services\TTSService;

echo "=== Test TTS Service ===\n";

try {
    $ttsService = new TTSService();
    
    echo "1. Testing generateQueueCall...\n";
    $result = $ttsService->generateQueueCall('Poli Umum', 'A001');
    echo "Result: " . json_encode($result, JSON_PRETTY_PRINT) . "\n\n";
    
    echo "2. Testing createCompleteAudioSequence...\n";
    $sequence = $ttsService->createCompleteAudioSequence('Poli Umum', 'A001');
    echo "Sequence: " . json_encode($sequence, JSON_PRETTY_PRINT) . "\n\n";
    
    echo "3. Testing dengan poli berbeda...\n";
    $sequence2 = $ttsService->createCompleteAudioSequence('Poli Gigi', 'B002');
    echo "Sequence 2: " . json_encode($sequence2, JSON_PRETTY_PRINT) . "\n\n";
    
    echo "✅ TTS Service berfungsi dengan baik!\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
}

echo "\n=== Test Selesai ===\n";
