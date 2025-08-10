<!-- Top Navigation -->
<nav class="bg-white shadow-lg sticky top-0 z-40">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <button id="sidebar-toggle" class="lg:hidden text-gray-700 hover:text-primary mr-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
                <div class="flex-shrink-0">
                    <h1 class="text-xl md:text-2xl font-bold text-primary">🏥 Admin Puskesmas</h1>
                </div>
            </div>
            <div class="hidden md:flex items-center space-x-4">
               
                <span class="text-gray-700">Selamat datang, Admin</span>
                <button onclick="confirmLogout()"
                    class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md text-sm font-medium transition duration-200">
                    Logout
                </button>
            </div>
        </div>
    </div>
</nav>
