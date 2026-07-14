<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kelola Event') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-gray-800">Daftar Event</h2>
                        <a href="{{ route('admin.events.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg font-bold hover:bg-blue-700">
                            + Tambah Event
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">JUDUL EVENT</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">JADWAL</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider w-1/4">PROGRESS KUOTA</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">STATUS</th>
                                    <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">AKSI</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($events as $event)
                                <tr>
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-bold text-gray-900">{{ $event->title }}</div>
                                        <div class="text-xs text-gray-500 mt-1">📍 {{ $event->location }}</div>
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900 font-medium">{{ \Carbon\Carbon::parse($event->date)->format('d M Y') }}</div>
                                        <div class="text-xs text-blue-600 mt-1 font-bold">⏰ {{ $event->time_start ?? '08:00' }} WIB</div>
                                    </td>

                                    <td class="px-6 py-4 align-middle">
                                        @php
                                            // Menggunakan ?->count() agar jika relasi null, tidak error
                                            $terisi = $event->registrations?->count() ?? 0;
                                            $persen = $event->quota > 0 ? ($terisi / $event->quota) * 100 : 0;
                                            $color = $persen >= 100 ? 'bg-red-500' : 'bg-blue-600';
                                        @endphp
                                        
                                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                                            <div class="{{ $color }} h-2.5 rounded-full transition-all duration-500" style="width: {{ $persen }}%"></div>
                                        </div>
                                        
                                        <div class="flex justify-between text-xs text-gray-500 mt-1 font-medium">
                                            <span>{{ $terisi }} Peserta</span>
                                            <span>Max: {{ $event->quota }}</span>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4">
                                        @if($event->quota_tersedia <= 0)
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Penuh</span>
                                        @else
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Buka</span>
                                        @endif
                                    </td>

                                    <td class="px-6 py-4 text-center text-sm font-medium">
                                        <div class="flex justify-center items-center gap-3">
                                            <a href="{{ route('admin.events.show', $event->id) }}" class="p-1 rounded-full text-blue-500 hover:bg-blue-50" title="Detail">👁️</a>
                                            <a href="{{ route('admin.events.edit', $event->id) }}" class="p-1 rounded-full text-yellow-500 hover:bg-yellow-50" title="Edit">✏️</a>
                                            <form action="{{ route('admin.events.destroy', $event->id) }}" method="POST" onsubmit="return confirm('Yakin hapus?');">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="p-1 rounded-full text-red-500 hover:bg-red-50" title="Hapus">🗑️</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout> 