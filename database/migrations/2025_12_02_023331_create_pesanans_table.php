<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pesanan', function (Blueprint $table) {
            $table->id();
            $table->integer('tarif');
            $table->date('tanggal_pemesanan');
            $table->date('tanggal_terkirim')->nullable();
            $table->string('foto_terkirim')->nullable();

            $table->foreignId('daftar_muat_id')->nullable()->constrained('daftar_muat');
            $table->foreignId('user_id')->constrained('users');

            $table->foreignId('metode_destinasi_pengiriman_id')->constrained('metode_destinasi_pengiriman');
            $table->foreignId('metode_asal_pengiriman_id')->constrained('metode_asal_pengiriman');

            $table->decimal('lat_asal', 10, 7);
            $table->decimal('lng_asal', 10, 7);
            $table->text('alamat_asal');

            $table->decimal('lat_destinasi', 10, 7);
            $table->decimal('lng_destinasi', 10, 7);
            $table->text('alamat_destinasi');

            $table->foreignId('status_id')->constrained('status_pesanan');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pesanan');
    }
};
