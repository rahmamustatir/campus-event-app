<x-app-layout>
    <style>
        body { background-color: #0f172a !important; color: white !important; }
        .min-h-screen { background-color: #0f172a !important; }
        .neon-bg {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: -1;
            background: radial-gradient(circle at 80% 20%, rgba(124, 58, 237, 0.15) 0%, transparent 40%),
                        radial-gradient(circle at 20% 80%, rgba(59, 130, 246, 0.15) 0%, transparent 40%);
        }
        /* Kartu Riwayat (Lebih tipis dari tiket aktif) */
        .history-card {
            background: rgba(30, 41, 59, 0.6);
            border-left: 4px solid #64748b; /* Warna abu-abu (tanda selesai) */
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        .history-card:hover {
            background: rgba(30, 41, 59, 0.9);
            border-left-color: #a855f7; /* Berubah ungu saat hover */
            transform: translateX(5px);
        }
    </style>

    <div class="neon-bg"></div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-8 flex items-center justify-between">
                <div>
                    <h2 class="text-3xl font-bold text-white">📜 Riwayat Event</h2>
                    <p class="text-gray-400">Daftar kegiatan yang telah kamu selesaikan.</p>
                </div>
                <div class="bg-gray-800 px-4 py-2 rounded-lg border border-gray-700">
                    <span class="text-gray-400 text-sm">Total Partisipasi:</span>
                    <span class="text-xl font-bold text-white ml-2">{{ $pastRegistrations->count() }}</span>
                </div>
            </div>

            @if($pastRegistrations->isEmpty())
                <div class="text-center py-16 border border-dashed border-gray-700 rounded-2xl bg-gray-800/30">
                    <div class="bg-gray-700 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 grayscale opacity-50">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-300">Belum ada riwayat</h3>
                    <p class="text-gray-500 text-sm">Event yang sudah selesai akan muncul di sini.</p>
                </div>
            @else
                <div class="grid gap-4">
                    @foreach($pastRegistrations as $reg)
                        <div class="history-card p-6 flex flex-col md:flex-row justify-between items-center gap-4">
                            <div class="flex-1">
                                <div class="flex items-center gap-3 mb-1">
                                    <span class="bg-gray-700 text-gray-300 text-[10px] px-2 py-0.5 rounded uppercase font-bold tracking-wider">Selesai</span>
                                    <span class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($reg->event->event_date)->format('d F Y') }}</span>
                                </div>
                                <h3 class="text-xl font-bold text-white mb-1">{{ $reg->event->title }}</h3>
                                <p class="text-gray-400 text-sm flex items-center">
                                    <svg class="w-4 h-4 mr-1 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    {{ $reg->event->location }}
                                </p>
                            </div>

                            <div class="flex items-center gap-4">
                                <div class="text-right hidden md:block">
                                    <p class="text-xs text-gray-500 uppercase">Kode Tiket</p>
                                    <p class="font-mono text-gray-300">{{ $reg->ticket_code }}</p>
                                </div>
                                <a href="{{ route('ticket.download', $reg->id) }}" class="p-2 bg-gray-700 rounded hover:bg-white hover:text-black transition" title="Download Arsip Tiket">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

        </div>
    </div>
</x-app-layout>