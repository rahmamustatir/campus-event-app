<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    // Relasi: Event punya banyak Pendaftaran
    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

    // Helper: Menghitung sisa kuota
    public function sisaKuota()
    {
        // Total Kuota - Jumlah Pendaftar yang statusnya bukan 'cancelled'
        return $this->quota - $this->registrations()->count();
    }
}