<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    // 1. DAFTAR KOLOM YANG BOLEH DIISI (Wajib update ini agar fitur baru jalan)
    protected $fillable = [
        'title',            // Judul
        'description',      // Deskripsi
        'date',             // Tanggal
        'time',             // Jam
        'location',         // Lokasi
        'quota',            // Kuota Total
        'price',            // Harga
        'image',            // Banner
        
        // --- KOLOM BARU UNTUK FILTER ---
        'kategori_peserta', // (umum / fakultas / prodi)
        'target_peserta',   // (Nama fakultas/prodinya)
    ];

    // 2. RELASI KE DATA PENDAFTAR (PENTING: Jangan dihapus)
    // Fungsi ini dipakai Admin untuk melihat siapa saja yang daftar event ini
    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

    // 3. LOGIKA SISA KUOTA (PENTING: Jangan dihapus)
    // Fungsi ini dipakai saat Mahasiswa mau daftar. Kalau dihapus, sistem kuota error.
    public function sisaKuota()
    {
        // Hitung berapa orang yang sudah daftar (status confirmed)
        $terdaftar = $this->registrations()->where('status', 'confirmed')->count();
        
        // Kembalikan sisa kursi (Total Kuota - Yang Sudah Daftar)
        return $this->quota - $terdaftar;
    }
}