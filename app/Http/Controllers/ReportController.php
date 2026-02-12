<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Event;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index()
    {
        // PERBAIKAN: Menggunakan 'date' (bukan event_date)
        // Kita juga hitung jumlah pendaftar otomatis dengan withCount
        $events = Event::withCount('registrations')
                       ->orderBy('date', 'desc') 
                       ->get();

        return view('admin.reports.index', compact('events'));
    }
    // --- FUNGSI BARU: EXPORT ABSENSI PESERTA ---
    public function exportParticipants($id)
    {
        // 1. Ambil data event beserta peserta yang statusnya 'confirmed' atau 'checked_in'
        $event = Event::with(['registrations' => function($query) {
                        $query->whereIn('status', ['confirmed', 'checked_in', 'paid']); // Hanya yang sudah fix ikut
                    }, 'registrations.user', 'registrations.user.biodata'])
                    ->findOrFail($id);

        // 2. Load View PDF Absensi
        // Kita akan buat file view baru khusus untuk ini
        $pdf = Pdf::loadView('admin.reports.attendance_list', compact('event'))
                  ->setPaper('a4', 'portrait');

        // 3. Download
        return $pdf->download('Absensi - ' . $event->slug . '.pdf');
    }
}