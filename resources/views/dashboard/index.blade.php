@extends('layouts.app')

@section('title', 'Dashboard - Sistem Antrian Puskesmas')

@section('content')
    <div class="min-h-screen bg-gray-50">
        <!-- Navigation -->
        <nav class="bg-white shadow-lg sticky top-0 z-40">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <h1 class="text-xl md:text-2xl font-bold text-primary">🏥 Puskesmas</h1>
                        </div>
                    </div>
                    <div class="hidden md:flex items-center space-x-4">
                        <a href="{{ route('display') }}"
                            class="text-gray-700 hover:text-primary px-3 py-2 rounded-md text-sm font-medium transition duration-200">Display</a>
                        <span class="text-gray-700">Selamat datang, {{ auth()->user()->nama ?? 'User' }}</span>
                        <button onclick="confirmLogout()"
                            class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md text-sm font-medium transition duration-200">
                            Logout
                        </button>
                    </div>
                    <!-- Mobile menu button -->
                    <div class="md:hidden flex items-center">
                        <button id="mobile-menu-button" class="text-gray-700 hover:text-primary">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                <!-- Mobile menu -->
                <div id="mobile-menu" class="hidden md:hidden">
                    <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3 bg-white border-t">
                        <a href="{{ route('display') }}"
                            class="text-gray-700 hover:text-primary block px-3 py-2 rounded-md text-base font-medium transition duration-200">Display</a>
                        <span class="text-gray-700 block px-3 py-2 text-base">Selamat datang,
                            {{ auth()->user()->nama ?? 'User' }}</span>
                        <button onclick="confirmLogout()"
                            class="bg-red-500 hover:bg-red-600 text-white block w-full text-left px-3 py-2 rounded-md text-base font-medium transition duration-200">
                            Logout
                        </button>
                    </div>
                </div>
            </div>
        </nav>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 md:py-8">
            <!-- Header -->
            <div class="mb-8 animate-fade-in">
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">Dashboard</h1>
                <p class="text-gray-600 text-lg">Kelola sistem antrian Puskesmas</p>
            </div>

            <!-- User Info Card -->
            <div class="bg-white rounded-2xl shadow-xl p-6 mb-8 animate-slide-up">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h2 class="text-xl font-bold text-gray-900">Data Diri</h2>
                        <p class="text-gray-600">Informasi pribadi Anda</p>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="p-3 rounded-full bg-green-100 text-green-600">
                            <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <button onclick="openEditModal()"
                            class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition duration-200 flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                </path>
                            </svg>
                            Edit Data
                        </button>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                        <div class="px-4 py-3 bg-gray-50 rounded-xl text-gray-900 font-medium">
                            {{ auth()->user()->nama ?? 'N/A' }}
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nomor HP</label>
                        <div class="px-4 py-3 bg-gray-50 rounded-xl text-gray-900 font-medium">
                            {{ auth()->user()->no_hp ?? 'N/A' }}
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nomor KTP</label>
                        <div class="px-4 py-3 bg-gray-50 rounded-xl text-gray-900 font-medium">
                            {{ auth()->user()->no_ktp ?? 'N/A' }}
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Kelamin</label>
                        <div class="px-4 py-3 bg-gray-50 rounded-xl text-gray-900 font-medium">
                            {{ auth()->user()->jenis_kelamin == 'laki-laki' ? 'Laki-laki' : 'Perempuan' }}
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Alamat</label>
                        <div class="px-4 py-3 bg-gray-50 rounded-xl text-gray-900 font-medium">
                            {{ auth()->user()->alamat ?? 'N/A' }}
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Pekerjaan</label>
                        <div class="px-4 py-3 bg-gray-50 rounded-xl text-gray-900 font-medium">
                            {{ auth()->user()->pekerjaan ?? 'N/A' }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Add Queue Form -->
            <div class="bg-white rounded-2xl shadow-xl p-6 mb-8 animate-slide-up" style="animation-delay: 0.1s;">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h2 class="text-xl font-bold text-gray-900">Ambil Antrian</h2>
                        <p class="text-gray-600">Pilih poli untuk mengambil antrian baru</p>
                    </div>
                    <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                        <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                    </div>
                </div>

                <form id="addQueueForm" class="space-y-6">
                    @csrf
                    <div class="max-w-md">
                        <div>
                            <label for="poli_id" class="block text-sm font-medium text-gray-700 mb-2">Pilih Poli</label>
                            <select name="poli_id" id="poli_id" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                                <option value="">Pilih poli yang dituju</option>
                                <option value="1">Poli Umum</option>
                                <option value="2">Poli Gigi</option>
                                <option value="3">Poli Jiwa</option>
                                <option value="4">Poli Tradisional</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" id="submitBtn"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-xl font-semibold transition duration-200 transform hover:scale-105 shadow-lg">
                            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Ambil Antrian
                        </button>
                    </div>
                </form>
            </div>

            <!-- Recent Queue Table -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden animate-slide-up" style="animation-delay: 0.2s;">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Antrian Saya</h3>
                </div>

                <!-- Desktop Table -->
                <div class="hidden lg:block overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    No. Antrian</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Nama</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Poli</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Waktu</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($antrianSaya ?? [] as $antrian)
                                <tr class="hover:bg-gray-50 transition duration-200">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="text-lg font-semibold text-primary">{{ $antrian->no_antrian ?? 'N/A' }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $antrian->user->nama ?? 'N/A' }}
                                        </div>
                                        <div class="text-sm text-gray-500">{{ $antrian->user->no_hp ?? 'N/A' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                            {{ $antrian->poli->nama_poli ?? 'N/A' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if (($antrian->status ?? '') == 'menunggu')
                                            <span
                                                class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                Menunggu
                                            </span>
                                        @elseif(($antrian->status ?? '') == 'dipanggil')
                                            <span
                                                class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                                Dipanggil
                                            </span>
                                        @elseif(($antrian->status ?? '') == 'selesai')
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
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $antrian->created_at ? $antrian->created_at->format('H:i') : 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-2">
                                            @if ($antrian->status == 'menunggu')
                                                <button onclick="batalAntrian({{ $antrian->id }})"
                                                    class="text-red-600 hover:text-red-900 text-xs">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                    </svg>
                                                    Batal
                                                </button>
                                            @endif
                                            @if ($antrian->status == 'menunggu')
                                                <a href="{{ route('user.antrian.cetak', $antrian->id) }}" target="_blank"
                                                    class="text-blue-600 hover:text-blue-900 text-xs">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z">
                                                        </path>
                                                    </svg>
                                                    Cetak
                                                </a>
                                            @else
                                                <span class="text-gray-400 text-xs cursor-not-allowed"
                                                    title="Tidak dapat dicetak untuk status {{ ucfirst($antrian->status) }}">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z">
                                                        </path>
                                                    </svg>
                                                    Cetak
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                        <svg class="w-12 h-12 mx-auto mb-4 text-gray-400" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                            </path>
                                        </svg>
                                        <p class="text-lg font-medium">Belum ada antrian</p>
                                        <p class="text-sm text-gray-400">Silakan ambil antrian baru di atas</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Mobile Table -->
                <div class="lg:hidden">
                    @forelse($antrianSaya ?? [] as $antrian)
                        <div class="border-b border-gray-200 p-4 hover:bg-gray-50">
                            <!-- 4 Kolom Penting untuk Mobile -->
                            <div class="grid grid-cols-2 gap-4 mb-3">
                                <div>
                                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">No. Antrian</p>
                                    <span
                                        class="text-lg font-semibold text-primary">{{ $antrian->no_antrian ?? 'N/A' }}</span>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</p>
                                    <div class="text-sm font-medium text-gray-900">{{ $antrian->user->nama ?? 'N/A' }}
                                    </div>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Poli</p>
                                    <span
                                        class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                        {{ $antrian->poli->nama_poli ?? 'N/A' }}
                                    </span>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Status</p>
                                    @if (($antrian->status ?? '') == 'menunggu')
                                        <span
                                            class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            Menunggu
                                        </span>
                                    @elseif(($antrian->status ?? '') == 'dipanggil')
                                        <span
                                            class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                            Dipanggil
                                        </span>
                                    @elseif(($antrian->status ?? '') == 'selesai')
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
                                </div>
                            </div>

                            <!-- Button Selengkapnya untuk Mobile -->
                            <div class="border-t border-gray-100 pt-3">
                                <button onclick="toggleUserDashboardDetails({{ $antrian->id }})"
                                    class="text-blue-600 hover:text-blue-800 text-sm font-medium flex items-center">
                                    <span id="user-dashboard-btn-text-{{ $antrian->id }}">Selengkapnya</span>
                                    <svg id="user-dashboard-icon-{{ $antrian->id }}"
                                        class="w-4 h-4 ml-1 transform transition-transform" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>

                                <!-- Detail Tambahan (Hidden by default) -->
                                <div id="user-dashboard-details-{{ $antrian->id }}" class="hidden mt-3 space-y-2">
                                    <div class="grid grid-cols-1 gap-2 text-sm">
                                        <div>
                                            <span class="font-medium text-gray-700">No. HP:</span>
                                            <span class="text-gray-600">{{ $antrian->user->no_hp ?? 'N/A' }}</span>
                                        </div>
                                        <div>
                                            <span class="font-medium text-gray-700">Waktu Daftar:</span>
                                            <span
                                                class="text-gray-600">{{ $antrian->created_at ? $antrian->created_at->format('H:i') : 'N/A' }}</span>
                                        </div>
                                        <div class="flex space-x-2 pt-2">
                                            @if ($antrian->status == 'menunggu')
                                                <button onclick="batalAntrian({{ $antrian->id }})"
                                                    class="text-red-600 hover:text-red-900 text-sm font-medium">
                                                    Batal
                                                </button>
                                            @endif
                                            @if ($antrian->status == 'menunggu')
                                                <a href="{{ route('user.antrian.cetak', $antrian->id) }}" target="_blank"
                                                    class="text-blue-600 hover:text-blue-900 text-sm font-medium">
                                                    Cetak
                                                </a>
                                            @else
                                                <span class="text-gray-400 text-sm cursor-not-allowed"
                                                    title="Tidak dapat dicetak untuk status {{ ucfirst($antrian->status) }}">
                                                    Cetak
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="p-8 text-center text-gray-500">
                            <svg class="w-12 h-12 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                </path>
                            </svg>
                            <p class="text-lg font-medium">Belum ada antrian</p>
                            <p class="text-sm text-gray-400">Silakan ambil antrian baru di atas</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Profile Modal -->
    <div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl max-h-screen overflow-y-auto">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl font-bold text-gray-900">Edit Data Diri</h3>
                        <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <form id="editForm" action="{{ route('dashboard.update-profile') }}" method="POST"
                        class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="edit_nama" class="block text-sm font-medium text-gray-700 mb-2">Nama
                                    Lengkap</label>
                                <input type="text" name="nama" id="edit_nama" value="{{ auth()->user()->nama }}"
                                    required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                            </div>

                            <div>
                                <label for="edit_no_hp" class="block text-sm font-medium text-gray-700 mb-2">Nomor
                                    HP</label>
                                <input type="tel" name="no_hp" id="edit_no_hp"
                                    value="{{ auth()->user()->no_hp }}" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                            </div>

                            <div>
                                <label for="edit_no_ktp" class="block text-sm font-medium text-gray-700 mb-2">Nomor
                                    KTP</label>
                                <input type="text" name="no_ktp" id="edit_no_ktp"
                                    value="{{ auth()->user()->no_ktp }}" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                            </div>

                            <div>
                                <label for="edit_jenis_kelamin" class="block text-sm font-medium text-gray-700 mb-2">Jenis
                                    Kelamin</label>
                                <select name="jenis_kelamin" id="edit_jenis_kelamin" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                                    <option value="laki-laki"
                                        {{ auth()->user()->jenis_kelamin == 'laki-laki' ? 'selected' : '' }}>
                                        Laki-laki</option>
                                    <option value="perempuan"
                                        {{ auth()->user()->jenis_kelamin == 'perempuan' ? 'selected' : '' }}>
                                        Perempuan</option>
                                </select>
                            </div>

                            <div class="md:col-span-2">
                                <label for="edit_alamat"
                                    class="block text-sm font-medium text-gray-700 mb-2">Alamat</label>
                                <textarea name="alamat" id="edit_alamat" rows="3" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">{{ auth()->user()->alamat }}</textarea>
                            </div>

                            <div class="md:col-span-2">
                                <label for="edit_pekerjaan"
                                    class="block text-sm font-medium text-gray-700 mb-2">Pekerjaan</label>
                                <input type="text" name="pekerjaan" id="edit_pekerjaan"
                                    value="{{ auth()->user()->pekerjaan }}" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                            </div>
                        </div>

                        <div class="flex justify-end space-x-3 pt-6">
                            <button type="button" onclick="closeEditModal()"
                                class="px-6 py-3 border border-gray-300 rounded-xl text-gray-700 font-medium hover:bg-gray-50 transition duration-200">
                                Batal
                            </button>
                            <button type="submit"
                                class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-medium transition duration-200">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // Mobile menu toggle
            document.getElementById('mobile-menu-button').addEventListener('click', function() {
                const mobileMenu = document.getElementById('mobile-menu');
                mobileMenu.classList.toggle('hidden');
            });

            // Modal functions
            function openEditModal() {
                document.getElementById('editModal').classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            }

            function closeEditModal() {
                document.getElementById('editModal').classList.add('hidden');
                document.body.style.overflow = 'auto';
            }

            // Close modal when clicking outside
            document.getElementById('editModal').addEventListener('click', function(e) {
                if (e.target === this) {
                    closeEditModal();
                }
            });

            // Form submission
            document.getElementById('editForm').addEventListener('submit', function(e) {
                e.preventDefault();

                const formData = new FormData(this);

                fetch(this.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: data.message,
                                confirmButtonText: 'OK'
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: data.message,
                                confirmButtonText: 'OK'
                            });
                        }
                    })
                    .catch(error => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Terjadi kesalahan saat menyimpan data',
                            confirmButtonText: 'OK'
                        });
                    });
            });

            // Show SweetAlert2 for success messages
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{{ session('success') }}',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#10B981',
                    timer: 3000,
                    timerProgressBar: true
                });
            @endif

            // Show SweetAlert2 for error messages
            @if (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: '{{ session('error') }}',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#EF4444',
                    timer: 4000,
                    timerProgressBar: true
                });
            @endif

            // Handle form submission for adding queue
            document.getElementById('addQueueForm').addEventListener('submit', function(e) {
                e.preventDefault();

                const submitBtn = document.getElementById('submitBtn');
                const originalText = submitBtn.innerHTML;

                // Disable button and show loading
                submitBtn.disabled = true;
                submitBtn.innerHTML = `
                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Memproses...
                `;

                const formData = new FormData(this);
                formData.append('_token', '{{ csrf_token() }}');

                fetch('{{ route('dashboard.add-queue') }}', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Success case
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: data.message,
                                confirmButtonText: 'OK',
                                confirmButtonColor: '#10B981',
                                timer: 3000, // Auto close after 3 seconds
                                timerProgressBar: true,
                                showConfirmButton: false
                            }).then(() => {
                                // After success alert closes, show reminder alert
                                Swal.fire({
                                    icon: 'info',
                                    title: 'Pengingat Penting!',
                                    html: `
                                    <div class="text-center">
                                        <div class="mb-4">
                                            <svg class="w-16 h-16 text-blue-500 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                        <p class="text-lg font-semibold text-gray-800 mb-3">
                                            Harap Hadir 30 Menit Sebelum Nomor Dipanggil!
                                        </p>
                                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4">
                                            <div class="flex items-center justify-center mb-2">
                                                <svg class="w-5 h-5 text-blue-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                                </svg>
                                                <span class="font-medium text-blue-800">Tips:</span>
                                            </div>
                                            <ul class="text-sm text-blue-700 text-left space-y-1">
                                                <li>• Pastikan membawa dokumen yang diperlukan</li>
                                                <li>• Ikuti protokol kesehatan yang berlaku</li>
                                                <li>• Tunggu di area yang ditentukan</li>
                                            </ul>
                                        </div>
                                        <p class="text-sm text-gray-600">
                                            Terima kasih telah menggunakan layanan kami!
                                        </p>
                                    </div>
                                `,
                                    confirmButtonText: 'Saya Mengerti',
                                    confirmButtonColor: '#3B82F6',
                                    allowOutsideClick: false,
                                    allowEscapeKey: false
                                }).then(() => {
                                    location.reload();
                                });
                            });
                        } else {
                            // Handle different error types
                            if (data.type === 'existing_queue') {
                                // User already has queue in same poli
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Antrian Sudah Ada!',
                                    html: `
                                    <div class="text-left">
                                        <p class="mb-3">${data.message}</p>
                                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3 mb-3">
                                            <div class="flex items-center">
                                                <svg class="w-5 h-5 text-yellow-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                                </svg>
                                                <span class="font-medium text-yellow-800">Detail Antrian:</span>
                                            </div>
                                            <div class="mt-2 text-sm text-yellow-700">
                                                <p><strong>No. Antrian:</strong> ${data.existing_queue.no_antrian}</p>
                                                <p><strong>Poli:</strong> ${data.existing_queue.poli_name}</p>
                                                <p><strong>Status:</strong> ${data.existing_queue.status === 'menunggu' ? 'Menunggu' : 'Dipanggil'}</p>
                                                <p><strong>Waktu Ambil:</strong> ${data.existing_queue.created_at}</p>
                                            </div>
                                        </div>
                                        <p class="text-sm text-gray-600">Silakan tunggu hingga antrian Anda dipanggil atau batalkan antrian ini terlebih dahulu.</p>
                                    </div>
                                `,
                                    confirmButtonText: 'OK',
                                    confirmButtonColor: '#F59E0B'
                                });
                            } else {
                                // Generic error
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error!',
                                    text: data.message,
                                    confirmButtonText: 'OK',
                                    confirmButtonColor: '#EF4444'
                                });
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Terjadi kesalahan saat mengambil antrian. Silakan coba lagi.',
                            confirmButtonText: 'OK',
                            confirmButtonColor: '#EF4444'
                        });
                    })
                    .finally(() => {
                        // Re-enable button and restore original text
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = originalText;
                    });
            });

            // Function to confirm logout
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

            // Function to cancel queue
            function batalAntrian(antrianId) {
                Swal.fire({
                    title: 'Konfirmasi Pembatalan',
                    text: 'Apakah Anda yakin ingin membatalkan antrian ini?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Batalkan',
                    cancelButtonText: 'Tidak',
                    confirmButtonColor: '#EF4444',
                    cancelButtonColor: '#6B7280'
                }).then((result) => {
                    if (result.isConfirmed) {
                        const formData = new FormData();
                        formData.append('antrian_id', antrianId);
                        formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);

                        fetch('/user/antrian/batal', {
                                method: 'POST',
                                body: formData
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Berhasil!',
                                        text: data.message,
                                        confirmButtonText: 'OK'
                                    }).then(() => {
                                        location.reload();
                                    });
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error!',
                                        text: data.message,
                                        confirmButtonText: 'OK'
                                    });
                                }
                            })
                            .catch(error => {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error!',
                                    text: 'Terjadi kesalahan saat membatalkan antrian',
                                    confirmButtonText: 'OK'
                                });
                            });
                    }
                });
            }

            // Function to toggle user dashboard details
            function toggleUserDashboardDetails(antrianId) {
                const detailsDiv = document.getElementById(`user-dashboard-details-${antrianId}`);
                const buttonText = document.getElementById(`user-dashboard-btn-text-${antrianId}`);
                const icon = document.getElementById(`user-dashboard-icon-${antrianId}`);

                if (detailsDiv.classList.contains('hidden')) {
                    detailsDiv.classList.remove('hidden');
                    buttonText.textContent = 'Lebih Sedikit';
                    icon.classList.remove('transform', 'rotate-180');
                } else {
                    detailsDiv.classList.add('hidden');
                    buttonText.textContent = 'Selengkapnya';
                    icon.classList.add('transform', 'rotate-180');
                }
            }
        </script>
    @endpush
@endsection
