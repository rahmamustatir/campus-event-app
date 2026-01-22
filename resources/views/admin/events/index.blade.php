<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight drop-shadow-md">
            {{ __('Kelola Event') }}
        </h2>
    </x-slot>

    <style>
        /* Container Background */
        .nature-bg-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1; 
            overflow: hidden;
            background-color: #1a202c; /* Warna cadangan jika gambar gagal load */
        }

        /* Gambar Alam dengan Animasi */
        .nature-bg-image {
            /* --- LINK GAMBAR LANGSUNG (Pemandangan Alam) --- */
            background-image: url('https://images.unsplash.com/photo-1506744038136-46273834b3fb?q=80&w=1920&auto=format&fit=crop');
            
            background-size: cover;
            background-position: center;
            width: 100%;
            height: 100%;
            /* Animasi Zoom lambat (40 detik) */
            animation: slowZoom 40s ease-in-out infinite alternate;
        }

        /* Lapisan Gelap (Overlay) agar tulisan jelas */
        .nature-bg-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.4); /* Gelap 40% */
        }

        /* Keyframe Animasi Zoom */
        @keyframes slowZoom {
            0% { transform: scale(1); }
            100% { transform: scale(1.2); }
        }

        /* Efek Kaca (Glassmorphism) */
        .glass-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
    </style>

    <div class="nature-bg-container">
        <div class="nature-bg-image"></div>
        <div class="nature-bg-overlay"></div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="glass-card mb-6 bg-green-100/90 border-l-4 border-green-500 text-green-800 p-4 rounded shadow-lg animate-bounce" role="alert">
                    <p class="font-bold">Berhasil!</p>
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="glass-card overflow-hidden rounded-lg p-6 border-l-4 border-blue-600 hover:scale-105 transition transform duration-300">
                    <div class="text-gray-600 text-sm font-bold uppercase tracking-wider">Total Event Aktif</div>
                    <div class="mt-2 text-4xl font-extrabold text-gray-900">{{ $events->count() }}</div>
                </div>
                <div class="glass-card overflow-hidden rounded-lg p-6 border-l-4 border-purple-600 hover:scale-105 transition transform duration-300">
                    <div class="text-gray-600 text-sm font-bold uppercase tracking-wider">Total Pendaftar</div>
                    <div class="mt-2 text-4xl font-extrabold text-gray-900">{{ $events->sum('registrations_count') }}</div>
                </div>
                <div class="glass-card overflow-hidden rounded-lg p-6 border-l-4 border-green-600 hover:scale-105 transition transform duration-300">
                    <div class="text-gray-600 text-sm font-bold uppercase tracking-wider">Status Sistem</div>
                    <div class="mt-2 text-lg font-bold text-green-700 flex items-center">
                        <span class="relative flex h-3 w-3 mr-2">
                          <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                          <span class="relative inline-flex rounded-full h-3 w-3 bg-green-500"></span>
                        </span>
                        Online
                    </div>
                </div>
            </div>

            <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
                <h3 class="text-2xl font-bold text-white drop-shadow-lg flex items-center">
                    <span class="bg-white/20 p-2 rounded-lg mr-2 backdrop-blur-sm">🏔️</span>
                    Daftar Event Kampus
                </h3>
                <a href="{{ route('admin.events.create') }}" class="glass-card text-blue-800 font-bold py-3 px-6 rounded-full shadow-xl transition transform hover:scale-110 hover:bg-white flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Tambah Event Baru
                </a>
            </div>

            <div class="glass-card overflow-hidden rounded-xl shadow-2xl">
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white/70 backdrop-blur-sm"> 
                        <thead>
                            <tr class="bg-gray-200/60 text-gray-800 uppercase text-xs leading-normal border-b border-gray-300/50">
                                <th class="py-4 px-6 text-left font-extrabold">Judul Event</th>
                                <th class="py-4 px-6 text-left font-extrabold">Jadwal</th>
                                <th class="py-4 px-6 text-left font-extrabold">Progress Kuota</th>
                                <th class="py-4 px-6 text-center font-extrabold">Status</th>
                                <th class="py-4 px-6 text-center font-extrabold">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-800 text-sm font-medium">
                            @foreach($events as $event)
                                <tr class="border-b border-gray-200/50 hover:bg-white/90 transition duration-200">
                                    <td class="py-4 px-6 text-left whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="mr-3">
                                                <div class="bg-blue-100 text-blue-700 p-2.5 rounded-lg shadow-sm">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                </div>
                                            </div>
                                            <div>
                                                <span class="font-bold text-gray-900 block text-base">{{ $event->title }}</span>
                                                <span class="text-xs text-gray-600 flex items-center mt-1">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                                    {{ $event->location }}
                                                </span>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="py-4 px-6 text-left">
                                        <div class="flex flex-col">
                                            <span class="font-semibold">{{ \Carbon\Carbon::parse($event->event_date)->translatedFormat('d M Y') }}</span>
                                            <span class="text-xs text-blue-800 bg-blue-100 px-2 py-0.5 rounded-full w-max mt-1 border border-blue-200">
                                                ⏰ {{ \Carbon\Carbon::parse($event->event_date)->format('H:i') }} WIB
                                            </span>
                                        </div>
                                    </td>
                                    
                                    <td class="py-4 px-6 text-left w-1/4">
                                        <div class="w-full bg-gray-300 rounded-full h-2.5 mb-2 overflow-hidden shadow-inner">
                                            @php 
                                                $percent = ($event->quota > 0) ? ($event->registrations_count / $event->quota) * 100 : 0;
                                                $color = $percent >= 100 ? 'bg-red-500' : ($percent >= 80 ? 'bg-yellow-500' : 'bg-blue-600');
                                            @endphp
                                            <div class="{{ $color }} h-2.5 rounded-full transition-all duration-1000" style="width: {{ $percent }}%"></div>
                                        </div>
                                        <div class="flex justify-between text-xs text-gray-600 font-bold">
                                            <span>👤 {{ $event->registrations_count }}</span>
                                            <span>Max: {{ $event->quota }}</span>
                                        </div>
                                    </td>

                                    <td class="py-4 px-6 text-center">
                                        @if($event->event_date < now())
                                            <span class="bg-gray-300 text-gray-800 py-1 px-3 rounded-full text-xs font-bold border border-gray-400">Selesai</span>
                                        @elseif($event->sisaKuota() <= 0)
                                            <span class="bg-red-100 text-red-800 py-1 px-3 rounded-full text-xs font-bold border border-red-300">Penuh</span>
                                        @else
                                            <span class="bg-green-100 text-green-800 py-1 px-3 rounded-full text-xs font-bold border border-green-300">Buka</span>
                                        @endif
                                    </td>

                                    <td class="py-4 px-6 text-center">
                                        <div class="flex item-center justify-center space-x-2">
                                            <a href="{{ route('admin.events.show', $event->id) }}" class="w-9 h-9 flex items-center justify-center bg-blue-100 text-blue-700 rounded-full hover:bg-blue-600 hover:text-white transition shadow-sm border border-blue-300" title="Lihat Peserta">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                            </a>
                                            <a href="{{ route('admin.events.edit', $event->id) }}" class="w-9 h-9 flex items-center justify-center bg-yellow-100 text-yellow-700 rounded-full hover:bg-yellow-500 hover:text-white transition shadow-sm border border-yellow-300" title="Edit Event">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                            </a>
                                            <a href="{{ route('admin.scan.index') }}" class="w-9 h-9 flex items-center justify-center bg-purple-100 text-purple-700 rounded-full hover:bg-purple-600 hover:text-white transition shadow-sm border border-purple-300" title="Scan Tiket">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                                            </a>
                                            <form action="{{ route('admin.events.destroy', $event->id) }}" method="POST" onsubmit="return confirm('Hapus event?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="w-9 h-9 flex items-center justify-center bg-red-100 text-red-700 rounded-full hover:bg-red-600 hover:text-white transition shadow-sm border border-red-300" title="Hapus">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if($events->isEmpty())
                    <div class="text-center py-12 bg-white/60 backdrop-blur-md">
                        <p class="text-gray-800 text-lg font-medium">Belum ada event.</p>
                        <a href="{{ route('admin.events.create') }}" class="text-blue-700 hover:underline mt-2 font-bold">Buat Event Baru</a>
                    </div>
                @endif
            </div>
            
        </div>
    </div>
</x-app-layout>