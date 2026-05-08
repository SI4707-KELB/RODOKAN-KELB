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
        Schema::table('laporans', function (Blueprint $table) {
            $table->text('alamat')->after('kecamatan')->nullable();
            $table->dateTime('waktu_kejadian')->after('deskripsi')->nullable();
            $table->boolean('is_anonim')->after('user_id')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('laporans', function (Blueprint $table) {
            $table->dropColumn(['alamat', 'waktu_kejadian', 'is_anonim']);
        });
    }
};
