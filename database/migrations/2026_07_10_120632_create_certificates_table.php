<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            // Menggunakan unique() karena relasinya One-to-One dengan tabel registrations
            $table->foreignId('registration_id')->unique()->constrained('registrations')->cascadeOnDelete();
            $table->string('certificate_number', 150)->unique();
            $table->string('file_path', 255);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('certificates');
    }
};