#!/bin/bash

# 🎤 Indonesian TTS Installation Script untuk Puskesmas
# Script ini akan menginstall semua dependencies yang diperlukan untuk Indonesian TTS

echo "🚀 Memulai instalasi Indonesian TTS System..."
echo "================================================"

# Check if running as root
if [ "$EUID" -eq 0 ]; then
    echo "❌ Jangan jalankan script ini sebagai root/sudo"
    exit 1
fi

# Check Python version
echo "🔍 Memeriksa Python..."
if command -v python3 &> /dev/null; then
    PYTHON_CMD="python3"
    echo "✅ Python3 ditemukan: $(python3 --version)"
elif command -v python &> /dev/null; then
    PYTHON_CMD="python"
    echo "✅ Python ditemukan: $(python --version)"
else
    echo "❌ Python tidak ditemukan. Silakan install Python 3.7+ terlebih dahulu."
    exit 1
fi

# Check pip
echo "🔍 Memeriksa pip..."
if ! command -v pip3 &> /dev/null && ! command -v pip &> /dev/null; then
    echo "❌ pip tidak ditemukan. Silakan install pip terlebih dahulu."
    exit 1
fi

# Install Python dependencies
echo "📦 Installing Python dependencies..."
echo "Installing pyttsx3..."
$PYTHON_CMD -m pip install pyttsx3

echo "Installing gTTS..."
$PYTHON_CMD -m pip install gTTS

echo "Installing Coqui TTS..."
$PYTHON_CMD -m pip install TTS

# Create necessary directories
echo "📁 Membuat direktori yang diperlukan..."
mkdir -p storage/app/tts_scripts
mkdir -p storage/app/tts/models
mkdir -p storage/app/public/audio/queue_calls

# Set permissions
echo "🔐 Setting permissions..."
chmod -R 755 storage/app/tts_scripts
chmod -R 755 storage/app/tts/models
chmod -R 755 storage/app/public/audio

# Download Indonesian TTS models (if available)
echo "📥 Downloading Indonesian TTS models..."
MODEL_DIR="storage/app/tts/models"

# Check if models already exist
if [ -f "$MODEL_DIR/checkpoint.pth" ] && [ -f "$MODEL_DIR/config.json" ]; then
    echo "✅ Model files sudah ada"
else
    echo "⚠️  Model files belum ada. Silakan download manual dari:"
    echo "   https://huggingface.co/coqui/Indonesian-TTS"
    echo "   Atau gunakan script download terpisah"
fi

# Create test script
echo "🧪 Membuat test script..."
cat > storage/app/tts_scripts/test_indonesian_tts.py << 'EOF'
#!/usr/bin/env python3
"""
Test script untuk Indonesian TTS
"""

import sys
import os

def test_pyttsx3():
    try:
        import pyttsx3
        print("✅ pyttsx3: OK")
        return True
    except ImportError:
        print("❌ pyttsx3: NOT FOUND")
        return False

def test_gtts():
    try:
        from gtts import gTTS
        print("✅ gTTS: OK")
        return True
    except ImportError:
        print("❌ gTTS: NOT FOUND")
        return False

def test_coqui_tts():
    try:
        import TTS
        print("✅ Coqui TTS: OK")
        return True
    except ImportError:
        print("❌ Coqui TTS: NOT FOUND")
        return False

def test_models():
    model_dir = "storage/app/tts/models"
    checkpoint = os.path.join(model_dir, "checkpoint.pth")
    config = os.path.join(model_dir, "config.json")
    
    if os.path.exists(checkpoint) and os.path.exists(config):
        print("✅ Model files: OK")
        return True
    else:
        print("❌ Model files: NOT FOUND")
        return False

def main():
    print("🔍 Testing Indonesian TTS Dependencies...")
    print("=" * 40)
    
    pyttsx3_ok = test_pyttsx3()
    gtts_ok = test_gtts()
    coqui_ok = test_coqui_tts()
    models_ok = test_models()
    
    print("=" * 40)
    
    if all([pyttsx3_ok, gtts_ok, coqui_ok, models_ok]):
        print("🎉 Semua dependencies berhasil diinstall!")
        print("🚀 Indonesian TTS siap digunakan!")
    else:
        print("⚠️  Beberapa dependencies belum terinstall dengan sempurna")
        print("   Silakan jalankan script ini lagi atau install manual")

if __name__ == "__main__":
    main()
EOF

# Make test script executable
chmod +x storage/app/tts_scripts/test_indonesian_tts.py

# Create Indonesian TTS generator script
echo "📝 Membuat Indonesian TTS generator script..."
cat > storage/app/tts_scripts/indonesian_tts_generator.py << 'EOF'
#!/usr/bin/env python3
"""
Indonesian TTS Generator menggunakan Coqui TTS
"""

import sys
import os
import json
from pathlib import Path

def generate_indonesian_tts(text, output_path, speaker="wibowo"):
    """
    Generate TTS audio menggunakan Indonesian TTS model
    """
    try:
        from TTS.api import TTS
        
        # Initialize TTS
        tts = TTS(model_path="storage/app/tts/models/checkpoint.pth",
                  config_path="storage/app/tts/models/config.json")
        
        # Generate audio
        tts.tts_to_file(text=text, file_path=output_path, speaker=speaker)
        
        return True
        
    except Exception as e:
        print(f"Error generating Indonesian TTS: {e}")
        return False

def main():
    if len(sys.argv) < 3:
        print("Usage: python indonesian_tts_generator.py <text> <output_path> [speaker]")
        sys.exit(1)
    
    text = sys.argv[1]
    output_path = sys.argv[2]
    speaker = sys.argv[3] if len(sys.argv) > 3 else "wibowo"
    
    print(f"Generating Indonesian TTS...")
    print(f"Text: {text}")
    print(f"Output: {output_path}")
    print(f"Speaker: {speaker}")
    
    success = generate_indonesian_tts(text, output_path, speaker)
    
    if success:
        print("✅ Indonesian TTS generated successfully!")
    else:
        print("❌ Failed to generate Indonesian TTS")
        sys.exit(1)

if __name__ == "__main__":
    main()
EOF

# Make generator script executable
chmod +x storage/app/tts_scripts/indonesian_tts_generator.py

# Test the installation
echo "🧪 Testing installation..."
$PYTHON_CMD storage/app/tts_scripts/test_indonesian_tts.py

# Create README for Indonesian TTS
echo "📖 Membuat README Indonesian TTS..."
cat > README_INDONESIAN_TTS.md << 'EOF'
# 🎤 Indonesian TTS System untuk Puskesmas

## 📋 Overview
Sistem Indonesian TTS menggunakan model Coqui TTS yang dioptimalkan untuk bahasa Indonesia.

## 🚀 Fitur
- Model TTS khusus bahasa Indonesia
- Pengucapan natural dan akurat
- Support multiple speakers
- Offline processing
- High quality audio output

## 📁 File Structure
```
storage/app/tts/
├── models/
│   ├── checkpoint.pth    # Model checkpoint
│   └── config.json       # Model configuration
└── scripts/
    ├── test_indonesian_tts.py
    └── indonesian_tts_generator.py
```

## 🔧 Usage
```bash
# Test dependencies
python storage/app/tts_scripts/test_indonesian_tts.py

# Generate TTS
python storage/app/tts_scripts/indonesian_tts_generator.py "Nomor antrian 001" output.wav
```

## 📥 Model Download
Download model files dari: https://huggingface.co/coqui/Indonesian-TTS

## 🆘 Troubleshooting
- Pastikan Python 3.7+ terinstall
- Pastikan semua dependencies terinstall
- Pastikan model files ada di direktori yang benar
EOF

echo ""
echo "🎉 Instalasi Indonesian TTS selesai!"
echo "================================================"
echo ""
echo "📋 Langkah selanjutnya:"
echo "1. Download model files dari Hugging Face"
echo "2. Test sistem dengan: python storage/app/tts_scripts/test_indonesian_tts.py"
echo "3. Akses Indonesian TTS di admin panel: /admin/indonesian-tts"
echo ""
echo "📖 Dokumentasi lengkap ada di: README_INDONESIAN_TTS.md"
echo ""
echo "🚀 Selamat menggunakan Indonesian TTS System!"
