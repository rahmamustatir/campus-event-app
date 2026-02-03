<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema; 
use Illuminate\Database\Schema\Blueprint;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::latest()->get();
        // Cek tabel registration untuk menghindari error view
        $totalPendaftar = class_exists(Registration::class) ? Registration::count() : 0;
        return view('admin.events.index', compact('events', 'totalPendaftar'));
    }

    public function create()
    {
        return view('admin.events.create');
    }

    public function store(Request $request)
    {
        // 1. VALIDASI DATA
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'date' => 'required',
            'time' => 'required',
            'location' => 'required',
            'quota' => 'required|numeric',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi Gambar
            'kategori_peserta' => 'required', // Kategori Baru
            'target_peserta' => 'nullable',   // Nama Fakultas Baru
        ]);

        // 2. PROSES UPLOAD GAMBAR (Ini yang mungkin hilang sebelumnya)
        $imagePath = null;
        if ($request->hasFile('image')) {
            // Simpan ke folder 'public/events' dan ambil nama filenya
            $imagePath = $request->file('image')->store('events', 'public');
        }

        // 3. SIMPAN KE DATABASE
        \App\Models\Event::create([
            'title' => $request->title,
            'description' => $request->description,
            'date' => $request->date,
            'time' => $request->time,
            'location' => $request->location,
            'quota' => $request->quota,
            'price' => $request->price,
            
            // Simpan path gambar yang sudah diupload tadi
            'image' => $imagePath, 
            
            // Simpan Kategori & Fakultas
            'kategori_peserta' => $request->kategori_peserta,
            'target_peserta' => $request->target_peserta,
        ]);

        return redirect()->route('admin.events.index')->with('success', 'Event berhasil dibuat beserta gambarnya!');
    }

    public function show(Event $event)
    {
        return view('admin.events.show', compact('event'));
    }

    public function edit(Event $event)
    {
        return view('admin.events.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        // --- AUTO-CLEANER JUGA DI SINI (BIAR AMAN SAAT EDIT) ---
        $tableName = 'events';
        Schema::table($tableName, function (Blueprint $table) use ($tableName) {
            if (Schema::hasColumn($tableName, 'created_by')) {
                try { $table->dropForeign('events_created_by_foreign'); } catch (\Exception $e) {}
                $table->dropColumn('created_by');
            }
            // Hapus sisa kolom hantu
            foreach (['event_date', 'registration_end'] as $col) {
                if (Schema::hasColumn($tableName, $col)) { $table->dropColumn($col); }
            }
        });

        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required',
            'date'        => 'required|date',
            'time'        => 'required',
            'location'    => 'required|string',
            'quota'       => 'required|integer|min:0',
            'category'    => 'nullable|string',
        ]);

        $validated['slug'] = Str::slug($request->title);
        
        $event->update($validated);

        return redirect()->route('admin.events.index')
            ->with('success', 'Event berhasil diperbarui!');
    }

    public function destroy(Event $event)
    {
        $event->delete();
        return redirect()->route('admin.events.index')
            ->with('success', 'Event berhasil dihapus.');
    }
}