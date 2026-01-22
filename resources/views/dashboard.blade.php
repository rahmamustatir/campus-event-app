<x-app-layout>
    
    <style>
        /* Override Background Default jadi Dark Mode Elegan */
        body { background-color: #0f172a !important; color: white !important; }
        .min-h-screen { background-color: #0f172a !important; }

        /* Background Abstrak Neon */
        .neon-bg {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: -1;
            background: radial-gradient(circle at 10% 20%, rgba(37, 99, 235, 0.2) 0%, transparent 40%),
                        radial-gradient(circle at 90% 80%, rgba(236, 72, 153, 0.2) 0%, transparent 40%);
        }

        /* Kartu Tiket Spesial */
        .ticket-card {
            background: rgba(30, 41, 59, 0.7);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            overflow: hidden;
            transition: all 0.3s ease;
            position: relative;
        }
        .ticket-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px -10px rgba(59, 130, 246, 0.5);
            border-color: rgba(59, 130, 246, 0.5);
        }

        /* Garis Putus-putus Tiket */
        .ticket-divider {
            border-top: 2px dashed rgba(255, 255, 255, 0.2);
            position: relative;
            margin: 15px 0;
        }
        /* Lubang Tiket (Kiri Kanan) */
        .ticket-divider::before, .ticket-divider::after {
            content: ''; position: absolute; top: -10px; width: 20px; height: 20px;
            background-color: #0f172a; border-radius: 50%;
        }
        .ticket-divider::before { left: -25px; }
        .ticket-divider::after { right: -25px; }

        /* Status Badge Neon */
        .badge-neon {
            background: linear-gradient(45deg, #3b82f6, #8b5cf6);
            color: white; padding: 4px 12px; border-radius: 20px;
            font-size: 0.75rem; font-weight: bold; text-transform: uppercase;
            box-shadow: 0 0 10px rgba(59, 130, 246, 0.5);
        }
    </style>

    <div class="neon-bg"></div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-10 flex flex-col md:flex-row justify-between items-end gap-4">
                <div>
                    <h3 class="text-3xl font-black text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-pink-500 mb-2">
                        Halo, {{ Auth::user()->name }}! 👋
                    </h3>
                    <p class="text-gray-400">Siap untuk pengalaman seru hari ini?</p>
                </div>
                <a href="/#events" class="bg-white text-gray-900 px-6 py-2 rounded-full font-bold hover:bg-blue-400 hover:text-white transition shadow-lg flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    Cari Event Baru
                </a>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-10">
                <div class="bg-gray-800/50 p-4 rounded-2xl border border-gray-700">
                    <span class="text-gray-400 text-xs uppercase font-bold">Total Event</span>
                    <p class="text-2xl font-bold text-white">{{ isset($myRegistrations) ? $myRegistrations->count() : 0 }}</p>
                </div>
                <div class="bg-gray-800/50 p-4 rounded-2xl border border-gray-700">
                    <span class="text-gray-400 text-xs uppercase font-bold">Status Akun</span>
                    <p class="text-2xl font-bold text-green-400">Aktif ✅</p>
                </div>
            </div>

            <h4 class="text-xl font-bold text-white mb-6 flex items-center border-l-4 border-pink-500 pl-3">
                🎟️ Tiket Saya (E-Wallet)
            </h4>

            @if(isset($myRegistrations) && $myRegistrations->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($myRegistrations as $reg)
                        <div class="ticket-card group">
                            <div class="p-5 pb-2 relative">
                                <div class="absolute top-4 right-4">
                                    <span class="badge-neon">TIKET RESMI</span>
                                </div>
                                <p class="text-xs text-blue-400 font-bold tracking-widest mb-1">EVENT TICKET</p>
                                <h3 class="text-xl font-bold text-white leading-tight group-hover:text-blue-400 transition">
                                    {{ $reg->event->title }}
                                </h3>
                                <p class="text-sm text-gray-400 mt-2 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    {{ Str::limit($reg->event->location, 25) }}
                                </p>
                            </div>

                            <div class="ticket-divider"></div>

                            <div class="p-5 pt-0">
                                <div class="flex justify-between items-center mb-4">
                                    <div>
                                        <p class="text-xs text-gray-500 uppercase">Tanggal</p>
                                        <p class="text-sm font-bold text-white">{{ \Carbon\Carbon::parse($reg->event->event_date)->format('d M Y') }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-xs text-gray-500 uppercase">Jam</p>
                                        <p class="text-sm font-bold text-white">{{ \Carbon\Carbon::parse($reg->event->event_date)->format('H:i') }} WIB</p>
                                    </div>
                                </div>

                                <div class="bg-gray-900/80 p-3 rounded-xl flex justify-between items-center border border-gray-700">
                                    <div class="flex flex-col">
                                        <span class="text-[10px] text-gray-500 uppercase">Kode Tiket</span>
                                        <span class="text-lg font-mono font-bold text-pink-500 tracking-wider">{{ $reg->ticket_code }}</span>
                                    </div>
                                    <a href="{{ route('ticket.download', $reg->id) }}" class="bg-gray-700 hover:bg-white hover:text-black text-white p-2 rounded-lg transition" title="Download PDF">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-16 border-2 border-dashed border-gray-700 rounded-2xl bg-gray-800/30">
                    <div class="bg-gray-800 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4 animate-bounce">
                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">Belum ada tiket</h3>
                    <p class="text-gray-400 mb-6">Wah, kamu belum mendaftar event apapun nih.</p>
                    <a href="/#events" class="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-8 py-3 rounded-full font-bold shadow-lg hover:scale-105 transition transform inline-block">
                        Mulai Jelajah Event 🚀
                    </a>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>