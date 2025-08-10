@extends('layouts.app')

@section('title', 'Indonesian TTS Settings')

@section('content')
    <div class="min-h-screen bg-gray-50">
        <!-- Top Navigation -->
        <nav class="bg-white shadow-lg sticky top-0 z-40">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <button id="sidebar-toggle" class="lg:hidden text-gray-700 hover:text-primary mr-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>
                        <div class="flex-shrink-0">
                            <h1 class="text-xl md:text-2xl font-bold text-primary">🏥 Admin Puskesmas</h1>
                        </div>
                    </div>
                    <div class="hidden md:flex items-center space-x-4">
                        <a href="{{ route('display') }}"
                            class="text-gray-700 hover:text-primary px-3 py-2 rounded-md text-sm font-medium transition duration-200">Display</a>
                        <span class="text-gray-700">Selamat datang, Admin</span>
                        <button onclick="confirmLogout()"
                            class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md text-sm font-medium transition duration-200">
                            Logout
                        </button>
                    </div>
                </div>
            </div>
        </nav>

        <div class="flex">
            <!-- Sidebar -->
            <aside id="sidebar"
                class="fixed inset-y-0 left-0 z-50 w-64 bg-white shadow-xl transform -translate-x-full lg:translate-x-0 lg:static lg:inset-0 transition duration-200 ease-in-out">
                <div class="flex items-center justify-between h-16 px-6 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">Menu Admin</h2>
                    <button id="sidebar-close" class="lg:hidden text-gray-500 hover:text-gray-700">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                            </path>
                        </svg>
                    </button>
                </div>

                <nav class="px-6 py-6">
                    <div class="space-y-6">
                        <!-- Dashboard -->
                        <div>
                            <a href="{{ route('admin.dashboard') }}"
                                class="flex items-center px-4 py-3 rounded-xl {{ request()->routeIs('admin.dashboard') ? 'bg-blue-50 text-blue-700 border border-blue-200' : 'text-gray-700 hover:bg-gray-50' }} transition duration-200">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 5a2 2 0 012-2h4a2 2 0 012 2v6H8V5z"></path>
                                </svg>
                                <span class="font-medium">Dashboard</span>
                            </a>
                        </div>

                        <!-- Daftar Antrian -->
                        <div>
                            <div
                                class="flex items-center px-4 py-2 text-sm font-semibold text-gray-500 uppercase tracking-wider">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                    </path>
                                </svg>
                                Daftar Antrian
                            </div>
                            <div class="mt-3 space-y-1">
                                <a href="{{ route('admin.poli.umum') }}"
                                    class="flex items-center px-4 py-2 rounded-lg {{ request()->routeIs('admin.poli.umum') ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:bg-gray-50' }} transition duration-200">
                                    <div class="w-2 h-2 bg-blue-500 rounded-full mr-3"></div>
                                    <span class="text-sm">Poli Umum</span>
                                </a>
                                <a href="{{ route('admin.poli.gigi') }}"
                                    class="flex items-center px-4 py-2 rounded-lg {{ request()->routeIs('admin.poli.gigi') ? 'bg-green-50 text-green-700' : 'text-gray-600 hover:bg-gray-50' }} transition duration-200">
                                    <div class="w-2 h-2 bg-green-500 rounded-full mr-3"></div>
                                    <span class="text-sm">Poli Gigi</span>
                                </a>
                                <a href="{{ route('admin.poli.jiwa') }}"
                                    class="flex items-center px-4 py-2 rounded-lg {{ request()->routeIs('admin.poli.jiwa') ? 'bg-purple-50 text-purple-700' : 'text-gray-600 hover:bg-gray-50' }} transition duration-200">
                                    <div class="w-2 h-2 bg-purple-500 rounded-full mr-3"></div>
                                    <span class="text-sm">Poli Jiwa</span>
                                </a>
                                <a href="{{ route('admin.poli.tradisional') }}"
                                    class="flex items-center px-4 py-2 rounded-lg {{ request()->routeIs('admin.poli.tradisional') ? 'bg-yellow-50 text-yellow-700' : 'text-gray-600 hover:bg-gray-50' }} transition duration-200">
                                    <div class="w-2 h-2 bg-yellow-500 rounded-full mr-3"></div>
                                    <span class="text-sm">Poli Tradisional</span>
                                </a>
                            </div>
                        </div>

                        <!-- Kelola User -->
                        <div>
                            <a href="{{ route('admin.users.index') }}"
                                class="flex items-center px-4 py-3 rounded-xl {{ request()->routeIs('admin.users.*') ? 'bg-blue-50 text-blue-700 border border-blue-200' : 'text-gray-700 hover:bg-gray-50' }} transition duration-200">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z">
                                    </path>
                                </svg>
                                <span class="font-medium">Kelola User</span>
                            </a>
                        </div>

                        <!-- Laporan -->
                        <div>
                            <a href="{{ route('admin.laporan.index') }}"
                                class="flex items-center px-4 py-3 rounded-xl {{ request()->routeIs('admin.laporan.*') ? 'bg-blue-50 text-blue-700 border border-blue-200' : 'text-gray-700 hover:bg-gray-50' }} transition duration-200">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                                <span class="font-medium">Laporan</span>
                            </a>
                        </div>

                        <!-- Indonesian TTS Settings -->
                        <div>
                            <a href="{{ route('admin.indonesian-tts.index') }}"
                                class="flex items-center px-4 py-3 rounded-xl {{ request()->routeIs('admin.indonesian-tts.*') ? 'bg-green-50 text-green-700 border border-green-200' : 'text-gray-700 hover:bg-gray-50' }} transition duration-200">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z">
                                    </path>
                                </svg>
                                <span class="font-medium">Indonesian TTS</span>
                            </a>
                        </div>

                        <!-- Display -->
                        <div>
                            <a href="{{ route('display') }}"
                                class="flex items-center px-4 py-3 rounded-xl text-gray-700 hover:bg-gray-50 transition duration-200">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z">
                                    </path>
                                </svg>
                                <span class="font-medium">Display</span>
                            </a>
                        </div>
                    </div>
                </nav>
            </aside>

            <!-- Overlay for mobile -->
            <div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden hidden"></div>

            <!-- Main Content -->
            <div class="flex-1 lg:ml-0">
                <div class="px-4 sm:px-6 lg:px-8 py-6 md:py-8">
                    <!-- Header -->
                    <div class="mb-8 animate-fade-in">
                        <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">Indonesian TTS Settings</h1>
                        <p class="text-gray-600 text-lg">Kelola pengaturan Text-to-Speech Indonesia</p>
                    </div>

                    <!-- Status Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                        <!-- Indonesian TTS Status -->
                        <div class="bg-white rounded-xl shadow-lg p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div id="indonesian-tts-status"
                                        class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center">
                                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-lg font-semibold text-gray-900">Indonesian TTS</h3>
                                    <p id="indonesian-tts-text" class="text-sm text-gray-500">Checking...</p>
                                </div>
                            </div>
                        </div>

                        <!-- Coqui TTS Status -->
                        <div class="bg-white rounded-xl shadow-lg p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div id="coqui-tts-status"
                                        class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center">
                                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-lg font-semibold text-gray-900">Coqui TTS</h3>
                                    <p id="coqui-tts-text" class="text-sm text-gray-500">Checking...</p>
                                </div>
                            </div>
                        </div>

                        <!-- Model Files Status -->
                        <div class="bg-white rounded-xl shadow-lg p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div id="model-files-status"
                                        class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center">
                                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-lg font-semibold text-gray-900">Model Files</h3>
                                    <p id="model-files-text" class="text-sm text-gray-500">Checking...</p>
                                </div>
                            </div>
                        </div>

                        <!-- Speakers Status -->
                        <div class="bg-white rounded-xl shadow-lg p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div id="speakers-status"
                                        class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center">
                                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-lg font-semibold text-gray-900">Available Speakers</h3>
                                    <p id="speakers-text" class="text-sm text-gray-500">Checking...</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Test TTS Section -->
                    <div class="bg-white rounded-2xl shadow-xl p-8 mb-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">Test Indonesian TTS</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="test-text" class="block text-sm font-medium text-gray-700 mb-2">Text untuk
                                    Test</label>
                                <textarea id="test-text" rows="4"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    placeholder="Masukkan text untuk test TTS...">Nomor antrian U Lima, silakan menuju ke Poli Umum</textarea>
                            </div>
                            <div class="flex items-end">
                                <button id="test-tts-btn"
                                    class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-md font-medium transition duration-200">
                                    Test TTS
                                </button>
                            </div>
                        </div>
                        <div id="test-result" class="mt-4 hidden">
                            <div class="bg-gray-50 rounded-lg p-4">
                                <h4 class="font-semibold text-gray-900 mb-2">Hasil Test:</h4>
                                <p id="test-result-text" class="text-sm text-gray-600"></p>
                            </div>
                        </div>
                    </div>

                    <!-- Installation Instructions -->
                    <div class="bg-white rounded-2xl shadow-xl p-8 mb-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">Instalasi Indonesian TTS</h2>
                        <div id="installation-instructions" class="prose max-w-none">
                            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-yellow-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z">
                                            </path>
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-yellow-800">Perhatian</h3>
                                        <div class="mt-2 text-sm text-yellow-700">
                                            <p>Indonesian TTS memerlukan instalasi Coqui TTS dan model files. Ikuti
                                                langkah-langkah di bawah ini.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="installation-steps" class="space-y-4">
                                <!-- Installation steps will be loaded here -->
                            </div>
                        </div>
                    </div>

                    <!-- Download Model Files -->
                    <div class="bg-white rounded-2xl shadow-xl p-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">Download Model Files</h2>
                        <div id="download-info" class="space-y-4">
                            <!-- Download info will be loaded here -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // Sidebar toggle for mobile
            document.getElementById('sidebar-toggle').addEventListener('click', function() {
                document.getElementById('sidebar').classList.remove('-translate-x-full');
                document.getElementById('sidebar-overlay').classList.remove('hidden');
            });

            document.getElementById('sidebar-close').addEventListener('click', function() {
                document.getElementById('sidebar').classList.add('-translate-x-full');
                document.getElementById('sidebar-overlay').classList.add('hidden');
            });

            document.getElementById('sidebar-overlay').addEventListener('click', function() {
                document.getElementById('sidebar').classList.add('-translate-x-full');
                document.getElementById('sidebar-overlay').classList.add('hidden');
            });

            // Load status on page load
            document.addEventListener('DOMContentLoaded', function() {
                loadStatus();
                loadInstallationInstructions();
                loadDownloadInfo();
            });

            // Load Indonesian TTS status
            function loadStatus() {
                fetch('{{ route('admin.indonesian-tts.status') }}')
                    .then(response => response.json())
                    .then(data => {
                        updateStatusCard('indonesian-tts', data.indonesian_tts_available, 'Indonesian TTS');
                        updateStatusCard('coqui-tts', data.coqui_tts_installed, 'Coqui TTS');
                        updateStatusCard('model-files', data.model_files_exist, 'Model Files');

                        const speakersCount = Object.keys(data.available_speakers || {}).length;
                        updateStatusCard('speakers', speakersCount > 0, `${speakersCount} Speakers Available`);
                    })
                    .catch(error => {
                        console.error('Error loading status:', error);
                    });
            }

            // Update status card
            function updateStatusCard(id, isAvailable, text) {
                const statusElement = document.getElementById(`${id}-status`);
                const textElement = document.getElementById(`${id}-text`);

                if (isAvailable) {
                    statusElement.className = 'w-8 h-8 rounded-full bg-green-100 flex items-center justify-center';
                    statusElement.innerHTML =
                        '<svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>';
                    textElement.textContent = text;
                    textElement.className = 'text-sm text-green-600';
                } else {
                    statusElement.className = 'w-8 h-8 rounded-full bg-red-100 flex items-center justify-center';
                    statusElement.innerHTML =
                        '<svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>';
                    textElement.textContent = 'Not Available';
                    textElement.className = 'text-sm text-red-600';
                }
            }

            // Load installation instructions
            function loadInstallationInstructions() {
                fetch('{{ route('admin.indonesian-tts.install') }}')
                    .then(response => response.json())
                    .then(data => {
                        const container = document.getElementById('installation-steps');
                        const steps = data.instructions.steps;

                        let html = '<ol class="list-decimal list-inside space-y-2">';
                        steps.forEach(step => {
                            if (step.trim() === '') {
                                html += '</ol><ol class="list-decimal list-inside space-y-2 mt-4">';
                            } else {
                                html += `<li class="text-sm text-gray-700">${step}</li>`;
                            }
                        });
                        html += '</ol>';

                        container.innerHTML = html;
                    })
                    .catch(error => {
                        console.error('Error loading installation instructions:', error);
                    });
            }

            // Load download info
            function loadDownloadInfo() {
                fetch('{{ route('admin.indonesian-tts.download') }}')
                    .then(response => response.json())
                    .then(data => {
                        const container = document.getElementById('download-info');
                        const info = data.download_info;

                        let html = `
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4">
                        <h3 class="text-lg font-semibold text-blue-900 mb-2">${info.title}</h3>
                        <p class="text-blue-700">${info.description}</p>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                `;

                        Object.entries(info.files).forEach(([filename, url]) => {
                            html += `
                        <div class="bg-gray-50 rounded-lg p-4">
                            <h4 class="font-semibold text-gray-900 mb-2">${filename}</h4>
                            <a href="${url}" target="_blank" 
                               class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Download
                            </a>
                        </div>
                    `;
                        });

                        html += '</div>';

                        html += '<div class="bg-gray-50 rounded-lg p-4">';
                        html += '<h4 class="font-semibold text-gray-900 mb-2">Langkah Manual:</h4>';
                        html += '<ol class="list-decimal list-inside space-y-1 text-sm text-gray-700">';
                        info.manual_steps.forEach(step => {
                            html += `<li>${step}</li>`;
                        });
                        html += '</ol></div>';

                        container.innerHTML = html;
                    })
                    .catch(error => {
                        console.error('Error loading download info:', error);
                    });
            }

            // Test TTS functionality
            document.getElementById('test-tts-btn').addEventListener('click', function() {
                const text = document.getElementById('test-text').value;
                const button = this;
                const resultDiv = document.getElementById('test-result');
                const resultText = document.getElementById('test-result-text');

                if (!text.trim()) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Text Kosong',
                        text: 'Masukkan text untuk test TTS'
                    });
                    return;
                }

                button.disabled = true;
                button.textContent = 'Testing...';

                fetch('{{ route('admin.indonesian-tts.test') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({
                            text: text
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        resultDiv.classList.remove('hidden');
                        if (data.success) {
                            resultText.textContent = `TTS berhasil dibuat! Type: ${data.tts_type}`;
                            resultText.className = 'text-sm text-green-600';

                            if (data.audio_url) {
                                resultText.innerHTML +=
                                    `<br><audio controls class="mt-2"><source src="${data.audio_url}" type="audio/wav">Your browser does not support the audio element.</audio>`;
                            }
                        } else {
                            resultText.textContent = `TTS gagal: ${data.message}`;
                            resultText.className = 'text-sm text-red-600';
                        }
                    })
                    .catch(error => {
                        resultDiv.classList.remove('hidden');
                        resultText.textContent = `Error: ${error.message}`;
                        resultText.className = 'text-sm text-red-600';
                    })
                    .finally(() => {
                        button.disabled = false;
                        button.textContent = 'Test TTS';
                    });
            });

            function confirmLogout() {
                Swal.fire({
                    title: 'Konfirmasi Logout',
                    text: 'Apakah Anda yakin ingin keluar dari sistem?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Logout',
                    cancelButtonText: 'Batal',
                    confirmButtonColor: '#EF4444',
                    cancelButtonColor: '#6B7280'
                }).then((result) => {
                    if (result.isConfirmed) {
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = '{{ route('logout') }}';

                        const csrfToken = document.createElement('input');
                        csrfToken.type = 'hidden';
                        csrfToken.name = '_token';
                        csrfToken.value = '{{ csrf_token() }}';

                        form.appendChild(csrfToken);
                        document.body.appendChild(form);
                        form.submit();
                    }
                });
            }
        </script>
    @endpush
@endsection
