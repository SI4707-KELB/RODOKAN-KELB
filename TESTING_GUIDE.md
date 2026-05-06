# Testing Guide - Admin Laporan Management

## 📋 Test Scenario yang Dibuat

Telah dibuat **15 test cases** untuk menguji fitur admin laporan dengan Laravel Feature Tests. Berikut penjelasannya:

---

## 🧪 Test Cases

### 1. **test_admin_can_view_laporan_list**
   - **Step:** Buka dashboard admin laporan
   - **Expected:** Halaman list terload, menampilkan daftar laporan
   - **Verifikasi:** Status 200, judul laporan terlihat

### 2. **test_non_admin_cannot_access_admin_laporan**
   - **Step:** User biasa akses halaman admin
   - **Expected:** Redirect ke home
   - **Verifikasi:** Middleware protection bekerja

### 3. **test_admin_can_view_laporan_detail**
   - **Step:** Admin membuka detail laporan
   - **Expected:** Halaman detail terload dengan informasi lengkap
   - **Verifikasi:** Judul, deskripsi, dan informasi pelapor terlihat

### 4. **test_admin_can_open_edit_form**
   - **Step:** Admin membuka form edit laporan
   - **Expected:** Form edit terload dengan data laporan
   - **Verifikasi:** Form dropdown status dan input catatan terlihat

### 5. **test_admin_can_update_laporan_status** ⭐
   - **Step:** Admin mengubah status laporan
   - **Expected:** Status berubah di database, waktu verifikasi otomatis set
   - **Verifikasi:** 
     - Status di database berubah menjadi 'Terverifikasi'
     - Catatan verifikasi tersimpan
     - Admin ID tercatat

### 6. **test_admin_can_add_verification_note**
   - **Step:** Admin menambah catatan verifikasi
   - **Expected:** Catatan tersimpan
   - **Verifikasi:** Catatan ada di database

### 7. **test_admin_can_reject_laporan_with_reason**
   - **Step:** Admin menolak laporan dengan alasan
   - **Expected:** Status menjadi Ditolak, alasan tersimpan
   - **Verifikasi:** 
     - Status = 'Ditolak'
     - Alasan penolakan tersimpan

### 8. **test_admin_can_delete_laporan** 🗑️
   - **Step:** Admin menghapus laporan
   - **Expected:** Laporan terhapus dari database
   - **Verifikasi:** 
     - Laporan tidak ada di database
     - Redirect ke list laporan

### 9. **test_admin_can_filter_laporan_by_status**
   - **Step:** Admin filter laporan berdasarkan status
   - **Expected:** Hanya laporan dengan status yang dipilih ditampilkan
   - **Verifikasi:** Laporan dengan status lain tidak terlihat

### 10. **test_admin_can_search_laporan**
   - **Step:** Admin search laporan dengan keyword
   - **Expected:** Hasil pencarian sesuai keyword
   - **Verifikasi:** Laporan yang dicari muncul

### 11. **test_admin_can_export_laporan_to_csv**
   - **Step:** Admin download laporan sebagai CSV
   - **Expected:** File CSV terdownload
   - **Verifikasi:** 
     - Content-Type = text/csv
     - File berisi data laporan

### 12. **test_admin_can_get_statistics**
   - **Step:** Admin akses endpoint statistics
   - **Expected:** JSON response dengan statistik lengkap
   - **Verifikasi:** Response include semua field statistik

### 13. **test_verification_time_is_set_on_status_change**
   - **Step:** Admin ubah status dari Menunggu ke Terverifikasi
   - **Expected:** waktu_verifikasi otomatis diset hari ini
   - **Verifikasi:** waktu_verifikasi tidak null dan hari ini

### 14. **test_admin_can_assign_other_admin**
   - **Step:** Admin 1 assign admin 2 untuk verifikasi
   - **Expected:** admin_id berubah ke admin 2
   - **Verifikasi:** admin_id di database = admin 2

### 15. **test_pagination_works_correctly**
   - **Step:** System buat 20+ laporan, admin buka list
   - **Expected:** Pagination bekerja (15 per halaman)
   - **Verifikasi:** Pagination controls terlihat

---

## 🚀 Cara Menjalankan Testing

### Step 1: Install Dependencies (Jika Belum)
```bash
cd d:\RODOKAN-KELB
composer install
```

### Step 2: Setup Database Testing
Edit `.env` untuk testing atau buat `.env.testing`:
```env
DB_CONNECTION=sqlite
DB_DATABASE=:memory:
```

Atau update database config di `phpunit.xml`:
```xml
<env name="DB_CONNECTION" value="sqlite"/>
<env name="DB_DATABASE" value=":memory:"/>
```

### Step 3: Jalankan Semua Tests
```bash
php artisan test
```

### Step 4: Jalankan Test Tertentu
```bash
# Run test file ini saja
php artisan test tests/Feature/AdminLaporanManagementTest.php

# Run test tertentu
php artisan test tests/Feature/AdminLaporanManagementTest.php --filter=test_admin_can_update_laporan_status
```

### Step 5: Jalankan dengan Verbose Output
```bash
php artisan test --verbose
```

### Step 6: Jalankan dengan Detail Perubahan Database
```bash
php artisan test --debug
```

---

## 📊 Expected Output

Saat menjalankan test, Anda akan melihat output seperti:

```
PASS  Tests\Feature\AdminLaporanManagementTest
  ✓ admin can view laporan list
  ✓ non admin cannot access admin laporan
  ✓ admin can view laporan detail
  ✓ admin can open edit form
  ✓ admin can update laporan status
  ✓ admin can add verification note
  ✓ admin can reject laporan with reason
  ✓ admin can delete laporan
  ✓ admin can filter laporan by status
  ✓ admin can search laporan
  ✓ admin can export laporan to csv
  ✓ admin can get statistics
  ✓ verification time is set on status change
  ✓ admin can assign other admin
  ✓ pagination works correctly

Tests:    15 passed
Time:     2.234s
```

---

## 🔍 Test Scenarios Rinci

### Scenario 1: Buka Dashboard → Pilih Laporan

**Test Files:**
- `test_admin_can_view_laporan_list` - Buka list
- `test_admin_can_view_laporan_detail` - Pilih dan view detail

**Step by Step:**
```
1. Login as admin
2. GET /admin/laporan
3. Cari laporan "Jalan Rusak di Jl. Sudirman"
4. Click/GET /admin/laporan/{id}
5. Verify halaman detail terload
```

**Expected Result:**
- ✅ List laporan tampil dengan 15 per halaman
- ✅ Detail laporan menampilkan judul, deskripsi, pelapor
- ✅ Status 200 OK

---

### Scenario 2: Edit Laporan

**Test Files:**
- `test_admin_can_open_edit_form` - Buka form edit
- `test_admin_can_update_laporan_status` - Update status
- `test_admin_can_add_verification_note` - Tambah catatan

**Step by Step:**
```
1. Admin buka detail laporan
2. Click tombol "Edit"
3. GET /admin/laporan/{id}/edit
4. Select status baru "Terverifikasi"
5. Input catatan: "Laporan sudah diverifikasi"
6. Select admin: "Admin Test"
7. Click "Simpan Perubahan"
8. PUT /admin/laporan/{id}
9. Redirect ke detail laporan
```

**Expected Result:**
- ✅ Status laporan berubah menjadi "Terverifikasi"
- ✅ Catatan verifikasi tersimpan
- ✅ Admin ID tercatat
- ✅ waktu_verifikasi otomatis set ke hari ini
- ✅ Data di database berubah (dapat dicek dengan query)

**Database Verification:**
```sql
SELECT id, status, catatan_verifikasi, admin_id, waktu_verifikasi 
FROM laporans WHERE id = 1;
```

Result sebelum:
```
id | status   | catatan_verifikasi | admin_id | waktu_verifikasi
1  | Menunggu | NULL               | NULL     | NULL
```

Result sesudah:
```
id | status       | catatan_verifikasi                | admin_id | waktu_verifikasi
1  | Terverifikasi| Laporan sudah diverifikasi       | 1        | 2026-05-06 12:34:56
```

---

### Scenario 3: Hapus Laporan

**Test Files:**
- `test_admin_can_delete_laporan` - Delete laporan

**Step by Step:**
```
1. Admin buka list laporan
2. Cari laporan yang ingin dihapus
3. Click tombol "Trash" (🗑️)
4. Modal konfirmasi muncul: "Apakah Anda yakin ingin menghapus?"
5. Click tombol "Hapus" di modal
6. DELETE /admin/laporan/{id}
7. Redirect ke /admin/laporan
```

**Expected Result:**
- ✅ Modal konfirmasi tampil
- ✅ Laporan terhapus dari database
- ✅ Laporan tidak ada di list laporan
- ✅ Total laporan berkurang 1

**Database Verification:**
```sql
SELECT COUNT(*) FROM laporans;  -- Sebelum delete: 1, Sesudah: 0
SELECT * FROM laporans WHERE id = 1;  -- Result: 0 rows
```

---

## 🎯 Kombinasi Test Scenarios

### Full Workflow Test
```bash
php artisan test tests/Feature/AdminLaporanManagementTest.php --filter="view_laporan_list|open_edit_form|update_laporan_status|delete_laporan"
```

Scenario:
1. List laporan → Find laporan
2. View detail → Open edit
3. Change status → Save
4. Back to list → Delete
5. Verify deleted

---

## 📈 Performance Testing Notes

Saat menjalankan tests:
- Database menggunakan **in-memory SQLite** (sangat cepat)
- Setiap test otomatis rollback database (RefreshDatabase)
- Tidak ada data yang tersisa setelah test
- Total execution time: ~2-3 detik untuk 15 tests

---

## 🐛 Troubleshooting

### Error: "Class not found"
```bash
# Jalankan composer dump-autoload
composer dump-autoload
php artisan test
```

### Error: "Database not found"
```bash
# Pastikan phpunit.xml sudah configure DB
# Atau set env untuk testing
php artisan test --env=testing
```

### Error: "Factory not found"
```bash
# Pastikan Model punya HasFactory trait
# Regenerate factories
php artisan tinker
> factory(App\Models\Laporan::class)->create()
```

---

## ✅ Verification Checklist

Saat semua test PASS, berikut yang terjadi:

✅ Admin bisa akses laporan list
✅ Admin bisa view detail laporan
✅ Admin bisa membuka form edit
✅ Admin bisa mengubah status laporan
✅ Catatan verifikasi tersimpan
✅ Waktu verifikasi otomatis di-set
✅ Admin bisa menolak laporan
✅ Admin bisa menghapus laporan
✅ Data terhapus dari database
✅ Filter & search bekerja
✅ Export CSV berfungsi
✅ Statistics endpoint response dengan JSON benar
✅ Pagination works dengan 15 per halaman
✅ Non-admin tidak bisa akses
✅ Admin dapat di-assign oleh admin lain

---

## 📝 Generating Test Report

### Generate HTML Report
```bash
php artisan test --coverage-html=tests/coverage
```

### Generate Text Report
```bash
php artisan test --coverage-text
```

---

## 🎓 Reference Files

- **Test File:** `tests/Feature/AdminLaporanManagementTest.php`
- **Factory Files:** 
  - `database/factories/LaporanFactory.php`
  - `database/factories/KategoriFactory.php`
- **Controller:** `app/Http/Controllers/AdminLaporanController.php`
- **Middleware:** `app/Http/Middleware/AdminMiddleware.php`

---

**Status:** ✅ Ready untuk Testing  
**Total Test Cases:** 15  
**Expected Duration:** 2-3 detik
