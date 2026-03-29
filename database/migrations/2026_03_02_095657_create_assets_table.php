<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('asset_code', 50)->unique()->comment('Kode unik/Barcode Aset');
            $table->string('name', 150);

            // Relasi Master Data
            $table->foreignUuid('category_id')->constrained('asset_categories')->restrictOnDelete();
            $table->foreignUuid('location_id')->constrained('locations')->restrictOnDelete();

            // Nilai & Waktu
            $table->date('purchase_date');
            $table->decimal('price', 15, 2)->default(0);

            // Status & Kondisi menggunakan string/enum (disarankan string di Laravel modern + Validation)
            $table->string('status', 30)->default('active')->comment('active, maintenance, disposed, lost');
            $table->string('condition', 30)->default('good')->comment('good, fair, poor, broken');

            $table->text('notes')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Indexing: Sangat penting untuk fitur Filter & Search di Dashboard agar tidak N+1/Lemot
            $table->index(['status', 'condition']);
            $table->index('purchase_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};
