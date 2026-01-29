<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Utama') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- LOGIKA: JIKA ADMIN, TAMPILKAN STATISTIK --}}
            @if(Auth::user()->usertype == 'admin')
                
                <div class="mb-6">
                    <h3 class="text-2xl font-bold text-gray-800">👋 Selamat Datang, Admin {{ Auth::user()->name }}!</h3>
                    <p class="text-gray-600">Berikut adalah ringkasan data sistem event kampus hari ini.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-8 border-blue-500">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-gray-500 text-sm font-bold uppercase tracking-wide">Total Event</p>
                                <p class="text-3xl font-black text-gray-800">
                                    {{ \App\Models\Event::count() }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-8 border-green-500">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-green-100 text-green-600 mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-gray-500 text-sm font-bold uppercase tracking-wide">Mahasiswa</p>
                                <p class="text-3xl font-black text-gray-800">
                                    {{ \App\Models\User::where('usertype', '!=', 'admin')->count() }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-8 border-purple-500">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-purple-100 text-purple-600 mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-gray-500 text-sm font-bold uppercase tracking-wide">Pendaftar</p>
                                <p class="text-3xl font-black text-gray-800">
                                    {{ \Illuminate\Support\Facades\DB::table('registrations')->count() }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h4 class="font-bold text-lg mb-4">Aksi Cepat</h4>
                    <div class="flex gap-4">
                        <a href="{{ route('admin.events.create') }}" class="bg-blue-600 text-white px-6 py-3 rounded-lg font-bold hover:bg-blue-700 shadow flex items-center gap-2">
                            <span>+</span> Buat Event Baru
                        </a>
                        <a href="{{ route('admin.scan.index') }}" class="bg-gray-800 text-white px-6 py-3 rounded-lg font-bold hover:bg-gray-700 shadow flex items-center gap-2">
                            <span>📷</span> Scan Tiket
                        </a>
                    </div>
                </div>

            @else
                
                {{-- LOGIKA: JIKA USER BIASA, TAMPILKAN TIKET SAYA --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="flex justify-between items-center mb-6">
                            <div>
                                <h3 class="text-xl font-bold text-gray-800">Halo, {{ Auth::user()->name }}! 👋</h3>
                                <p class="text-gray-600">Siap untuk pengalaman seru hari ini?</p>
                            </div>
                            <div class="bg-green-100 text-green-800 px-4 py-2 rounded-full text-sm font-bold">
                                Akun Mahasiswa Aktif
                            </div>
                        </div>

                        <div class="border-t pt-6">
                            <h4 class="font-bold text-lg mb-4 flex items-center gap-2">
                                🎫 Tiket Saya
                            </h4>
                            
                            {{-- Cek Tiket User --}}
                            @php
                                $myTickets = \Illuminate\Support\Facades\DB::table('registrations')
                                            ->join('events', 'registrations.event_id', '=', 'events.id')
                                            ->where('registrations.user_id', Auth::id())
                                            ->select('events.title', 'events.date', 'events.time', 'events.location')
                                            ->get();
                            @endphp

                            @if($myTickets->count() > 0)
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    @foreach($myTickets as $ticket)
                                        <div class="border rounded-lg p-4 hover:shadow-md transition bg-blue-50 border-blue-100">
                                            <h5 class="font-bold text-blue-900">{{ $ticket->title }}</h5>
                                            <p class="text-sm text-gray-600 mt-1">📅 {{ $ticket->date }} | ⏰ {{ $ticket->time }}</p>
                                            <p class="text-sm text-gray-500">📍 {{ $ticket->location }}</p>
                                            <div class="mt-3">
                                                <span class="bg-green-200 text-green-800 text-xs px-2 py-1 rounded font-bold">TERDAFTAR</span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-12 bg-gray-50 border border-dashed border-gray-300 rounded-lg">
                                    <div class="text-4xl mb-2">📂</div>
                                    <p class="text-gray-500 mb-4">Kamu belum mendaftar event apapun.</p>
                                    <a href="{{ url('/') }}" class="inline-block bg-blue-600 text-white px-4 py-2 rounded-lg font-bold hover:bg-blue-700">
                                        Cari Event Sekarang
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

            @endif

        </div>
    </div>
</x-app-layout>