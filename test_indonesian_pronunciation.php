<?php
/**
 * Test Indonesian Pronunciation Conversion
 * 
 * This file tests the Indonesian pronunciation conversion logic
 * that converts alphanumeric queue numbers to Indonesian pronunciation.
 */

// Indonesian number words (same as in TTSService)
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

/**
 * Convert alphanumeric queue number to Indonesian pronunciation
 * Example: "U5" becomes "U Lima", "A10" becomes "A Sepuluh"
 */
function convertQueueNumberToIndonesian($queueNumber) {
    global $indonesianNumbers;
    
    // If it's a pure number, convert it
    if (is_numeric($queueNumber)) {
        $number = (int)$queueNumber;
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
        $numberValue = (int)$numbers;
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

// Test cases
echo "=== Indonesian Pronunciation Conversion Test ===\n\n";

$testCases = [
    // Pure numbers
    '1' => 'Satu',
    '5' => 'Lima',
    '10' => 'Sepuluh',
    '15' => 'Lima Belas',
    '25' => 'Dua Puluh Lima',
    '100' => 'Seratus',
    
    // Alphanumeric queue numbers
    'U5' => 'U Lima',
    'A10' => 'A Sepuluh',
    'B15' => 'B Lima Belas',
    'C25' => 'C Dua Puluh Lima',
    'D100' => 'D Seratus',
    
    // Edge cases
    'ABC123' => 'ABC Seratus Dua Puluh Tiga',
    'X1' => 'X Satu',
    'Y0' => 'Y Nol',
    'Z99' => 'Z Sembilan Puluh Sembilan',
    
    // Non-alphanumeric (should remain unchanged)
    'POLI-UMUM' => 'POLI-UMUM',
    'ANTRIAN-1' => 'ANTRIAN-1', // Mixed with dash
];

echo "Test Results:\n";
echo str_repeat('-', 50) . "\n";

foreach ($testCases as $input => $expected) {
    $result = convertQueueNumberToIndonesian($input);
    $status = ($result === $expected) ? '✓ PASS' : '✗ FAIL';
    echo sprintf("%-15s → %-25s [%s]\n", $input, $result, $status);
    
    if ($result !== $expected) {
        echo "  Expected: $expected\n";
    }
}

echo "\n" . str_repeat('-', 50) . "\n";
echo "Test completed!\n\n";

// Additional examples for user verification
echo "=== Examples for User Verification ===\n";
echo "Queue Number → Indonesian Pronunciation\n";
echo str_repeat('-', 40) . "\n";

$examples = ['U5', 'A10', 'B15', 'C25', 'D100', 'X1', 'Y0', 'Z99'];

foreach ($examples as $example) {
    $pronunciation = convertQueueNumberToIndonesian($example);
    echo "$example → $pronunciation\n";
}

echo "\nThese examples show how alphanumeric queue numbers\n";
echo "are converted to Indonesian pronunciation for TTS.\n";
echo "For example, 'U5' becomes 'U Lima' instead of 'U five'.\n";
