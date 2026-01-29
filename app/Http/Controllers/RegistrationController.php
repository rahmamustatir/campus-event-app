<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Registration;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf; // Jika nanti pakai PDF

class RegistrationController extends Controller
{
    // 1. PROSES DAFTAR EVENT
    public function store(Request $request, $id)
    {
        $event = Event::findOrFail($id);

        // Cek apakah sudah daftar?
        $existing = Registration::where('user_id', Auth::id())
                                ->where('event_id', $id)
                                ->first();

        if ($existing) {
            return back()->with('error', 'Anda sudah terdaftar di event ini!');
        }

        // Cek Kuota
        if ($event->sisaKuota() <= 0) {
            return back()->with('error', 'Maaf, kuota event ini sudah penuh.');
        }

        // Simpan Pendaftaran
        Registration::create([
            'user_id' => Auth::id(),
            'event_id' => $id,
            'status' => 'confirmed', // Langsung konfirmasi
        ]);

        return redirect()->route('history')->with('success', 'Hore! Pendaftaran berhasil.');
    }

    // 2. HALAMAN RIWAYAT SAYA (INI YANG TADI EROR)
    public function history()
    {
        // Ambil semua pendaftaran milik user yang sedang login
        $registrations = Registration::with('event')
                                     ->where('user_id', Auth::id())
                                     ->latest()
                                     ->get();

        return view('history', compact('registrations'));
    }

    // 3. DOWNLOAD TIKET
    public function downloadTicket($id)
    {
        $registration = Registration::with(['user', 'event'])->findOrFail($id);

        // Pastikan yang download adalah pemilik tiket atau admin
        if (Auth::id() !== $registration->user_id && Auth::user()->usertype !== 'admin') {
            abort(403);
        }

        // Tampilan Tiket Sederhana (Print View)
        return view('pdf.ticket', compact('registration'));
    }

    // --- BAGIAN ADMIN ---

    // 4. ADMIN HAPUS PESERTA
    public function destroy($id)
    {
        $registration = Registration::findOrFail($id);
        $registration->delete();
        return back()->with('success', 'Peserta berhasil dihapus.');
    }

    // 5. ADMIN SCAN (INDEX)
    public function scanIndex()
    {
        return view('admin.scan');
    }

    // 6. ADMIN PROSES SCAN
    public function processScan(Request $request)
    {
        // Logika scan nanti bisa ditambahkan di sini
        return back()->with('success', 'Scan berhasil (Simulasi).');
    }
}