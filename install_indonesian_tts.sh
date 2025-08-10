#!/bin/bash

# Indonesian TTS Installation Script
# This script automates the installation of Indonesian TTS for Puskesmas system

set -e

echo "🏥 Indonesian TTS Installation for Puskesmas System"
echo "=================================================="
echo ""

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Function to print colored output
print_status() {
    echo -e "${BLUE}[INFO]${NC} $1"
}

print_success() {
    echo -e "${GREEN}[SUCCESS]${NC} $1"
}

print_warning() {
    echo -e "${YELLOW}[WARNING]${NC} $1"
}

print_error() {
    echo -e "${RED}[ERROR]${NC} $1"
}

# Check if running as root
if [[ $EUID -eq 0 ]]; then
   print_error "This script should not be run as root"
   exit 1
fi

# Check if Python is installed
print_status "Checking Python installation..."
if ! command -v python3 &> /dev/null; then
    print_error "Python 3 is not installed. Please install Python 3.8+ first."
    exit 1
fi

PYTHON_VERSION=$(python3 --version | cut -d' ' -f2)
print_success "Python $PYTHON_VERSION found"

# Check if pip is installed
print_status "Checking pip installation..."
if ! command -v pip3 &> /dev/null; then
    print_error "pip3 is not installed. Please install pip first."
    exit 1
fi

print_success "pip3 found"

# Install Coqui TTS
print_status "Installing Coqui TTS..."
if pip3 install TTS; then
    print_success "Coqui TTS installed successfully"
else
    print_error "Failed to install Coqui TTS"
    exit 1
fi

# Verify TTS installation
print_status "Verifying TTS installation..."
if tts --version &> /dev/null; then
    print_success "TTS command available"
else
    print_error "TTS command not found. Installation may have failed."
    exit 1
fi

# Create necessary directories
print_status "Creating directories..."
mkdir -p storage/app/tts/models
mkdir -p storage/app/public/audio/queue_calls

print_success "Directories created"

# Download model files
print_status "Downloading Indonesian TTS model files..."

MODEL_URL="https://github.com/Wikidepia/indonesian-tts/releases/download/v1.2"
CHECKPOINT_URL="$MODEL_URL/checkpoint.pth"
CONFIG_URL="$MODEL_URL/config.json"

# Download checkpoint.pth
print_status "Downloading checkpoint.pth..."
if curl -L -o storage/app/tts/models/checkpoint.pth "$CHECKPOINT_URL"; then
    print_success "checkpoint.pth downloaded"
else
    print_warning "Failed to download checkpoint.pth automatically"
    print_status "Please download manually from: $CHECKPOINT_URL"
    print_status "And save to: storage/app/tts/models/checkpoint.pth"
fi

# Download config.json
print_status "Downloading config.json..."
if curl -L -o storage/app/tts/models/config.json "$CONFIG_URL"; then
    print_success "config.json downloaded"
else
    print_warning "Failed to download config.json automatically"
    print_status "Please download manually from: $CONFIG_URL"
    print_status "And save to: storage/app/tts/models/config.json"
fi

# Install g2p-id (optional)
print_status "Installing g2p-id for better pronunciation..."
if pip3 install g2p-id; then
    print_success "g2p-id installed successfully"
else
    print_warning "Failed to install g2p-id. This is optional but recommended."
fi

# Set proper permissions
print_status "Setting file permissions..."
chmod -R 755 storage/app/tts/
chmod 644 storage/app/tts/models/* 2>/dev/null || true

print_success "Permissions set"

# Test the installation
print_status "Testing Indonesian TTS installation..."

TEST_TEXT="Halo dunia"
TEST_OUTPUT="test_indonesian_tts.wav"

if tts --text "$TEST_TEXT" \
    --model_path storage/app/tts/models/checkpoint.pth \
    --config_path storage/app/tts/models/config.json \
    --speaker_idx wibowo \
    --out_path "$TEST_OUTPUT" 2>/dev/null; then
    
    print_success "Indonesian TTS test successful!"
    
    # Check if audio file was created
    if [ -f "$TEST_OUTPUT" ]; then
        FILE_SIZE=$(du -h "$TEST_OUTPUT" | cut -f1)
        print_success "Test audio file created: $TEST_OUTPUT ($FILE_SIZE)"
        
        # Clean up test file
        rm "$TEST_OUTPUT"
        print_status "Test file cleaned up"
    fi
else
    print_warning "Indonesian TTS test failed. Please check the installation manually."
fi

# Create symbolic link for public access
print_status "Creating symbolic link for public access..."
if [ ! -L "public/storage" ]; then
    php artisan storage:link
    print_success "Storage link created"
else
    print_status "Storage link already exists"
fi

# Update .env file
print_status "Updating environment configuration..."

# Check if .env exists
if [ -f ".env" ]; then
    # Add Indonesian TTS configuration if not exists
    if ! grep -q "INDONESIAN_TTS_ENABLED" .env; then
        echo "" >> .env
        echo "# Indonesian TTS Configuration" >> .env
        echo "INDONESIAN_TTS_ENABLED=true" >> .env
        echo "INDONESIAN_TTS_MODEL_PATH=storage/app/tts/models/checkpoint.pth" >> .env
        echo "INDONESIAN_TTS_CONFIG_PATH=storage/app/tts/models/config.json" >> .env
        echo "INDONESIAN_TTS_DEFAULT_SPEAKER=wibowo" >> .env
        print_success "Environment variables added to .env"
    else
        print_status "Indonesian TTS environment variables already exist"
    fi
else
    print_warning ".env file not found. Please add Indonesian TTS configuration manually."
fi

# Final status check
print_status "Performing final status check..."

echo ""
echo "📋 Installation Summary:"
echo "========================"

# Check Python
if command -v python3 &> /dev/null; then
    echo -e "✅ Python: $(python3 --version)"
else
    echo -e "❌ Python: Not found"
fi

# Check TTS
if command -v tts &> /dev/null; then
    echo -e "✅ Coqui TTS: $(tts --version 2>/dev/null | head -n1 || echo 'Installed')"
else
    echo -e "❌ Coqui TTS: Not found"
fi

# Check model files
if [ -f "storage/app/tts/models/checkpoint.pth" ]; then
    echo -e "✅ Model file: checkpoint.pth"
else
    echo -e "❌ Model file: checkpoint.pth (missing)"
fi

if [ -f "storage/app/tts/models/config.json" ]; then
    echo -e "✅ Config file: config.json"
else
    echo -e "❌ Config file: config.json (missing)"
fi

# Check g2p-id
if command -v g2p-id &> /dev/null; then
    echo -e "✅ g2p-id: Installed"
else
    echo -e "⚠️  g2p-id: Not installed (optional)"
fi

echo ""
echo "🎉 Installation completed!"
echo ""
echo "📖 Next steps:"
echo "1. Access Indonesian TTS settings at: /admin/indonesian-tts"
echo "2. Test the TTS functionality"
echo "3. Configure speakers and preferences"
echo ""
echo "📚 Documentation: README_INDONESIAN_TTS.md"
echo "🐛 Troubleshooting: Check the documentation for common issues"
echo ""
echo "Happy coding! 🚀"
