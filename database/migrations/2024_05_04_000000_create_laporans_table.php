<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('laporans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('judul_laporan');
            $table->text('deskripsi')->nullable();
            $table->foreignId('kategori_id')->constrained('kategoris')->onDelete('restrict');
            $table->string('kecamatan');
            $table->enum('status', ['Menunggu', 'Terverifikasi', 'Ditolak', 'Diproses', 'Selesai', 'Darurat', 'Ditindaklanjuti'])->default('Menunggu');
            $table->enum('urgensi', ['Rendah', 'Sedang', 'Tinggi'])->default('Rendah');
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->string('foto')->nullable();
            
            // Verification fields
            $table->foreignId('admin_id')->nullable()->constrained('users')->onDelete('set null');
            $table->text('catatan_verifikasi')->nullable();
            $table->text('alasan_penolakan')->nullable();
            
            // Relasi parent untuk laporan duplikat
            $table->foreignId('duplicate_of_id')->nullable()->constrained('laporans')->onDelete('set null');
            $table->timestamp('waktu_verifikasi')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporans');
    }
};
