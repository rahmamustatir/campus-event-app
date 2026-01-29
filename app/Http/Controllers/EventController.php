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
        // =========================================================
        // 🛠️ AUTO-CLEANER (PEMBERSIH DATABASE - VERSI FINAL)
        // =========================================================
        $tableName = 'events';

        Schema::table($tableName, function (Blueprint $table) use ($tableName) {
            
            // 1. SIASAT KHUSUS: HAPUS FOREIGN KEY 'created_by' (Biang kerok error 1828)
            if (Schema::hasColumn($tableName, 'created_by')) {
                try {
                    // Coba putus kuncinya dulu
                    $table->dropForeign('events_created_by_foreign'); 
                } catch (\Exception $e) {
                    // Abaikan jika kuncinya sudah tidak ada
                }
                // Baru hapus kolomnya
                $table->dropColumn('created_by');
            }

            // 2. HAPUS KOLOM LAINNYA
            $ghostColumns = ['event_date', 'registration_end', 'deleted_at'];
            foreach ($ghostColumns as $col) {
                if (Schema::hasColumn($tableName, $col)) {
                    $table->dropColumn($col);
                }
            }

            // 3. PASTIKAN KOLOM WAJIB ADA
            if (!Schema::hasColumn($tableName, 'slug')) { $table->string('slug')->nullable()->after('title'); }
            if (!Schema::hasColumn($tableName, 'quota')) { $table->integer('quota')->default(0)->after('location'); }
            if (!Schema::hasColumn($tableName, 'category')) { $table->string('category')->nullable()->after('title'); }
        });
        // =========================================================


        // --- PROSES SIMPAN SEPERTI BIASA ---
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

        Event::create($validated);

        return redirect()->route('admin.events.index')
            ->with('success', 'Alhamdulillah! Event berhasil disimpan. Database sudah bersih total.');
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