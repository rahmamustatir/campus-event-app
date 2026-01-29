<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
}