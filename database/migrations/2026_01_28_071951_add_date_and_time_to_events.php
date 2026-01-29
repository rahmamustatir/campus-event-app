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
        Schema::table('events', function (Blueprint $table) {
            
            // 1. Cek & Tambah Kolom DATE (Jika belum ada)
            if (!Schema::hasColumn('events', 'date')) {
                $table->date('date')->nullable()->after('description');
            }

            // 2. Cek & Tambah Kolom TIME (Jika belum ada)
            if (!Schema::hasColumn('events', 'time')) {
                $table->string('time')->nullable()->after('date'); 
                // Kita pakai string saja biar aman untuk format jam (08:30)
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            if (Schema::hasColumn('events', 'date')) {
                $table->dropColumn('date');
            }
            if (Schema::hasColumn('events', 'time')) {
                $table->dropColumn('time');
            }
        });
    }
};