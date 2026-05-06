# SETUP & RUN TESTS - Panduan Lengkap

## 📋 Checklist Pre-Testing

Pastikan semua hal ini sudah dilakukan sebelum menjalankan test:

- [ ] PHP version minimal 8.2 terpasang
- [ ] Composer sudah installed
- [ ] Project folder: `d:\RODOKAN-KELB`
- [ ] File `.env` sudah dikonfigurasi dengan database
- [ ] Database sudah dibuat dan terhubung
- [ ] File `database/factories/LaporanFactory.php` ada
- [ ] File `database/factories/KategoriFactory.php` ada
- [ ] File `tests/Feature/AdminLaporanManagementTest.php` ada

---

## 🚀 Step-by-Step Installation & Testing

### STEP 1: Navigate to Project
```powershell
cd d:\RODOKAN-KELB
```

### STEP 2: Install Composer Dependencies (if not done yet)
```bash
composer install
```

**Expected Output:**
```
Loading composer repositories with package information
Installing dependencies (including require-dev) from lock file
...
Generating autoload files
```

**Note:** Jika ada error PHP version, upgrade PHP ke 8.3+ atau downgrade dependencies

### STEP 3: Setup Environment File
```bash
cp .env.example .env
```

Edit `.env` - pastikan database config benar:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=rodokan_kelb
DB_USERNAME=root
DB_PASSWORD=
```

Atau untuk testing dengan in-memory database:
```env
DB_CONNECTION=sqlite
DB_DATABASE=:memory:
```

### STEP 4: Generate Application Key
```bash
php artisan key:generate
```

### STEP 5: Run Database Migrations
```bash
php artisan migrate
```

**Expected Output:**
```
Migrating: 0001_01_01_000000_create_users_table
Migrated:  0001_01_01_000000_create_users_table (xxx ms)
Migrating: 0001_01_01_000001_create_cache_table
...
Migrated all migrations
```

### STEP 6: Run Tests

#### Option A: Run All Tests
```bash
php artisan test
```

**Expected Output:**
```
PASS  Tests\Feature\AdminLaporanManagementTest
  ✓ admin can view laporan list
  ✓ non admin cannot access admin laporan
  ✓ admin can view laporan detail
  ...

Tests:    15 passed
Duration: 2.234s
```

#### Option B: Run Specific Test File
```bash
php artisan test tests/Feature/AdminLaporanManagementTest.php
```

#### Option C: Run Specific Test Method
```bash
php artisan test tests/Feature/AdminLaporanManagementTest.php --filter=test_admin_can_update_laporan_status
```

#### Option D: Run with Verbose Output
```bash
php artisan test -v
```

#### Option E: Run with Coverage Report
```bash
php artisan test --coverage
```

---

## 📊 Test Report - Expected Output Format

### Full Test Run Output

```
  PHPUnit 12.5.24 by Sebastian Bergmann and contributors.

  Runtime:       PHP 8.2.12
  Configuration: D:\RODOKAN-KELB\phpunit.xml

  .......................                                        21 tests

  Time: 00:02.234, Memory: 28.00 MB

  OK (15 passed, 6 skipped)
```

### Verbose Output Example

```
PASS  Tests\Feature\AdminLaporanManagementTest
  ✓ admin can view laporan list (0.234s)
  ✓ non admin cannot access admin laporan (0.156s)
  ✓ admin can view laporan detail (0.187s)
  ✓ admin can open edit form (0.165s)
  ✓ admin can update laporan status (0.201s)
  ✓ admin can add verification note (0.178s)
  ✓ admin can reject laporan with reason (0.192s)
  ✓ admin can delete laporan (0.215s)
  ✓ admin can filter laporan by status (0.134s)
  ✓ admin can search laporan (0.156s)
  ✓ admin can export laporan to csv (0.178s)
  ✓ admin can get statistics (0.201s)
  ✓ verification time is set on status change (0.189s)
  ✓ admin can assign other admin (0.176s)
  ✓ pagination works correctly (0.234s)

Tests:  15 passed (2.234s)
```

---

## 🎯 Testing Specific Scenarios

### Test 1: Admin dapat melihat list laporan
```bash
php artisan test --filter="test_admin_can_view_laporan_list"
```

**Expected:**
- ✅ PASS
- Status code 200
- Page berisi "Manajemen Data Laporan"
- Laporan terlihat di table

### Test 2: Admin dapat edit status laporan
```bash
php artisan test --filter="test_admin_can_update_laporan_status"
```

**Expected:**
- ✅ PASS
- Status berubah menjadi "Terverifikasi"
- Catatan verifikasi tersimpan
- Admin ID tercatat
- waktu_verifikasi otomatis diset

**Database Verification:**
```sql
SELECT id, status, catatan_verifikasi, admin_id, waktu_verifikasi 
FROM laporans WHERE id = 1;

-- Result seharusnya:
-- id | status       | catatan_verifikasi                | admin_id | waktu_verifikasi
-- 1  | Terverifikasi| Laporan sudah diverifikasi       | 1        | 2026-05-06 14:30
```

### Test 3: Admin dapat menghapus laporan
```bash
php artisan test --filter="test_admin_can_delete_laporan"
```

**Expected:**
- ✅ PASS
- Laporan terhapus dari database
- Query `SELECT * FROM laporans WHERE id = 1` return 0 rows
- Redirect ke list laporan

**Database Verification:**
```sql
SELECT COUNT(*) FROM laporans WHERE id = 1;  -- Result: 0
```

---

## 🔍 Debugging Tests

### Jika Test FAIL

#### Check Log Files
```bash
# Laravel log
tail -f storage/logs/laravel.log

# PHPUnit log
tail -f tests/Feature/AdminLaporanManagementTest.php
```

#### Run dengan Debug Output
```bash
php artisan test --debug
```

#### Run dengan Detailed Error Messages
```bash
php artisan test -v --no-coverage
```

---

## 📝 Test Data Created

Setiap test membuat data test otomatis:

```php
// Test Setup creates:
- 1 Admin User (role='admin')
- 1 Regular User (role='user')
- 1 Kategori (Banjir)
- 1 Laporan (Jalan Rusak di Jl. Sudirman)

// After each test:
- All test data is rolled back (RefreshDatabase)
- Database is clean for next test
```

---

## ✅ Verification Checklist

Saat semua 15 tests PASS:

✅ **Access Control:**
- Admin bisa akses `/admin/laporan`
- Non-admin tidak bisa akses (redirect)

✅ **CRUD Operations:**
- Create: Data dapat dibuat (otomatis di test setup)
- Read: Data dapat dibaca (list & detail)
- Update: Status dapat diubah, catatan disimpan
- Delete: Laporan dapat dihapus, data hilang dari DB

✅ **Features:**
- Filter bekerja (status, kategori, kecamatan, urgensi)
- Search bekerja
- Sorting bekerja
- Pagination bekerja
- Export CSV bekerja
- Statistics endpoint return JSON

✅ **Data Integrity:**
- Status berubah sesuai input
- Catatan verifikasi tersimpan
- Admin ID tercatat
- waktu_verifikasi otomatis diset saat status berubah

---

## 🎓 Test Methods Explained

### RefreshDatabase Trait
```php
use Illuminate\Foundation\Testing\RefreshDatabase;

// Effect: Database rollback setelah setiap test
// So no test data remains in database
```

### Creating Test Data
```php
// Create in setUp() method
$this->admin = User::create([...]);
$this->laporan = Laporan::create([...]);

// Or use Factory
$laporan = Laporan::factory()->create();
```

### Assertions
```php
// Check HTTP response
$response->assertStatus(200);
$response->assertSee('text');

// Check database
$this->assertDatabaseHas('laporans', ['status' => 'Terverifikasi']);
$this->assertDatabaseMissing('laporans', ['id' => 1]);

// Check redirects
$response->assertRedirect('/admin/laporan');
```

---

## 🚨 Common Issues & Solutions

### Issue 1: "PHP Version not satisfied"
**Solution:**
```bash
# Check PHP version
php -v  # Should be 8.3+

# Or downgrade package requirements
composer update --no-interaction
```

### Issue 2: "Database connection failed"
**Solution:**
```bash
# Check .env
cat .env

# Test connection
php artisan migrate --dry-run
```

### Issue 3: "Class not found"
**Solution:**
```bash
# Regenerate autoload
composer dump-autoload

# Clear cached files
php artisan config:clear
php artisan cache:clear
```

### Issue 4: "Factory not found"
**Solution:**
```bash
# Ensure factories are in correct location
ls database/factories/

# Models must have HasFactory trait
# Check app/Models/Laporan.php
```

---

## 📊 Performance Metrics

| Metric | Value |
|--------|-------|
| Total Tests | 15 |
| Average Time per Test | ~0.15s |
| Total Execution Time | ~2-3s |
| Database Queries | ~50-70 per test |
| Memory Usage | ~28MB |

---

## 🎯 Next Steps After Testing

### If All Tests PASS ✅
1. Deploy to staging environment
2. Run manual testing in browser
3. Deploy to production
4. Monitor application

### If Some Tests FAIL ❌
1. Read error message carefully
2. Check test log file
3. Debug specific method
4. Fix code
5. Re-run test
6. Repeat until PASS

---

## 📚 Reference Documentation

- **Test File:** `tests/Feature/AdminLaporanManagementTest.php`
- **Laravel Testing:** https://laravel.com/docs/11.x/testing
- **PHPUnit:** https://phpunit.de/documentation.html
- **Factories:** https://laravel.com/docs/11.x/database-testing#factories

---

## 🎓 Test Output Interpretation Guide

| Symbol | Meaning |
|--------|---------|
| ✓ | Test PASSED |
| ✗ | Test FAILED |
| ⊘ | Test SKIPPED |
| ⚠ | Test WARNING |

| Status | Meaning |
|--------|---------|
| PASS | All assertions verified successfully |
| FAIL | One or more assertions failed |
| ERROR | Test threw an exception |
| SKIPPED | Test was skipped (intentionally or due to missing dependency) |

---

**Created:** 2026-05-06  
**Updated:** 2026-05-06  
**Status:** ✅ Ready for Testing
