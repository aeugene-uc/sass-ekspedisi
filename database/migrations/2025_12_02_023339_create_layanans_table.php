<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('layanan', function (Blueprint $table) {
            $table->id();
            $table->string('nama')->unique();
            $table->string('gambar');
            $table->string('model_harga')->unique();
            $table->foreignId('perusahaan_id')->constrained('perusahaan');
        });

        Schema::create('layanan_jangkauan', function (Blueprint $table) {
            $table->foreignId('layanan_id')->constrained('layanan');
            $table->foreignId('jangkauan_id')->constrained('jangkauan');
        });

        Schema::create('layanan_metode_pengiriman', function (Blueprint $table) {
            $table->foreignId('layanan_id')->constrained('layanan');
            $table->foreignId('metode_asal_pengiriman_id')->constrained('metode_asal_pengiriman');
            $table->foreignId('metode_destinasi_pengiriman_id')->constrained('metode_destinasi_pengiriman');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('layanan');
        Schema::dropIfExists('layanan_jangkauan');
        Schema::dropIfExists('layanan_metode_pengiriman');
    }
};
