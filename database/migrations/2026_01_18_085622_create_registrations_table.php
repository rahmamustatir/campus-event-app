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
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            
            // Relasi ke User (Mahasiswa) dan Event
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('event_id')->constrained('events')->onDelete('cascade');
            
            // Data Tiket
            $table->string('ticket_code')->unique(); // Kode QR Unik
            $table->enum('status', ['registered', 'attended'])->default('registered');
            
            // Data Presensi (Diisi saat hari H)
            $table->dateTime('checked_in_at')->nullable();
            
            // Siapa panitia yang melakukan scan? (Audit)
            $table->foreignId('checked_in_by')->nullable()->constrained('users')->onDelete('set null');
            
            $table->timestamps();

            // Constraint: Satu user hanya boleh daftar 1x di event yang sama
            $table->unique(['user_id', 'event_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registrations');
    }
};