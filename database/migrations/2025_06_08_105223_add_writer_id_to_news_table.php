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
        Schema::table('news', function (Blueprint $table) {
            $table->unsignedBigInteger('idAuthor');
            $table->enum('status', ['Sedang Ditinjau', 'Revisi Diperlukan', 'Terpublikasi', 'Ditolak'])->default('Sedang Ditinjau');
            $table->text('editorNotes')->nullable();
            $table->integer('revision')->default(0);
            $table->foreign('idAuthor')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('news', function (Blueprint $table) {
            $table->dropForeign(['idAuthor']);
            $table->dropColumn(['idAuthor', 'status', 'editorNotes', 'revision']);
        });
    }
};
