<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use OpenApi\Attributes as OA;

class AuthController extends Controller
{
    #[OA\Post(
        path: '/api/send-otp',
        tags: ['Authentication'],
        summary: 'Kirim OTP via Go-WhatsApp Local',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['phone'],
                properties: [
                    new OA\Property(property: 'phone', type: 'string', example: '08123456789'),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: 'Sukses'),
            new OA\Response(response: 500, description: 'Gagal Koneksi')
        ]
    )]
    public function sendOtp(Request $request)
    {
        // 1. Validasi
        $request->validate(['phone' => 'required']);

        // 2. Format Nomor (08 -> 628)
        $phone = $request->phone;
        if (substr($phone, 0, 1) == '0') {
            $phone = '62' . substr($phone, 1);
        }
        // Hapus suffix @s.whatsapp.net jika ada (biar bersih)
        $phone = str_replace('@s.whatsapp.net', '', $phone);
        // Tambahkan lagi (wajib untuk library ini)
        $phone = $phone . '@s.whatsapp.net';

        // 3. Generate OTP
        $otp = rand(100000, 999999);
        $message = "Kode OTP Anda: *{$otp}*";

        try {
            // ====================================================
            // PERBAIKAN URL & DEBUG MODE
            // Gunakan IP 127.0.0.1 dan endpoint /message/send-text
            // ====================================================
            $url = 'http://127.0.0.1:3000/send/message';
            
            $response = Http::timeout(10)->withHeaders([
                'X-Device-Id' => 'c17b2a9b-ecf6-41a1-9893-e934a5ecccda', // Pastikan ID ini sesuai dashboard
            ])->post($url, [
                'phone' => $phone,
                'message' => $message,
            ]);

            // Cek Response
            if ($response->successful()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'OTP Terkirim ke WhatsApp!',
                    'data' => $response->json(),
                    'debug_otp' => $otp
                ]);
            } else {
                // GAGAL: Tampilkan isi error aslinya (walaupun HTML)
                return response()->json([
                    'status' => 'error',
                    'message' => 'Gagal mengirim WA (Server Menolak).',
                    'http_status' => $response->status(),
                    'raw_response' => $response->body() // <--- Ini akan menampilkan alasan errornya
                ], 500);
            }

        } catch (\Exception $e) {
            // ERROR KONEKSI: Tampilkan detail errornya
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal koneksi ke Go-WhatsApp (Cek Port 3000).',
                'error_detail' => $e->getMessage()
            ], 500);
        }
    }
}