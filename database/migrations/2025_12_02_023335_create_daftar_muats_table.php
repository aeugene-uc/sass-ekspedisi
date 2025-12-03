<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('daftar_muat', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_dibuat');
            $table->date('tanggal_selesai')->nullable();
            $table->foreignId('counter_asal_id')->nullable()->constrained('counter');
            $table->foreignId('kendaraan_id')->constrained('kendaraan');
        });

        Schema::create('kurir_daftar_muat', function (Blueprint $table) {
            $table->foreignId('daftar_muat_id')->primary()->constrained('daftar_muat');
            $table->foreignId('kurir_id')->constrained('users');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('daftar_muat');
        Schema::dropIfExists('kurir_daftar_muat');
    }
};
