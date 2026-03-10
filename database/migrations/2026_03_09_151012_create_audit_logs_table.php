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
    Schema::create('audit_logs', function (Blueprint $table) {
        $table->uuid('id')->primary();
        $table->foreignUuid('document_id')->constrained()->cascadeOnDelete();
        $table->foreignUuid('user_id')->constrained(); // Siapa pelakunya
        $table->string('activity'); // 'view', 'download', 'print'
        $table->string('ip_address')->nullable();
        $table->string('user_agent')->nullable();
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};
