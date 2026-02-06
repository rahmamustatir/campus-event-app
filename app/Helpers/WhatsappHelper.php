<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;

class WhatsappHelper
{
    public static function send($target, $message)
    {
        // 1. Format Nomor HP
        $target = preg_replace('/[^0-9]/', '', $target);
        
        // Ubah 08xx jadi 628xx
        if (substr($target, 0, 1) == '0') {
            $target = '62' . substr($target, 1);
        }

        // 2. Kirim ke Server Go
        // URL yang benar untuk v8.2.0 adalah /send/message
        try {
            $response = Http::post('http://localhost:3000/send/message', [
                'phone' => $target,     // Kuncinya 'phone', bukan 'recipient'
                'message' => $message,
            ]);

            // Jika Gagal (Status bukan 200 OK)
            if ($response->failed()) {
                // TAMPILKAN ERROR KE LAYAR (Untuk Debugging)
                dd([
                    'Status' => 'Gagal mengirim pesan ke Server WA',
                    'Kode HTTP' => $response->status(),
                    'Respon Server' => $response->body(),
                    'URL Tujuan' => 'http://localhost:3000/send/message'
                ]);
            }

            return $response->json();

        } catch (\Exception $e) {
            // Jika tidak bisa connect sama sekali (Server mati / Port salah)
            dd([
                'Error' => 'Laravel tidak bisa menghubungi Server WA',
                'Pesan Error' => $e->getMessage(),
                'Saran' => 'Pastikan terminal server WA (windows-amd64.exe) masih menyala di port 3000'
            ]);
        }
    }
}