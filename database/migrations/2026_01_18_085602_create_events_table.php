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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique(); // URL cantik (SEO Friendly)
            $table->text('description');
            $table->string('location');
            $table->dateTime('event_date'); // Tanggal Acara
            $table->dateTime('registration_end'); // Batas Akhir Daftar
            $table->integer('quota'); // Jumlah Kuota
            $table->string('poster')->nullable(); // Foto Poster
            $table->enum('status', ['draft', 'published', 'closed'])->default('draft');
            
            // Audit Trail: Siapa admin yang membuat dan mengupdate
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};