<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 
        'description', 
        'date', 
        'location', 
        'quota', 
        'quota_tersedia', 
        'status',
        'category_id',
        'time_start',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    // MASUKKAN DI SINI:
    protected static function booted()
    {
        static::creating(function ($event) {
            // Ini akan otomatis mengisi quota_tersedia 
            // dengan nilai yang sama dengan quota saat pertama kali dibuat
            $event->quota_tersedia = $event->quota;
        });
    }

public function registrations()
{
    return $this->hasMany(Registration::class);
}

public function sisaKuota()
{
    return $this->quota_tersedia;
}
}