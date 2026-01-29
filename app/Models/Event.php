<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    // Izinkan semua kolom diisi (biar tidak ribet define satu-satu)
    protected $guarded = ['id'];

    // Relasi: Satu Event memiliki banyak Pendaftaran
    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

    // --- INI FUNGSI YANG TADI HILANG ---
    // Fungsi untuk menghitung sisa kuota secara otomatis
    public function sisaKuota()
    {
        // Rumus: Kuota Total dikurangi Jumlah Orang yang Sudah Daftar
        return $this->quota - $this->registrations()->count();
    }
}