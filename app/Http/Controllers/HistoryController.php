<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function index()
    {
        // Ambil event yang SAYA ikuti DAN tanggalnya SUDAH LEWAT (< now)
        $pastRegistrations = auth()->user()->registrations()
                                ->whereHas('event', function($query) {
                                    $query->where('event_date', '<', now());
                                })
                                ->with('event')
                                ->latest() // Yang baru selesai paling atas
                                ->get();

        return view('history', compact('pastRegistrations'));
    }
}