<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Models\Event;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

class EventController extends Controller
{
    #[OA\Get(
        path: '/api/events',
        tags: ['Events'],
        summary: 'List Event',
        responses: [
            new OA\Response(response: 200, description: 'Success')
        ]
    )]
    public function index()
{
    // 1. Ambil data event dari database
    $events = Event::all(); 

    // 2. Kirim ke tampilan (View)
    // Sesuai folder: resources/views/admin/events/index.blade.php
    return view('admin.events.index', compact('events'));
}

// ============================================================
    // TAMBAHKAN KODE INI DI BAWAH FUNGSI index()
    // ============================================================

    // 1. UNTUK TOMBOL TAMBAH (Create)
    public function create()
    {
        return view('admin.events.create');
    }

    // 2. UNTUK MENYIMPAN DATA (Store)
    public function store(Request $request)
    {
        // 1. Validasi
        $request->validate([
            'title' => 'required',
            // ... validasi lainnya ...
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // 2. Siapkan Data
        $data = $request->except('image'); // Ambil semua input kecuali gambar mentah
        
        // --- TAMBAHAN PENTING DI SINI ---
        // Buat slug otomatis dari judul (Contoh: "Event Akbar" -> "event-akbar")
        $data['slug'] = Str::slug($request->title); 
        // --------------------------------

        // 3. Proses Upload Gambar
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('events', 'public');
            $data['image'] = $imagePath;
        }

        // 4. Simpan
        Event::create($data);

        return redirect()->route('admin.events.index')
                         ->with('success', 'Event berhasil dibuat');
    }

    // 3. UNTUK TOMBOL MATA 👁️ (Detail)
    public function show($id)
    {
        // Cari event berdasarkan ID
        $event = Event::findOrFail($id);
        
        // Arahkan ke file resources/views/admin/events/show.blade.php
        return view('admin.events.show', compact('event'));
    }

    // 4. UNTUK TOMBOL PENSIL ✏️ (Edit)
    public function edit($id)
    {
        $event = Event::findOrFail($id);
        
        // Arahkan ke file resources/views/admin/events/edit.blade.php
        return view('admin.events.edit', compact('event'));
    }

    // 5. UNTUK MENYIMPAN PERUBAHAN (Update)
    public function update(Request $request, $id)
    {
        $event = Event::findOrFail($id);
        $event->update($request->all());

        return redirect()->route('admin.events.index')
                         ->with('success', 'Data berhasil diupdate');
    }

    // 6. UNTUK TOMBOL SAMPAH 🗑️ (Delete)
    public function destroy($id)
    {
        $event = Event::findOrFail($id);
        $event->delete();

        return redirect()->route('admin.events.index')
                         ->with('success', 'Data berhasil dihapus');
    }

} // <--- INI DIA YANG HILANG! PASTIKAN ADA.