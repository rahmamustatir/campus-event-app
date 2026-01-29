<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('events', function (Blueprint $table) {
        // Kita tambahkan kolom category, boleh kosong (nullable)
        // Kita letakkan setelah kolom title biar rapi
        $table->string('category')->nullable()->after('title');
    });
}

public function down()
{
    Schema::table('events', function (Blueprint $table) {
        $table->dropColumn('category');
    });
}
};
