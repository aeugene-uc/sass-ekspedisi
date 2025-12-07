<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('layanan_jangkauan', function (Blueprint $table) {
            $table->foreignId('layanan_id')->constrained('layanan')->cascadeOnDelete();
            $table->foreignId('jangkauan_id')->constrained('jangkauan')->cascadeOnDelete();
            $table->primary(['layanan_id', 'jangkauan_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('layanan_jangkauan');
    }
};
