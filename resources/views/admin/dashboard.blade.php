@extends('layouts.app')

@section('title', 'Admin Dashboard - Sistem Antrian Puskesmas')

@section('content')
    <div class="min-h-screen bg-gray-50">
        @include('admin.partials.top-nav')

        <div class="flex">
            @include('admin.partials.sidebar')

            <!-- Main Content -->
            <div class="flex-1 lg:ml-0">
                <div class="px-4 sm:px-6 lg:px-8 py-6 md:py-8">
                    <!-- Header -->
                    <div class="mb-8 animate-fade-in">
                        <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">Admin Dashboard</h1>
                        <p class="text-gray-600 text-lg">Kelola sistem antrian Puskesmas</p>
                    </div>

                    <!-- Poli Summary -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                        <div class="bg-white rounded-2xl shadow-xl p-6">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm text-gray-500">Poli Umum</p>
                                    <p class="text-2xl font-bold text-gray-900">{{ $poliUmumCount ?? 0 }}</p>
                                    <p class="text-xs text-gray-400">Antrian menunggu</p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-2xl shadow-xl p-6">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-green-100 text-green-600">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm text-gray-500">Poli Gigi</p>
                                    <p class="text-2xl font-bold text-gray-900">{{ $poliGigiCount ?? 0 }}</p>
                                    <p class="text-xs text-gray-400">Antrian menunggu</p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-2xl shadow-xl p-6">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm text-gray-500">Poli Jiwa</p>
                                    <p class="text-2xl font-bold text-gray-900">{{ $poliJiwaCount ?? 0 }}</p>
                                    <p class="text-xs text-gray-400">Antrian menunggu</p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-2xl shadow-xl p-6">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm text-gray-500">Poli Tradisional</p>
                                    <p class="text-2xl font-bold text-gray-900">{{ $poliTradisionalCount ?? 0 }}</p>
                                    <p class="text-xs text-gray-400">Antrian menunggu</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                        <div class="bg-white rounded-2xl shadow-xl p-6">
                            <div class="flex items-center mb-4">
                                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900 ml-3">Tambah Antrian</h3>
                            </div>
                            <p class="text-gray-600 mb-4">Bantu pasien yang tidak bisa antri online</p>
                            <a href="{{ route('admin.antrian.tambah') }}"
                                class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200">
                                Tambah Antrian
                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>

                        <div class="bg-white rounded-2xl shadow-xl p-6">
                            <div class="flex items-center mb-4">
                                <div class="p-3 rounded-full bg-green-100 text-green-600">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900 ml-3">Display Antrian</h3>
                            </div>
                            <p class="text-gray-600 mb-4">Lihat display antrian untuk pasien</p>
                            <a href="{{ route('display') }}"
                                class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition duration-200">
                                Lihat Display
                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>

                        <div class="bg-white rounded-2xl shadow-xl p-6">
                            <div class="flex items-center mb-4">
                                <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                        </path>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900 ml-3">Laporan</h3>
                            </div>
                            <p class="text-gray-600 mb-4">Lihat laporan dan statistik antrian</p>
                            <a href="{{ route('admin.laporan.index') }}"
                                class="inline-flex items-center px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition duration-200">
                                Lihat Laporan
                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Logout Form -->
    <form id="logout-form" method="POST" action="{{ route('logout') }}" class="hidden">
        @csrf
    </form>

    @include('admin.partials.sidebar-script')
@endsection
