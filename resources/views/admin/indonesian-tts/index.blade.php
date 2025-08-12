@extends('layouts.app')

@section('title', 'Indonesian TTS Management')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">🎤 Indonesian TTS Management</h1>
            <p class="text-gray-600">Kelola sistem Text-to-Speech bahasa Indonesia untuk panggilan antrian</p>
        </div>

        <!-- Status Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-blue-500">
                <div class="flex items-center">
                    <div class="p-2 bg-blue-100 rounded-lg">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                            </path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Indonesian TTS</p>
                        <p class="text-2xl font-semibold text-gray-900" id="indonesian-tts-status">Checking...</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-green-500">
                <div class="flex items-center">
                    <div class="p-2 bg-green-100 rounded-lg">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Coqui TTS</p>
                        <p class="text-2xl font-semibold text-gray-900" id="coqui-tts-status">Checking...</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-purple-500">
                <div class="flex items-center">
                    <div class="p-2 bg-purple-100 rounded-lg">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 4V2a1 1 0 011-1h8a1 1 0 011 1v2m-9 0h10m-10 0a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V6a2 2 0 00-2-2">
                            </path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Model Files</p>
                        <p class="text-2xl font-semibold text-gray-900" id="model-files-status">Checking...</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-orange-500">
                <div class="flex items-center">
                    <div class="p-2 bg-orange-100 rounded-lg">
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Speakers</p>
                        <p class="text-2xl font-semibold text-gray-900" id="speakers-status">Checking...</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- TTS Test Panel -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">🧪 Test Indonesian TTS</h2>

                <div class="space-y-4">
                    <div>
                        <label for="test-text" class="block text-sm font-medium text-gray-700 mb-2">Text untuk Test</label>
                        <textarea id="test-text" rows="3"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Masukkan text untuk test TTS...">Nomor antrian 001, silakan menuju ke Poli Umum</textarea>
                    </div>

                    <button id="test-tts-btn"
                        class="w-full bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors">
                        <span class="inline-flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-6 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                </path>
                            </svg>
                            Test TTS
                        </span>
                    </button>

                    <div id="test-result" class="hidden">
                        <div class="p-3 bg-gray-50 rounded-md">
                            <p class="text-sm text-gray-700" id="test-message"></p>
                            <audio id="test-audio" controls class="w-full mt-2"></audio>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Queue Call Generator -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">📞 Generate Panggilan Antrian</h2>

                <div class="space-y-4">
                    <div>
                        <label for="poli-name" class="block text-sm font-medium text-gray-700 mb-2">Nama Poli</label>
                        <select id="poli-name"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Pilih Poli</option>
                            <option value="Poli Umum">Poli Umum</option>
                            <option value="Poli Gigi">Poli Gigi</option>
                            <option value="Poli Jiwa">Poli Jiwa</option>
                            <option value="Poli Tradisional">Poli Tradisional</option>
                        </select>
                    </div>

                    <div>
                        <label for="queue-number" class="block text-sm font-medium text-gray-700 mb-2">Nomor
                            Antrian</label>
                        <input type="text" id="queue-number"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Contoh: 001">
                    </div>

                    <button id="generate-call-btn"
                        class="w-full bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 transition-colors">
                        <span class="inline-flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z">
                                </path>
                            </svg>
                            Generate Panggilan
                        </span>
                    </button>

                    <div id="call-result" class="hidden">
                        <div class="p-3 bg-gray-50 rounded-md">
                            <p class="text-sm text-gray-700" id="call-message"></p>
                            <audio id="call-audio" controls class="w-full mt-2"></audio>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Installation & Setup -->
        <div class="mt-8 bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">⚙️ Installation & Setup</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-3">📥 Download Model Files</h3>
                    <p class="text-sm text-gray-600 mb-4">Download model Indonesian TTS yang diperlukan untuk sistem ini.
                    </p>
                    <button id="download-models-btn"
                        class="bg-purple-600 text-white px-4 py-2 rounded-md hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 transition-colors">
                        Download Models
                    </button>
                </div>

                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-3">📋 Installation Guide</h3>
                    <p class="text-sm text-gray-600 mb-4">Panduan lengkap instalasi Indonesian TTS system.</p>
                    <button id="show-install-guide-btn"
                        class="bg-orange-600 text-white px-4 py-2 rounded-md hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-orange-500 transition-colors">
                        Lihat Panduan
                    </button>
                </div>
            </div>

            <div id="install-guide" class="hidden mt-6 p-4 bg-gray-50 rounded-md">
                <h4 class="font-medium text-gray-900 mb-3">📖 Panduan Instalasi Indonesian TTS</h4>
                <div id="install-content" class="text-sm text-gray-700 space-y-2">
                    <!-- Installation content will be loaded here -->
                </div>
            </div>
        </div>

        <!-- System Information -->
        <div class="mt-8 bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">ℹ️ System Information</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-3">🔍 Available Speakers</h3>
                    <div id="speakers-list" class="text-sm text-gray-600">
                        <!-- Speakers list will be loaded here -->
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-3">📊 Model Details</h3>
                    <div id="model-details" class="text-sm text-gray-600">
                        <!-- Model details will be loaded here -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Loading Overlay -->
    <div id="loading-overlay" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 flex items-center space-x-3">
            <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-blue-600"></div>
            <span class="text-gray-700">Processing...</span>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize
            checkStatus();
            loadSpeakers();
            loadModelDetails();

            // Event Listeners
            document.getElementById('test-tts-btn').addEventListener('click', testTTS);
            document.getElementById('generate-call-btn').addEventListener('click', generateQueueCall);
            document.getElementById('download-models-btn').addEventListener('click', downloadModels);
            document.getElementById('show-install-guide-btn').addEventListener('click', toggleInstallGuide);

            // Check system status
            function checkStatus() {
                fetch('/admin/indonesian-tts/status')
                    .then(response => response.json())
                    .then(data => {
                        updateStatusDisplay(data);
                    })
                    .catch(error => {
                        console.error('Error checking status:', error);
                        showError('Gagal memeriksa status sistem');
                    });
            }

            // Update status display
            function updateStatusDisplay(status) {
                document.getElementById('indonesian-tts-status').textContent = status.indonesian_tts_available ?
                    'Available' : 'Not Available';
                document.getElementById('coqui-tts-status').textContent = status.coqui_tts_installed ? 'Installed' :
                    'Not Installed';
                document.getElementById('model-files-status').textContent = status.model_files_exist ? 'Ready' :
                    'Missing';
                document.getElementById('speakers-status').textContent = status.available_speakers ? status
                    .available_speakers.length : '0';
            }

            // Load speakers
            function loadSpeakers() {
                fetch('/admin/indonesian-tts/status')
                    .then(response => response.json())
                    .then(data => {
                        const speakersList = document.getElementById('speakers-list');
                        if (data.available_speakers && data.available_speakers.length > 0) {
                            speakersList.innerHTML = data.available_speakers.map(speaker =>
                                `<div class="p-2 bg-blue-50 rounded mb-2">🎤 ${speaker}</div>`
                            ).join('');
                        } else {
                            speakersList.innerHTML = '<p class="text-gray-500">No speakers available</p>';
                        }
                    });
            }

            // Load model details
            function loadModelDetails() {
                const modelDetails = document.getElementById('model-details');
                modelDetails.innerHTML = `
            <div class="space-y-2">
                <div><strong>Model Path:</strong> <code class="text-xs">storage/app/tts/models/</code></div>
                <div><strong>Config:</strong> <span id="config-status">Checking...</span></div>
                <div><strong>Checkpoint:</strong> <span id="checkpoint-status">Checking...</span></div>
            </div>
        `;

                // Check individual files
                checkModelFiles();
            }

            // Check model files
            function checkModelFiles() {
                fetch('/admin/indonesian-tts/status')
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('config-status').textContent = data.model_files_exist ?
                            '✅ Available' : '❌ Missing';
                        document.getElementById('checkpoint-status').textContent = data.model_files_exist ?
                            '✅ Available' : '❌ Missing';
                    });
            }

            // Test TTS
            function testTTS() {
                const text = document.getElementById('test-text').value;
                if (!text.trim()) {
                    showError('Masukkan text untuk test');
                    return;
                }

                showLoading();

                fetch('/admin/indonesian-tts/test', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content')
                        },
                        body: JSON.stringify({
                            text: text
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        hideLoading();
                        if (data.success) {
                            showTestResult(data.message, data.audio_url);
                        } else {
                            showError(data.message || 'Test TTS gagal');
                        }
                    })
                    .catch(error => {
                        hideLoading();
                        console.error('Error testing TTS:', error);
                        showError('Terjadi kesalahan saat test TTS');
                    });
            }

            // Generate queue call
            function generateQueueCall() {
                const poliName = document.getElementById('poli-name').value;
                const queueNumber = document.getElementById('queue-number').value;

                if (!poliName || !queueNumber) {
                    showError('Pilih poli dan masukkan nomor antrian');
                    return;
                }

                showLoading();

                fetch('/admin/indonesian-tts/generate', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content')
                        },
                        body: JSON.stringify({
                            poli_name: poliName,
                            queue_number: queueNumber
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        hideLoading();
                        if (data.success) {
                            showCallResult(data.message, data.audio_url);
                        } else {
                            showError(data.message || 'Generate panggilan gagal');
                        }
                    })
                    .catch(error => {
                        hideLoading();
                        console.error('Error generating call:', error);
                        showError('Terjadi kesalahan saat generate panggilan');
                    });
            }

            // Download models
            function downloadModels() {
                showLoading();
                window.location.href = '/admin/indonesian-tts/download';
                setTimeout(hideLoading, 2000);
            }

            // Toggle install guide
            function toggleInstallGuide() {
                const guide = document.getElementById('install-guide');
                const content = document.getElementById('install-content');

                if (guide.classList.contains('hidden')) {
                    // Load installation guide
                    fetch('/admin/indonesian-tts/install')
                        .then(response => response.json())
                        .then(data => {
                            content.innerHTML = data.instructions || 'Installation guide not available';
                            guide.classList.remove('hidden');
                        })
                        .catch(error => {
                            console.error('Error loading install guide:', error);
                            content.innerHTML = 'Failed to load installation guide';
                            guide.classList.remove('hidden');
                        });
                } else {
                    guide.classList.add('hidden');
                }
            }

            // Show test result
            function showTestResult(message, audioUrl) {
                const result = document.getElementById('test-result');
                const messageEl = document.getElementById('test-message');
                const audio = document.getElementById('test-audio');

                messageEl.textContent = message;
                audio.src = audioUrl;
                result.classList.remove('hidden');
            }

            // Show call result
            function showCallResult(message, audioUrl) {
                const result = document.getElementById('call-result');
                const messageEl = document.getElementById('call-message');
                const audio = document.getElementById('call-audio');

                messageEl.textContent = message;
                audio.src = audioUrl;
                result.classList.remove('hidden');
            }

            // Show error
            function showError(message) {
                // You can implement a toast notification here
                alert(message);
            }

            // Show/hide loading
            function showLoading() {
                document.getElementById('loading-overlay').classList.remove('hidden');
            }

            function hideLoading() {
                document.getElementById('loading-overlay').classList.add('hidden');
            }
        });
    </script>
@endpush
