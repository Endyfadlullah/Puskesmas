<?php
/**
 * Simple test untuk fitur TTS
 * Test manual untuk memverifikasi logika TTS
 */

echo "=== Simple TTS Test ===\n";

// Test 1: Check file audio exists
$attentionSound = 'public/assets/music/call-to-attention-123107.mp3';
if (file_exists($attentionSound)) {
    echo "✅ Attention sound file exists: $attentionSound\n";
} else {
    echo "❌ Attention sound file not found: $attentionSound\n";
}

// Test 2: Check storage directory
$storageDir = 'public/storage/audio/queue_calls';
if (is_dir($storageDir)) {
    echo "✅ Storage directory exists: $storageDir\n";
} else {
    echo "❌ Storage directory not found: $storageDir\n";
}

// Test 3: Check symbolic link
$storageLink = 'public/storage';
if (is_link($storageLink)) {
    echo "✅ Storage symbolic link exists: $storageLink\n";
} else {
    echo "❌ Storage symbolic link not found: $storageLink\n";
}

// Test 4: Simulate TTS sequence
echo "\n=== Simulating TTS Sequence ===\n";
$poliName = 'Poli Umum';
$queueNumber = 'A001';

echo "1. Attention Sound: $attentionSound\n";
echo "2. TTS Text: \"Nomor antrian $queueNumber, silakan menuju ke $poliName\"\n";
echo "3. Attention Sound: $attentionSound\n";

echo "\n=== Test Configuration ===\n";
echo "Google TTS API Key: " . (getenv('GOOGLE_TTS_API_KEY') ? 'Set' : 'Not Set') . "\n";
echo "Browser TTS: Available (Speech Synthesis API)\n";

echo "\n=== Manual Testing Instructions ===\n";
echo "1. Buka halaman admin: /admin/poli/umum\n";
echo "2. Klik tombol 'Panggil' pada antrian\n";
echo "3. Periksa console browser untuk log\n";
echo "4. Buka halaman display: /display\n";
echo "5. Test cross-page communication\n";

echo "\n✅ Simple TTS Test Complete!\n";
