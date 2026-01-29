<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use App\Models\Event;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class CertificateController extends Controller
{
    public function download($registration_id)
    {
        // 1. Cari data pendaftaran berdasarkan ID
        // Pastikan yang download adalah pemilik tiket itu sendiri (Security Check)
        $registration = Registration::where('id', $registration_id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // 2. Cek Status: Hanya yang sudah 'hadir' (scanned) yang boleh dapat sertifikat
        // Sesuaikan 'checked_in' dengan status di database Anda.
        // Jika belum ada fitur scan, kita anggap semua 'confirmed' boleh download dulu.
        // 2. Cek Status: Sesuaikan dengan ENUM di database ('attended')
        if ($registration->status != 'attended') {
             return back()->with('error', 'Maaf, Anda belum menghadiri event ini.');
        }

        // 3. Siapkan Data untuk Sertifikat
        $data = [
            'user' => Auth::user(),
            'event' => $registration->event,
            'code' => $registration->ticket_code,
            // Gunakan format tanggal dari Event
            'date' => \Carbon\Carbon::parse($registration->event->date)->translatedFormat('d F Y'),
        ];

        // 4. Generate PDF
        // Kita pakai kertas A4 Landscape
        $pdf = Pdf::loadView('certificate.template', $data);
        $pdf->setPaper('a4', 'landscape');

        // 5. Download file dengan nama unik
        return $pdf->download('Sertifikat-'. $registration->event->title .'.pdf');
    }
}