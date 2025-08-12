@extends('layouts.app')

@section('title', 'Audio Management')

@section('content')
    <div class="min-h-screen bg-gray-50">
        @include('admin.partials.top-nav')

        <div class="flex">
            @include('admin.partials.sidebar')

            <!-- Main Content -->
            <div class="flex-1 lg:ml-0">
                <div class="px-4 sm:px-6 lg:px-8 py-6 md:py-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">🎵 Audio Management</h1>
            <p class="text-gray-600">Kelola dan test audio untuk panggilan antrian</p>
        </div>

        <!-- Audio Test Panel -->
        <div class="bg-white shadow rounded-lg mb-8">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-900">🧪 Test Audio</h2>
                <p class="mt-1 text-sm text-gray-500">Test audio untuk setiap poli</p>
            </div>
            <div class="p-6">
                <form id="audio-test-form">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Poli Selection -->
                        <div>
                            <label for="poli_name" class="block text-sm font-medium text-gray-700 mb-2">Pilih Poli</label>
                            <select name="poli_name" id="poli_name" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Pilih Poli</option>
                                <option value="umum">Poli Umum</option>
                                <option value="gigi">Poli Gigi</option>
                                <option value="kesehatan jiwa">Poli Kesehatan Jiwa</option>
                                <option value="kesehatan tradisional">Poli Kesehatan Tradisional</option>
                            </select>
                        </div>

                        <!-- Test Button -->
                        <div class="flex items-end">
                            <button type="submit" id="test-audio-btn"
                                class="w-full bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-200">
                                <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-6 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Test Audio
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Test Result -->
                <div id="test-result" class="mt-6 hidden">
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Audio Sequence:</h3>
                        <div id="audio-sequence-info" class="text-sm text-gray-600"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Available Audio Files -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-900">📁 Available Audio Files</h2>
                <p class="mt-1 text-sm text-gray-500">Daftar file audio yang tersedia</p>
            </div>
            <div class="p-6">
                <div id="audio-files-list" class="space-y-3">
                    <div class="text-center text-gray-500 py-8">
                        <svg class="w-8 h-8 mx-auto mb-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"></path>
                        </svg>
                        <p>Loading audio files...</p>
                    </div>
                </div>
            </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    const audioTestForm = document.getElementById('audio-test-form');
    const testAudioBtn = document.getElementById('test-audio-btn');
    const testResult = document.getElementById('test-result');
    const audioSequenceInfo = document.getElementById('audio-sequence-info');
    const audioFilesList = document.getElementById('audio-files-list');

    // Load available audio files
    async function loadAudioFiles() {
        try {
            const response = await fetch('{{ route('audio.files') }}');
            const data = await response.json();

            if (data.success && data.files.length > 0) {
                audioFilesList.innerHTML = data.files.map(file => `
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg border border-gray-200">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"></path>
                            </svg>
                            <span class="text-sm font-medium text-gray-900">${file}</span>
                        </div>
                        <button onclick="playAudioFile('${file}')" 
                            class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                            Play
                        </button>
                    </div>
                `).join('');
            } else {
                audioFilesList.innerHTML = `
                    <div class="text-center text-gray-500 py-8">
                        <svg class="w-8 h-8 mx-auto mb-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                        <p>No audio files found</p>
                    </div>
                `;
            }
        } catch (error) {
            console.error('Error loading audio files:', error);
            audioFilesList.innerHTML = `
                <div class="text-center text-red-500 py-8">
                    <svg class="w-8 h-8 mx-auto mb-2 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                    <p>Error loading audio files</p>
                </div>
            `;
        }
    }

    // Play single audio file
    function playAudioFile(filename) {
        const audio = new Audio(`/assets/music/tts/${filename}`);
        audio.play().catch(error => {
            console.error('Error playing audio:', error);
        });
    }

    // Handle form submission
    audioTestForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const formData = new FormData(audioTestForm);
        const poliName = formData.get('poli_name');
        
        if (!poliName) {
            alert('Pilih poli terlebih dahulu');
            return;
        }

        testAudioBtn.disabled = true;
        testAudioBtn.innerHTML = `
            <svg class="w-4 h-4 mr-2 inline animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
            </svg>
            Testing...
        `;

        try {
            const response = await fetch('{{ route('audio.test') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    poli_name: poliName
                })
            });

            const result = await response.json();

            if (result.success) {
                showTestResult(result.audio_sequence);
                testResult.classList.remove('hidden');
            } else {
                alert('Error: ' + result.message);
            }
        } catch (error) {
            console.error('Error testing audio:', error);
            alert('Terjadi kesalahan saat test audio');
        } finally {
            testAudioBtn.disabled = false;
            testAudioBtn.innerHTML = `
                <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-6 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Test Audio
            `;
        }
    });

    // Show test result
    function showTestResult(audioSequence) {
        const sequenceHtml = audioSequence.map((item, index) => {
            if (item.type === 'audio_file') {
                return `
                    <div class="mb-2 p-2 bg-white rounded border">
                        <strong>Step ${index + 1}:</strong> Audio File
                        <br>
                        <small class="text-gray-500">URL: ${item.url}</small>
                        <br>
                        <small class="text-gray-500">Duration: ${item.duration}ms</small>
                    </div>
                `;
            } else if (item.type === 'delay') {
                return `
                    <div class="mb-2 p-2 bg-gray-100 rounded border">
                        <strong>Step ${index + 1}:</strong> Delay
                        <br>
                        <small class="text-gray-500">Duration: ${item.duration}ms</small>
                    </div>
                `;
            } else {
                return `
                    <div class="mb-2 p-2 bg-white rounded border">
                        <strong>Step ${index + 1}:</strong> ${item.type}
                        <br>
                        <small class="text-gray-500">Duration: ${item.duration}ms</small>
                    </div>
                `;
            }
        }).join('');

        audioSequenceInfo.innerHTML = sequenceHtml;
    }

    // Load audio files on page load
    document.addEventListener('DOMContentLoaded', function() {
        loadAudioFiles();
    });
</script>
@endpush
@endsection
