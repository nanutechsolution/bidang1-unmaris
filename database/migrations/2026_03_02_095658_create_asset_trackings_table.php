<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('asset_trackings', function (Blueprint $table) {
            $table->uuid('id')->primary();
            
            // Jika aset dihapus permanen, riwayatnya juga ikut terhapus (cascade)
            $table->foreignUuid('asset_id')->constrained('assets')->cascadeOnDelete();
            
            // Relasi ke user yang melakukan perubahan (menggunakan tabel users bawaan Laravel)
            $table->foreignUuid('user_id')->nullable()->constrained('users')->nullOnDelete();
            
            $table->string('action', 50)->comment('created, updated, moved, status_changed');
            $table->text('notes')->nullable();
            
            // Menyimpan state sebelum dan sesudah perubahan (berguna untuk audit)
            $table->json('previous_state')->nullable();
            $table->json('new_state')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asset_trackings');
    }
};