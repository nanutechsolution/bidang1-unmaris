<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('key')->unique(); // Cth: 'pimpinan_nidn'
            $table->text('value')->nullable(); // Menyimpan data (bisa JSON)
            $table->string('label'); // Nama yang muncul di UI
            $table->string('type')->default('text'); // text, array, boolean
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};