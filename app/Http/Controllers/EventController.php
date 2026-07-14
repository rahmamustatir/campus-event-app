<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Registration;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    // --- FUNGSI ADMIN ---

    public function index()
    {
        $events = Event::all(); 
        return view('admin.events.index', compact('events'));
    }

    public function create()
    {
        return view('admin.events.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'date'        => 'required|date',
            'location'    => 'required|string|max:255',
            'quota'       => 'required|integer|min:1',
        ]);

        $validated['category_id'] = 1; 
        $validated['quota_tersedia'] = $request->quota;
        $validated['status'] = 'pending'; 
        $validated['time_start'] = '08:00:00';

        Event::create($validated);

        return redirect()->route('admin.events.index')->with('success', 'Event berhasil ditambahkan!');
    }

    public function show($id)
    {
        $event = Event::with('registrations')->findOrFail($id);
        return view('admin.events.show', compact('event'));
    }

    public function edit($id)
    {
        $event = Event::findOrFail($id);
        return view('admin.events.edit', compact('event'));
    }

    public function destroy($id)
    {
        $event = Event::findOrFail($id);
        $event->delete();
        return redirect()->route('admin.events.index')->with('success', 'Event berhasil dihapus!');
    }

    public function update(Request $request, $id)
{
    $event = Event::findOrFail($id);
    $event->update($request->all());
    return redirect()->route('admin.events.index')->with('success', 'Event berhasil diupdate!');
}

    // --- FUNGSI MAHASISWA ---

    public function register(Request $request, $id)
    {
        $event = Event::findOrFail($id);

        if ($event->quota_tersedia <= 0) {
            return back()->with('error', 'Maaf, kuota event sudah penuh.');
        }

        $alreadyRegistered = Registration::where('user_id', Auth::id())
                                        ->where('event_id', $event->id)
                                        ->exists();
        if ($alreadyRegistered) {
            return back()->with('error', 'Anda sudah terdaftar di event ini.');
        }

        DB::beginTransaction();
        try {
            $event->decrement('quota_tersedia');

            Registration::create([
                'user_id'           => Auth::id(),
                'event_id'          => $event->id,
                'registration_code' => 'EVT-' . strtoupper(bin2hex(random_bytes(3))),
                'status_presence'   => 'absent',
            ]);

            DB::commit();
            return redirect()->route('history')->with('success', 'Pendaftaran berhasil!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan, silakan coba lagi.');
        }
    }
}