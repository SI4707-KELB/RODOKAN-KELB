<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Laporan;
use App\Models\Kategori;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class AdminLaporanManagementTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;
    protected $kategori;
    protected $laporan;

    protected function setUp(): void
    {
        parent::setUp();

        // Create kategori
        $this->kategori = Kategori::create([
            'nama' => 'Banjir',
        ]);

        // Create admin user
        $this->admin = User::create([
            'name' => 'Admin Test',
            'email' => 'admin@test.com',
            'password' => bcrypt('password'),
            'phone_number' => '08123456789',
            'city' => 'Bandung',
            'role' => 'admin',
        ]);

        // Create regular user (pelapor)
        $user = User::create([
            'name' => 'User Test',
            'email' => 'user@test.com',
            'password' => bcrypt('password'),
            'phone_number' => '08987654321',
            'city' => 'Bandung',
            'role' => 'user',
        ]);

        // Create laporan
        $this->laporan = Laporan::create([
            'user_id' => $user->id,
            'judul_laporan' => 'Jalan Rusak di Jl. Sudirman',
            'deskripsi' => 'Jalan sangat rusak dan berbahaya',
            'kategori_id' => $this->kategori->id,
            'kecamatan' => 'Bandung Wetan',
            'status' => 'Menunggu',
            'urgensi' => 'Tinggi',
            'latitude' => '-6.9147',
            'longitude' => '107.6098',
        ]);
    }

    /**
     * Test 1: Admin dapat membuka halaman list laporan
     */
    public function test_admin_can_view_laporan_list()
    {
        $response = $this->actingAs($this->admin)->get('/admin/laporan');

        $response->assertStatus(200);
        $response->assertSee('Manajemen Data Laporan');
        $response->assertSee($this->laporan->judul_laporan);
    }

    /**
     * Test 2: Non-admin tidak dapat akses halaman admin laporan
     */
    public function test_non_admin_cannot_access_admin_laporan()
    {
        $user = User::create([
            'name' => 'User Test',
            'email' => 'user2@test.com',
            'password' => bcrypt('password'),
            'phone_number' => '08987654321',
            'city' => 'Bandung',
            'role' => 'user',
        ]);

        $response = $this->actingAs($user)->get('/admin/laporan');

        $response->assertRedirect('/');
    }

    /**
     * Test 3: Admin dapat melihat detail laporan
     */
    public function test_admin_can_view_laporan_detail()
    {
        $response = $this->actingAs($this->admin)
            ->get("/admin/laporan/{$this->laporan->id}");

        $response->assertStatus(200);
        $response->assertSee($this->laporan->judul_laporan);
        $response->assertSee($this->laporan->deskripsi);
        $response->assertSee('Detail Laporan');
    }

    /**
     * Test 4: Admin dapat membuka form edit laporan
     */
    public function test_admin_can_open_edit_form()
    {
        $response = $this->actingAs($this->admin)
            ->get("/admin/laporan/{$this->laporan->id}/edit");

        $response->assertStatus(200);
        $response->assertSee('Edit Laporan');
        $response->assertSee($this->laporan->judul_laporan);
    }

    /**
     * Test 5: Admin dapat mengubah status laporan
     */
    public function test_admin_can_update_laporan_status()
    {
        $response = $this->actingAs($this->admin)
            ->put("/admin/laporan/{$this->laporan->id}", [
                'status' => 'Terverifikasi',
                'catatan_verifikasi' => 'Laporan sudah diverifikasi',
                'admin_id' => $this->admin->id,
            ]);

        $response->assertRedirect("/admin/laporan/{$this->laporan->id}");

        $this->assertDatabaseHas('laporans', [
            'id' => $this->laporan->id,
            'status' => 'Terverifikasi',
            'catatan_verifikasi' => 'Laporan sudah diverifikasi',
            'admin_id' => $this->admin->id,
        ]);

        // Verify waktu_verifikasi was set
        $laporan = Laporan::find($this->laporan->id);
        $this->assertNotNull($laporan->waktu_verifikasi);
    }

    /**
     * Test 6: Admin dapat menambah catatan saat update status
     */
    public function test_admin_can_add_verification_note()
    {
        $catatan = 'Ini adalah catatan verifikasi lengkap';

        $this->actingAs($this->admin)
            ->put("/admin/laporan/{$this->laporan->id}", [
                'status' => 'Diproses',
                'catatan_verifikasi' => $catatan,
                'admin_id' => $this->admin->id,
            ]);

        $this->assertDatabaseHas('laporans', [
            'id' => $this->laporan->id,
            'catatan_verifikasi' => $catatan,
        ]);
    }

    /**
     * Test 7: Admin dapat menolak laporan dengan alasan
     */
    public function test_admin_can_reject_laporan_with_reason()
    {
        $alasan = 'Laporan tidak memiliki bukti yang cukup';

        $this->actingAs($this->admin)
            ->put("/admin/laporan/{$this->laporan->id}", [
                'status' => 'Ditolak',
                'alasan_penolakan' => $alasan,
                'admin_id' => $this->admin->id,
            ]);

        $this->assertDatabaseHas('laporans', [
            'id' => $this->laporan->id,
            'status' => 'Ditolak',
            'alasan_penolakan' => $alasan,
        ]);
    }

    /**
     * Test 8: Admin dapat menghapus laporan
     */
    public function test_admin_can_delete_laporan()
    {
        $laporanId = $this->laporan->id;

        $response = $this->actingAs($this->admin)
            ->delete("/admin/laporan/{$laporanId}");

        $response->assertRedirect('/admin/laporan');

        // Verify laporan terhapus
        $this->assertDatabaseMissing('laporans', [
            'id' => $laporanId,
        ]);
    }

    /**
     * Test 9: Admin dapat filter laporan berdasarkan status
     */
    public function test_admin_can_filter_laporan_by_status()
    {
        // Create laporan dengan status berbeda
        $laporan2 = Laporan::create([
            'user_id' => $this->laporan->user_id,
            'judul_laporan' => 'Fasilitas Rusak',
            'deskripsi' => 'Deskripsi laporan 2',
            'kategori_id' => $this->kategori->id,
            'kecamatan' => 'Bandung Utara',
            'status' => 'Selesai',
            'urgensi' => 'Rendah',
        ]);

        $response = $this->actingAs($this->admin)
            ->get('/admin/laporan?status=Selesai');

        $response->assertStatus(200);
        $response->assertSee('Fasilitas Rusak');
    }

    /**
     * Test 10: Admin dapat search laporan
     */
    public function test_admin_can_search_laporan()
    {
        $response = $this->actingAs($this->admin)
            ->get('/admin/laporan?search=Jalan%20Rusak');

        $response->assertStatus(200);
        $response->assertSee('Jalan Rusak di Jl. Sudirman');
    }

    /**
     * Test 11: Admin dapat export laporan ke CSV
     */
    public function test_admin_can_export_laporan_to_csv()
    {
        $response = $this->actingAs($this->admin)
            ->get('/admin/laporan/export/csv');

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'text/csv');
        $response->assertHeader('Content-Disposition');
        $response->assertSee('Jalan Rusak di Jl. Sudirman');
    }

    /**
     * Test 12: Laporan statistics endpoint berfungsi
     */
    public function test_admin_can_get_statistics()
    {
        $response = $this->actingAs($this->admin)
            ->get('/admin/laporan/stats/data');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'status',
            'data' => [
                'statistik' => [
                    'total',
                    'menunggu',
                    'terverifikasi',
                    'diproses',
                    'ditindaklanjuti',
                    'selesai',
                    'ditolak',
                    'darurat',
                ],
                'top_kategori',
                'top_kecamatan',
                'tren_7_hari',
            ]
        ]);
    }

    /**
     * Test 13: Update status dari Menunggu ke Terverifikasi otomatis set waktu_verifikasi
     */
    public function test_verification_time_is_set_on_status_change()
    {
        $this->actingAs($this->admin)
            ->put("/admin/laporan/{$this->laporan->id}", [
                'status' => 'Terverifikasi',
                'admin_id' => $this->admin->id,
            ]);

        $laporan = Laporan::find($this->laporan->id);
        
        $this->assertNotNull($laporan->waktu_verifikasi);
        $this->assertTrue($laporan->waktu_verifikasi->isToday());
    }

    /**
     * Test 14: Admin bisa assign admin lain untuk verifikasi
     */
    public function test_admin_can_assign_other_admin()
    {
        $admin2 = User::create([
            'name' => 'Admin 2',
            'email' => 'admin2@test.com',
            'password' => bcrypt('password'),
            'phone_number' => '08123456789',
            'city' => 'Bandung',
            'role' => 'admin',
        ]);

        $this->actingAs($this->admin)
            ->put("/admin/laporan/{$this->laporan->id}", [
                'status' => 'Diproses',
                'admin_id' => $admin2->id,
            ]);

        $this->assertDatabaseHas('laporans', [
            'id' => $this->laporan->id,
            'admin_id' => $admin2->id,
        ]);
    }

    /**
     * Test 15: Pagination works correctly
     */
    public function test_pagination_works_correctly()
    {
        // Create 20 more laporans
        Laporan::factory()->count(20)->create([
            'kategori_id' => $this->kategori->id,
        ]);

        $response = $this->actingAs($this->admin)
            ->get('/admin/laporan');

        $response->assertStatus(200);
        // Default is 15 per page
        $response->assertSee('pagination');
    }
}
