<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('daftar_muat', function (Blueprint $table) {
            $table->id();
            $table->datetime('tanggal_dibuat');
            $table->datetime('tanggal_selesai')->nullable();
            $table->foreignId('counter_asal_id')->nullable()->constrained('counters');
            $table->foreignId('kendaraan_id')->constrained('kendaraan');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('daftar_muat');
    }
};
