@extends('layouts.app')

@section('title', 'Display Antrian - Puskesmas')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-blue-900 via-blue-800 to-blue-700">
        <div class="container mx-auto px-4 py-6 md:py-8">
            <!-- Header -->
            <div class="text-center mb-8 md:mb-12 animate-fade-in">
                <h1 class="text-3xl md:text-5xl lg:text-6xl font-bold text-white mb-3">🏥 PUSKESMAS</h1>
                <p class="text-blue-200 text-lg md:text-xl">Sistem Antrian Digital</p>
                <div class="w-24 h-1 bg-white mx-auto mt-4 rounded-full"></div>
            </div>

            <!-- Current Queue Display -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 md:gap-8">
                <!-- Poli Umum -->
                <div class="bg-white rounded-2xl shadow-2xl p-6 md:p-8 animate-slide-up">
                    <div class="text-center mb-6">
                        <h2 class="text-xl md:text-2xl font-bold text-gray-900 mb-3">Poli Umum</h2>
                        <div class="w-16 h-1 bg-blue-500 mx-auto rounded-full"></div>
                    </div>

                    <div class="text-center mb-6">
                        <div class="text-4xl md:text-6xl lg:text-7xl font-bold text-blue-600 mb-3" id="poli-umum-current">
                            {{ $poliUmumCurrent?->no_antrian ?? '---' }}
                        </div>
                        <p class="text-gray-600 text-sm md:text-base font-medium">Sedang Dipanggil</p>
                    </div>

                    <div class="mt-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Antrian Berikutnya:</h3>
                        <div class="space-y-3" data-next-queue="poli-umum-next">
                            @forelse($poliUmumNext ?? [] as $antrian)
                                <div
                                    class="bg-gray-50 rounded-xl p-4 border border-gray-200 hover:shadow-md transition duration-200">
                                    <span
                                        class="text-lg md:text-xl font-bold text-gray-900">{{ $antrian->no_antrian }}</span>
                                </div>
                            @empty
                                <div class="text-gray-500 text-center py-6 bg-gray-50 rounded-xl">
                                    <svg class="w-8 h-8 mx-auto mb-2 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                        </path>
                                    </svg>
                                    <p class="text-sm">Tidak ada antrian</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Poli Gigi -->
                <div class="bg-white rounded-2xl shadow-2xl p-6 md:p-8 animate-slide-up" style="animation-delay: 0.1s;">
                    <div class="text-center mb-6">
                        <h2 class="text-xl md:text-2xl font-bold text-gray-900 mb-3">Poli Gigi</h2>
                        <div class="w-16 h-1 bg-green-500 mx-auto rounded-full"></div>
                    </div>

                    <div class="text-center mb-6">
                        <div class="text-4xl md:text-6xl lg:text-7xl font-bold text-green-600 mb-3" id="poli-gigi-current">
                            {{ $poliGigiCurrent?->no_antrian ?? '---' }}
                        </div>
                        <p class="text-gray-600 text-sm md:text-base font-medium">Sedang Dipanggil</p>
                    </div>

                    <div class="mt-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Antrian Berikutnya:</h3>
                        <div class="space-y-3" data-next-queue="poli-gigi-next">
                            @forelse($poliGigiNext ?? [] as $antrian)
                                <div
                                    class="bg-gray-50 rounded-xl p-4 border border-gray-200 hover:shadow-md transition duration-200">
                                    <span
                                        class="text-lg md:text-xl font-bold text-gray-900">{{ $antrian->no_antrian }}</span>
                                </div>
                            @empty
                                <div class="text-gray-500 text-center py-6 bg-gray-50 rounded-xl">
                                    <svg class="w-8 h-8 mx-auto mb-2 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                        </path>
                                    </svg>
                                    <p class="text-sm">Tidak ada antrian</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Poli Jiwa -->
                <div class="bg-white rounded-2xl shadow-2xl p-6 md:p-8 animate-slide-up" style="animation-delay: 0.2s;">
                    <div class="text-center mb-6">
                        <h2 class="text-xl md:text-2xl font-bold text-gray-900 mb-3">Poli Jiwa</h2>
                        <div class="w-16 h-1 bg-pink-500 mx-auto rounded-full"></div>
                    </div>

                    <div class="text-center mb-6">
                        <div class="text-4xl md:text-6xl lg:text-7xl font-bold text-pink-600 mb-3" id="poli-jiwa-current">
                            {{ $poliJiwaCurrent?->no_antrian ?? '---' }}
                        </div>
                        <p class="text-gray-600 text-sm md:text-base font-medium">Sedang Dipanggil</p>
                    </div>

                    <div class="mt-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Antrian Berikutnya:</h3>
                        <div class="space-y-3" data-next-queue="poli-jiwa-next">
                            @forelse($poliJiwaNext ?? [] as $antrian)
                                <div
                                    class="bg-gray-50 rounded-xl p-4 border border-gray-200 hover:shadow-md transition duration-200">
                                    <span
                                        class="text-lg md:text-xl font-bold text-gray-900">{{ $antrian->no_antrian }}</span>
                                </div>
                            @empty
                                <div class="text-gray-500 text-center py-6 bg-gray-50 rounded-xl">
                                    <svg class="w-8 h-8 mx-auto mb-2 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                        </path>
                                    </svg>
                                    <p class="text-sm">Tidak ada antrian</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Poli Tradisional -->
                <div class="bg-white rounded-2xl shadow-2xl p-6 md:p-8 animate-slide-up" style="animation-delay: 0.3s;">
                    <div class="text-center mb-6">
                        <h2 class="text-xl md:text-2xl font-bold text-gray-900 mb-3">Poli Tradisional</h2>
                        <div class="w-16 h-1 bg-yellow-500 mx-auto rounded-full"></div>
                    </div>

                    <div class="text-center mb-6">
                        <div class="text-4xl md:text-6xl lg:text-7xl font-bold text-yellow-600 mb-3"
                            id="poli-tradisional-current">
                            {{ $poliTradisionalCurrent?->no_antrian ?? '---' }}
                        </div>
                        <p class="text-gray-600 text-sm md:text-base font-medium">Sedang Dipanggil</p>
                    </div>

                    <div class="mt-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Antrian Berikutnya:</h3>
                        <div class="space-y-3" data-next-queue="poli-tradisional-next">
                            @forelse($poliTradisionalNext ?? [] as $antrian)
                                <div
                                    class="bg-gray-50 rounded-xl p-4 border border-gray-200 hover:shadow-md transition duration-200">
                                    <span
                                        class="text-lg md:text-xl font-bold text-gray-900">{{ $antrian->no_antrian }}</span>
                                </div>
                            @empty
                                <div class="text-gray-500 text-center py-6 bg-gray-50 rounded-xl">
                                    <svg class="w-8 h-8 mx-auto mb-2 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <p class="text-sm">Tidak ada antrian</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="text-center mt-12 md:mt-16">
                <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-4 md:p-6 inline-block">
                    <p class="text-blue-200 text-sm md:text-base font-medium">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        {{ now()->format('d F Y H:i:s') }}
                    </p>
                </div>
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

            // Show display error message
            @if (session('error') && str_contains(session('error'), 'display'))
                Swal.fire({
                    icon: 'error',
                    title: 'Error Display!',
                    text: '{{ session('error') }}',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#EF4444',
                    timer: 4000,
                    timerProgressBar: true
                });
            @endif

            // No more auto refresh - using real-time updates instead

            // Add sound effect for new calls
            function playNotificationSound() {
                const audio = new Audio(
                    'data:audio/wav;base64,UklGRnoGAABXQVZFZm10IBAAAAABAAEAQB8AAEAfAAABAAgAZGF0YQoGAACBhYqFbF1fdJivrJBhNjVgodDbq2EcBj+a2/LDciUFLIHO8tiJNwgZaLvt559NEAxQp+PwtmMcBjiR1/LMeSwFJHfH8N2QQAoUXrTp66hVFApGn+DyvmwhBSuBzvLZiTYIG2m98OScTgwOUarm7blmGgU7k9n1unEiBC13yO/eizEIHWq+8+OWT'
                );
                audio.play();
            }

            // Check for new calls every 2 seconds
            setInterval(function() {
                // This would typically make an AJAX call to check for new calls
                // For now, we'll just reload the page
            }, 2000);

            // Show notification when new call is detected
            function showNewCallNotification(poliName, number) {
                Swal.fire({
                    icon: 'info',
                    title: 'Panggilan Baru!',
                    text: `Antrian selanjutnya poli ${poliName} nomor ${number}`,
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#3B82F6',
                    timer: 5000,
                    timerProgressBar: true,
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    background: '#3B82F6',
                    color: '#ffffff'
                });

                // Play notification sound
                playNotificationSound();
            }

            // Add pulse animation to current numbers
            function addPulseAnimation() {
                const currentNumbers = document.querySelectorAll('[id$="-current"]');
                currentNumbers.forEach(element => {
                    if (element.textContent !== '---') {
                        element.classList.add('animate-pulse');
                        setTimeout(() => {
                            element.classList.remove('animate-pulse');
                        }, 2000);
                    }
                });
            }

            // Initialize animations
            document.addEventListener('DOMContentLoaded', function() {
                addPulseAnimation();
            });

            // Check for new calls using polling (fallback for broadcast)
            let lastCallTime = new Date().getTime();

            function checkForNewCalls() {
                fetch('/api/check-new-calls?last_check=' + lastCallTime)
                    .then(response => response.json())
                    .then(data => {
                        if (data.has_new_call && data.antrian) {
                            console.log('New call detected:', data.antrian);



                            // Show notification
                            showNewCallNotification(data.antrian.poli_name, data.antrian.queue_number);

                            // Add pulse animation to the current number
                            addPulseAnimation();

                            // Update last check time
                            lastCallTime = new Date().getTime();

                            // Update display without refresh
                            updateDisplayData();
                        }
                    })
                    .catch(error => {
                        console.log('Error checking for new calls:', error);
                    });
            }

            // Function to update display data without refresh
            function updateDisplayData() {
                fetch('/api/display-data')
                    .then(response => response.json())
                    .then(data => {
                        // Update current numbers
                        if (data.poliUmumCurrent) {
                            document.getElementById('poli-umum-current').textContent = data.poliUmumCurrent.no_antrian;
                        }
                        if (data.poliGigiCurrent) {
                            document.getElementById('poli-gigi-current').textContent = data.poliGigiCurrent.no_antrian;
                        }
                        if (data.poliJiwaCurrent) {
                            document.getElementById('poli-jiwa-current').textContent = data.poliJiwaCurrent.no_antrian;
                        }
                        if (data.poliTradisionalCurrent) {
                            document.getElementById('poli-tradisional-current').textContent = data.poliTradisionalCurrent
                                .no_antrian;
                        }

                        // Update next queues
                        updateNextQueue('poli-umum-next', data.poliUmumNext);
                        updateNextQueue('poli-gigi-next', data.poliGigiNext);
                        updateNextQueue('poli-jiwa-next', data.poliJiwaNext);
                        updateNextQueue('poli-tradisional-next', data.poliTradisionalNext);
                    })
                    .catch(error => {
                        console.log('Error updating display data:', error);
                    });
            }

            // Function to update next queue section
            function updateNextQueue(containerId, nextQueues) {
                const container = document.querySelector(`[data-next-queue="${containerId}"]`);
                if (!container) return;

                if (nextQueues && nextQueues.length > 0) {
                    container.innerHTML = nextQueues.map(antrian => `
                        <div class="bg-gray-50 rounded-xl p-4 border border-gray-200 hover:shadow-md transition duration-200">
                            <span class="text-lg md:text-xl font-bold text-gray-900">${antrian.no_antrian}</span>
                        </div>
                    `).join('');
                } else {
                    container.innerHTML = `
                        <div class="text-gray-500 text-center py-6 bg-gray-50 rounded-xl">
                            <svg class="w-8 h-8 mx-auto mb-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <p class="text-sm">Tidak ada antrian</p>
                        </div>
                    `;
                }
            }

            // Check for new calls every 3 seconds
            setInterval(checkForNewCalls, 3000);

            // Update display data every 10 seconds
            setInterval(updateDisplayData, 10000);


        </script>
    @endpush
@endsection
