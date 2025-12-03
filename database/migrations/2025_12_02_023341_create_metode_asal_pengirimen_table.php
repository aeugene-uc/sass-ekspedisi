<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('metode_asal_pengiriman', function (Blueprint $table) {
            $table->id();
            $table->string('nama')->unique();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('metode_asal_pengiriman');
    }
};
