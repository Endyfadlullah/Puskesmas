<div class="space-y-6">
    <!-- User Info -->
    <div class="bg-gray-50 rounded-xl p-6">
        <h4 class="text-lg font-semibold text-gray-900 mb-4">Informasi User</h4>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                <div class="px-4 py-3 bg-white rounded-xl text-gray-900 font-medium border">
                    {{ $user->nama }}
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nomor KTP</label>
                <div class="px-4 py-3 bg-white rounded-xl text-gray-900 font-medium border">
                    {{ $user->no_ktp }}
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nomor HP</label>
                <div class="px-4 py-3 bg-white rounded-xl text-gray-900 font-medium border">
                    {{ $user->no_hp }}
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Kelamin</label>
                <div class="px-4 py-3 bg-white rounded-xl text-gray-900 font-medium border">
                    {{ $user->jenis_kelamin == 'laki-laki' ? 'Laki-laki' : 'Perempuan' }}
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Pekerjaan</label>
                <div class="px-4 py-3 bg-white rounded-xl text-gray-900 font-medium border">
                    {{ $user->pekerjaan }}
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Registrasi</label>
                <div class="px-4 py-3 bg-white rounded-xl text-gray-900 font-medium border">
                    {{ $user->created_at ? $user->created_at->format('d/m/Y H:i') : 'N/A' }}
                </div>
            </div>
        </div>

        <div class="mt-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Alamat</label>
            <div class="px-4 py-3 bg-white rounded-xl text-gray-900 font-medium border">
                {{ $user->alamat }}
            </div>
        </div>
    </div>

    <!-- Edit User Form -->
    <div class="bg-gray-50 rounded-xl p-6">
        <h4 class="text-lg font-semibold text-gray-900 mb-4">Edit Data User</h4>
        <form id="editUserForm" action="{{ route('admin.users.update', $user->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="edit_nama" class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                    <input type="text" name="nama" id="edit_nama" value="{{ $user->nama }}" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                </div>

                <div>
                    <label for="edit_no_hp" class="block text-sm font-medium text-gray-700 mb-2">Nomor HP</label>
                    <input type="tel" name="no_hp" id="edit_no_hp" value="{{ $user->no_hp }}" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                </div>

                <div>
                    <label for="edit_no_ktp" class="block text-sm font-medium text-gray-700 mb-2">Nomor KTP</label>
                    <input type="text" name="no_ktp" id="edit_no_ktp" value="{{ $user->no_ktp }}" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                </div>

                <div>
                    <label for="edit_jenis_kelamin" class="block text-sm font-medium text-gray-700 mb-2">Jenis
                        Kelamin</label>
                    <select name="jenis_kelamin" id="edit_jenis_kelamin" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                        <option value="laki-laki" {{ $user->jenis_kelamin == 'laki-laki' ? 'selected' : '' }}>
                            Laki-laki</option>
                        <option value="perempuan" {{ $user->jenis_kelamin == 'perempuan' ? 'selected' : '' }}>
                            Perempuan</option>
                    </select>
                </div>

                <div class="md:col-span-2">
                    <label for="edit_alamat" class="block text-sm font-medium text-gray-700 mb-2">Alamat</label>
                    <textarea name="alamat" id="edit_alamat" rows="3" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">{{ $user->alamat }}</textarea>
                </div>

                <div class="md:col-span-2">
                    <label for="edit_pekerjaan" class="block text-sm font-medium text-gray-700 mb-2">Pekerjaan</label>
                    <input type="text" name="pekerjaan" id="edit_pekerjaan" value="{{ $user->pekerjaan }}" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                </div>
            </div>

            <div class="flex justify-end space-x-3 pt-6">
                <button type="button" onclick="closeUserModal()"
                    class="px-6 py-3 border border-gray-300 rounded-xl text-gray-700 font-medium hover:bg-gray-50 transition duration-200">
                    Batal
                </button>
                <button type="submit"
                    class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-medium transition duration-200">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

    <!-- User Statistics -->
    <div class="bg-gray-50 rounded-xl p-6">
        <h4 class="text-lg font-semibold text-gray-900 mb-4">Statistik Antrian User</h4>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="bg-white rounded-xl p-4 border">
                <div class="text-2xl font-bold text-blue-600">
                    {{ $user->antrians->where('status', 'menunggu')->count() }}</div>
                <div class="text-sm text-gray-600">Antrian Menunggu</div>
            </div>
            <div class="bg-white rounded-xl p-4 border">
                <div class="text-2xl font-bold text-green-600">
                    {{ $user->antrians->where('status', 'selesai')->count() }}</div>
                <div class="text-sm text-gray-600">Antrian Selesai</div>
            </div>
            <div class="bg-white rounded-xl p-4 border">
                <div class="text-2xl font-bold text-red-600">{{ $user->antrians->where('status', 'batal')->count() }}
                </div>
                <div class="text-sm text-gray-600">Antrian Batal</div>
            </div>
            <div class="bg-white rounded-xl p-4 border">
                <div class="text-2xl font-bold text-gray-600">{{ $user->antrians->count() }}</div>
                <div class="text-sm text-gray-600">Total Antrian</div>
            </div>
        </div>
    </div>

    <!-- Recent Queues -->
    @if ($user->antrians->count() > 0)
        <div class="bg-gray-50 rounded-xl p-6">
            <h4 class="text-lg font-semibold text-gray-900 mb-4">Riwayat Antrian Terbaru</h4>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-white">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                No. Antrian</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Poli</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tanggal</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($user->antrians->take(5) as $antrian)
                            <tr class="hover:bg-gray-50 transition duration-200">
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <span class="text-lg font-semibold text-primary">{{ $antrian->no_antrian }}</span>
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
    @endif
</div>

<script>
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
</script>
