<!-- Sidebar -->
<aside id="sidebar"
    class="fixed inset-y-0 left-0 z-50 w-64 bg-white shadow-xl transform -translate-x-full lg:translate-x-0 transition duration-200 ease-in-out">
    <div class="flex items-center justify-between h-16 px-6 border-b border-gray-200">
        <h2 class="text-lg font-semibold text-gray-900">Menu Admin</h2>
        <button id="sidebar-close" class="lg:hidden text-gray-500 hover:text-gray-700">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                </path>
            </svg>
        </button>
    </div>

    <nav class="px-6 py-6 overflow-y-auto h-full flex flex-col">
        <div class="space-y-6 flex-1">
            <!-- Dashboard -->
            <div>
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center px-4 py-3 rounded-xl {{ request()->routeIs('admin.dashboard') ? 'bg-blue-50 text-blue-700 border border-blue-200' : 'text-gray-700 hover:bg-gray-50' }} transition duration-200">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 5a2 2 0 012-2h4a2 2 0 012 2v6H8V5z"></path>
                    </svg>
                    <span class="font-medium">Dashboard</span>
                </a>
            </div>

            <!-- Daftar Antrian -->
            <div>
                <div class="flex items-center px-4 py-2 text-sm font-semibold text-gray-500 uppercase tracking-wider">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                        </path>
                    </svg>
                    Daftar Antrian
                </div>
                <div class="mt-3 space-y-1">
                    <a href="{{ route('admin.poli.umum') }}"
                        class="flex items-center px-4 py-2 rounded-lg {{ request()->routeIs('admin.poli.umum') ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:bg-gray-50' }} transition duration-200">
                        <div class="w-2 h-2 bg-blue-500 rounded-full mr-3"></div>
                        <span class="text-sm">Poli Umum</span>
                    </a>
                    <a href="{{ route('admin.poli.gigi') }}"
                        class="flex items-center px-4 py-2 rounded-lg {{ request()->routeIs('admin.poli.gigi') ? 'bg-green-50 text-green-700' : 'text-gray-600 hover:bg-gray-50' }} transition duration-200">
                        <div class="w-2 h-2 bg-green-500 rounded-full mr-3"></div>
                        <span class="text-sm">Poli Gigi</span>
                    </a>
                    <a href="{{ route('admin.poli.jiwa') }}"
                        class="flex items-center px-4 py-2 rounded-lg {{ request()->routeIs('admin.poli.jiwa') ? 'bg-purple-50 text-purple-700' : 'text-gray-600 hover:bg-gray-50' }} transition duration-200">
                        <div class="w-2 h-2 bg-purple-500 rounded-full mr-3"></div>
                        <span class="text-sm">Poli Jiwa</span>
                    </a>
                    <a href="{{ route('admin.poli.tradisional') }}"
                        class="flex items-center px-4 py-2 rounded-lg {{ request()->routeIs('admin.poli.tradisional') ? 'bg-yellow-50 text-yellow-700' : 'text-gray-600 hover:bg-gray-50' }} transition duration-200">
                        <div class="w-2 h-2 bg-yellow-500 rounded-full mr-3"></div>
                        <span class="text-sm">Poli Tradisional</span>
                    </a>
                </div>
            </div>

            <!-- Tambah Antrian Manual -->
            <div>
                <a href="{{ route('admin.antrian.tambah') }}"
                    class="flex items-center px-4 py-3 rounded-xl {{ request()->routeIs('admin.antrian.tambah') ? 'bg-blue-50 text-blue-700 border border-blue-200' : 'text-gray-700 hover:bg-gray-50' }} transition duration-200">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    <span class="font-medium">Tambah Antrian</span>
                </a>
            </div>

            <!-- Kelola User -->
            <div>
                <a href="{{ route('admin.users.index') }}"
                    class="flex items-center px-4 py-3 rounded-xl {{ request()->routeIs('admin.users.*') ? 'bg-blue-50 text-blue-700 border border-blue-200' : 'text-gray-700 hover:bg-gray-50' }} transition duration-200">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z">
                        </path>
                    </svg>
                    <span class="font-medium">Kelola User</span>
                </a>
            </div>

            <!-- Laporan -->
            <div>
                <a href="{{ route('admin.laporan.index') }}"
                    class="flex items-center px-4 py-3 rounded-xl {{ request()->routeIs('admin.laporan.*') ? 'bg-blue-50 text-blue-700 border border-blue-200' : 'text-gray-700 hover:bg-gray-50' }} transition duration-200">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                    <span class="font-medium">Laporan</span>
                </a>
            </div>

            <!-- Display -->
            <div>
                <a href="{{ route('display') }}"
                    class="flex items-center px-4 py-3 rounded-xl text-gray-700 hover:bg-gray-50 transition duration-200">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z">
                        </path>
                    </svg>
                    <span class="font-medium">Display</span>
                </a>
            </div>
        </div>

        <!-- Logout Button at Bottom -->
        <div class="pt-6 border-t border-gray-200 mt-auto">
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                @csrf
            </form>
            <button onclick="confirmLogout()"
                class="w-full flex items-center px-4 py-3 rounded-xl text-red-600 hover:bg-red-50 hover:text-red-700 transition duration-200">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                    </path>
                </svg>
                <span class="font-medium">Logout</span>
            </button>
        </div>
    </nav>
</aside>

<!-- Overlay for mobile -->
<div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden hidden"></div>

@include('admin.partials.sidebar-script')
