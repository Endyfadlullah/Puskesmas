@extends('layouts.app')

@section('title', 'Sistem Antrian Puskesmas')

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-primary via-blue-600 to-secondary">
        <div class="text-center text-white animate-fade-in">
            <div class="mb-8">
                <div class="text-6xl md:text-8xl mb-6">🏥</div>
                <h1 class="text-4xl md:text-6xl font-bold mb-4">Sistem Antrian Puskesmas</h1>
                <p class="text-xl md:text-2xl text-blue-100 mb-8">Memudahkan pelayanan kesehatan masyarakat</p>
            </div>

            <div class="space-y-4">
                <a href="{{ route('landing') }}"
                    class="inline-block bg-white text-primary hover:bg-gray-100 px-8 py-4 rounded-xl text-lg font-semibold transition duration-200 transform hover:scale-105 shadow-lg">
                    Masuk ke Beranda
                </a>
            </div>

            <div class="mt-12 text-blue-100 text-sm">
                <p>Mengalihkan ke beranda dalam <span id="countdown">3</span> detik...</p>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
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

            // Show welcome error message
            @if (session('error') && str_contains(session('error'), 'welcome'))
                Swal.fire({
                    icon: 'error',
                    title: 'Error Welcome!',
                    text: '{{ session('error') }}',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#EF4444',
                    timer: 4000,
                    timerProgressBar: true
                });
            @endif

            // Auto redirect after 3 seconds
            let countdown = 3;
            const countdownElement = document.getElementById('countdown');

            const timer = setInterval(() => {
                countdown--;
                countdownElement.textContent = countdown;

                if (countdown <= 0) {
                    clearInterval(timer);
                    window.location.href = '{{ route('landing') }}';
                }
            }, 1000);
        </script>
    @endpush
@endsection
