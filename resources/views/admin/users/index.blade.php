@extends('layouts.app')

@section('title', 'Kelola User - Admin Dashboard')

@section('content')
    <div class="min-h-screen bg-gray-50">
        @include('admin.partials.top-nav')

        <div class="flex">
            @include('admin.partials.sidebar')

            <!-- Main Content -->
            <div class="flex-1 lg:ml-0">
                <div class="px-4 sm:px-6 lg:px-8 py-6 md:py-8">
                    <!-- Header -->
                    <div class="mb-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <h1 class="text-2xl font-bold text-gray-900 mb-2">Kelola Data User</h1>
                                <p class="text-gray-600">Kelola data pengguna yang terdaftar dalam sistem</p>
                            </div>
                            <a href="{{ route('admin.users.create') }}"
                                class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 transition duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Tambah User
                            </a>
                        </div>
                    </div>

                    <!-- Search and Filter -->
                    <div class="bg-white rounded-lg shadow-sm border p-6 mb-6">
                        <div class="flex flex-col sm:flex-row gap-4">
                            <div class="flex-1">
                                <input type="text" id="searchInput"
                                    placeholder="Cari berdasarkan nama, NIK, atau nomor HP..."
                                    value="{{ request('search') }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>
                            <button id="searchBtn"
                                class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500">
                                Cari
                            </button>
                            @if(request('search'))
                                <a href="{{ route('admin.users.index') }}"
                                    class="px-6 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 focus:ring-2 focus:ring-gray-500">
                                    Clear
                                </a>
                            @endif
                        </div>
                    </div>

                    <!-- Users Table -->
                    <div class="bg-white rounded-lg shadow-sm border overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900">Daftar User</h3>
                        </div>

                        <!-- Desktop Table -->
                        <div class="hidden lg:block overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Nama</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            NIK</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Jenis Kelamin</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            No. HP</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Alamat</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="usersTableBody" class="bg-white divide-y divide-gray-200">
                                    @forelse($users as $user)
                                        <tr class="hover:bg-gray-50 transition duration-200">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">{{ $user->nama }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $user->no_ktp }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span
                                                    class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $user->jenis_kelamin == 'Laki-laki' ? 'bg-blue-100 text-blue-800' : 'bg-pink-100 text-pink-800' }}">
                                                    {{ $user->jenis_kelamin }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $user->no_hp }}</div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="text-sm text-gray-900 max-w-xs truncate">{{ $user->alamat }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <a href="{{ route('admin.users.show', $user->id) }}"
                                                    class="text-blue-600 hover:text-blue-900 mr-3">Detail</a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                                <svg class="w-12 h-12 mx-auto mb-4 text-gray-400" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z">
                                                    </path>
                                                </svg>
                                                <p class="text-lg font-medium">Belum ada user terdaftar</p>
                                                <p class="text-sm text-gray-400">User akan muncul di sini setelah ada
                                                    pendaftaran</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Mobile Table -->
                        <div class="lg:hidden">
                            @forelse($users as $user)
                                <div class="border-b border-gray-200 p-4 hover:bg-gray-50">
                                    <div class="grid grid-cols-2 gap-4 mb-3">
                                        <div>
                                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</p>
                                            <div class="text-sm font-medium text-gray-900">{{ $user->nama }}</div>
                                        </div>
                                        <div>
                                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">NIK</p>
                                            <div class="text-sm text-gray-900">{{ $user->no_ktp }}</div>
                                        </div>
                                        <div>
                                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis
                                                Kelamin</p>
                                            <span
                                                class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $user->jenis_kelamin == 'Laki-laki' ? 'bg-blue-100 text-blue-800' : 'bg-pink-100 text-pink-800' }}">
                                                {{ $user->jenis_kelamin }}
                                            </span>
                                        </div>
                                        <div>
                                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">No. HP</p>
                                            <div class="text-sm text-gray-900">{{ $user->no_hp }}</div>
                                        </div>
                                    </div>

                                    <div class="border-t border-gray-100 pt-3">
                                        <div class="mb-2">
                                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Alamat</p>
                                            <div class="text-sm text-gray-900">{{ $user->alamat }}</div>
                                        </div>
                                        <a href="{{ route('admin.users.show', $user->id) }}"
                                            class="inline-flex items-center text-blue-600 hover:text-blue-900 text-sm font-medium">
                                            Lihat Detail
                                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 5l7 7-7 7"></path>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            @empty
                                <div class="p-8 text-center text-gray-500">
                                    <svg class="w-12 h-12 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z">
                                        </path>
                                    </svg>
                                    <p class="text-lg font-medium">Belum ada user terdaftar</p>
                                    <p class="text-sm text-gray-400">User akan muncul di sini setelah ada pendaftaran</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Pagination -->
                    @if ($users->hasPages())
                        <div class="mt-6">
                            {{ $users->links() }}
                        </div>
                    @endif

                    <!-- Show total count -->
                    <div class="mt-4 text-sm text-gray-600 text-center">
                        Total: {{ $users->total() }} user
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Logout Form -->
    <form id="logout-form" method="POST" action="{{ route('logout') }}" class="hidden">
        @csrf
    </form>

    <script>
        // Search functionality
        document.getElementById('searchBtn').addEventListener('click', function() {
            const searchTerm = document.getElementById('searchInput').value.trim();
            if (searchTerm.length < 3) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Peringatan',
                    text: 'Masukkan minimal 3 karakter untuk pencarian',
                    confirmButtonColor: '#3B82F6'
                });
                return;
            }
            searchUsers(searchTerm);
        });

        document.getElementById('searchInput').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                document.getElementById('searchBtn').click();
            }
        });

        function searchUsers(searchTerm) {
            // Redirect to search with query parameter
            const currentUrl = new URL(window.location);
            currentUrl.searchParams.set('search', searchTerm);
            window.location.href = currentUrl.toString();
        }
    </script>

    @include('admin.partials.sidebar-script')
@endsection
