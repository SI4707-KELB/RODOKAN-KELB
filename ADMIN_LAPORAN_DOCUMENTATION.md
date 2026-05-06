# Dokumentasi Manajemen Data Laporan - Admin Dashboard

## Daftar Isi
1. [Overview](#overview)
2. [Struktur File](#struktur-file)
3. [Fitur Utama](#fitur-utama)
4. [Instalasi & Setup](#instalasi--setup)
5. [Penggunaan](#penggunaan)
6. [API Endpoints](#api-endpoints)
7. [Contoh Kode](#contoh-kode)

---

## Overview

Fitur manajemen data laporan oleh admin memungkinkan administrator untuk mengelola seluruh data laporan yang masuk di dashboard admin. Admin dapat melihat, memfilter, mengubah status, dan menghapus laporan dengan mudah.

**Fitur Tersedia:**
- ✅ List laporan dengan pagination
- ✅ Filter laporan (status, kategori, kecamatan, urgensi, date range)
- ✅ Search laporan
- ✅ Sort laporan
- ✅ View detail laporan
- ✅ Edit status laporan
- ✅ Tambah catatan verifikasi
- ✅ Delete laporan
- ✅ Export laporan ke CSV
- ✅ Statistics & dashboard
- ✅ Bulk update status

---

## Struktur File

Berikut adalah file-file yang telah dibuat untuk fitur ini:

```
app/
├── Http/
│   ├── Controllers/
│   │   └── AdminLaporanController.php      # Controller utama
│   └── Middleware/
│       └── AdminMiddleware.php              # Middleware untuk proteksi route admin
├── Models/
│   └── Laporan.php                         # Model sudah ada
│
resources/
└── views/
    └── admin/
        └── laporan/
            ├── index.blade.php             # List laporan
            ├── show.blade.php              # Detail laporan
            └── edit.blade.php              # Form edit status

routes/
└── web.php                                  # Routes sudah diupdate

bootstrap/
└── app.php                                  # Middleware sudah didaftarkan
```

---

## Fitur Utama

### 1. **List Laporan dengan Filter**
- Tampilkan semua laporan dengan pagination (15 per halaman)
- Filter berdasarkan: Status, Kategori, Kecamatan, Urgensi, Date Range
- Search berdasarkan: Judul, Deskripsi, Nama Pelapor
- Sort berdasarkan: Judul, Status, Tanggal
- Statistik real-time: Total, Menunggu, Diproses, Ditindaklanjuti, Selesai, Ditolak

### 2. **View Detail Laporan**
- Lihat informasi lengkap laporan
- Lihat data pelapor
- Lihat admin yang melakukan verifikasi
- Timeline perubahan status
- Foto laporan dan lokasi (latitude/longitude)

### 3. **Edit Status Laporan**
- Update status laporan
- Assign admin verifikasi
- Tambahkan catatan verifikasi
- Tambahkan alasan penolakan (jika ditolak)

### 4. **Delete Laporan**
- Hapus laporan dengan konfirmasi
- Data akan dihapus dari database

### 5. **Export CSV**
- Download laporan dalam format CSV
- Include: ID, Judul, Pelapor, Email, Kategori, Kecamatan, Status, Urgensi, Tanggal, Catatan

### 6. **Statistik Dashboard**
- Total laporan
- Laporan menunggu verifikasi
- Laporan sedang diproses
- Laporan ditindaklanjuti
- Laporan selesai
- Laporan ditolak
- Laporan darurat

---

## Instalasi & Setup

### Langkah 1: Verifikasi File Database
Pastikan migrasi database sudah berjalan dan tabel `laporans`, `kategoris`, dan `users` sudah ada.

```bash
php artisan migrate
```

### Langkah 2: Update User Model
Pastikan User model sudah memiliki field `role`. Jika belum, jalankan migration:

```bash
php artisan make:migration add_role_to_users_table
```

Tambahkan ke migration:
```php
$table->string('role')->default('user'); // 'user' atau 'admin'
```

Kemudian:
```bash
php artisan migrate
```

### Langkah 3: Setup Admin User
Buat user dengan role 'admin' di database atau gunakan Tinker:

```bash
php artisan tinker
```

```php
App\Models\User::create([
    'name' => 'Admin',
    'email' => 'admin@example.com',
    'password' => bcrypt('password123'),
    'phone_number' => '08xxx',
    'city' => 'Bandung',
    'role' => 'admin'
]);
```

### Langkah 4: Update Layout Dashboard (Jika Diperlukan)
Pastikan file `resources/views/layouts/dashboard.blade.php` sudah ada dan memiliki struktur dasar.

Contoh struktur minimal:
```html
<!DOCTYPE html>
<html>
<head>
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="/">Dashboard</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @auth
                        @if(auth()->user()->role === 'admin')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.laporan.index') }}">Manajemen Laporan</a>
                            </li>
                        @endif
                        <li class="nav-item">
                            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                                @csrf
                                <button class="btn btn-sm btn-danger">Logout</button>
                            </form>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="py-4">
        <div class="container-fluid">
            @yield('content')
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
```

---

## Penggunaan

### Akses Menu Admin Laporan
1. Login dengan user yang memiliki `role = 'admin'`
2. Navigasi ke: `/admin/laporan`

### Filter Laporan
1. Pilih kriteria filter (Status, Kategori, Kecamatan, Urgensi, Date Range)
2. Masukkan kata kunci search (optional)
3. Klik tombol "Filter"
4. Hasil akan di-update sesuai filter

### View Detail Laporan
1. Klik tombol "Eye" (👁️) di bagian "Aksi"
2. Atau klik langsung pada judul laporan

### Edit Status Laporan
1. Dari halaman list, klik tombol "Pencil" (✏️) di bagian "Aksi"
2. Atau dari halaman detail, klik tombol "Edit"
3. Ubah status, assign admin, dan tambahkan catatan
4. Klik "Simpan Perubahan"

### Delete Laporan
1. Klik tombol "Trash" (🗑️) di bagian "Aksi"
2. Konfirmasi hapus
3. Laporan akan dihapus

### Export Laporan
1. (Optional) Atur filter sesuai yang diinginkan
2. Klik tombol "Export CSV" di bagian atas
3. File CSV akan diunduh

---

## API Endpoints

Berikut adalah endpoint yang tersedia:

| Method | Route | Controller | Function | Deskripsi |
|--------|-------|-----------|----------|-----------|
| GET | `/admin/laporan` | AdminLaporanController | index | List laporan |
| GET | `/admin/laporan/{id}` | AdminLaporanController | show | Detail laporan |
| GET | `/admin/laporan/{id}/edit` | AdminLaporanController | edit | Form edit |
| PUT | `/admin/laporan/{id}` | AdminLaporanController | update | Update laporan |
| DELETE | `/admin/laporan/{id}` | AdminLaporanController | destroy | Delete laporan |
| POST | `/admin/laporan/bulk-update` | AdminLaporanController | bulkUpdate | Update massal |
| GET | `/admin/laporan/stats/data` | AdminLaporanController | getStats | Statistics JSON |
| GET | `/admin/laporan/export/csv` | AdminLaporanController | export | Export CSV |

---

## Contoh Kode

### Menggunakan Routes
```php
// List laporan
{{ route('admin.laporan.index') }}

// View detail
{{ route('admin.laporan.show', $laporan->id) }}

// Edit form
{{ route('admin.laporan.edit', $laporan->id) }}

// Export CSV
{{ route('admin.laporan.export', request()->query()) }}

// Statistics
{{ route('admin.laporan.stats') }}
```

### Menggunakan Controller Method
```php
// Di dalam Controller atau View
$laporan = Laporan::find($id);

// Get statistics
$response = AdminLaporanController::getStats();

// Filter laporan
$laporan = Laporan::where('status', 'Menunggu')
    ->where('urgensi', 'Darurat')
    ->get();
```

### Query Custom
```php
use App\Models\Laporan;
use Carbon\Carbon;

// Laporan menunggu verifikasi
$menunggu = Laporan::where('status', 'Menunggu')->count();

// Laporan hari ini
$hariIni = Laporan::whereDate('created_at', Carbon::today())->count();

// Laporan per kategori
$perKategori = Laporan::select('kategoris.nama', DB::raw('count(*) as total'))
    ->join('kategoris', 'laporans.kategori_id', '=', 'kategoris.id')
    ->groupBy('kategoris.nama')
    ->get();

// Laporan darurat
$darurat = Laporan::where('urgensi', 'Darurat')->get();
```

---

## File Migrasi & Model Reference

### Model Laporan Fields
```php
protected $fillable = [
    'user_id',              // ID user (pelapor)
    'judul_laporan',        // Judul laporan
    'deskripsi',            // Deskripsi detail
    'kategori_id',          // ID kategori
    'kecamatan',            // Nama kecamatan
    'status',               // Status: Menunggu, Terverifikasi, Diproses, Ditindaklanjuti, Selesai, Ditolak
    'urgensi',              // Urgensi: Rendah, Sedang, Tinggi, Darurat
    'latitude',             // Latitude lokasi
    'longitude',            // Longitude lokasi
    'foto',                 // Path foto
    'admin_id',             // ID admin verifikasi
    'catatan_verifikasi',   // Catatan dari admin
    'alasan_penolakan',     // Alasan jika ditolak
    'waktu_verifikasi',     // Waktu verifikasi
];
```

### Relationships
```php
// Hubungan dengan User (Pelapor)
$laporan->user;

// Hubungan dengan Admin
$laporan->admin;

// Hubungan dengan Kategori
$laporan->kategori;
```

---

## Troubleshooting

### Error: "Anda tidak memiliki akses ke halaman ini"
- Pastikan user memiliki `role = 'admin'`
- Check middleware registration di `bootstrap/app.php`

### Routes tidak terdaftar
- Jalankan `php artisan route:list` untuk melihat semua routes
- Pastikan routes sudah di-update di `routes/web.php`

### View tidak ditemukan
- Pastikan direktori `resources/views/admin/laporan/` sudah ada
- Pastikan layout `resources/views/layouts/dashboard.blade.php` sudah ada

### Database error
- Jalankan `php artisan migrate` untuk memastikan semua table ada
- Check koneksi database di `.env`

---

## Tips & Best Practices

1. **Security**: Middleware `AdminMiddleware` sudah melindungi routes admin
2. **Performance**: Query sudah menggunakan `with()` untuk eager loading
3. **Usability**: Fitur filter dan search untuk kemudahan admin
4. **Data Export**: CSV export untuk analisis lebih lanjut
5. **Audit**: Catatan verifikasi dan waktu verifikasi tersimpan otomatis

---

## Kontribusi

Untuk pengembangan lebih lanjut, dapat ditambahkan:
- Statistics chart/graph
- Email notification ke pelapor
- Assigned staff untuk follow-up
- Activity log
- Advanced filtering dengan date range lebih kompleks
- Bulk import laporan
- Integration dengan Google Maps API

---

**Created:** 2026-05-06  
**Version:** 1.0  
**Author:** Admin System
