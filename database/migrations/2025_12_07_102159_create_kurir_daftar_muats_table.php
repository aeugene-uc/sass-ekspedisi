<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('kurir_daftar_muat', function (Blueprint $table) {
            $table->foreignId('daftar_muat_id')->constrained('daftar_muat')->cascadeOnDelete();
            $table->foreignId('kurir_id')->constrained('users')->cascadeOnDelete();
            $table->primary(['daftar_muat_id', 'kurir_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kurir_daftar_muat');
    }
};
