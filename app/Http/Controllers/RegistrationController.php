<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail; // Import Mail
use App\Mail\RegistrationSuccess;    // Import Class Mail kita
use Illuminate\Support\Facades\Http; // Import Http untuk WA

class RegistrationController extends Controller
{
    /**
     * MAHASISWA: Proses Mendaftar Event
     */
    public function store(Request $request, $eventId)
    {
        $event = Event::findOrFail($eventId);
        $user = auth()->user();

        // 1. CEK DUPLIKASI
        $existing = Registration::where('user_id', $user->id)
            ->where('event_id', $event->id)
            ->exists();

        if ($existing) {
            if ($request->wantsJson()) {
                return response()->json(['status' => 'error', 'message' => 'Gagal: Anda sudah terdaftar!'], 409);
            }
            return back()->with('error', 'Anda sudah terdaftar di event ini!');
        }

        // 2. CEK KUOTA
        if ($event->sisaKuota() <= 0) {
            if ($request->wantsJson()) {
                return response()->json(['status' => 'error', 'message' => 'Gagal: Mohon maaf, kuota penuh!'], 400);
            }
            return back()->with('error', 'Kuota event sudah penuh!');
        }

        // 3. PROSES SIMPAN
        $ticketCode = 'EVT-' . $event->id . '-' . strtoupper(Str::random(6));

        $reg = Registration::create([
            'user_id' => $user->id,
            'event_id' => $event->id,
            'ticket_code' => $ticketCode,
            'status' => 'registered',
        ]);

        // --- MULAI LOGIC NOTIFIKASI ---
        
        // A. KIRIM EMAIL (Dibungkus try-catch)
        try {
            // Pastikan Anda sudah setting .env (MAIL_MAILER=log atau smtp)
            Mail::to($user->email)->send(new RegistrationSuccess($reg));
        } catch (\Exception $e) {
            \Log::error('Gagal kirim email: ' . $e->getMessage());
        }

        // B. KIRIM WHATSAPP (Opsional - Kode disiapkan tapi dimatikan dulu)
        /*
        try {
            $token = 'TOKEN_FONNTE_ANDA'; 
            $message = "Halo {$user->name}, pendaftaran {$event->title} berhasil! Kode Tiket: {$ticketCode}";
            
            Http::withHeaders(['Authorization' => $token])
                ->post('https://api.fonnte.com/send', [
                    'target' => $user->phone ?? '08123456789', 
                    'message' => $message,
                ]);
        } catch (\Exception $e) {
             \Log::error('Gagal kirim WA: ' . $e->getMessage());
        }
        */

        // 4. RESPON SUKSES
        if ($request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Pendaftaran Berhasil!',
                'ticket_code' => $ticketCode,
                'data' => $reg
            ], 201);
        }

        return redirect()->route('dashboard')->with('success', 'Pendaftaran Berhasil! Silakan cek email Anda.');
    }

    /**
     * ADMIN: Proses Scan QR Code (API)
     */
    public function checkInApi(Request $request)
    {
        $request->validate(['ticket_code' => 'required']);
        $code = $request->ticket_code;

        $registration = Registration::with(['user', 'event'])
                        ->where('ticket_code', $code)
                        ->first();

        if (!$registration) {
            return response()->json(['status' => 'error', 'message' => 'Tiket Tidak Valid / Tidak Ditemukan!'], 404);
        }

        if ($registration->status === 'attended') {
            return response()->json([
                'status' => 'warning',
                'message' => 'PERINGATAN: Peserta SUDAH Check-in sebelumnya!',
                'participant_name' => $registration->user->name
            ]); 
        }

        $registration->update([
            'status' => 'attended',
            'checked_in_at' => now(),
            'checked_in_by' => auth()->id(),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Check-in Berhasil!',
            'participant_name' => $registration->user->name,
            'participant_nim' => $registration->user->nim,
            'event_title' => $registration->event->title
        ]);
    }

    /**
     * FITUR: Download PDF
     */
    public function downloadPdf($id)
    {
        $registration = Registration::with(['event', 'user'])->findOrFail($id);

        if ($registration->user_id !== auth()->id()) {
            abort(403, 'Anda tidak berhak mengunduh tiket ini.');
        }

        // Generate PDF dengan Opsi Remote Enabled
        $pdf = Pdf::setOption(['isRemoteEnabled' => true])
                    ->setOption(['defaultFont' => 'sans-serif'])
                    ->loadView('pdf.ticket', compact('registration'));

        return $pdf->download('Tiket-' . $registration->ticket_code . '.pdf');
    }
}