<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('kurir_penjemputan', function (Blueprint $table) {
            $table->foreignId('kurir_id')
                  ->constrained('users')
                  ->primary();

            $table->foreignId('penjemputan_id')
                  ->constrained('penjemputan');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penjemputan');
    }
};