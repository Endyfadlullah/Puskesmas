@extends('layouts.app')

@section('title', $title)

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
                        <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">{{ $title }}</h1>
                        <p class="text-gray-600 text-lg">Kelola antrian untuk {{ $title }}</p>
                    </div>

                    <!-- Table -->
                    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            No Antrian</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Nama</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Alamat</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Jenis Kelamin</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Nomor HP</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Nomor KTP</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Status</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse($antrians as $antrian)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap font-semibold text-gray-900">
                                                {{ $antrian->no_antrian }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-gray-900">
                                                {{ $antrian->user?->nama }}</td>
                                            <td class="px-6 py-4 text-gray-700">{{ $antrian->user?->alamat }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-gray-700">
                                                {{ $antrian->user?->jenis_kelamin }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-gray-700">
                                                {{ $antrian->user?->no_hp }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-gray-700">
                                                {{ $antrian->user?->no_ktp }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if ($antrian->status == 'menunggu')
                                                    <span
                                                        class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                        Menunggu
                                                    </span>
                                                @elseif($antrian->status == 'dipanggil')
                                                    <span
                                                        class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                                        Dipanggil
                                                    </span>
                                                @elseif($antrian->status == 'selesai')
                                                    <span
                                                        class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                                        Selesai
                                                    </span>
                                                @else
                                                    <span
                                                        class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                                        Batal
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if ($antrian->status == 'menunggu')
                                                    <button
                                                        onclick="panggil('{{ route('admin.panggil-antrian-id', $antrian) }}')"
                                                        class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-md text-xs font-medium transition duration-200">
                                                        Panggil
                                                    </button>
                                                @elseif($antrian->status == 'dipanggil')
                                                    <div class="flex space-x-2">
                                                        <button
                                                            onclick="selesai('{{ route('admin.selesai-antrian') }}', {{ $antrian->id }})"
                                                            class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded-md text-xs font-medium transition duration-200">
                                                            Selesai
                                                        </button>
                                                        <button
                                                            onclick="batal('{{ route('admin.batal-antrian') }}', {{ $antrian->id }})"
                                                            class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-md text-xs font-medium transition duration-200">
                                                            Batal
                                                        </button>
                                                    </div>
                                                @else
                                                    <span class="text-gray-400 text-xs">-</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="px-6 py-8 text-center text-gray-500">
                                                <svg class="w-12 h-12 mx-auto mb-4 text-gray-400" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                                    </path>
                                                </svg>
                                                <p class="text-lg font-medium">Belum ada antrian</p>
                                                <p class="text-sm text-gray-400">Antrian akan muncul di sini setelah ada
                                                    pendaftaran</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
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

            function panggil(url) {
                Swal.fire({
                    title: 'Panggil Antrian?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Ya',
                    cancelButtonText: 'Batal'
                }).then((res) => {
                    if (!res.isConfirmed) return;
                    fetch(url, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            }
                        })
                        .then(r => r.json())
                        .then(d => {
                            if (d.success) {
                                // Play TTS on display page
                                if (d.audio_sequence && d.poli_name && d.queue_number) {
                                    // Send message to display page if it's open
                                    if (window.opener && !window.opener.closed) {
                                        window.opener.postMessage({
                                            type: 'TTS_CALL',
                                            poliName: d.poli_name,
                                            queueNumber: d.queue_number,
                                            audioSequence: d.audio_sequence
                                        }, '*');
                                    }

                                    // Also try to play locally if display is not open
                                    playTTSLocally(d.poli_name, d.queue_number);
                                }

                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: d.message
                                }).then(() => location.reload());
                            } else {
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Gagal',
                                    text: d.message
                                });
                            }
                        })
                        .catch(() => Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Terjadi kesalahan'
                        }));
                });
            }

            // Function to play TTS locally (fallback)
            function playTTSLocally(poliName, queueNumber) {
                // Create audio sequence manually
                const attentionSound = '{{ asset('assets/music/call-to-attention-123107.mp3') }}';

                // Play attention sound first
                const audio1 = new Audio(attentionSound);
                audio1.play();

                // After attention sound, use browser TTS for poli and number
                setTimeout(() => {
                    const text = `Nomor antrian ${queueNumber}, silakan menuju ke ${poliName}`;
                    if ('speechSynthesis' in window) {
                        const utterance = new SpeechSynthesisUtterance(text);
                        utterance.lang = 'id-ID';
                        utterance.rate = 0.85; // Slightly faster for more natural flow
                        utterance.volume = 1.0;

                        // Try to select a female Indonesian voice if available
                        const voices = speechSynthesis.getVoices();
                        const indonesianVoice = voices.find(voice =>
                            voice.lang === 'id-ID' &&
                            voice.name.toLowerCase().includes('female')
                        ) || voices.find(voice => voice.lang === 'id-ID');

                        if (indonesianVoice) {
                            utterance.voice = indonesianVoice;
                        }

                        speechSynthesis.speak(utterance);
                    }

                    // Play final attention sound
                    setTimeout(() => {
                        const audio2 = new Audio(attentionSound);
                        audio2.play();
                    }, 3000);
                }, 2000);
            }

            function selesai(url, antrianId) {
                Swal.fire({
                    title: 'Selesai Antrian?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Ya',
                    cancelButtonText: 'Batal'
                }).then((res) => {
                    if (!res.isConfirmed) return;
                    fetch(url, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                antrian_id: antrianId
                            })
                        })
                        .then(r => r.json())
                        .then(d => {
                            Swal.fire({
                                    icon: d.success ? 'success' : 'warning',
                                    title: d.success ? 'Berhasil' : 'Gagal',
                                    text: d.message
                                })
                                .then(() => location.reload());
                        })
                        .catch(() => Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Terjadi kesalahan'
                        }));
                });
            }

            function batal(url, antrianId) {
                Swal.fire({
                    title: 'Batal Antrian?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya',
                    cancelButtonText: 'Tidak'
                }).then((res) => {
                    if (!res.isConfirmed) return;
                    fetch(url, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                antrian_id: antrianId
                            })
                        })
                        .then(r => r.json())
                        .then(d => {
                            Swal.fire({
                                    icon: d.success ? 'success' : 'warning',
                                    title: d.success ? 'Berhasil' : 'Gagal',
                                    text: d.message
                                })
                                .then(() => location.reload());
                        })
                        .catch(() => Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Terjadi kesalahan'
                        }));
                });
            }

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
