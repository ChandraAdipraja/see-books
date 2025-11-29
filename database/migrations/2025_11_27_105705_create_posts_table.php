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
    Schema::create('posts', function (Blueprint $table) {
        $table->uuid('id')->primary();

        // relasi ke users (UUID)
        $table->foreignUuid('user_id')
              ->constrained('users')
              ->cascadeOnDelete();

        $table->string('title', 150);
        $table->string('slug')->unique(); // buat URL cantik nanti (optional tapi enak)

        // meta kuliah
        $table->unsignedTinyInteger('semester')->nullable();
        $table->string('course')->nullable();   // nama mata kuliah
        $table->unsignedTinyInteger('meeting')->nullable(); // pertemuan ke berapa

        $table->longText('body'); // isi catatan

        $table->boolean('is_public')->default(true);

        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
