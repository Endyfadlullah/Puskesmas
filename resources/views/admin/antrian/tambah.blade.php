@extends('layouts.app')

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
                    <h1 class="text-2xl font-bold text-gray-900 mb-2">Tambah Antrian Manual</h1>
                    <p class="text-gray-600">Bantu pasien yang tidak bisa antri online dengan membuat antrian manual</p>
                </div>

                <!-- Search User Section -->
                <div class="bg-white rounded-lg shadow-sm border p-6 mb-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Cari Pasien</h2>
                    
                    <div class="flex space-x-4 mb-4">
                        <div class="flex-1">
                            <input type="text" id="searchInput" placeholder="Cari berdasarkan nama, NIK, atau nomor HP..." 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                        <button id="searchBtn" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500">
                            Cari
                        </button>
                    </div>

                    <!-- Search Results -->
                    <div id="searchResults" class="hidden">
                        <h3 class="text-md font-medium text-gray-900 mb-3">Hasil Pencarian:</h3>
                        <div id="userList" class="space-y-2"></div>
                    </div>

                    <!-- No Results Message -->
                    <div id="noResults" class="hidden text-center py-4 text-gray-500">
                        Tidak ada hasil yang ditemukan
                    </div>
                </div>

                <!-- Selected User & Poli Selection -->
                <div id="userSelection" class="hidden bg-white rounded-lg shadow-sm border p-6 mb-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Pilih Poli</h2>
                    
                    <div class="mb-4">
                        <h3 class="text-md font-medium text-gray-700 mb-2">Pasien yang dipilih:</h3>
                        <div id="selectedUserInfo" class="bg-gray-50 rounded-lg p-3"></div>
                    </div>

                    <div class="mb-4">
                        <label for="poliSelect" class="block text-sm font-medium text-gray-700 mb-2">Pilih Poli:</label>
                        <select id="poliSelect" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">Pilih Poli</option>
                            @foreach($polis as $poli)
                                <option value="{{ $poli->id }}">{{ ucfirst($poli->nama_poli) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <button id="createQueueBtn" class="w-full px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 focus:ring-2 focus:ring-green-500 disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                        Buat Antrian
                    </button>
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
let selectedUser = null;

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
    fetch('{{ route("admin.antrian.cari-user") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ search: searchTerm })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success && data.users.length > 0) {
            displaySearchResults(data.users);
        } else {
            showNoResults();
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Terjadi kesalahan saat mencari user',
            confirmButtonColor: '#EF4444'
        });
    });
}

function displaySearchResults(users) {
    const userList = document.getElementById('userList');
    const searchResults = document.getElementById('searchResults');
    const noResults = document.getElementById('noResults');
    
    userList.innerHTML = '';
    
    users.forEach(user => {
        const userDiv = document.createElement('div');
        userDiv.className = 'flex items-center justify-between p-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer';
        userDiv.innerHTML = `
            <div>
                <div class="font-medium text-gray-900">${user.nama}</div>
                <div class="text-sm text-gray-600">NIK: ${user.no_ktp} | HP: ${user.no_hp}</div>
                <div class="text-sm text-gray-500">${user.jenis_kelamin} - ${user.alamat}</div>
            </div>
            <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm" onclick="selectUser(${JSON.stringify(user).replace(/"/g, '&quot;')})">
                Pilih
            </button>
        `;
        userList.appendChild(userDiv);
    });
    
    searchResults.classList.remove('hidden');
    noResults.classList.add('hidden');
}

function showNoResults() {
    document.getElementById('searchResults').classList.add('hidden');
    document.getElementById('noResults').classList.remove('hidden');
}

function selectUser(user) {
    selectedUser = user;
    
    // Display selected user info
    const selectedUserInfo = document.getElementById('selectedUserInfo');
    selectedUserInfo.innerHTML = `
        <div class="font-medium text-gray-900">${user.nama}</div>
        <div class="text-sm text-gray-600">NIK: ${user.no_ktp} | HP: ${user.no_hp}</div>
        <div class="text-sm text-gray-500">${user.jenis_kelamin} - ${user.alamat}</div>
    `;
    
    // Show user selection section
    document.getElementById('userSelection').classList.remove('hidden');
    
    // Reset poli selection
    document.getElementById('poliSelect').value = '';
    document.getElementById('createQueueBtn').disabled = true;
    
    // Hide search results
    document.getElementById('searchResults').classList.add('hidden');
    document.getElementById('searchInput').value = '';
}

// Poli selection change
document.getElementById('poliSelect').addEventListener('change', function() {
    const createQueueBtn = document.getElementById('createQueueBtn');
    createQueueBtn.disabled = !this.value;
});

// Create queue
document.getElementById('createQueueBtn').addEventListener('click', function() {
    if (!selectedUser || !document.getElementById('poliSelect').value) {
        Swal.fire({
            icon: 'warning',
            title: 'Peringatan',
            text: 'Pilih user dan poli terlebih dahulu',
            confirmButtonColor: '#3B82F6'
        });
        return;
    }
    
    createQueue();
});

function createQueue() {
    const poliId = document.getElementById('poliSelect').value;
    
    fetch('{{ route("admin.antrian.store") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            user_id: selectedUser.id,
            poli_id: poliId
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: data.message,
                confirmButtonColor: '#10B981'
            }).then(() => {
                resetForm();
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: data.message,
                confirmButtonColor: '#EF4444'
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Terjadi kesalahan saat membuat antrian',
            confirmButtonColor: '#EF4444'
        });
    });
}

function resetForm() {
    selectedUser = null;
    document.getElementById('userSelection').classList.add('hidden');
    document.getElementById('searchResults').classList.add('hidden');
    document.getElementById('noResults').classList.add('hidden');
    document.getElementById('searchInput').value = '';
    document.getElementById('poliSelect').value = '';
    document.getElementById('createQueueBtn').disabled = true;
}
</script>

@include('admin.partials.sidebar-script')
@endsection
