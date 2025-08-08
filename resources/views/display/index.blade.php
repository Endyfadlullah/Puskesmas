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
                        <div class="space-y-3">
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
                        <div class="space-y-3">
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
                        <div class="space-y-3">
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
                        <div class="space-y-3">
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
            // TTS Audio Player
            class TTSAudioPlayer {
                constructor() {
                    this.audioQueue = [];
                    this.isPlaying = false;
                    this.currentAudio = null;
                }

                // Play complete audio sequence
                async playAudioSequence(audioSequence) {
                    if (this.isPlaying) {
                        console.log('Audio already playing, queueing...');
                        this.audioQueue.push(audioSequence);
                        return;
                    }

                    this.isPlaying = true;

                    for (let i = 0; i < audioSequence.length; i++) {
                        const audioItem = audioSequence[i];
                        await this.playAudioItem(audioItem);

                        // Wait between audio items
                        if (i < audioSequence.length - 1) {
                            await this.delay(500);
                        }
                    }

                    this.isPlaying = false;

                    // Play next in queue if available
                    if (this.audioQueue.length > 0) {
                        const nextSequence = this.audioQueue.shift();
                        this.playAudioSequence(nextSequence);
                    }
                }

                // Play single audio item
                playAudioItem(audioItem) {
                    return new Promise((resolve, reject) => {
                        if (audioItem.type === 'browser_tts') {
                            // Use browser TTS
                            if ('speechSynthesis' in window) {
                                const utterance = new SpeechSynthesisUtterance(audioItem.text);
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

                                utterance.addEventListener('end', () => {
                                    resolve();
                                });

                                utterance.addEventListener('error', (error) => {
                                    console.error('TTS error:', error);
                                    resolve();
                                });

                                speechSynthesis.speak(utterance);

                                // Fallback timeout
                                setTimeout(() => {
                                    resolve();
                                }, audioItem.duration || 4000);
                            } else {
                                console.warn('Speech synthesis not supported');
                                resolve();
                            }
                        } else {
                            // Play audio file
                            const audio = new Audio(audioItem.url);

                            audio.addEventListener('loadeddata', () => {
                                audio.play();
                            });

                            audio.addEventListener('ended', () => {
                                resolve();
                            });

                            audio.addEventListener('error', (error) => {
                                console.error('Audio playback error:', error);
                                resolve(); // Continue even if audio fails
                            });

                            // Fallback timeout
                            setTimeout(() => {
                                resolve();
                            }, audioItem.duration || 3000);
                        }
                    });
                }

                // Utility function for delays
                delay(ms) {
                    return new Promise(resolve => setTimeout(resolve, ms));
                }

                // Play TTS for queue call
                async playQueueCall(poliName, queueNumber) {
                    try {
                        const response = await fetch('{{ route('tts.play-sequence') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({
                                poli_name: poliName,
                                queue_number: queueNumber
                            })
                        });

                        const data = await response.json();

                        if (data.success && data.audio_sequence) {
                            await this.playAudioSequence(data.audio_sequence);
                        } else {
                            console.error('Failed to get audio sequence:', data.message);
                        }
                    } catch (error) {
                        console.error('Error playing TTS:', error);
                    }
                }
            }

            // Initialize TTS Audio Player
            const ttsPlayer = new TTSAudioPlayer();

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

            // Auto refresh every 5 seconds
            setInterval(function() {
                location.reload();
            }, 5000);

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
                    text: `Poli ${poliName} memanggil nomor ${number}`,
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

            // Listen for TTS events from admin panel
            window.addEventListener('message', function(event) {
                if (event.data.type === 'TTS_CALL') {
                    const {
                        poliName,
                        queueNumber
                    } = event.data;
                    ttsPlayer.playQueueCall(poliName, queueNumber);
                }
            });
        </script>
    @endpush
@endsection
