<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight drop-shadow-md">
            {{ __('Scan Tiket') }}
        </h2>
    </x-slot>

    <style>
        .nature-bg-container { position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: -1; background-color: #1a202c; }
        .nature-bg-image {
            background-image: url('https://images.unsplash.com/photo-1506744038136-46273834b3fb?q=80&w=1920&auto=format&fit=crop');
            background-size: cover; background-position: center; width: 100%; height: 100%;
            animation: slowZoom 40s ease-in-out infinite alternate;
        }
        .nature-bg-overlay { position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.4); }
        @keyframes slowZoom { 0% { transform: scale(1); } 100% { transform: scale(1.2); } }
        .glass-card {
            background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.5); box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
    </style>

    <div class="nature-bg-container"><div class="nature-bg-image"></div><div class="nature-bg-overlay"></div></div>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="glass-card overflow-hidden shadow-2xl sm:rounded-2xl p-8 text-center">
                
                <div class="mb-6">
                    <div class="bg-blue-100 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4 animate-pulse">
                        <svg class="w-10 h-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800">Scan QR Code</h3>
                    <p class="text-gray-500">Arahkan kamera ke tiket peserta</p>
                </div>

                <div id="reader" class="w-full bg-black rounded-lg h-64 flex items-center justify-center text-white border-4 border-blue-500 mb-6">
                    <p class="text-sm opacity-50">[ Area Kamera Scanner ]</p>
                </div>

                <form action="{{ route('admin.scan.process') }}" method="POST" class="flex gap-2">
                    @csrf
                    <input type="text" name="ticket_code" placeholder="Atau ketik kode tiket..." class="flex-1 rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 shadow-md">Check In</button>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>