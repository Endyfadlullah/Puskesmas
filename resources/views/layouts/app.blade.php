<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Sistem Antrian Puskesmas')</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#3B82F6',
                        secondary: '#1E40AF',
                        accent: '#10B981',
                        success: '#10B981',
                        warning: '#F59E0B',
                        error: '#EF4444',
                        info: '#3B82F6'
                    },
                    fontFamily: {
                        sans: ['Inter', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.5s ease-in-out',
                        'slide-up': 'slideUp 0.3s ease-out',
                        'bounce-in': 'bounceIn 0.6s ease-out',
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': {
                                opacity: '0'
                            },
                            '100%': {
                                opacity: '1'
                            },
                        },
                        slideUp: {
                            '0%': {
                                transform: 'translateY(10px)',
                                opacity: '0'
                            },
                            '100%': {
                                transform: 'translateY(0)',
                                opacity: '1'
                            },
                        },
                        bounceIn: {
                            '0%': {
                                transform: 'scale(0.3)',
                                opacity: '0'
                            },
                            '50%': {
                                transform: 'scale(1.05)'
                            },
                            '70%': {
                                transform: 'scale(0.9)'
                            },
                            '100%': {
                                transform: 'scale(1)',
                                opacity: '1'
                            },
                        },
                    }
                }
            }
        }
    </script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Custom Styles -->
    <style>
        .swal2-popup {
            font-family: 'Inter', sans-serif;
        }

        .swal2-title {
            color: #1F2937 !important;
        }

        .swal2-content {
            color: #6B7280 !important;
        }

        .swal2-confirm {
            background-color: #3B82F6 !important;
        }

        .swal2-cancel {
            background-color: #6B7280 !important;
        }

        .swal2-success {
            background-color: #10B981 !important;
        }

        .swal2-error {
            background-color: #EF4444 !important;
        }

        .swal2-warning {
            background-color: #F59E0B !important;
        }

        .swal2-info {
            background-color: #3B82F6 !important;
        }
    </style>

    @stack('styles')
</head>

<body class="bg-gray-50 font-sans antialiased">
    @yield('content')

    @stack('scripts')
    
    <script>
        // Global logout function
        function confirmLogout() {
            if (confirm('Apakah Anda yakin ingin logout?')) {
                document.getElementById('logout-form').submit();
            }
        }
    </script>
</body>
</html>
