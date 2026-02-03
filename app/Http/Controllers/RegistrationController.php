<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Registration;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;

class RegistrationController extends Controller
{
    /**
     * FUNGSI 1: ADMIN SCAN TIKET (SESUAI REQUEST ERROR ANDA: scanIndex)
     * Ini akan memperbaiki error "Call to undefined method scanIndex"
     */
    public function scanIndex()
    {
        // Ambil data pendaftaran terbaru (pagination 10 per halaman)
        $registrations = Registration::with(['user', 'event'])->latest()->paginate(10);

        // Cek apakah ada view khusus scan, jika tidak pakai index biasa
        if (view()->exists('admin.scan')) {
            return view('admin.scan', compact('registrations'));
        }

        // Tampilkan ke halaman daftar pendaftaran
        return view('admin.registrations.index', compact('registrations'));
    }

    /**
     * FUNGSI 2: USER MENDAFTAR (Tombol Daftar di Dashboard)
     */
    public function store(Request $request)
    {
        // 1. Validasi
        $request->validate([
            'event_id' => 'required|exists:events,id',
        ]);

        $user = Auth::user();
        $event = Event::findOrFail($request->event_id);

        // 2. CEK FAKULTAS (Sesuai Permintaan)
        if ($event->kategori_peserta != 'umum') {
            $fakultasUser = optional($user->biodata)->fakultas;

            if ($fakultasUser != $event->target_peserta) {
                return redirect()->back()->with('error', '⛔ Maaf! Event ini khusus mahasiswa ' . $event->target_peserta);
            }
        }

        // 3. Cek Double Daftar
        $sudahDaftar = Registration::where('user_id', $user->id)
                        ->where('event_id', $event->id)
                        ->exists();

        if ($sudahDaftar) {
            return redirect()->back()->with('error', '✅ Anda sudah terdaftar di event ini.');
        }

        // 4. Cek Kuota
        if ($event->sisaKuota() <= 0) {
            return redirect()->back()->with('error', '❌ Kuota penuh.');
        }

        // 5. Simpan
        Registration::create([
            'user_id' => $user->id,
            'event_id' => $event->id,
            'status' => 'confirmed',
            'payment_status' => ($event->price == 0) ? 'paid' : 'pending',
        ]);

        return redirect()->back()->with('success', '🚀 Berhasil mendaftar event!');
    }

    /**
     * FUNGSI 3: ADMIN UPDATE STATUS (CHECK-IN)
     */
    public function update(Request $request, $id)
    {
        $registration = Registration::findOrFail($id);
        
        $registration->update([
            'status' => 'checked_in'
        ]);

        return redirect()->back()->with('success', 'Peserta Check-In! ✅');
    }

    /**
     * FUNGSI TAMBAHAN: RIWAYAT PENDAFTARAN USER
     * (Tambahkan ini agar menu Riwayat bisa dibuka)
     */
    public function history()
    {
        $registrations = Registration::with('event')
                        ->where('user_id', Auth::id())
                        ->latest()
                        ->get();

        // UBAH DARI 'user.history' MENJADI 'history' SAJA
        return view('history', compact('registrations'));
    }
}