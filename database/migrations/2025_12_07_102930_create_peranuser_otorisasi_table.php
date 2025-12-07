<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('peran_user_otorisasi', function (Blueprint $table) {
            $table->foreignId('peran_id')->constrained('peran_users')->cascadeOnDelete();
            $table->foreignId('otorisasi_id')->constrained('otorisasi')->cascadeOnDelete();
            $table->primary(['peran_id', 'otorisasi_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peran_user_otorisasi');
    }
};
