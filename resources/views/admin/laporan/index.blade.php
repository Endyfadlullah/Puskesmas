
@section('title', 'Laporan Antrian - Admin Dashboard')

@section('content')
    <div class="min-h-screen bg-gray-50">
        @include('admin.partials.top-nav')

        <div class="flex">
            @include('admin.partials.sidebar')

            <!-- Main Content -->
            <div class="flex-1 lg:ml-64">
                <div class="px-4 sm:px-6 lg:px-8 py-6 md:py-8">
                    <!-- Header -->
                    <div class="mb-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <h1 class="text-2xl font-bold text-gray-900 mb-2">Laporan Antrian</h1>
                                <p class="text-gray-600">Laporan dan statistik antrian puskesmas</p>
                            </div>
                            <button onclick="exportToPDF()"
                                class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 focus:ring-2 focus:ring-red-500 transition duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                                Export PDF
                            </button>
                        </div>
                    </div>

                    <!-- Filter Section -->
                    <div class="bg-white rounded-lg shadow-sm border p-6 mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Filter Laporan</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Mulai</label>
                                <input type="date" id="tanggal_mulai" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Akhir</label>
                                <input type="date" id="tanggal_akhir" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Poli</label>
                                <select id="poli_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    <option value="">Semua Poli</option>
                                    <option value="1">Poli Umum</option>
                                    <option value="2">Poli Gigi</option>
                                    <option value="3">Poli Jiwa</option>
                                    <option value="4">Poli Tradisional</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                                <select id="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    <option value="">Semua Status</option>
                                    <option value="menunggu">Menunggu</option>
                                    <option value="dipanggil">Dipanggil</option>
                                    <option value="selesai">Selesai</option>
                                    <option value="batal">Batal</option>
                                </select>
                            </div>
                        </div>
                        <div class="mt-4 flex gap-2">
                            <button onclick="filterLaporan()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                                Filter
                            </button>
                            <button onclick="resetFilter()" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600">
                                Reset
                            </button>
                        </div>
                    </div>

                    <!-- Summary Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                        <div class="bg-white p-6 rounded-lg shadow-sm border">
                            <div class="flex items-center">
                                <div class="p-2 bg-blue-100 rounded-lg">
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-600">Total Antrian</p>
                                    <p class="text-2xl font-semibold text-gray-900">{{ $totalAntrian ?? 0 }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white p-6 rounded-lg shadow-sm border">
                            <div class="flex items-center">
                                <div class="p-2 bg-yellow-100 rounded-lg">
                                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-600">Menunggu</p>
                                    <p class="text-2xl font-semibold text-gray-900">{{ $antrianMenunggu ?? 0 }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white p-6 rounded-lg shadow-sm border">
                            <div class="flex items-center">
                                <div class="p-2 bg-green-100 rounded-lg">
                                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-600">Selesai</p>
                                    <p class="text-2xl font-semibold text-gray-900">{{ $antrianSelesai ?? 0 }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white p-6 rounded-lg shadow-sm border">
                            <div class="flex items-center">
                                <div class="p-2 bg-red-100 rounded-lg">
                                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-600">Batal</p>
                                    <p class="text-2xl font-semibold text-gray-900">{{ $antrianBatal ?? 0 }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Chart Section -->
                    <div class="bg-white rounded-lg shadow-sm border p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Grafik Antrian per Poli</h3>
                        <div class="h-64 bg-gray-50 rounded-lg flex items-center justify-center">
                            <p class="text-gray-500">Chart akan ditampilkan di sini</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // Function to filter laporan
            function filterLaporan() {
                const tanggalMulai = document.getElementById('tanggal_mulai').value;
                const tanggalAkhir = document.getElementById('tanggal_akhir').value;
                const poliId = document.getElementById('poli_id').value;
                const status = document.getElementById('status').value;

                // Reload page with filter parameters
                const params = new URLSearchParams();
                if (tanggalMulai) params.append('tanggal_mulai', tanggalMulai);
                if (tanggalAkhir) params.append('tanggal_akhir', tanggalAkhir);
                if (poliId) params.append('poli_id', poliId);
                if (status) params.append('status', status);

                window.location.href = '{{ route("admin.laporan.index") }}?' + params.toString();
            }

            // Function to reset filter
            function resetFilter() {
                document.getElementById('tanggal_mulai').value = '';
                document.getElementById('tanggal_akhir').value = '';
                document.getElementById('poli_id').value = '';
                document.getElementById('status').value = '';
                
                window.location.href = '{{ route("admin.laporan.index") }}';
            }

            // Function to export data to PDF
            function exportToPDF() {
                const params = new URLSearchParams(window.location.search);
                const tanggalMulai = params.get('tanggal_mulai') || '';
                const tanggalAkhir = params.get('tanggal_akhir') || '';
                const poliId = params.get('poli_id') || '';
                const status = params.get('status') || '';

                const url = `{{ route('admin.laporan.export-pdf') }}?tanggal_mulai=${tanggalMulai}&tanggal_akhir=${tanggalAkhir}&poli_id=${poliId}&status=${status}`;

                window.location.href = url;
            }
        </script>
    @endpush
@endsection
