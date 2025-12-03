<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('barang', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pesanan_id')->constrained('pesanan');
            $table->string('foto');
            $table->decimal('berat_g', 10, 2);
            $table->decimal('panjang_cm', 10, 2);
            $table->decimal('lebar_cm', 10, 2);
            $table->decimal('tinggi_cm', 10, 2);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('barang');
    }
};
