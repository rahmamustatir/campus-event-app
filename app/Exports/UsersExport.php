<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize; // Tambahan agar lebar kolom otomatis rapi

class UsersExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    /**
    * Ambil data user dari database.
    * Logika: Ambil semua user yang BUKAN admin.
    */
    public function collection()
    {
        // Ambil user yang role-nya TIDAK SAMA DENGAN 'admin'
        // ATAU yang role-nya masih NULL (kosong)
        return User::where('role', '!=', 'admin')
                   ->orWhereNull('role')
                   ->get();
    }

    /**
    * Membuat Judul Kolom (Header) di baris pertama Excel.
    */
    public function headings(): array
    {
        return [
            'Nama Lengkap',
            'Email',
            'NIM / NPM',
            'Jurusan',
            'No. WhatsApp',
            'Tanggal Bergabung',
        ];
    }

    /**
    * Mengatur data apa saja yang dimasukkan ke setiap kolom.
    */
    public function map($user): array
    {
        return [
            $user->name,
            $user->email,
            $user->nim ?? '-',      // Jika kosong, tulis strip (-)
            $user->jurusan ?? '-',
            $user->no_hp ? "'".$user->no_hp : '-', // Tambah kutip (') agar Excel membacanya sebagai teks, bukan angka ilmiah
            $user->created_at->format('d-m-Y H:i'), // Format tanggal: 23-01-2026 14:00
        ];
    }
}