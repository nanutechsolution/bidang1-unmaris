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
        Schema::create('survey_answers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('survey_response_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('survey_question_id')->constrained()->cascadeOnDelete();
            $table->text('answer_text')->nullable(); // Jika pertanyaannya tipe teks
            $table->integer('answer_rating')->nullable(); // Jika pertanyaannya tipe rating (1-5)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('survey_answers');
    }
};
