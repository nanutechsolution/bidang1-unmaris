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
        Schema::create('documents', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('unit_id')->constrained('units')->cascadeOnDelete();
            $table->foreignUuid('document_category_id')->constrained('document_categories')->cascadeOnDelete();
            $table->foreignUuid('user_id')->constrained('users')->cascadeOnDelete(); // Siapa yang upload
            $table->string('title');
            $table->string('file_path'); // Lokasi file PDF/Word disimpan
            $table->text('description')->nullable();
            $table->string('status')->default('draft'); // draft, submitted, revised, approved
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
