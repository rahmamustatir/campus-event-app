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
    'password',
    'nim',
    'jurusan',
    'no_hp',
    'avatar', // <--- Tambahan
    'role',
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