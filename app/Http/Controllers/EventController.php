<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage; // Pastikan ini ada

class EventController extends Controller
{
    /**
     * Menampilkan daftar event di Dashboard Admin
     */
    public function index()
    {
        // Ambil event terbaru, hitung juga jumlah pendaftarnya
        $events = Event::withCount('registrations')
                    ->orderBy('created_at', 'desc')
                    ->get();

        return view('admin.events.index', compact('events'));
    }

    /**
     * Menampilkan Form Pembuatan Event
     */
    public function create()
    {
        return view('admin.events.create');
    }

    /**
     * Proses Menyimpan Event Baru ke Database
     */
    public function store(Request $request)
    {
        // 1. VALIDASI INPUT
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string',
            'event_date' => 'required|date',
            'registration_end' => 'required|date|before:event_date', 
            'quota' => 'required|integer|min:1',
            'poster' => 'nullable|image|max:2048', // Max 2MB
        ]);

        // 2. PROSES UPLOAD POSTER (Jika ada)
        $posterPath = null;
        if ($request->hasFile('poster')) {
            $posterPath = $request->file('poster')->store('posters', 'public');
        }

        // 3. SIMPAN DATA EVENT
        $event = Event::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title) . '-' . Str::random(5), 
            'description' => $request->description,
            'location' => $request->location,
            'event_date' => $request->event_date,
            'registration_end' => $request->registration_end,
            'quota' => $request->quota,
            'poster' => $posterPath,
            'status' => 'published',
            'created_by' => auth()->id(),
        ]);

        // 4. RESPON SUKSES
        if ($request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Event Berhasil Dibuat!',
                'data' => $event
            ], 201);
        }

        return redirect()->route('admin.events.index')->with('success', 'Event Berhasil Dibuat!');
    }

    /**
     * Menghapus Event
     */
    public function destroy($id)
    {
        // 1. Cari Event
        $event = Event::findOrFail($id);

        // 2. Hapus Poster (Jika ada) agar hemat memori
        if ($event->poster) {
            Storage::disk('public')->delete($event->poster);
        }

        // 3. Hapus Data Event dari Database
        $event->delete();

        return back()->with('success', 'Event berhasil dihapus!');
    }

    /**
     * Tampilkan Form Edit
     */
    public function edit($id)
    {
        $event = Event::findOrFail($id);
        return view('admin.events.edit', compact('event'));
    }

    /**
     * Proses Update Data ke Database
     */
    public function update(Request $request, $id)
    {
        $event = Event::findOrFail($id);

        // 1. Validasi (Poster dibuat nullable/boleh kosong jika tidak diganti)
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string',
            'event_date' => 'required|date',
            'registration_end' => 'required|date|before:event_date',
            'quota' => 'required|integer|min:1',
            'poster' => 'nullable|image|max:2048',
        ]);

        // 2. Cek apakah ada upload poster baru?
        if ($request->hasFile('poster')) {
            // Hapus poster lama biar hemat storage
            if ($event->poster) {
                Storage::disk('public')->delete($event->poster);
            }
            // Simpan poster baru
            $posterPath = $request->file('poster')->store('posters', 'public');
            $event->poster = $posterPath; // Update path di object event
        }

        // 3. Update data lainnya
        $event->update([
            'title' => $request->title,
            'description' => $request->description,
            'location' => $request->location,
            'event_date' => $request->event_date,
            'registration_end' => $request->registration_end,
            'quota' => $request->quota,
            // Field poster sudah dihandle di atas
        ]);

        return redirect()->route('admin.events.index')->with('success', 'Event berhasil diperbarui!');
    }

    /**
     * Tampilkan Detail Peserta (Fitur Mata)
     */
    public function show($id)
    {
        // Ambil event beserta daftar pendaftarnya (dan data user-nya)
        $event = Event::with(['registrations.user'])->findOrFail($id);
        
        return view('admin.events.show', compact('event'));
    }

    /**
     * Menghapus Peserta dari Event
     */
    public function destroyParticipant($id)
    {
        // 1. Cari data pendaftaran (Gunakan model Registration)
        // Pastikan namespace App\Models\Registration sudah di-import atau panggil lengkap
        $registration = \App\Models\Registration::findOrFail($id);

        // 2. Hapus data
        $registration->delete();

        // 3. Kembali ke halaman sebelumnya dengan pesan sukses
        return back()->with('success', 'Data peserta berhasil dihapus!');
    }
} // <--- KURUNG KURAWAL PENUTUP CLASS ADA DI SINI (PALING BAWAH)