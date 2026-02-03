<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * FUNGSI 1: DASHBOARD UTAMA (SAPAAN)
     */
    public function index()
    {
        // Jika Admin, ke dashboard admin
        if (Auth::user()->usertype == 'admin') {
            return view('admin.dashboard'); 
        }

        // Jika User Biasa, ke dashboard sapaan (banner)
        return view('dashboard');
    }

    /**
     * FUNGSI 2: JELAJAH EVENT (DAFTAR EVENT & FILTER)
     */
    public function explore(Request $request)
    {
        // Logika Filter Event (Sama seperti sebelumnya)
        $query = Event::query();

        if ($request->filled('kategori')) {
            if ($request->kategori == 'umum') {
                $query->where('kategori_peserta', 'umum');
            } else {
                $query->where('target_peserta', $request->kategori);
            }
        }

        $events = $query->latest()->get();

        // Panggil file 'explore.blade.php' (File lama yg kita rename)
        return view('explore', compact('events'));
    }
}