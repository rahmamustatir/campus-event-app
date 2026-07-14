<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Certificate extends Model
{
    use HasFactory;

    // Tentukan kolom mana saja yang boleh diisi (mass assignable)
    protected $fillable = [
        'user_id',
        'event_id',
        'file_path',
        'issued_at'
    ];

    // Definisikan relasi ke User (Sertifikat milik siapa?)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Definisikan relasi ke Event (Sertifikat untuk event apa?)
    public function event()
    {
        return $this->belongsTo(Event::class);
    }
    public function registration()
{
    return $this->belongsTo(Registration::class);
}
}