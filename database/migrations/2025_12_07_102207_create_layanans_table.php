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
    }

    public function down(): void
    {
        Schema::dropIfExists('layanan');
    }
};
