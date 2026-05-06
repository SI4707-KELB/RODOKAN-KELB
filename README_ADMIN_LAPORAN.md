# Quick Start - Manajemen Data Laporan Admin

## 📌 Apa yang Sudah Dibuat?

Sistem manajemen data laporan untuk admin dashboard dengan fitur:
- ✅ List laporan dengan filter & search
- ✅ View detail laporan
- ✅ Edit status laporan
- ✅ Delete laporan
- ✅ Export CSV
- ✅ Statistics & dashboard
- ✅ Role-based access control (middleware)

---

## 🚀 Mulai Menggunakan

### 1. Pastikan User Admin Sudah Ada

```bash
php artisan tinker
```

```php
App\Models\User::create([
    'name' => 'Admin',
    'email' => 'admin@example.com',
    'password' => bcrypt('admin123'),
    'phone_number' => '08123456789',
    'city' => 'Bandung',
    'role' => 'admin'  # ← Important!
]);
exit
```

### 2. Akses Admin Laporan
1. Login dengan user admin
2. Kunjungi: `http://localhost:8000/admin/laporan`

### 3. Gunakan Fitur

#### List & Filter
- Pilih filter (status, kategori, kecamatan, urgensi)
- Gunakan search untuk mencari judul/pelapor
- Klik "Filter" untuk apply

#### View Detail
- Klik tombol 👁️ (eye) untuk lihat detail
- Atau klik judul laporan langsung

#### Edit Status
- Klik tombol ✏️ (pencil)
- Ubah status dan catatan
- Klik "Simpan Perubahan"

#### Delete
- Klik tombol 🗑️ (trash)
- Konfirmasi delete

#### Export
- Klik tombol "Export CSV"
- File akan diunduh

---

## 📂 File Structure

```
Created:
├── app/Http/Controllers/AdminLaporanController.php
├── app/Http/Middleware/AdminMiddleware.php
├── resources/views/admin/laporan/
│   ├── index.blade.php
│   ├── show.blade.php
│   └── edit.blade.php
└── ADMIN_LAPORAN_DOCUMENTATION.md

Updated:
├── routes/web.php (Added admin routes)
└── bootstrap/app.php (Added middleware)
```

---

## 🔗 Routes

| URL | Method | Purpose |
|-----|--------|---------|
| `/admin/laporan` | GET | List laporan |
| `/admin/laporan/{id}` | GET | Detail laporan |
| `/admin/laporan/{id}/edit` | GET | Form edit |
| `/admin/laporan/{id}` | PUT | Update laporan |
| `/admin/laporan/{id}` | DELETE | Delete laporan |
| `/admin/laporan/export/csv` | GET | Export CSV |
| `/admin/laporan/stats/data` | GET | Get statistics |

---

## 📱 Integrasi di Navigation

Tambahkan link ini di navigation/menu Anda:

**Untuk Admin User:**
```html
@if(auth()->user()->role === 'admin')
    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.laporan.index') }}">
            <i class="bi bi-clipboard-data"></i> Manajemen Laporan
        </a>
    </li>
@endif
```

---

## 🔐 Security

- Protected dengan middleware `AdminMiddleware`
- Hanya user dengan `role = 'admin'` bisa akses
- CSRF protection di semua form
- Method spoofing untuk DELETE

---

## 💡 Tips

1. **Bulk Edit**: Rencana untuk menambah fitur bulk update status di masa depan
2. **Statistics**: Statistics card menampilkan real-time data
3. **Export**: Export CSV bisa difilter sesuai kebutuhan
4. **Responsive**: UI responsif untuk semua ukuran layar

---

## ❓ FAQ

**Q: User saya tidak bisa akses admin laporan?**  
A: Pastikan user memiliki `role = 'admin'` di database

**Q: Bagaimana cara menambah admin baru?**  
A: Update field `role` user ke `'admin'` atau create user baru dengan role admin

**Q: Bisa bulk edit laporan?**  
A: Belum, tapi sudah disiapkan method `bulkUpdate` di controller

**Q: Format export apa?**  
A: CSV (Comma Separated Values) - bisa dibuka dengan Excel, Google Sheets, dll

---

## 📖 Documentation Files

- `ADMIN_LAPORAN_DOCUMENTATION.md` - Dokumentasi lengkap
- `SETUP_CHECKLIST.md` - Checklist setup & troubleshooting
- `README_ADMIN_LAPORAN.md` - File ini (quick reference)

---

## 🎯 Next Steps (Optional)

Fitur yang bisa ditambahkan:
- [ ] Statistics charts (Chart.js / ApexCharts)
- [ ] Email notification ke pelapor
- [ ] Assigned staff untuk follow-up
- [ ] Activity log
- [ ] Advanced filtering dengan multiple date ranges
- [ ] Bulk import laporan (CSV upload)
- [ ] Integration dengan Google Maps API
- [ ] Reporting & analytics dashboard

---

**Status:** ✅ Ready for Use  
**Last Updated:** 2026-05-06
