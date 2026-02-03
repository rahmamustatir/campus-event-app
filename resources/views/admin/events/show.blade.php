<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Event: ') }} {{ $event->title }}
            </h2>
            <a href="{{ route('admin.events.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md text-sm">
                &larr; Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 flex flex-col md:flex-row gap-6">
                <div class="w-full md:w-1/3">
                    @if($event->image)
                        <img src="{{ asset('storage/' . $event->image) }}" class="w-full rounded-lg shadow-md object-cover">
                    @else
                        <div class="w-full h-48 bg-gray-200 rounded-lg flex items-center justify-center text-gray-500 font-bold">
                            No Image
                        </div>
                    @endif
                </div>

                <div class="w-full md:w-2/3 space-y-4">
                    <h3 class="text-2xl font-bold text-gray-900">{{ $event->title }}</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                        <div>
                            <p class="text-gray-500">Tanggal:</p>
                            <p class="font-semibold">{{ \Carbon\Carbon::parse($event->date)->format('d F Y') }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500">Waktu:</p>
                            <p class="font-semibold">{{ $event->time }} WIB</p>
                        </div>
                        <div>
                            <p class="text-gray-500">Lokasi:</p>
                            <p class="font-semibold">{{ $event->location }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500">Harga Tiket:</p>
                            <p class="font-semibold text-green-600">
                                {{ $event->price == 0 ? 'Gratis' : 'Rp ' . number_format($event->price, 0, ',', '.') }}
                            </p>
                        </div>
                        <div>
                            <p class="text-gray-500">Kuota:</p>
                            <p class="font-semibold">{{ $event->quota }} Peserta</p>
                        </div>
                        <div>
                            <p class="text-gray-500">Target Peserta:</p>
                            <span class="px-2 py-1 rounded text-xs font-bold {{ $event->kategori_peserta == 'umum' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                                {{ strtoupper($event->target_peserta) }}
                            </span>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-gray-100">
                        <p class="text-gray-500 mb-1">Deskripsi:</p>
                        <p class="text-gray-700 leading-relaxed">{{ $event->description }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold mb-4 border-b pb-2">📋 Peserta Terdaftar ({{ $event->registrations->count() }})</h3>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-gray-600">
                        <thead class="bg-gray-50 uppercase text-xs font-bold">
                            <tr>
                                <th class="px-4 py-3">No</th>
                                <th class="px-4 py-3">Nama Mahasiswa</th>
                                <th class="px-4 py-3">Email</th>
                                <th class="px-4 py-3">Status</th>
                                <th class="px-4 py-3">Tanggal Daftar</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($event->registrations as $index => $reg)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3">{{ $index + 1 }}</td>
                                    <td class="px-4 py-3 font-medium text-gray-900 flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold text-xs">
                                            {{ substr($reg->user->name, 0, 1) }}
                                        </div>
                                        {{ $reg->user->name }}
                                    </td>
                                    <td class="px-4 py-3">{{ $reg->user->email }}</td>
                                    <td class="px-4 py-3">
                                        @if($reg->status == 'confirmed')
                                            <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs">Terdaftar</span>
                                        @elseif($reg->status == 'checked_in')
                                            <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs">Hadir</span>
                                        @else
                                            <span class="bg-gray-100 text-gray-800 px-2 py-1 rounded text-xs">{{ $reg->status }}</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">{{ $reg->created_at->format('d M Y H:i') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-6 text-center text-gray-400">
                                        Belum ada peserta yang mendaftar.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>