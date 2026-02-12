<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    use HasRoles;

    /**
     * Kolom yang boleh diisi secara massal (create/update).
     */
    protected $fillable = [
        'name',
        'email',
        'whatsapp',       // <--- WAJIB ADA
        'password',
        'role',
        'otp_code',       // <--- WAJIB ADA
        'otp_expires_at', // <--- WAJIB ADA
        'is_verified',    
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Konversi tipe data otomatis.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'otp_expires_at' => 'datetime', // <--- [PENTING] TAMBAHKAN INI!
        ];
    }

    // --- RELASI ---

    // Relasi ke Biodata
    public function biodata()
    {
        return $this->hasOne(Biodata::class);
    }

    // Relasi ke Pendaftaran Event
    public function registrations()
    {
        return $this->hasMany(\App\Models\Registration::class);
    }
}