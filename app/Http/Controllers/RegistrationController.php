<?php

namespace App\Http\Controllers;

use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Http\Request;
use App\Models\Registration;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class RegistrationController extends Controller
{
    // 1. HISTORY (Mahasiswa)
    public function history()
    {
        $registrations = Registration::with('event')
                            ->where('user_id', Auth::id())
                            ->latest()
                            ->get();
        return view('mahasiswa.history', compact('registrations'));
    }

    // 2. STORE (Pendaftaran Event)
    public function store(Request $request)
    {
        $request->validate(['event_id' => 'required|exists:events,id']);
        
        $user = Auth::user();
        $event = Event::findOrFail($request->event_id);

        if ($event->kategori_peserta != 'umum') {
            $fakultasUser = optional($user->biodata)->fakultas;
            if (strtoupper($fakultasUser) != strtoupper($event->target_peserta)) {
                return redirect()->back()->with('error', 'Khusus ' . $event->target_peserta);
            }
        }

        if (Registration::where('user_id', $user->id)->where('event_id', $event->id)->exists()) {
            return redirect()->back()->with('error', 'Sudah terdaftar.');
        }

        if ($event->quota <= 0) return redirect()->back()->with('error', 'Kuota penuh.');

        Registration::create([
            'user_id' => $user->id,
            'event_id' => $event->id,
            'status' => 'confirmed',
            'status_presence' => 'registered', // Status awal
            'payment_status' => ($event->price == 0) ? 'paid' : 'pending',
        ]);

        $event->decrement('quota');
        return redirect()->back()->with('success', 'Berhasil mendaftar!');
    }

    // 3. CHECK-IN (Mahasiswa)
    public function checkIn($id) {
        $reg = Registration::where('user_id', Auth::id())->findOrFail($id);
        $reg->update(['status_presence' => 'check-in']);
        return back()->with('success', 'Berhasil Check-in!');
    }

    // 4. CHECK-OUT (Mahasiswa)
    public function checkOut($id) {
        $reg = Registration::where('user_id', Auth::id())->findOrFail($id);
        $reg->update(['status_presence' => 'check-out']);
        return back()->with('success', 'Berhasil Check-out! Sertifikat siap diunduh.');
    }

    // 5. DOWNLOAD TIKET
    public function downloadTicket($id)
    {
        $registration = Registration::with(['event', 'user'])->findOrFail($id);
        if ($registration->user_id !== Auth::id()) abort(403);

        $tahun = date('Y');
        $eventCode = 'E' . str_pad($registration->event_id, 2, '0', STR_PAD_LEFT);
        $regCode = str_pad($registration->id, 4, '0', STR_PAD_LEFT);
        $kodeTiket = "TKT-{$tahun}-{$eventCode}-{$regCode}";
        $qrcode = base64_encode(QrCode::format('svg')->size(100)->generate($kodeTiket));

        $pdf = Pdf::loadView('pdf.ticket', compact('registration', 'kodeTiket', 'qrcode'));
        return $pdf->download("{$kodeTiket}.pdf");
    }

    // 6. DOWNLOAD SERTIFIKAT (Hanya jika status check-out)
    public function downloadCertificate($id)
    {
        $registration = Registration::with(['user', 'event'])->findOrFail($id);
        if ($registration->user_id !== Auth::id()) abort(403);

        // Validasi: Harus sudah Check-Out
        if ($registration->status_presence != 'check-out') {
            return redirect()->back()->with('error', '⚠️ Selesaikan event (Check-Out) untuk mendapatkan sertifikat.');
        }

        $pdf = Pdf::loadView('pdf.certificate', compact('registration'))->setPaper('a4', 'landscape');
        return $pdf->download('Sertifikat - ' . $registration->user->name . '.pdf');
    }

    // 7. SCAN INDEX (Untuk Admin)
    public function scanIndex()
    {
        $registrations = Registration::with(['user', 'event'])->latest()->paginate(10);
        return view('admin.scan', compact('registrations'));
    }

    // 8. PROSES SCAN (Untuk Admin)
    public function processScan(Request $request)
{
    $request->validate(['ticket_code' => 'required', 'action' => 'required']);

    $reg = Registration::where('ticket_code', $request->ticket_code)->first();

    if (!$reg) {
        return back()->with('error', 'Tiket tidak ditemukan.');
    }

    if ($request->action === 'checkin') {
        $reg->update(['status_presence' => 'check-in']);
        return back()->with('success', 'Check-In Berhasil!');
    } elseif ($request->action === 'checkout') {
        $reg->update(['status_presence' => 'check-out']);
        return back()->with('success', 'Check-Out Berhasil!');
    }
}
}