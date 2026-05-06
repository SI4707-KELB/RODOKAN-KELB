# Setup Checklist - Manajemen Data Laporan Admin

## ✅ Pre-Installation Checklist

Sebelum menggunakan fitur ini, pastikan hal-hal berikut sudah dikonfigurasi:

### Database & Migrations
- [ ] Database sudah terhubung dengan baik
- [ ] `php artisan migrate` sudah dijalankan
- [ ] Tabel `users` memiliki field `role` (varchar, default: 'user')
- [ ] Tabel `laporans` sudah ada dengan semua field
- [ ] Tabel `kategoris` sudah ada
- [ ] Relationships sudah benar di model

### Models
- [ ] `User` model sudah memiliki field `role`
- [ ] `Laporan` model sudah memiliki relationships dengan User, Admin, dan Kategori
- [ ] `Kategori` model sudah ada

### Routes
- [ ] Routes untuk admin laporan sudah didaftarkan di `routes/web.php`
- [ ] Prefix `/admin/laporan` sudah benar
- [ ] Middleware `admin` sudah diterapkan

### Middleware
- [ ] File `app/Http/Middleware/AdminMiddleware.php` sudah dibuat
- [ ] Middleware sudah didaftarkan di `bootstrap/app.php`
- [ ] Middleware logic sudah benar

### Views
- [ ] Direktori `resources/views/admin/laporan/` sudah ada
- [ ] File `index.blade.php` sudah ada
- [ ] File `show.blade.php` sudah ada
- [ ] File `edit.blade.php` sudah ada
- [ ] Layout `resources/views/layouts/dashboard.blade.php` sudah ada

### Controllers
- [ ] File `app/Http/Controllers/AdminLaporanController.php` sudah ada
- [ ] Semua methods sudah diimplementasikan dengan benar

---

## 🚀 Installation Steps

### Step 1: Database Setup
```bash
# Jalankan migrasi jika belum
php artisan migrate

# (Optional) Jika butuh menambah field role ke users
php artisan make:migration add_role_to_users_table --table=users
# Edit migration dan jalankan: php artisan migrate
```

### Step 2: Create Admin User
```bash
php artisan tinker
```

Kemudian di Tinker shell:
```php
App\Models\User::create([
    'name' => 'Admin Bandung',
    'email' => 'admin@bandung.com',
    'password' => bcrypt('password123'),
    'phone_number' => '08123456789',
    'city' => 'Bandung',
    'role' => 'admin'
]);
exit
```

### Step 3: Verify Files
```bash
# Check if controller exists
ls app/Http/Controllers/AdminLaporanController.php

# Check if middleware exists
ls app/Http/Middleware/AdminMiddleware.php

# Check if views exist
ls resources/views/admin/laporan/
```

### Step 4: Test Routes
```bash
php artisan route:list | grep admin.laporan
```

Seharusnya tampil:
```
GET|HEAD  /admin/laporan                       admin.laporan.index
GET|HEAD  /admin/laporan/{id}                  admin.laporan.show
GET|HEAD  /admin/laporan/{id}/edit             admin.laporan.edit
PUT       /admin/laporan/{id}                  admin.laporan.update
DELETE    /admin/laporan/{id}                  admin.laporan.destroy
POST      /admin/laporan/bulk-update           admin.laporan.bulk-update
GET|HEAD  /admin/laporan/stats/data            admin.laporan.stats
GET|HEAD  /admin/laporan/export/csv            admin.laporan.export
```

### Step 5: Start Development Server
```bash
php artisan serve
```

---

## 🧪 Testing Checklist

### Authentication Test
- [ ] Login dengan user biasa (role: user) - harus ditolak
- [ ] Login dengan admin user (role: admin) - harus berhasil
- [ ] Akses `/admin/laporan` - harus bisa lihat list

### Functionality Test
- [ ] List laporan menampilkan data dengan benar
- [ ] Statistik menampilkan angka yang benar
- [ ] Filter by status berfungsi
- [ ] Filter by kategori berfungsi
- [ ] Filter by kecamatan berfungsi
- [ ] Search berfungsi
- [ ] Pagination berfungsi
- [ ] Sort by status/judul/tanggal berfungsi
- [ ] View detail laporan berfungsi
- [ ] Edit status laporan berfungsi
- [ ] Delete laporan berfungsi (dengan konfirmasi)
- [ ] Export CSV berfungsi

### UI/UX Test
- [ ] Layout responsif (mobile, tablet, desktop)
- [ ] Warna status badge sesuai
- [ ] Icon menampilkan dengan benar
- [ ] Button-button accessible dan jelas
- [ ] Form validation berfungsi
- [ ] Alert success/error menampilkan dengan benar

---

## 📋 Database Query Reference

### Check Admin Users
```sql
SELECT id, name, email, role FROM users WHERE role = 'admin';
```

### Count Reports by Status
```sql
SELECT status, COUNT(*) as total FROM laporans GROUP BY status;
```

### Count Reports Today
```sql
SELECT COUNT(*) FROM laporans WHERE DATE(created_at) = CURDATE();
```

### Check Report with Details
```sql
SELECT 
    l.id, 
    l.judul_laporan, 
    u.name as pelapor, 
    k.nama as kategori, 
    l.status,
    l.urgensi
FROM laporans l
JOIN users u ON l.user_id = u.id
LEFT JOIN kategoris k ON l.kategori_id = k.id
ORDER BY l.created_at DESC
LIMIT 10;
```

---

## 🔧 Configuration Notes

### Status Values
Laporan dapat memiliki status:
- `Menunggu` - Menunggu verifikasi admin
- `Terverifikasi` - Sudah diverifikasi, valid
- `Diproses` - Sedang dalam proses penanganan
- `Ditindaklanjuti` - Sudah ditindaklanjuti/ada aksi
- `Selesai` - Penanganan selesai
- `Ditolak` - Laporan ditolak (invalid)

### Urgency Values
Laporan dapat memiliki urgensi:
- `Rendah` - Tidak urgent
- `Sedang` - Moderate urgency
- `Tinggi` - High priority
- `Darurat` - Critical/emergency

---

## 🐛 Troubleshooting Guide

### Problem: Middleware error
**Solution:**
1. Check `bootstrap/app.php` sudah register middleware
2. Run: `php artisan config:clear`
3. Restart server

### Problem: Routes not found
**Solution:**
1. Run: `php artisan route:clear`
2. Check `routes/web.php` sudah update
3. Verify prefix and middleware

### Problem: Views not found
**Solution:**
1. Check directory path: `resources/views/admin/laporan/`
2. Verify layout: `resources/views/layouts/dashboard.blade.php`
3. Run: `php artisan view:clear`

### Problem: Database errors
**Solution:**
1. Check `.env` database configuration
2. Run: `php artisan migrate`
3. Verify table structure: `php artisan tinker` → `Schema::getColumns('laporans')`

### Problem: Admin user can't access
**Solution:**
1. Verify user `role = 'admin'` in database
2. Check middleware logic in `AdminMiddleware.php`
3. Logout and login kembali

---

## 📝 Important Files Summary

| File | Purpose | Status |
|------|---------|--------|
| `app/Http/Controllers/AdminLaporanController.php` | Main controller | ✅ Created |
| `app/Http/Middleware/AdminMiddleware.php` | Route protection | ✅ Created |
| `resources/views/admin/laporan/index.blade.php` | List view | ✅ Created |
| `resources/views/admin/laporan/show.blade.php` | Detail view | ✅ Created |
| `resources/views/admin/laporan/edit.blade.php` | Edit view | ✅ Created |
| `routes/web.php` | Routes config | ✅ Updated |
| `bootstrap/app.php` | Middleware registration | ✅ Updated |

---

## 📞 Support Notes

Jika menemui issues:
1. Check error logs: `storage/logs/laravel.log`
2. Enable debug mode di `.env`: `APP_DEBUG=true`
3. Check database connection
4. Verify file permissions
5. Clear all caches: `php artisan optimize:clear`

---

**Last Updated:** 2026-05-06  
**Status:** Ready for Implementation
