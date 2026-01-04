<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('penjemputan', function (Blueprint $table) {
            $table->id();
            $table->dateTime('tanggal_dibuat');
            $table->dateTime('tanggal_selesai')->nullable();
            $table->foreignId('counter_destinasi_id')->constrained('counters');
            $table->foreignId('kendaraan_id')->constrained('kendaraan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penjemputan');
    }
};
