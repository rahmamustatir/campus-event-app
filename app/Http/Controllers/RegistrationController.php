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
    // 1. HISTORY
    public function history()
    {
        $registrations = Registration::with('event')->where('user_id', Auth::id())->latest()->get();
        return view('history', compact('registrations'));
    }

    // 2. STORE
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
            'payment_status' => ($event->price == 0) ? 'paid' : 'pending',
        ]);

        $event->decrement('quota');
        return redirect()->back()->with('success', 'Berhasil mendaftar!');
    }

    // 3. SCAN INDEX
    public function scanIndex()
    {
        $registrations = Registration::with(['user', 'event'])->latest()->paginate(10);
        if (view()->exists('admin.scan')) {
            return view('admin.scan', compact('registrations'));
        }
        return view('admin.registrations.index', compact('registrations'));
    }

    // 4. UPDATE
    public function update(Request $request, $id)
    {
        Registration::findOrFail($id)->update(['status' => 'checked_in']);
        return redirect()->back()->with('success', 'Check-In Berhasil!');
    }

    // ... (kode atas tetap sama)

   // ... (kode atas tetap sama)

    // ... (kode atas jangan diubah)

    // 5. DOWNLOAD TIKET (DENGAN QR CODE BASE64)
    public function downloadTicket($id)
    {
        $registration = Registration::with(['event', 'user'])->findOrFail($id);

        if ($registration->user_id !== Auth::id()) {
            abort(403);
        }

        // 1. Buat Kode Unik
        $tahun = date('Y');
        $eventCode = 'E' . str_pad($registration->event_id, 2, '0', STR_PAD_LEFT);
        $regCode = str_pad($registration->id, 4, '0', STR_PAD_LEFT);
        $kodeTiket = "TKT-{$tahun}-{$eventCode}-{$regCode}";

        // 2. Generate QR Code menjadi Base64 Image
        // Kita pakai format SVG lalu di-encode agar PDF bisa membacanya sebagai gambar
        $qrcode = base64_encode(QrCode::format('svg')->size(100)->generate($kodeTiket));

        // 3. Kirim data ke View (termasuk variabel $qrcode)
        $pdf = Pdf::loadView('pdf.ticket', compact('registration', 'kodeTiket', 'qrcode'));
        
        $namaFile = "{$kodeTiket} - {$registration->user->name}.pdf";
        return $pdf->download($namaFile);
    }
    // --- 6. PROSES SCAN (CHECK-IN VIA KODE/QR) ---
    public function processScan(Request $request)
    {
        // PERBAIKAN DI SINI:
        // Sebelumnya 'code', sekarang kita ganti jadi 'ticket_code' sesuai HTML Anda
        $code = trim($request->input('ticket_code'));

        // Cek jika kosong
        if (!$code) {
            return redirect()->back()->with('error', '⚠️ Kolom input kosong. Mohon isi kode tiket.');
        }

        // LOGIKA EKSTRAK ID
        // Kode: "TKT-2026-E09-0004" -> Ambil angka 4
        try {
            if (str_contains($code, '-')) {
                $parts = explode('-', $code);
                $lastPart = end($parts);
                $id = intval($lastPart); // Ubah "0004" jadi angka 4
            } else {
                $id = intval($code); // Jika inputnya cuma angka
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', '⚠️ Format kode tiket salah.');
        }

        // Cari Data
        $registration = Registration::find($id);

        // Validasi Data
        if (!$registration) {
            return redirect()->back()->with('error', "❌ Tiket ID #$id tidak ditemukan.");
        }

        // Cek Status
        if ($registration->status == 'checked_in') {
            return redirect()->back()->with('warning', "⚠️ Peserta " . $registration->user->name . " SUDAH Check-In sebelumnya.");
        }

        // Update jadi Hadir
        $registration->status = 'checked_in';
        $registration->save(); 

        return redirect()->back()->with('success', "✅ SUKSES! Selamat datang, " . strtoupper($registration->user->name));
    }

    // --- 8. DOWNLOAD SERTIFIKAT (HANYA JIKA SUDAH CHECK-IN) ---
    public function downloadCertificate($id)
    {
        $registration = Registration::with(['user', 'event'])->findOrFail($id);

        // Validasi: Harus login & punya sendiri
        if ($registration->user_id !== Auth::id()) {
            abort(403);
        }

        // Validasi: Harus sudah Check-In (Hadir)
        if ($registration->status != 'checked_in') {
            return redirect()->back()->with('error', '⚠️ Maaf, Anda belum melakukan Check-In pada event ini.');
        }

        // Generate PDF (Format Landscape)
        $pdf = Pdf::loadView('pdf.certificate', compact('registration'))
                  ->setPaper('a4', 'landscape');

        // Nama File
        $namaFile = 'Sertifikat - ' . $registration->user->name . ' - ' . $registration->event->title . '.pdf';
        
        return $pdf->download($namaFile);
    }

} // <--- INI KURUNG PENUTUP CLASS YANG SUDAH ADA
