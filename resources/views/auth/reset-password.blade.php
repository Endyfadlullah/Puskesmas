@extends('layouts.app')

@section('title', 'Reset Password - Sistem Antrian Puskesmas')

@section('content')
    <div
        class="min-h-screen flex items-center justify-center bg-gradient-to-br from-primary via-blue-600 to-secondary py-6 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8 animate-fade-in">
            <!-- Header -->
            <div class="text-center">
                <div class="mx-auto h-20 w-20 bg-white rounded-full flex items-center justify-center mb-6 shadow-lg">
                    <span class="text-4xl">🔑</span>
                </div>
                <h2 class="text-3xl md:text-4xl font-bold text-white mb-3">Reset Password</h2>
                <p class="text-blue-100 text-lg">Masukkan password baru Anda</p>
            </div>

            <!-- Reset Password Form -->
            <div class="bg-white rounded-2xl shadow-2xl p-6 md:p-8 animate-slide-up">
                <form method="POST" action="{{ route('reset-password') }}" class="space-y-6">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ session('reset_user_id') }}">

                    <!-- New Password Field -->
                    <div>
                        <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                            Password Baru
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                    </path>
                                </svg>
                            </div>
                            <input id="password" name="password" type="password" required
                                class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition duration-200 text-sm"
                                placeholder="Masukkan password baru (min. 8 karakter)">
                        </div>
                    </div>

                    <!-- Confirm Password Field -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
                            Konfirmasi Password Baru
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                    </path>
                                </svg>
                            </div>
                            <input id="password_confirmation" name="password_confirmation" type="password" required
                                class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition duration-200 text-sm"
                                placeholder="Konfirmasi password baru">
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
                            Reset Password
                        </button>
                    </div>

                    <!-- Back to Login Link -->
                    <div class="text-center">
                        <p class="text-sm text-gray-600">
                            Ingat password lama?
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
                const password = document.getElementById('password').value.trim();
                const passwordConfirmation = document.getElementById('password_confirmation').value.trim();

                if (!password || !passwordConfirmation) {
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

                if (password.length < 8) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'warning',
                        title: 'Password Terlalu Pendek!',
                        text: 'Password harus minimal 8 karakter.',
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#F59E0B'
                    });
                    return;
                }

                if (password !== passwordConfirmation) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'error',
                        title: 'Password Tidak Cocok!',
                        text: 'Konfirmasi password tidak sama dengan password baru.',
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#EF4444'
                    });
                    return;
                }

                if (!hasConfirmedSubmission) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Konfirmasi Reset Password',
                        text: 'Apakah Anda yakin ingin mereset password?',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'Ya, Reset Password',
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
