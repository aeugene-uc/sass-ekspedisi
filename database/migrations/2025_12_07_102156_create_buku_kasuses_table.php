<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('buku_kasus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pesanan_id')->constrained('pesanan')->cascadeOnDelete();
            $table->text('kasus');
            $table->text('foto')->nullable();
            $table->datetime('tanggal_dibuat');
            $table->datetime('tanggal_selesai')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('buku_kasus');
    }
};
