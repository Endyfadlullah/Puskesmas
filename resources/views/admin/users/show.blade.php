@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50 py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Detail User</h1>
                        <p class="mt-2 text-gray-600">Kelola informasi dan data user</p>
                    </div>
                    <div class="flex space-x-3">
                        <a href="{{ route('admin.users.index') }}"
                            class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Kembali
                        </a>
                    </div>
                </div>
            </div>

            <!-- User Info Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-6">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-900">Informasi User</h2>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                            <div class="px-4 py-3 bg-gray-50 rounded-lg text-gray-900 font-medium border border-gray-200">
                                {{ $user->nama }}
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nomor KTP</label>
                            <div class="px-4 py-3 bg-gray-50 rounded-lg text-gray-900 font-medium border border-gray-200">
                                {{ $user->no_ktp }}
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nomor HP</label>
                            <div class="px-4 py-3 bg-gray-50 rounded-lg text-gray-900 font-medium border border-gray-200">
                                {{ $user->no_hp }}
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Kelamin</label>
                            <div class="px-4 py-3 bg-gray-50 rounded-lg text-gray-900 font-medium border border-gray-200">
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $user->jenis_kelamin == 'laki-laki' ? 'bg-blue-100 text-blue-800' : 'bg-pink-100 text-pink-800' }}">
                                    {{ $user->jenis_kelamin == 'laki-laki' ? 'Laki-laki' : 'Perempuan' }}
                                </span>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Pekerjaan</label>
                            <div class="px-4 py-3 bg-gray-50 rounded-lg text-gray-900 font-medium border border-gray-200">
                                {{ $user->pekerjaan }}
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Registrasi</label>
                            <div class="px-4 py-3 bg-gray-50 rounded-lg text-gray-900 font-medium border border-gray-200">
                                {{ $user->created_at ? $user->created_at->format('d/m/Y H:i') : 'N/A' }}
                            </div>
                        </div>
                    </div>

                    <div class="mt-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Alamat</label>
                        <div class="px-4 py-3 bg-gray-50 rounded-lg text-gray-900 font-medium border border-gray-200">
                            {{ $user->alamat }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Edit User Form -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-6">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-900">Edit Data User</h2>
                </div>
                <div class="p-6">
                    <form id="editUserForm" action="{{ route('admin.users.update', $user->id) }}" method="POST"
                        class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="edit_nama" class="block text-sm font-medium text-gray-700 mb-2">Nama
                                    Lengkap</label>
                                <input type="text" name="nama" id="edit_nama" value="{{ $user->nama }}" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                            </div>

                            <div>
                                <label for="edit_no_hp" class="block text-sm font-medium text-gray-700 mb-2">Nomor
                                    HP</label>
                                <input type="tel" name="no_hp" id="edit_no_hp" value="{{ $user->no_hp }}" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                            </div>

                            <div>
                                <label for="edit_no_ktp" class="block text-sm font-medium text-gray-700 mb-2">Nomor
                                    KTP</label>
                                <input type="text" name="no_ktp" id="edit_no_ktp" value="{{ $user->no_ktp }}" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                            </div>

                            <div>
                                <label for="edit_jenis_kelamin" class="block text-sm font-medium text-gray-700 mb-2">Jenis
                                    Kelamin</label>
                                <select name="jenis_kelamin" id="edit_jenis_kelamin" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                                    <option value="laki-laki" {{ $user->jenis_kelamin == 'laki-laki' ? 'selected' : '' }}>
                                        Laki-laki</option>
                                    <option value="perempuan" {{ $user->jenis_kelamin == 'perempuan' ? 'selected' : '' }}>
                                        Perempuan</option>
                                </select>
                            </div>

                            <div class="md:col-span-2">
                                <label for="edit_alamat" class="block text-sm font-medium text-gray-700 mb-2">Alamat</label>
                                <textarea name="alamat" id="edit_alamat" rows="3" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">{{ $user->alamat }}</textarea>
                            </div>

                            <div class="md:col-span-2">
                                <label for="edit_pekerjaan"
                                    class="block text-sm font-medium text-gray-700 mb-2">Pekerjaan</label>
                                <input type="text" name="pekerjaan" id="edit_pekerjaan" value="{{ $user->pekerjaan }}"
                                    required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                            </div>
                        </div>

                        <div class="flex flex-col sm:flex-row justify-end space-y-3 sm:space-y-0 sm:space-x-3 pt-6">
                            <button type="button" onclick="history.back()"
                                class="w-full sm:w-auto px-6 py-3 border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50 transition duration-200">
                                Batal
                            </button>
                            <button type="submit"
                                class="w-full sm:w-auto px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition duration-200">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Reset Password Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-6">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-900">Reset Password User</h2>
                    <p class="text-sm text-gray-600 mt-1">Buat password baru untuk user ini</p>
                </div>
                <div class="p-6">
                    <form id="resetPasswordForm" action="{{ route('admin.users.reset-password', $user->id) }}"
                        method="POST" class="space-y-6">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="new_password" class="block text-sm font-medium text-gray-700 mb-2">Password
                                    Baru</label>
                                <div class="relative">
                                    <input type="password" name="new_password" id="new_password" required minlength="8"
                                        class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                                        placeholder="Minimal 8 karakter">
                                    <button type="button" onclick="togglePassword('new_password')"
                                        class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                        <svg id="eye-icon-new" class="h-5 w-5 text-gray-400" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                            </path>
                                        </svg>
                                    </button>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">Password minimal 8 karakter</p>
                            </div>

                            <div>
                                <label for="confirm_password"
                                    class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Password</label>
                                <div class="relative">
                                    <input type="password" name="confirm_password" id="confirm_password" required
                                        minlength="8"
                                        class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                                        placeholder="Ulangi password baru">
                                    <button type="button" onclick="togglePassword('confirm_password')"
                                        class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                        <svg id="eye-icon-confirm" class="h-5 w-5 text-gray-400" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                            </path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit"
                                class="px-6 py-3 bg-red-600 hover:bg-red-700 text-white rounded-lg font-medium transition duration-200">
                                Reset Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- User Statistics -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-6">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-900">Statistik Antrian User</h2>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-4 border border-blue-200">
                            <div class="text-2xl font-bold text-blue-600">
                                {{ $user->antrians->where('status', 'menunggu')->count() }}
                            </div>
                            <div class="text-sm text-blue-700 font-medium">Antrian Menunggu</div>
                        </div>
                        <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-4 border border-green-200">
                            <div class="text-2xl font-bold text-green-600">
                                {{ $user->antrians->where('status', 'selesai')->count() }}
                            </div>
                            <div class="text-sm text-green-700 font-medium">Antrian Selesai</div>
                        </div>
                        <div class="bg-gradient-to-br from-red-50 to-red-100 rounded-xl p-4 border border-red-200">
                            <div class="text-2xl font-bold text-red-600">
                                {{ $user->antrians->where('status', 'batal')->count() }}
                            </div>
                            <div class="text-sm text-red-700 font-medium">Antrian Batal</div>
                        </div>
                        <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-xl p-4 border border-gray-200">
                            <div class="text-2xl font-bold text-gray-600">
                                {{ $user->antrians->count() }}
                            </div>
                            <div class="text-sm text-gray-700 font-medium">Total Antrian</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Queues -->
            @if ($user->antrians->count() > 0)
                <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-xl font-semibold text-gray-900">Riwayat Antrian Terbaru</h2>
                    </div>
                    <div class="p-6">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th
                                            class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            No. Antrian</th>
                                        <th
                                            class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Poli</th>
                                        <th
                                            class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Status</th>
                                        <th
                                            class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Tanggal</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($user->antrians->take(5) as $antrian)
                                        <tr class="hover:bg-gray-50 transition duration-200">
                                            <td class="px-4 py-3 whitespace-nowrap">
                                                <span
                                                    class="text-lg font-semibold text-blue-600">{{ $antrian->no_antrian }}</span>
                                            </td>
                                            <td class="px-4 py-3 whitespace-nowrap">
                                                <span
                                                    class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                                    {{ $antrian->poli->nama_poli ?? 'N/A' }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-3 whitespace-nowrap">
                                                @if ($antrian->status == 'menunggu')
                                                    <span
                                                        class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                        Menunggu
                                                    </span>
                                                @elseif($antrian->status == 'dipanggil')
                                                    <span
                                                        class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                                        Dipanggil
                                                    </span>
                                                @elseif($antrian->status == 'selesai')
                                                    <span
                                                        class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                                        Selesai
                                                    </span>
                                                @else
                                                    <span
                                                        class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                                        Batal
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                                {{ $antrian->created_at ? $antrian->created_at->format('d/m/Y H:i') : 'N/A' }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script>
        // Toggle password visibility
        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            const eyeIcon = document.getElementById(inputId === 'new_password' ? 'eye-icon-new' : 'eye-icon-confirm');

            if (input.type === 'password') {
                input.type = 'text';
                eyeIcon.innerHTML = `
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>
        `;
            } else {
                input.type = 'password';
                eyeIcon.innerHTML = `
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
        `;
            }
        }

        // Edit user form submission
        document.getElementById('editUserForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);

            fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: data.message,
                            confirmButtonText: 'OK'
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: data.message,
                            confirmButtonText: 'OK'
                        });
                    }
                })
                .catch(error => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Terjadi kesalahan saat menyimpan data',
                        confirmButtonText: 'OK'
                    });
                });
        });

        // Reset password form submission
        document.getElementById('resetPasswordForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const newPassword = document.getElementById('new_password').value;
            const confirmPassword = document.getElementById('confirm_password').value;

            if (newPassword !== confirmPassword) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Password dan konfirmasi password tidak cocok!',
                    confirmButtonText: 'OK'
                });
                return;
            }

            if (newPassword.length < 8) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Password minimal 8 karakter!',
                    confirmButtonText: 'OK'
                });
                return;
            }

            const formData = new FormData(this);

            fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: data.message,
                            confirmButtonText: 'OK'
                        }).then(() => {
                            // Clear form
                            document.getElementById('new_password').value = '';
                            document.getElementById('confirm_password').value = '';
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: data.message,
                            confirmButtonText: 'OK'
                        });
                    }
                })
                .catch(error => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Terjadi kesalahan saat reset password',
                        confirmButtonText: 'OK'
                    });
                });
        });
    </script>
@endsection
