<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Riwayat Pendaftaran') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    @if($registrations->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @foreach($registrations as $reg)
                                <div class="border rounded-lg p-6 hover:shadow-lg transition-all duration-300 border-l-4 border-l-blue-500 bg-white">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h3 class="text-xl font-bold text-blue-900 mb-1">{{ $reg->event->title }}</h3>
                                            <p class="text-sm text-gray-600 mb-3">
                                                📅 {{ \Carbon\Carbon::parse($reg->event->date)->format('d M Y') }} | ⏰ {{ $reg->event->time }}
                                            </p>
                                            <p class="text-sm text-gray-500">
                                                📍 {{ $reg->event->location }}
                                            </p>
                                        </div>
                                        <div class="text-right">
                                            <span class="bg-green-100 text-green-800 text-xs font-bold px-3 py-1 rounded-full uppercase">
                                                {{ $reg->status }}
                                            </span>
                                        </div>
                                    </div>
                                    
                                    <hr class="my-4 border-gray-100">
                                    
                                    <div class="flex justify-between items-center">
                                        <span class="text-xs text-gray-400">Didaftar pada: {{ $reg->created_at->format('d M Y') }}</span>
                                        <a href="{{ route('ticket.download', $reg->id) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                                            🖨️ Cetak Tiket
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-10">
                            <h3 class="text-lg font-medium text-gray-500">Belum ada riwayat event.</h3>
                            <a href="/" class="text-blue-600 hover:underline mt-2 inline-block">Cari Event Baru &rarr;</a>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>