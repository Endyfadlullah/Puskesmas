@extends('layouts.app')

@section('title', 'Sistem Antrian Puskesmas - Beranda')

@section('content')
    @if (session('success'))
        <div id="success-message"
            class="fixed top-4 right-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded shadow-lg z-50">
            {{ session('success') }}
        </div>
    @endif

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
                    <a href="#layanan"
                        class="text-gray-700 hover:text-primary px-3 py-2 rounded-md text-sm font-medium transition duration-200">Layanan</a>
                    <a href="#tentang"
                        class="text-gray-700 hover:text-primary px-3 py-2 rounded-md text-sm font-medium transition duration-200">Tentang</a>
                    <a href="{{ route('display') }}"
                        class="text-gray-700 hover:text-primary px-3 py-2 rounded-md text-sm font-medium transition duration-200">Display</a>
                    <a href="{{ route('login') }}"
                        class="bg-primary hover:bg-secondary text-white px-4 py-2 rounded-md text-sm font-medium transition duration-200">Login</a>
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
                    <a href="#layanan"
                        class="text-gray-700 hover:text-primary block px-3 py-2 rounded-md text-base font-medium transition duration-200">Layanan</a>
                    <a href="#tentang"
                        class="text-gray-700 hover:text-primary block px-3 py-2 rounded-md text-base font-medium transition duration-200">Tentang</a>
                    <a href="{{ route('display') }}"
                        class="text-gray-700 hover:text-primary block px-3 py-2 rounded-md text-base font-medium transition duration-200">Display</a>
                    <a href="{{ route('login') }}"
                        class="bg-primary hover:bg-secondary text-white block px-3 py-2 rounded-md text-base font-medium transition duration-200">Login</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-primary via-blue-600 to-secondary text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-24">
            <div class="text-center animate-fade-in">
                <h1 class="text-4xl md:text-6xl lg:text-7xl font-bold mb-6 leading-tight">
                    Sistem Antrian Puskesmas
                </h1>
                <p class="text-xl md:text-2xl mb-8 text-blue-100 max-w-4xl mx-auto">
                    Antrian digital yang memudahkan pelayanan kesehatan masyarakat
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('register') }}"
                        class="bg-white text-primary hover:bg-gray-100 px-8 py-4 rounded-xl text-lg font-semibold inline-block transition duration-200 transform hover:scale-105 shadow-lg">
                        Daftar Antrian
                    </a>
                    <a href="#layanan"
                        class="border-2 border-white text-white hover:bg-white hover:text-primary px-8 py-4 rounded-xl text-lg font-semibold inline-block transition duration-200 transform hover:scale-105">
                        Lihat Layanan
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div id="layanan" class="py-16 md:py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12 md:mb-16 animate-slide-up">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Layanan Kami</h2>
                <p class="text-lg md:text-xl text-gray-600 max-w-3xl mx-auto">Berbagai layanan kesehatan yang tersedia</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 md:gap-12">
                <div
                    class="bg-white p-6 md:p-8 rounded-2xl shadow-xl border border-gray-200 hover:shadow-2xl transition duration-300 transform hover:-translate-y-2 animate-slide-up">
                    <div class="text-4xl md:text-5xl mb-4">👨‍⚕️</div>
                    <h3 class="text-xl md:text-2xl font-semibold mb-3">Poli Umum</h3>
                    <p class="text-gray-600 text-sm md:text-base">Layanan pemeriksaan kesehatan umum untuk semua usia</p>
                </div>

                <div class="bg-white p-6 md:p-8 rounded-2xl shadow-xl border border-gray-200 hover:shadow-2xl transition duration-300 transform hover:-translate-y-2 animate-slide-up"
                    style="animation-delay: 0.1s;">
                    <div class="text-4xl md:text-5xl mb-4">👶</div>
                    <h3 class="text-xl md:text-2xl font-semibold mb-3">Poli Anak</h3>
                    <p class="text-gray-600 text-sm md:text-base">Layanan kesehatan khusus untuk anak-anak</p>
                </div>

                <div class="bg-white p-6 md:p-8 rounded-2xl shadow-xl border border-gray-200 hover:shadow-2xl transition duration-300 transform hover:-translate-y-2 animate-slide-up"
                    style="animation-delay: 0.2s;">
                    <div class="text-4xl md:text-5xl mb-4">🤰</div>
                    <h3 class="text-xl md:text-2xl font-semibold mb-3">Poli Ibu Hamil</h3>
                    <p class="text-gray-600 text-sm md:text-base">Layanan kesehatan untuk ibu hamil dan keluarga berencana
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- How It Works -->
    <div class="py-16 md:py-24 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12 md:mb-16 animate-slide-up">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Cara Kerja</h2>
                <p class="text-lg md:text-xl text-gray-600 max-w-3xl mx-auto">Langkah-langkah menggunakan sistem antrian
                    digital</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 md:gap-12">
                <div class="text-center animate-slide-up">
                    <div
                        class="bg-primary text-white rounded-full w-16 h-16 md:w-20 md:h-20 flex items-center justify-center text-2xl font-bold mx-auto mb-4 shadow-lg">
                        1</div>
                    <h3 class="text-lg md:text-xl font-semibold mb-3">Daftar Online</h3>
                    <p class="text-gray-600 text-sm md:text-base">Isi formulir pendaftaran dengan data lengkap</p>
                </div>

                <div class="text-center animate-slide-up" style="animation-delay: 0.1s;">
                    <div
                        class="bg-primary text-white rounded-full w-16 h-16 md:w-20 md:h-20 flex items-center justify-center text-2xl font-bold mx-auto mb-4 shadow-lg">
                        2</div>
                    <h3 class="text-lg md:text-xl font-semibold mb-3">Dapatkan Nomor</h3>
                    <p class="text-gray-600 text-sm md:text-base">Sistem akan memberikan nomor antrian</p>
                </div>

                <div class="text-center animate-slide-up" style="animation-delay: 0.2s;">
                    <div
                        class="bg-primary text-white rounded-full w-16 h-16 md:w-20 md:h-20 flex items-center justify-center text-2xl font-bold mx-auto mb-4 shadow-lg">
                        3</div>
                    <h3 class="text-lg md:text-xl font-semibold mb-3">Tunggu Panggilan</h3>
                    <p class="text-gray-600 text-sm md:text-base">Monitor layar atau tunggu panggilan</p>
                </div>

                <div class="text-center animate-slide-up" style="animation-delay: 0.3s;">
                    <div
                        class="bg-primary text-white rounded-full w-16 h-16 md:w-20 md:h-20 flex items-center justify-center text-2xl font-bold mx-auto mb-4 shadow-lg">
                        4</div>
                    <h3 class="text-lg md:text-xl font-semibold mb-3">Layanan</h3>
                    <p class="text-gray-600 text-sm md:text-base">Dapatkan pelayanan kesehatan</p>
                </div>
            </div>
        </div>
    </div>

    <!-- About Section -->
    <div id="tentang" class="py-16 md:py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-center">
                <div class="animate-slide-up">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6">Tentang Kami</h2>
                    <p class="text-lg md:text-xl text-gray-600 mb-4">
                        Puskesmas kami berkomitmen untuk memberikan pelayanan kesehatan yang berkualitas
                        kepada masyarakat dengan sistem antrian digital yang modern dan efisien.
                    </p>
                    <p class="text-lg md:text-xl text-gray-600 mb-8">
                        Dengan teknologi terkini, kami memastikan proses antrian berjalan lancar
                        dan mengurangi waktu tunggu pasien.
                    </p>
                    <div class="space-y-3">
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-primary rounded-full mr-4"></div>
                            <span class="text-gray-700 text-base md:text-lg">Pelayanan 24/7</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-primary rounded-full mr-4"></div>
                            <span class="text-gray-700 text-base md:text-lg">Sistem Antrian Digital</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-primary rounded-full mr-4"></div>
                            <span class="text-gray-700 text-base md:text-lg">Tim Medis Profesional</span>
                        </div>
                    </div>
                </div>
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-2xl p-8 md:p-12 animate-slide-up"
                    style="animation-delay: 0.2s;">
                    <div class="text-center">
                        <div class="text-6xl md:text-8xl mb-6">🏥</div>
                        <h3 class="text-2xl md:text-3xl font-bold text-gray-900 mb-4">Puskesmas Modern</h3>
                        <p class="text-gray-600 text-base md:text-lg">Melayani dengan teknologi terkini</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-16">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 md:gap-12">
                <div>
                    <h3 class="text-xl md:text-2xl font-bold mb-4">🏥 Puskesmas</h3>
                    <p class="text-gray-400 text-sm md:text-base">Sistem antrian digital untuk pelayanan kesehatan yang
                        lebih baik.</p>
                </div>
                <div>
                    <h4 class="text-lg md:text-xl font-semibold mb-4">Layanan</h4>
                    <ul class="space-y-2 text-gray-400 text-sm md:text-base">
                        <li>Poli Umum</li>
                        <li>Poli Anak</li>
                        <li>Poli Ibu Hamil</li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg md:text-xl font-semibold mb-4">Kontak</h4>
                    <ul class="space-y-2 text-gray-400 text-sm md:text-base">
                        <li>📞 (021) 1234-5678</li>
                        <li>📧 info@puskesmas.com</li>
                        <li>📍 Jl. Kesehatan No. 123</li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg md:text-xl font-semibold mb-4">Jam Operasional</h4>
                    <ul class="space-y-2 text-gray-400 text-sm md:text-base">
                        <li>Senin - Jumat: 08:00 - 16:00</li>
                        <li>Sabtu: 08:00 - 12:00</li>
                        <li>Minggu: Tutup</li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-8 md:mt-12 pt-8 text-center text-gray-400">
                <p class="text-sm md:text-base">&copy; 2024 Sistem Antrian Puskesmas. All rights reserved.</p>
            </div>
        </div>
    </footer>

    @push('scripts')
        <script>
            // Mobile menu toggle
            document.getElementById('mobile-menu-button').addEventListener('click', function() {
                const mobileMenu = document.getElementById('mobile-menu');
                mobileMenu.classList.toggle('hidden');
            });

            // Smooth scrolling for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
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

            // Show logout success message
            @if (session('success') && str_contains(session('success'), 'logout'))
                Swal.fire({
                    icon: 'success',
                    title: 'Logout Berhasil!',
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

            // Show system error message
            @if (session('error') && str_contains(session('error'), 'sistem'))
                Swal.fire({
                    icon: 'error',
                    title: 'Error Sistem!',
                    text: '{{ session('error') }}',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#EF4444',
                    timer: 4000,
                    timerProgressBar: true
                });
            @endif

            // Intersection Observer for animations
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('animate-fade-in');
                    }
                });
            }, observerOptions);

            // Observe all sections
            document.querySelectorAll('section, .animate-slide-up').forEach(el => {
                observer.observe(el);
            });
        </script>
    @endpush
@endsection
