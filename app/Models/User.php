<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'whatsapp',   // <--- Tambahkan ini
        'password',
        'role',
        'otp_code',        // Tambahan opsi (jika pakai create massal)
        'otp_expires_at',  // Tambahan opsi
        'is_verified',     // Tambahan opsi
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // --- TAMBAHKAN INI ---
   // Relasi ke Biodata
    public function biodata()
    {
        // Pastikan model Biodata ada di folder Models
        return $this->hasOne(Biodata::class);
    }

    // Relasi ke Pendaftaran Event
    public function registrations()
    {
        // Kita pakai alamat lengkap agar pasti ketemu
        return $this->hasMany(\App\Models\Registration::class);
    }

}