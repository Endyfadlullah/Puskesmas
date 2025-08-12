@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50 py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Text-to-Speech Management</h1>
                        <p class="mt-2 text-gray-600">Kelola sistem TTS untuk panggilan nomor antrian</p>
                    </div>
                    <div class="flex space-x-3">
                        <a href="{{ route('admin.dashboard') }}"
                            class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Kembali
                        </a>
                    </div>
                </div>
            </div>

            <!-- Status Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Python Status -->
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Python</dt>
                                    <dd class="text-lg font-medium text-gray-900" id="python-status">Checking...</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- pyttsx3 Status -->
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z">
                                    </path>
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">pyttsx3</dt>
                                    <dd class="text-lg font-medium text-gray-900" id="pyttsx3-status">Checking...</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- gTTS Status -->
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                    </path>
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">gTTS</dt>
                                    <dd class="text-lg font-medium text-gray-900" id="gtts-status">Checking...</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Audio Files -->
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3">
                                    </path>
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Audio Files</dt>
                                    <dd class="text-lg font-medium text-gray-900" id="audio-files-count">Checking...</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- TTS Test Panel -->
                <div class="bg-white shadow rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Test TTS</h3>
                        <p class="mt-1 text-sm text-gray-500">Test sistem TTS dengan nomor antrian</p>
                    </div>
                    <div class="p-6">
                        <form id="tts-test-form">
                            <div class="space-y-4">
                                <div>
                                    <label for="test-queue-number" class="block text-sm font-medium text-gray-700">Nomor
                                        Antrian</label>
                                    <input type="text" id="test-queue-number" name="queue_number" value="001"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                </div>

                                <div>
                                    <label for="test-service-name" class="block text-sm font-medium text-gray-700">Nama
                                        Layanan</label>
                                    <input type="text" id="test-service-name" name="service_name" value="Poli Umum"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                </div>

                                <div class="flex space-x-3">
                                    <button type="submit"
                                        class="flex-1 bg-indigo-600 border border-transparent rounded-md shadow-sm py-2 px-4 inline-flex justify-center text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z">
                                            </path>
                                        </svg>
                                        Generate TTS
                                    </button>

                                    <button type="button" id="test-tts-btn"
                                        class="flex-1 bg-green-600 border border-transparent rounded-md shadow-sm py-2 px-4 inline-flex justify-center text-sm font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500"
                                        disabled>
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-6 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                            </path>
                                        </svg>
                                        Test TTS
                                    </button>
                                </div>
                            </div>
                        </form>

                        <!-- Test Results -->
                        <div id="test-results" class="mt-6 hidden">
                            <div class="rounded-md bg-gray-50 p-4">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-gray-800" id="test-result-title">Test Result
                                        </h3>
                                        <div class="mt-2 text-sm text-gray-700" id="test-result-content"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TTS Management Panel -->
                <div class="bg-white shadow rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">TTS Management</h3>
                        <p class="mt-1 text-sm text-gray-500">Kelola file audio dan suara TTS</p>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            <!-- Available Voices -->
                            <div>
                                <h4 class="text-sm font-medium text-gray-700 mb-2">Available Voices</h4>
                                <button type="button" id="refresh-voices-btn"
                                    class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                                        </path>
                                    </svg>
                                    Refresh Voices
                                </button>
                                <div id="voices-list" class="mt-3 text-sm text-gray-600">Click refresh to load voices...
                                </div>
                            </div>

                            <!-- Cleanup -->
                            <div>
                                <h4 class="text-sm font-medium text-gray-700 mb-2">File Management</h4>
                                <button type="button" id="cleanup-btn"
                                    class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                        </path>
                                    </svg>
                                    Cleanup Old Files
                                </button>
                                <p class="mt-1 text-xs text-gray-500">Hapus file audio lama (lebih dari 1 jam)</p>
                            </div>

                            <!-- Status -->
                            <div>
                                <h4 class="text-sm font-medium text-gray-700 mb-2">System Status</h4>
                                <button type="button" id="refresh-status-btn"
                                    class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                                        </path>
                                    </svg>
                                    Refresh Status
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Audio Player -->
            <div id="audio-player" class="mt-8 bg-white shadow rounded-lg hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Audio Player</h3>
                </div>
                <div class="p-6">
                    <audio id="tts-audio" controls class="w-full">
                        Your browser does not support the audio element.
                    </audio>
                    <div class="mt-4 text-sm text-gray-600">
                        <p><strong>File:</strong> <span id="audio-file-name">-</span></p>
                        <p><strong>Size:</strong> <span id="audio-file-size">-</span></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Loading Overlay -->
    <div id="loading-overlay" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen">
            <div class="bg-white rounded-lg p-6 flex items-center space-x-3">
                <svg class="animate-spin h-5 w-5 text-indigo-600" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                        stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor"
                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                    </path>
                </svg>
                <span class="text-gray-700">Processing...</span>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Elements
            const ttsForm = document.getElementById('tts-test-form');
            const testTTSBtn = document.getElementById('test-tts-btn');
            const testResults = document.getElementById('test-results');
            const testResultTitle = document.getElementById('test-result-title');
            const testResultContent = document.getElementById('test-result-content');
            const audioPlayer = document.getElementById('audio-player');
            const ttsAudio = document.getElementById('tts-audio');
            const audioFileName = document.getElementById('audio-file-name');
            const audioFileSize = document.getElementById('audio-file-size');
            const loadingOverlay = document.getElementById('loading-overlay');

            // Buttons
            const refreshVoicesBtn = document.getElementById('refresh-voices-btn');
            const cleanupBtn = document.getElementById('cleanup-btn');
            const refreshStatusBtn = document.getElementById('refresh-status-btn');

            let currentAudioPath = null;

            // Initialize
            checkStatus();

            // Event Listeners
            ttsForm.addEventListener('submit', handleTTSGenerate);
            testTTSBtn.addEventListener('click', playCurrentAudio);
            refreshVoicesBtn.addEventListener('click', getVoices);
            cleanupBtn.addEventListener('click', cleanupFiles);
            refreshStatusBtn.addEventListener('click', checkStatus);

            // TTS Generate
            async function handleTTSGenerate(e) {
                e.preventDefault();

                const formData = new FormData(ttsForm);
                const data = {
                    queue_number: formData.get('queue_number'),
                    service_name: formData.get('service_name')
                };

                showLoading(true);

                try {
                    const response = await fetch('{{ route('admin.tts.generate') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify(data)
                    });

                    const result = await response.json();

                    if (result.success) {
                        currentAudioPath = result.data.file_path;
                        showTestResult('success', 'TTS berhasil di-generate!', result.data);
                        testTTSBtn.disabled = false;
                        showAudioPlayer(result.data);
                    } else {
                        showTestResult('error', 'Gagal generate TTS', result.message);
                    }

                } catch (error) {
                    showTestResult('error', 'Error', error.message);
                } finally {
                    showLoading(false);
                }
            }

            // Play Audio
            function playCurrentAudio() {
                if (currentAudioPath && ttsAudio.src) {
                    ttsAudio.play();
                }
            }

            // Show Test Result
            function showTestResult(type, title, content) {
                testResultTitle.textContent = title;

                if (type === 'success') {
                    testResultTitle.className = 'text-sm font-medium text-green-800';
                    testResultContent.innerHTML = `
                <p><strong>File:</strong> ${content.file_name}</p>
                <p><strong>Size:</strong> ${content.file_size} bytes</p>
                <p><strong>Type:</strong> ${content.file_type}</p>
            `;
                } else {
                    testResultTitle.className = 'text-sm font-medium text-red-800';
                    testResultContent.textContent = content;
                }

                testResults.classList.remove('hidden');
            }

            // Show Audio Player
            function showAudioPlayer(audioData) {
                const audioUrl =
                    `{{ route('admin.tts.play') }}?file_path=${encodeURIComponent(audioData.file_path)}`;
                ttsAudio.src = audioUrl;
                audioFileName.textContent = audioData.file_name;
                audioFileSize.textContent = audioData.file_size + ' bytes';
                audioPlayer.classList.remove('hidden');
            }

            // Get Voices
            async function getVoices() {
                showLoading(true);

                try {
                    const response = await fetch('{{ route('admin.tts.voices') }}');
                    const result = await response.json();

                    if (result.success) {
                        displayVoices(result.voices);
                    } else {
                        console.error('Failed to get voices:', result.message);
                    }

                } catch (error) {
                    console.error('Error getting voices:', error);
                } finally {
                    showLoading(false);
                }
            }

            // Display Voices
            function displayVoices(voices) {
                const voicesList = document.getElementById('voices-list');

                if (voices.length === 0) {
                    voicesList.innerHTML = '<p class="text-gray-500">No voices found</p>';
                    return;
                }

                const voicesHtml = voices.map(voice => `
            <div class="border rounded p-2 mb-2">
                <p><strong>ID:</strong> ${voice.id}</p>
                <p><strong>Name:</strong> ${voice.name}</p>
                <p><strong>Languages:</strong> ${voice.languages || 'N/A'}</p>
                <p><strong>Gender:</strong> ${voice.gender || 'N/A'}</p>
            </div>
        `).join('');

                voicesList.innerHTML = voicesHtml;
            }

            // Cleanup Files
            async function cleanupFiles() {
                if (!confirm('Are you sure you want to cleanup old files?')) return;

                showLoading(true);

                try {
                    const response = await fetch('{{ route('admin.tts.cleanup') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    });

                    const result = await response.json();

                    if (result.success) {
                        alert(`Berhasil menghapus ${result.deleted_count} file lama`);
                        checkStatus();
                    } else {
                        alert('Gagal cleanup files: ' + result.message);
                    }

                } catch (error) {
                    alert('Error: ' + error.message);
                } finally {
                    showLoading(false);
                }
            }

            // Check Status
            async function checkStatus() {
                try {
                    const response = await fetch('{{ route('admin.tts.status') }}');
                    const result = await response.json();

                    if (result.success) {
                        updateStatusDisplay(result.status);
                    }

                } catch (error) {
                    console.error('Error checking status:', error);
                }
            }

            // Update Status Display
            function updateStatusDisplay(status) {
                document.getElementById('python-status').textContent = status.python_available ? 'Available' :
                    'Not Available';
                document.getElementById('pyttsx3-status').textContent = status.pyttsx3_available ? 'Available' :
                    'Not Available';
                document.getElementById('gtts-status').textContent = status.gtts_available ? 'Available' :
                    'Not Available';
                document.getElementById('audio-files-count').textContent = status.total_audio_files;

                // Update status colors
                updateStatusColor('python-status', status.python_available);
                updateStatusColor('pyttsx3-status', status.pyttsx3_available);
                updateStatusColor('gtts-status', status.gtts_available);
            }

            // Update Status Color
            function updateStatusColor(elementId, isAvailable) {
                const element = document.getElementById(elementId);
                if (isAvailable) {
                    element.className = 'text-lg font-medium text-green-600';
                } else {
                    element.className = 'text-lg font-medium text-red-600';
                }
            }

            // Show/Hide Loading
            function showLoading(show) {
                if (show) {
                    loadingOverlay.classList.remove('hidden');
                } else {
                    loadingOverlay.classList.add('hidden');
                }
            }
        });
    </script>
@endpush
