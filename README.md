# Sistem Antrian Puskesmas

Sistem antrian digital untuk Puskesmas yang dibangun dengan Laravel dan Tailwind CSS.

## 🚀 Fitur

- **Landing Page** - Halaman utama yang menarik dengan informasi layanan
- **Sistem Login/Register** - Autentikasi pengguna dengan validasi
- **Dashboard Admin** - Panel admin untuk mengelola antrian
- **Display Antrian** - Layar display untuk menampilkan antrian yang sedang dipanggil
- **Responsive Design** - Tampilan yang responsif untuk semua perangkat

## 🛠️ Teknologi

- **Backend**: Laravel 11
- **Frontend**: Tailwind CSS
- **Database**: MySQL
- **Authentication**: Laravel Built-in Auth

## 📋 Struktur Database

### Tabel Users
- `id` - Primary Key
- `nama` - Nama lengkap pasien
- `alamat` - Alamat pasien
- `jenis_kelamin` - Laki-laki/Perempuan
- `no_hp` - Nomor HP
- `no_ktp` - Nomor KTP (unique)
- `poli_id` - Foreign key ke tabel polis
- `pekerjaan` - Pekerjaan pasien
- `password` - Password untuk login
- `remember_token` - Token untuk remember me

### Tabel Polis
- `id` - Primary Key
- `nama_poli` - Nama poli (umum, gigi, kesehatan jiwa, kesehatan tradisional)

### Tabel Lokets
- `id` - Primary Key
- `nama_loket` - Nama loket

### Tabel Antrians
- `id` - Primary Key
- `user_id` - Foreign key ke users
- `no_antrian` - Nomor antrian
- `tanggal_antrian` - Tanggal antrian
- `is_call` - Status dipanggil
- `status` - Status antrian (menunggu, dipanggil, selesai, batal)
- `waktu_panggil` - Waktu dipanggil
- `loket_id` - Foreign key ke lokets

### Tabel Riwayat Panggilan
- `id` - Primary Key
- `antrian_id` - Foreign key ke antrians
- `waktu_panggilan` - Waktu panggilan

## 🚀 Instalasi

1. **Clone repository**
   ```bash
   git clone <repository-url>
   cd Puskesmas
   ```

2. **Install dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Setup environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Konfigurasi database**
   - Edit file `.env` dan sesuaikan konfigurasi database
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=puskesmas
   DB_USERNAME=root
   DB_PASSWORD=
   ```

5. **Jalankan migrasi dan seeder**
   ```bash
   php artisan migrate:fresh --seed
   ```

6. **Jalankan server development**
   ```bash
   php artisan serve
   ```

## 📱 Halaman yang Tersedia

### 1. Landing Page (`/`)
- Halaman utama dengan informasi layanan
- Navigasi ke login dan register
- Informasi tentang cara kerja sistem

### 2. Login (`/login`)
- Form login dengan email dan password
- Remember me functionality
- Link ke halaman register

### 3. Register (`/register`)
- Form pendaftaran dengan data lengkap
- Validasi input
- Pilihan poli

### 4. Dashboard (`/dashboard`)
- Panel admin dengan statistik
- Quick actions untuk mengelola antrian
- Tabel antrian terbaru
- Logout functionality

### 5. Display (`/display`)
- Layar display untuk antrian
- Auto-refresh setiap 5 detik
- Tampilan antrian per poli
- Antrian berikutnya

## 👤 Akun Default

Setelah menjalankan seeder, tersedia akun default:

**Admin:**
- Username: `admin`
- Password: `password`

**User:**
- Nama: `Budi Santoso`
- No KTP: `1234567890123456`
- Password: `password`

## 🎨 Customization

### Warna
Sistem menggunakan warna custom yang dapat diubah di `resources/views/layouts/app.blade.php`:

```javascript
tailwind.config = {
    theme: {
        extend: {
            colors: {
                primary: '#3B82F6',    // Blue
                secondary: '#1E40AF',   // Dark Blue
                accent: '#10B981'       // Green
            }
        }
    }
}
```

### Layout
Layout utama dapat dimodifikasi di `resources/views/layouts/app.blade.php`

## 🔧 Development

### Menambah Poli Baru
1. Tambahkan data di seeder `AntrianPuskesmasSeeder.php`
2. Update controller `DisplayController.php` untuk menampilkan poli baru
3. Update view `display/index.blade.php` untuk menampilkan poli baru

### Menambah Fitur Baru
1. Buat controller baru di `app/Http/Controllers/`
2. Buat view di `resources/views/`
3. Tambahkan route di `routes/web.php`
4. Update navigasi di layout

## 📊 Monitoring

Sistem menyediakan monitoring real-time untuk:
- Total pasien terdaftar
- Antrian yang sedang menunggu
- Antrian yang sudah selesai
- Poli yang aktif

## 🔒 Security

- Password di-hash menggunakan bcrypt
- CSRF protection aktif
- Validasi input pada semua form
- Session management yang aman

## 📞 Support

Untuk bantuan atau pertanyaan, silakan hubungi:
- Email: support@puskesmas.com
- Phone: (021) 1234-5678

## 📄 License

Proyek ini dilisensikan di bawah MIT License.

---

**Dibuat dengan ❤️ untuk Puskesmas**
