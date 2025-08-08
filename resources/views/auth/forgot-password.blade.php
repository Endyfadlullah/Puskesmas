@extends('layouts.app')

@section('title', 'Lupa Password - Sistem Antrian Puskesmas')

@section('content')
    <div
        class="min-h-screen flex items-center justify-center bg-gradient-to-br from-primary via-blue-600 to-secondary py-6 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8 animate-fade-in">
            <!-- Header -->
            <div class="text-center">
                <div class="mx-auto h-20 w-20 bg-white rounded-full flex items-center justify-center mb-6 shadow-lg">
                    <span class="text-4xl">🔐</span>
                </div>
                <h2 class="text-3xl md:text-4xl font-bold text-white mb-3">Lupa Password</h2>
                <p class="text-blue-100 text-lg">Verifikasi data diri untuk reset password</p>
            </div>

            <!-- Forgot Password Form -->
            <div class="bg-white rounded-2xl shadow-2xl p-6 md:p-8 animate-slide-up">
                <form method="POST" action="{{ route('forgot-password') }}" class="space-y-6">
                    @csrf

                    <!-- Nama Field -->
                    <div>
                        <label for="nama" class="block text-sm font-semibold text-gray-700 mb-2">
                            Nama Lengkap
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <input id="nama" name="nama" type="text" required
                                class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition duration-200 text-sm"
                                placeholder="Masukkan nama lengkap sesuai KTP" value="{{ old('nama') }}">
                        </div>
                    </div>

                    <!-- No KTP Field -->
                    <div>
                        <label for="no_ktp" class="block text-sm font-semibold text-gray-700 mb-2">
                            Nomor KTP
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V4a2 2 0 114 0v2m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path>
                                </svg>
                            </div>
                            <input id="no_ktp" name="no_ktp" type="text" required
                                class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition duration-200 text-sm"
                                placeholder="Masukkan nomor KTP" value="{{ old('no_ktp') }}">
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div>
                        <button type="submit"
                            class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-semibold rounded-xl text-white bg-primary hover:bg-secondary focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition duration-200 transform hover:scale-105">
                            <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                                <svg class="h-5 w-5 text-blue-200 group-hover:text-blue-100 transition duration-200"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </span>
                            Verifikasi Data
                        </button>
                    </div>

                    <!-- Back to Login Link -->
                    <div class="text-center">
                        <p class="text-sm text-gray-600">
                            Ingat password?
                            <a href="{{ route('login') }}"
                                class="font-semibold text-primary hover:text-secondary transition duration-200">
                                Login di sini
                            </a>
                        </p>
                    </div>
                </form>
            </div>

            <!-- Back to Home -->
            <div class="text-center">
                <a href="{{ route('landing') }}"
                    class="text-blue-100 hover:text-white text-sm transition duration-200 flex items-center justify-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // Show SweetAlert2 for errors
            @if ($errors->any())
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: '{{ $errors->first() }}',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#EF4444'
                });
            @endif

            // Show SweetAlert2 for session errors
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

            // Form validation with SweetAlert2
            let hasConfirmedSubmission = false;
            document.querySelector('form').addEventListener('submit', function(e) {
                const nama = document.getElementById('nama').value.trim();
                const noKtp = document.getElementById('no_ktp').value.trim();

                if (!nama || !noKtp) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'warning',
                        title: 'Perhatian!',
                        text: 'Mohon lengkapi semua field yang diperlukan.',
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#F59E0B'
                    });
                    return;
                }

                if (!hasConfirmedSubmission) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Konfirmasi Verifikasi',
                        text: 'Apakah Anda yakin data yang dimasukkan sudah benar?',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'Ya, Verifikasi',
                        cancelButtonText: 'Batal',
                        confirmButtonColor: '#3B82F6',
                        cancelButtonColor: '#6B7280'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            hasConfirmedSubmission = true;
                            document.querySelector('form').submit();
                        }
                    });
                }
            });
        </script>
    @endpush
@endsection
