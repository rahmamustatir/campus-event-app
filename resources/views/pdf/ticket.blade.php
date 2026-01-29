<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Tiket - {{ $registration->event->title }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            body { -webkit-print-color-adjust: exact; }
            .no-print { display: none; }
        }
    </style>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen p-4">

    <div class="max-w-md w-full bg-white shadow-2xl rounded-xl overflow-hidden border border-gray-200">
        <div class="bg-blue-600 px-6 py-4 text-white text-center">
            <h2 class="text-xs font-bold tracking-widest uppercase opacity-80">E-TIKET RESMI</h2>
            <h1 class="text-2xl font-black mt-1">{{ $registration->event->title }}</h1>
        </div>

        <div class="p-6">
            <div class="text-center mb-6">
                <p class="text-sm text-gray-500 font-bold uppercase">Jadwal Event</p>
                <p class="text-lg font-bold text-gray-800">
                    {{ \Carbon\Carbon::parse($registration->event->date)->format('d F Y') }}
                </p>
                <p class="text-blue-600 font-bold text-xl">
                    {{ $registration->event->time }} WIB
                </p>
                <p class="text-sm text-gray-500 mt-1">
                    📍 {{ $registration->event->location }}
                </p>
            </div>

            <div class="border-t-2 border-dashed border-gray-300 my-4"></div>

            <div class="flex justify-between items-center mb-4">
                <div>
                    <p class="text-xs text-gray-500 uppercase font-bold">Nama Peserta</p>
                    <p class="text-lg font-bold text-gray-900">{{ $registration->user->name }}</p>
                    <p class="text-xs text-gray-400">{{ $registration->user->email }}</p>
                </div>
                <div class="text-right">
                    <p class="text-xs text-gray-500 uppercase font-bold">ID Tiket</p>
                    <p class="text-lg font-mono font-bold text-gray-900">#{{ str_pad($registration->id, 5, '0', STR_PAD_LEFT) }}</p>
                </div>
            </div>

            <div class="bg-gray-100 p-4 rounded-lg flex flex-col items-center justify-center border-2 border-dashed border-gray-300">
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ $registration->id }}-{{ $registration->user->email }}" 
                     alt="QR Code Tiket" 
                     class="w-32 h-32 mix-blend-multiply">
            </div>
        </div>

        <div class="bg-gray-50 px-6 py-4 border-t border-gray-100 flex justify-between items-center">
            <span class="text-xs text-gray-400">Dicetak: {{ now()->format('d/m/Y H:i') }}</span>
            <button onclick="window.print()" class="no-print bg-blue-600 text-white text-xs px-4 py-2 rounded font-bold hover:bg-blue-700 transition">
                🖨️ CETAK SEKARANG
            </button>
        </div>
    </div>

    <script>
        window.onload = function() { setTimeout(function() { window.print(); }, 1000); }
    </script>
</body>
</html>