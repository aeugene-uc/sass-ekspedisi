<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('counters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('perusahaan_id')->constrained('perusahaan');
            $table->string('alamat');
            $table->string('nama');
            $table->decimal('lat');
            $table->decimal('lng');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('counters');
    }
};
