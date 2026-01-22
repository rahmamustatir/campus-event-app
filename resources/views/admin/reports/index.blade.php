<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight drop-shadow-md no-print">
            {{ __('Laporan Event') }}
        </h2>
    </x-slot>

    <style>
        /* Tampilan Layar (Screen) */
        .nature-bg-container { position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: -1; background-color: #1a202c; }
        .nature-bg-image {
            background-image: url('https://images.unsplash.com/photo-1506744038136-46273834b3fb?q=80&w=1920&auto=format&fit=crop');
            background-size: cover; background-position: center; width: 100%; height: 100%;
            animation: slowZoom 40s ease-in-out infinite alternate;
        }
        .nature-bg-overlay { position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.4); }
        @keyframes slowZoom { 0% { transform: scale(1); } 100% { transform: scale(1.2); } }
        
        .glass-card {
            background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.5); box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }

        /* Tampilan Cetak (Print) - Background Hilang */
        @media print {
            .nature-bg-container, nav, header, .no-print { display: none !important; }
            body { background: white !important; color: black !important; }
            @page { margin: 2cm; }
            .print-header { display: block !important; }
            .glass-card { box-shadow: none !important; border: none !important; background: white !important; }
        }
        .print-header { display: none; text-align: center; margin-bottom: 20px; border-bottom: 2px solid black; padding-bottom: 10px; }
    </style>

    <div class="nature-bg-container"><div class="nature-bg-image"></div><div class="nature-bg-overlay"></div></div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="glass-card overflow-hidden shadow-sm sm:rounded-lg p-8">
                
                <div class="flex justify-between items-center mb-6 no-print">
                    <h3 class="text-lg font-bold text-gray-800 border-l-4 border-blue-600 pl-3">Rekapitulasi Data Event</h3>
                    
                    <div class="flex gap-2">
                        <a href="{{ route('admin.reports.export') }}" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition flex items-center gap-2 shadow-md">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            Download Excel
                        </a>

                        <button onclick="window.print()" class="bg-gray-800 text-white px-4 py-2 rounded-lg hover:bg-black transition flex items-center gap-2 shadow-md">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                            Print / PDF
                        </button>
                    </div>
                </div>

                <div class="print-header">
                    <h1 class="text-2xl font-bold uppercase">{{ config('app.name', 'Campus Event') }}</h1>
                    <p>Laporan Rekapitulasi Kegiatan & Pendaftaran</p>
                    <p class="text-sm">Dicetak pada: {{ date('d F Y, H:i') }}</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full border border-gray-300">
                        <thead>
                            <tr class="bg-gray-100 text-gray-700 text-sm uppercase">
                                <th class="py-3 px-4 border border-gray-300 text-left">Nama Event</th>
                                <th class="py-3 px-4 border border-gray-300 text-left">Waktu</th>
                                <th class="py-3 px-4 border border-gray-300 text-left">Lokasi</th>
                                <th class="py-3 px-4 border border-gray-300 text-center">Kuota</th>
                                <th class="py-3 px-4 border border-gray-300 text-center">Terdaftar</th>
                                <th class="py-3 px-4 border border-gray-300 text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($events as $event)
                                <tr class="hover:bg-gray-50 text-sm">
                                    <td class="py-2 px-4 border border-gray-300 font-bold">{{ $event->title }}</td>
                                    <td class="py-2 px-4 border border-gray-300">
                                        {{ \Carbon\Carbon::parse($event->event_date)->translatedFormat('d F Y') }}
                                    </td>
                                    <td class="py-2 px-4 border border-gray-300">{{ $event->location }}</td>
                                    <td class="py-2 px-4 border border-gray-300 text-center">{{ $event->quota }}</td>
                                    <td class="py-2 px-4 border border-gray-300 text-center font-bold text-blue-600">{{ $event->registrations_count }}</td>
                                    <td class="py-2 px-4 border border-gray-300 text-center">
                                        @if($event->event_date < now()) Selesai @else Aktif @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-10 hidden print:flex justify-end">
                    <div class="text-center">
                        <p>Mengetahui,</p>
                        <p>Admin Kampus</p>
                        <br><br><br>
                        <p class="font-bold underline">{{ Auth::user()->name }}</p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>