<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('peran_users', function (Blueprint $table) {
            $table->id();
            $table->string('nama')->unique();
            // $table->boolean('is_platform_admin')->default(false);
            // $table->foreignId('perusahaan_id')->nullable()->constrained('perusahaan');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peran_users');
    }
};
