<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('kendaraan', function (Blueprint $table) {
            $table->id();
            $table->string('plat_nomor');
            $table->boolean('operasional');
            $table->foreignId('jenis_kendaraan_id')->constrained('jenis_kendaraan');
            $table->foreignId('perusahaan_id')->constrained('perusahaan');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kendaraan');
    }
};
