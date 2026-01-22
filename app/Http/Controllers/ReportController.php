<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        // Ambil data event beserta jumlah pendaftarnya
        $events = Event::withCount('registrations')
                    ->orderBy('event_date', 'desc')
                    ->get();

        return view('admin.reports.index', compact('events'));
    }
    /**
     * Export Laporan ke Excel (Format CSV)
     */
    public function export()
    {
        // 1. Ambil Data
        $events = Event::withCount('registrations')
                    ->orderBy('event_date', 'desc')
                    ->get();

        // 2. Siapkan Nama File
        $fileName = 'Laporan-Event-' . date('Y-m-d-His') . '.csv';

        // 3. Header agar browser tahu ini file Excel/CSV
        $headers = [
            "Content-Type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        // 4. Buat Isi File (Stream)
        $callback = function() use ($events) {
            $file = fopen('php://output', 'w');

            // Tulis Judul Kolom (Header Row)
            fputcsv($file, ['No', 'Nama Event', 'Tanggal Pelaksanaan', 'Lokasi', 'Kuota', 'Jumlah Pendaftar', 'Status']);

            // Tulis Baris Data
            foreach ($events as $index => $event) {
                fputcsv($file, [
                    $index + 1,
                    $event->title,
                    $event->event_date, // Bisa diformat jika mau: date('d-m-Y', strtotime($event->event_date))
                    $event->location,
                    $event->quota,
                    $event->registrations_count,
                    ($event->event_date < now() ? 'Selesai' : 'Aktif')
                ]);
            }

            fclose($file);
        };

        // 5. Download File
        return response()->stream($callback, 200, $headers);
    }
}