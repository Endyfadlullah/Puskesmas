@extends('layouts.app')

@section('title', 'Dashboard Admin - Puskesmas')

@section('content')
<div class="min-h-screen bg-gray-50">
    @include('admin.partials.top-nav')

    <div class="flex">
        @include('admin.partials.sidebar')

        <!-- Main Content -->
        <div class="flex-1 lg:ml-64">
            <div class="px-4 sm:px-6 lg:px-8 py-6 md:py-8">
                <!-- Header -->
                <div class="mb-8">
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">Dashboard</h1>
                    <p class="text-lg text-gray-600">Selamat datang di Dashboard Admin Puskesmas</p>
                </div>

                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <!-- Poli Umum Card -->
                    <div class="bg-white p-6 rounded-2xl shadow-xl border border-gray-200 hover:shadow-2xl transition duration-300 transform hover:-translate-y-2">
                        <div class="flex items-center justify-between mb-4">
                            <div class="text-3xl text-blue-500">👨‍⚕️</div>
                            <div class="text-right">
                                <div class="text-2xl font-bold text-gray-900">{{ $poliUmumCount ?? 0 }}</div>
                                <div class="text-sm text-gray-600">Antrian menunggu</div>
                            </div>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Poli Umum</h3>
                        <a href="{{ route('admin.poli.umum') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                            Lihat Antrian →
                        </a>
                    </div>

                    <!-- Poli Gigi Card -->
                    <div class="bg-white p-6 rounded-2xl shadow-xl border border-gray-200 hover:shadow-2xl transition duration-300 transform hover:-translate-y-2">
                        <div class="flex items-center justify-between mb-4">
                            <div class="text-3xl text-green-500">🦷</div>
                            <div class="text-right">
                                <div class="text-2xl font-bold text-gray-900">{{ $poliGigiCount ?? 0 }}</div>
                                <div class="text-sm text-gray-600">Antrian menunggu</div>
                            </div>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Poli Gigi</h3>
                        <a href="{{ route('admin.poli.gigi') }}" class="text-green-600 hover:text-green-800 text-sm font-medium">
                            Lihat Antrian →
                        </a>
                    </div>

                    <!-- Poli Jiwa Card -->
                    <div class="bg-white p-6 rounded-2xl shadow-xl border border-gray-200 hover:shadow-2xl transition duration-300 transform hover:-translate-y-2">
                        <div class="flex items-center justify-between mb-4">
                            <div class="text-3xl text-purple-500">🧠</div>
                            <div class="text-right">
                                <div class="text-2xl font-bold text-gray-900">{{ $poliJiwaCount ?? 0 }}</div>
                                <div class="text-sm text-gray-600">Antrian menunggu</div>
                            </div>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Poli Jiwa</h3>
                        <a href="{{ route('admin.poli.jiwa') }}" class="text-purple-600 hover:text-purple-800 text-sm font-medium">
                            Lihat Antrian →
                        </a>
                    </div>

                    <!-- Poli Tradisional Card -->
                    <div class="bg-white p-6 rounded-2xl shadow-xl border border-gray-200 hover:shadow-2xl transition duration-300 transform hover:-translate-y-2">
                        <div class="flex items-center justify-between mb-4">
                            <div class="text-3xl text-yellow-500">🌿</div>
                            <div class="text-right">
                                <div class="text-2xl font-bold text-gray-900">{{ $poliTradisionalCount ?? 0 }}</div>
                                <div class="text-sm text-gray-600">Antrian menunggu</div>
                            </div>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Poli Tradisional</h3>
                        <a href="{{ route('admin.poli.tradisional') }}" class="text-yellow-600 hover:text-yellow-800 text-sm font-medium">
                            Lihat Antrian →
                        </a>
                    </div>
                </div>

                <!-- Action Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Display Antrian Card -->
                    <div class="bg-white p-6 rounded-2xl shadow-xl border border-gray-200 hover:shadow-2xl transition duration-300 transform hover:-translate-y-2">
                        <div class="flex items-center justify-between mb-4">
                            <div class="text-3xl text-green-500">📺</div>
                            <div class="text-right">
                                <div class="text-sm text-gray-600">Lihat display antrian</div>
                            </div>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Display Antrian</h3>
                        <p class="text-gray-600 mb-4">Lihat display antrian untuk pasien</p>
                        <a href="{{ route('display') }}" 
                           class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition duration-200">
                            Lihat Display →
                        </a>
                    </div>

                    <!-- Laporan Card -->
                    <div class="bg-white p-6 rounded-2xl shadow-xl border border-gray-200 hover:shadow-2xl transition duration-300 transform hover:-translate-y-2">
                        <div class="flex items-center justify-between mb-4">
                            <div class="text-3xl text-purple-500">📊</div>
                            <div class="text-right">
                                <div class="text-sm text-gray-600">Lihat laporan</div>
                            </div>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Laporan</h3>
                        <p class="text-gray-600 mb-4">Lihat laporan dan statistik antrian</p>
                        <a href="{{ route('admin.laporan.index') }}" 
                           class="inline-flex items-center px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition duration-200">
                            Lihat Laporan →
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Function untuk logout
    function confirmLogout() {
        if (confirm('Apakah Anda yakin ingin logout?')) {
            document.getElementById('logout-form').submit();
        }
    }
</script>
@endpush
@endsection
