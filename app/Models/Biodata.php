<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Biodata extends Model
{
    use HasFactory;

    // Pastikan nama tabel di database Anda benar (biasanya 'biodatas' atau 'mahasiswas')
    // Jika ragu, cek di phpMyAdmin.
    protected $table = 'biodatas'; 

    protected $fillable = [
        'user_id',
        'nim',
        'prodi',
        'fakultas',
        'phone',
        'address',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}