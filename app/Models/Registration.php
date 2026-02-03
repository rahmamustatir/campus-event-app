<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    use HasFactory;

    // --- BAGIAN INI YANG MEMBUAT ERROR SEBELUMNYA ---
    // Kita harus mengizinkan (fillable) kolom ini agar bisa diisi oleh Controller baru
    protected $fillable = [
        'user_id',
        'event_id',
        'status',
    ];

    // --- RELASI (Agar Menu Riwayat & Tiket Tidak Eror) ---
    
    // Relasi ke User (Siapa yang daftar)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Event (Event apa yang didaftar)
    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}