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
                        <h1 class="text-xl md:text-2xl font-bold text-primary">�� Admin Puskesmas</h1>
                    </div>
                </div>
                <div class="hidden md:flex items-center space-x-4">
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
                        <div class="flex items-center px-4 py-2 text-sm font-semibold text-gray-500 uppercase tracking-wider">
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
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                </path>
                            </svg>
                            <span class="font-medium">Laporan</span>
                        </a>
                    </div>

                    <!-- Audio -->
                    <div>
                        <a href="{{ route('admin.audio.index') }}"
                            class="flex items-center px-4 py-3 rounded-xl {{ request()->routeIs('admin.audio.*') ? 'bg-blue-50 text-blue-700 border border-blue-200' : 'text-gray-700 hover:bg-gray-50' }} transition duration-200">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z">
                                </path>
                            </svg>
                            <span class="font-medium">Audio</span>
                        </a>
                    </div>
                </div>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1">
            <!-- Sidebar Overlay -->
            <div id="sidebar-overlay"
                class="fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden hidden"></div>

            <!-- Content -->
            <div class="p-6">
                <div class="max-w-7xl mx-auto">
                    <!-- Header -->
                    <div class="mb-8">
                        <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $title }}</h1>
                        <p class="text-gray-600 text-lg">Kelola antrian untuk {{ $title }}</p>
                    </div>

                    <!-- Table -->
                    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                        <!-- Desktop Table -->
                        <div class="hidden lg:block overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            No Antrian</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Nama</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Detail</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
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
                                            <td class="px-6 py-4 text-gray-700">
                                                <div class="space-y-1">
                                                    <div class="flex items-start space-x-2">
                                                        <svg class="w-4 h-4 text-gray-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                        </svg>
                                                        <span class="text-sm">{{ Str::limit($antrian->user?->alamat, 30) }}</span>
                                                    </div>
                                                    <div class="flex items-center space-x-2">
                                                        <svg class="w-4 h-4 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                        </svg>
                                                        <span class="text-sm">{{ $antrian->user?->jenis_kelamin }}</span>
                                                    </div>
                                                    <div class="flex items-center space-x-2">
                                                        <svg class="w-4 h-4 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                                        </svg>
                                                        <span class="text-sm">{{ $antrian->user?->no_hp }}</span>
                                                    </div>
                                                    <div class="flex items-center space-x-2">
                                                        <svg class="w-4 h-4 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V4a2 2 0 114 0v2m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path>
                                                        </svg>
                                                        <span class="text-sm">{{ $antrian->user?->no_ktp }}</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if ($antrian->status == 'menunggu')
                                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                        Menunggu
                                                    </span>
                                                @elseif($antrian->status == 'dipanggil')
                                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                                        Dipanggil
                                                    </span>
                                                @elseif($antrian->status == 'selesai')
                                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                                        Selesai
                                                    </span>
                                                @else
                                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
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
                                            <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                                <svg class="w-12 h-12 mx-auto mb-4 text-gray-400" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                                    </path>
                                                </svg>
                                                <p class="text-lg font-medium">Tidak ada antrian</p>
                                                <p class="text-sm text-gray-400">Belum ada antrian yang terdaftar</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Mobile Table -->
                        <div class="lg:hidden">
                            @forelse($antrians as $antrian)
                                <div class="border-b border-gray-200 p-4 hover:bg-gray-50">
                                    <!-- 4 Kolom Penting untuk Mobile -->
                                    <div class="grid grid-cols-2 gap-4 mb-3">
                                        <div>
                                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">No Antrian</p>
                                            <p class="text-sm font-semibold text-gray-900">{{ $antrian->no_antrian }}</p>
                                        </div>
                                        <div>
                                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</p>
                                            <p class="text-sm text-gray-900">{{ $antrian->user?->nama }}</p>
                                        </div>
                                        <div>
                                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Status</p>
                                            @if ($antrian->status == 'menunggu')
                                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                    Menunggu
                                                </span>
                                            @elseif($antrian->status == 'dipanggil')
                                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                                    Dipanggil
                                                </span>
                                            @elseif($antrian->status == 'selesai')
                                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                                    Selesai
                                                </span>
                                            @else
                                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                                    Batal
                                                </span>
                                            @endif
                                        </div>
                                        <div>
                                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</p>
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
                                        </div>
                                    </div>

                                    <!-- Button Selengkapnya untuk Mobile -->
                                    <div class="border-t border-gray-100 pt-3">
                                        <button onclick="toggleDetails({{ $antrian->id }})"
                                            class="text-blue-600 hover:text-blue-800 text-sm font-medium flex items-center">
                                            <span id="btn-text-{{ $antrian->id }}">Selengkapnya</span>
                                            <svg id="icon-{{ $antrian->id }}"
                                                class="w-4 h-4 ml-1 transform transition-transform" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        </button>

                                        <!-- Detail Tambahan (Hidden by default) -->
                                        <div id="details-{{ $antrian->id }}" class="hidden mt-3 space-y-2">
                                            <div class="grid grid-cols-1 gap-2 text-sm">
                                                <div>
                                                    <span class="font-medium text-gray-700">Alamat:</span>
                                                    <span class="text-gray-600">{{ $antrian->user?->alamat }}</span>
                                                </div>
                                                <div>
                                                    <span class="font-medium text-gray-700">Jenis Kelamin:</span>
                                                    <span class="text-gray-600">{{ $antrian->user?->jenis_kelamin }}</span>
                                                </div>
                                                <div>
                                                    <span class="font-medium text-gray-700">Nomor HP:</span>
                                                    <span class="text-gray-600">{{ $antrian->user?->no_hp }}</span>
                                                </div>
                                                <div>
                                                    <span class="font-medium text-gray-700">Nomor KTP:</span>
                                                    <span class="text-gray-600">{{ $antrian->user?->no_ktp }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-8 text-gray-500">
                                    <svg class="w-12 h-12 mx-auto mb-4 text-gray-400" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                        </path>
                                    </svg>
                                    <p class="text-lg font-medium">Tidak ada antrian</p>
                                    <p class="text-sm text-gray-400">Belum ada antrian yang terdaftar</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Sidebar functionality
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

    function toggleDetails(antrianId) {
        const details = document.getElementById(`details-${antrianId}`);
        const buttonText = document.getElementById(`btn-text-${antrianId}`);
        const icon = document.getElementById(`icon-${antrianId}`);

        if (details.classList.contains('hidden')) {
            details.classList.remove('hidden');
            buttonText.textContent = 'Kurangi';
            icon.classList.remove('transform', 'rotate-180');
        } else {
            details.classList.add('hidden');
            buttonText.textContent = 'Selengkapnya';
            icon.classList.add('transform', 'rotate-180');
        }
    }

    function panggil(url) {
        // Ambil nama poli dari URL atau data yang tersedia
        const poliName = getPoliNameFromUrl();
        
        // Tampilkan loading terlebih dahulu
        Swal.fire({
            title: 'Memeriksa status antrian...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
        
        // Cek status antrian sebelumnya terlebih dahulu
        fetch('{{ route("admin.cek-status-antrian-sebelumnya") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                poli_name: poliName
            })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            // Tutup loading
            Swal.close();
            
            if (data.success && data.ada_antrian_sebelumnya) {
                // Ada antrian sebelumnya yang masih dipanggil, tampilkan konfirmasi
                Swal.fire({
                    title: '⚠️ Antrian Sebelumnya Belum Selesai',
                    html: `
                        <div class="text-left">
                            <p class="mb-3">Antrian <strong>${data.antrian.no_antrian}</strong> (${data.antrian.user_name}) masih dalam status <strong>Dipanggil</strong>.</p>
                            <p class="mb-4">Silakan selesaikan atau batalkan antrian sebelumnya terlebih dahulu.</p>
                            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3">
                                <p class="text-sm text-yellow-800">
                                    <strong>Info:</strong> Antrian dipanggil pada ${formatWaktu(data.antrian.waktu_panggil)}
                                </p>
                            </div>
                        </div>
                    `,
                    icon: 'warning',
                    showCancelButton: true,
                    showDenyButton: true,
                    confirmButtonText: 'Selesaikan',
                    denyButtonText: 'Batalkan',
                    cancelButtonText: 'Kembali',
                    confirmButtonColor: '#10B981',
                    denyButtonColor: '#EF4444',
                    cancelButtonColor: '#6B7280',
                    reverseButtons: true,
                    width: '500px'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Admin memilih "Selesai" - panggil fungsi selesai
                        selesai('{{ route("admin.selesai-antrian") }}', data.antrian.id);
                    } else if (result.isDenied) {
                        // Admin memilih "Batal" - panggil fungsi batal
                        batal('{{ route("admin.batal-antrian") }}', data.antrian.id);
                    }
                    // Jika result.isDismissed (Kembali), tidak ada aksi yang dilakukan
                });
            } else {
                // Tidak ada antrian sebelumnya, langsung panggil antrian berikutnya
                konfirmasiPanggilAntrian(url);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            // Tutup loading dan tampilkan error
            Swal.close();
            
            // Jika terjadi error, tampilkan pesan error yang informatif
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Terjadi kesalahan saat memeriksa status antrian. Silakan coba lagi.',
                confirmButtonText: 'OK'
            }).then(() => {
                // Setelah user klik OK, coba panggil antrian berikutnya
                konfirmasiPanggilAntrian(url);
            });
        });
    }

    function konfirmasiPanggilAntrian(url) {
        Swal.fire({
            title: 'Panggil Antrian?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Batal'
        }).then((res) => {
            if (!res.isConfirmed) return;
            
            // Tampilkan loading saat memanggil antrian
            Swal.fire({
                title: 'Memanggil antrian...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            
            fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => {
                console.log('Response status:', response.status);
                console.log('Response headers:', response.headers);
                
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(d => {
                console.log('Response data:', d);
                
                // Tutup loading
                Swal.close();
                
                if (d.success) {
                    // Show success alert with sound
                    Swal.fire({
                        icon: 'success',
                        title: 'Antrian Dipanggil!',
                        text: `Antrian selanjutnya poli ${d.poli_name} nomor ${d.queue_number}`,
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#10B981',
                        timer: 3000,
                        timerProgressBar: true,
                        showClass: {
                            popup: 'animate__animated animate__fadeInDown'
                        },
                        hideClass: {
                            popup: 'animate__animated animate__fadeOutUp'
                        }
                    });

                    // Reload page after delay
                    setTimeout(() => {
                        location.reload();
                    }, 2000);
                } else {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Gagal',
                        text: d.message || 'Terjadi kesalahan saat memanggil antrian'
                    });
                }
            })
            .catch(error => {
                console.error('Error dalam panggil antrian:', error);
                console.error('Error details:', {
                    name: error.name,
                    message: error.message,
                    stack: error.stack
                });
                
                // Tutup loading
                Swal.close();
                
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Terjadi kesalahan saat memanggil antrian. Silakan coba lagi.',
                    footer: 'Detail error: ' + error.message
                });
            });
        });
    }

    // Fungsi helper untuk mendapatkan nama poli dari URL
    function getPoliNameFromUrl() {
        const currentUrl = window.location.href;
        if (currentUrl.includes('umum')) return 'umum';
        if (currentUrl.includes('gigi')) return 'gigi';
        if (currentUrl.includes('jiwa')) return 'kesehatan jiwa';
        if (currentUrl.includes('tradisional')) return 'kesehatan tradisional';
        return 'umum'; // fallback
    }

    // Fungsi helper untuk format waktu
    function formatWaktu(waktuString) {
        if (!waktuString) return '-';
        
        try {
            const waktu = new Date(waktuString);
            
            // Cek apakah tanggal valid
            if (isNaN(waktu.getTime())) {
                return '-';
            }
            
            return waktu.toLocaleTimeString('id-ID', {
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            });
        } catch (error) {
            console.error('Error formatting waktu:', error);
            return '-';
        }
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
                        .then(() => {
                            if (d.success) {
                                location.reload();
                            }
                        });
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
                        .then(() => {
                            if (d.success) {
                                location.reload();
                            }
                        });
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