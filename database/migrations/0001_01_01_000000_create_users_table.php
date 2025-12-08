<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            $table->string('full_name');
            $table->string('email')->unique();
            $table->string('password');
            $table->boolean('is_platform_admin')->default(false);
            $table->foreignId('peran_id')->constrained('peran_users');
            $table->foreignId('perusahaan_id')->nullable()->constrained('perusahaan');

            // Optional FK examples:
            // $table->foreignId('company_id')->nullable()->constrained();

            $table->rememberToken(); // required for "remember me"
            // NO timestamps
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
