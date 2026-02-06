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
    Schema::table('users', function (Blueprint $table) {
        $table->string('whatsapp')->nullable()->after('email'); // Nomor WA
        $table->string('otp_code')->nullable()->after('password'); // Kode OTP
        $table->timestamp('otp_expires_at')->nullable()->after('otp_code'); // Waktu expired
        $table->boolean('is_verified')->default(false)->after('otp_expires_at'); // Status Verifikasi
    });
}

public function down()
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn(['whatsapp', 'otp_code', 'otp_expires_at', 'is_verified']);
    });
}
};
