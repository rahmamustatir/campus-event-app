<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Jelajah Event Kampus') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white p-6 rounded-xl shadow-sm mb-8 border border-gray-100">
                <form action="{{ route('explore') }}" method="GET">
                    
                    <label class="block text-gray-700 text-sm font-bold mb-2 flex items-center gap-2">
                        🔍 Filter Event Berdasarkan Kategori:
                    </label>

                    <div class="flex flex-col md:flex-row gap-3">
                        <select name="kategori" class="w-full md:w-1/3 rounded-lg border-gray-300 text-gray-700 focus:ring-blue-500 focus:border-blue-500 shadow-sm cursor-pointer">
                            <option value="">📂 Tampilkan Semua Event</option>
                            <option value="umum" {{ request('kategori') == 'umum' ? 'selected' : '' }}>🌍 Umum (Semua Mahasiswa)</option>
                            <option value="Fastek" {{ request('kategori') == 'Fastek' ? 'selected' : '' }}>⚙️ Fakultas Teknik (FASTEK)</option>
                            <option value="FP3" {{ request('kategori') == 'FP3' ? 'selected' : '' }}>💰 Fakultas Ekonomi (FEB)</option>
                            <option value="FEB" {{ request('kategori') == 'FEB' ? 'selected' : '' }}>⚖️ Fakultas Hukum</option>
                            <option value="FKIP" {{ request('kategori') == 'FKIP' ? 'selected' : '' }}>🎓 Fakultas Keguruan (FKIP)</option>
                        </select>
                        
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-bold shadow-md transition flex items-center justify-center">
                            Terapkan Filter
                        </button>
                        
                        @if(request('kategori'))
                            <a href="{{ route('explore') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-600 px-6 py-2 rounded-lg font-bold border border-gray-300 transition text-center flex items-center justify-center">
                                Reset 🔄
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($events as $event)
                    @php
                        // Logika Cek Fakultas & Kuota
                        $userFakultas = Auth::user()->biodata->fakultas ?? '';
                        $bolehDaftar = ($event->kategori_peserta == 'umum') || ($event->target_peserta == $userFakultas);
                        $terisi = \App\Models\Registration::where('event_id', $event->id)->count();
                        $sisaKuota = $event->quota - $terisi;
                        $sudahDaftar = \App\Models\Registration::where('user_id', Auth::id())
                                        ->where('event_id', $event->id)->exists();
                    @endphp

                    <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition duration-300 border border-gray-100 flex flex-col h-full group">
                        
                        <div class="relative h-48 bg-gray-100 overflow-hidden flex items-center justify-center">
                            @if($event->image)
                                <img src="{{ asset('storage/' . $event->image) }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                            @else
                                <span class="text-gray-400 font-bold text-lg">No Image</span>
                            @endif

                            <div class="absolute top-3 left-3">
                                @if($event->kategori_peserta == 'umum')
                                    <span class="bg-green-500 text-white text-xs font-bold px-3 py-1 rounded-full shadow-md uppercase flex items-center gap-1">
                                        <span class="w-2 h-2 bg-white rounded-full inline-block"></span> UMUM
                                    </span>
                                @else
                                    <span class="bg-purple-600 text-white text-xs font-bold px-3 py-1 rounded-full shadow-md uppercase flex items-center gap-1">
                                        <span class="w-2 h-2 bg-white rounded-full inline-block"></span> {{ Str::limit($event->target_peserta, 15) }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="p-6 flex-1 flex flex-col">
                            <h3 class="font-bold text-xl text-gray-900 mb-2 leading-tight">{{ $event->title }}</h3>
                            
                            <div class="text-sm text-gray-600 space-y-2 mb-4">
                                <p class="flex items-center gap-2">📅 {{ \Carbon\Carbon::parse($event->date)->format('d M Y') }}</p>
                                <p class="flex items-center gap-2">📍 {{ Str::limit($event->location, 30) }}</p>
                                <p class="text-green-600 font-bold flex items-center gap-2">💰 {{ $event->price == 0 ? 'Gratis' : 'Rp ' . number_format($event->price, 0, ',', '.') }}</p>
                            </div>

                            <div class="mt-auto pt-4 border-t border-gray-100">
                                @if($sudahDaftar)
                                    <button disabled class="w-full bg-green-100 text-green-700 font-bold py-2 rounded-lg cursor-not-allowed border border-green-200">
                                        ✅ Terdaftar
                                    </button>
                                @elseif(!$bolehDaftar)
                                    <button disabled class="w-full bg-gray-100 text-gray-400 font-bold py-2 rounded-lg cursor-not-allowed border border-gray-200">
                                        ⛔ Khusus {{ $event->target_peserta }}
                                    </button>
                                @elseif($sisaKuota <= 0)
                                    <button disabled class="w-full bg-red-100 text-red-500 font-bold py-2 rounded-lg cursor-not-allowed">
                                        ❌ Penuh
                                    </button>
                                @else
                                    <form action="{{ route('registrations.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="event_id" value="{{ $event->id }}">
                                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 rounded-lg shadow-md transition transform hover:-translate-y-1" onclick="return confirm('Apakah Anda yakin ingin mendaftar?')">
                                            Daftar Sekarang 🚀
                                        </button>
                                    </form>
                                    <p class="text-center text-xs text-gray-400 mt-2">Sisa Kuota: {{ $sisaKuota }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-1 md:col-span-3 py-12 text-center text-gray-500">
                        <p>Belum ada event yang tersedia saat ini.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>