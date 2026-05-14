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
        Schema::create('validasi_laporans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('laporan_id')->constrained('laporans')->onDelete('cascade');
            $table->foreignId('admin_id')->nullable()->constrained('users')->onDelete('set null');

            $table->boolean('deskripsi_lengkap')->default(false);
            $table->boolean('foto_tersedia')->default(false);
            $table->boolean('lokasi_gps')->default(false);
            $table->boolean('lokasi_bandung')->default(false);
            $table->boolean('kategori_sesuai')->default(false);
            $table->boolean('tidak_duplikasi')->default(false);
            $table->boolean('foto_relevan')->default(false);
            $table->boolean('urgensi_sesuai')->default(false);

            $table->integer('total_passed')->default(0);
            $table->integer('total_items')->default(8);
            $table->text('keterangan_validasi')->nullable();
            $table->enum('status_validasi', ['draft', 'completed', 'approved', 'rejected'])->default('draft');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('validasi_laporans');
    }
};
