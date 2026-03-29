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
        Schema::create('feedback', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->enum('role', ['mahasiswa', 'dosen', 'staf']);
            $table->integer('rating_facility')->comment('1-5 Bintang untuk Fasilitas/Aset');
            $table->integer('rating_service')->comment('1-5 Bintang untuk Layanan Sarpras');
            $table->text('comments')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feedback');
    }
};
