<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('layanan_metode_pengiriman', function (Blueprint $table) {
            $table->id();
            $table->foreignId('layanan_id')->constrained('layanan')->cascadeOnDelete();
            $table->foreignId('metode_asal_pengiriman_id')->constrained('metode_asal_pengiriman')->cascadeOnDelete();
            $table->foreignId('metode_destinasi_pengiriman_id')->constrained('metode_destinasi_pengiriman')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('layanan_metode_pengiriman');
    }
};
