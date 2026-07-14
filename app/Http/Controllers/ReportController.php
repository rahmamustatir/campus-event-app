<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Event;
use Carbon\Carbon;

class ReportController extends Controller
{
    
    // Tambahkan fungsi ini di dalam class ReportController
public function downloadLaporanBulanan() 
{
    // Mengambil data event untuk bulan berjalan (Juli 2026)
    $events = \App\Models\Event::whereMonth('date', now()->month)
                                ->whereYear('date', now()->year)
                                ->get();
    
    $bulan = now()->translatedFormat('F Y'); // Menggunakan bahasa Indonesia

    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.reports.laporan_bulanan', compact('events', 'bulan'));
    return $pdf->download('Laporan_Event_' . $bulan . '.pdf');
}

        public function index()
    {
        $events = Event::withCount('registrations')
                       ->orderBy('date', 'desc') 
                       ->get();

        return view('admin.reports.index', compact('events'));
    }

    public function downloadLaporanEvent($id) {
    $event = Event::findOrFail($id);
    $pdf = Pdf::loadView('admin.reports.laporan_event', compact('event'));
    return $pdf->download('Laporan_Event_' . $event->title . '.pdf');
}

    public function exportParticipants($id) {
    $event = Event::with(['registrations.user'])->findOrFail($id);
    // Ini tetap menggunakan attendance_list.blade.php
    $pdf = Pdf::loadView('admin.reports.attendance_list', compact('event'));
    return $pdf->download('Daftar_Hadir_' . $event->title . '.pdf');
}
}