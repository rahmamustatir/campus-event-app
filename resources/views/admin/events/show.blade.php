<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Detail Peserta</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm" role="alert">
                    <p class="font-bold">Berhasil!</p>
                    <p>{{ session('success') }}</p>
                </div>
            @endif
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6 flex justify-between items-center border-l-4 border-blue-600">
                <div>
                    <h3 class="text-2xl font-bold text-gray-800">{{ $event->title }}</h3>
                    <p class="text-gray-600 flex items-center mt-1">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        {{ \Carbon\Carbon::parse($event->event_date)->translatedFormat('d F Y, H:i') }} WIB 
                        <span class="mx-2">|</span> 
                        📍 {{ $event->location }}
                    </p>
                </div>
                <div class="text-right">
                    <span class="text-4xl font-extrabold text-blue-600">{{ $event->registrations->count() }}</span>
                    <span class="text-gray-500 block text-sm font-bold uppercase tracking-wide">/ {{ $event->quota }} Peserta</span>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4 border-b pb-2">
                        <h4 class="text-lg font-bold text-gray-800">Daftar Kehadiran</h4>
                        <span class="text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded">Total: {{ $event->registrations->count() }} Data</span>
                    </div>
                    
                    @if($event->registrations->isEmpty())
                        <div class="text-center py-10">
                            <svg class="w-16 h-16 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            <p class="text-gray-500">Belum ada peserta yang mendaftar.</p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full text-sm text-left text-gray-500">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
                                    <tr>
                                        <th class="px-6 py-3">Nama Mahasiswa</th>
                                        <th class="px-6 py-3">Email</th>
                                        <th class="px-6 py-3 text-center">Kode Tiket</th>
                                        <th class="px-6 py-3 text-center">Waktu Daftar</th>
                                        <th class="px-6 py-3 text-center">Status</th>
                                        <th class="px-6 py-3 text-center">Aksi</th> </tr>
                                </thead>
                                <tbody>
                                    @foreach($event->registrations as $reg)
                                        <tr class="bg-white border-b hover:bg-gray-50 transition">
                                            <td class="px-6 py-4 font-medium text-gray-900">{{ $reg->user->name }}</td>
                                            <td class="px-6 py-4">{{ $reg->user->email }}</td>
                                            <td class="px-6 py-4 text-center">
                                                <span class="font-mono text-blue-600 bg-blue-50 px-2 py-1 rounded border border-blue-100">{{ $reg->ticket_code }}</span>
                                            </td>
                                            <td class="px-6 py-4 text-center">{{ $reg->created_at->format('d M H:i') }}</td>
                                            <td class="px-6 py-4 text-center">
                                                @if($reg->status == 'attended')
                                                    <span class="bg-green-100 text-green-800 text-xs font-bold px-2.5 py-0.5 rounded border border-green-200">Hadir ✅</span>
                                                @else
                                                    <span class="bg-yellow-100 text-yellow-800 text-xs font-bold px-2.5 py-0.5 rounded border border-yellow-200">Belum Hadir</span>
                                                @endif
                                            </td>
                                            
                                            <td class="px-6 py-4 text-center">
                                                <form action="{{ route('admin.participants.destroy', $reg->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus peserta ini? Tiket mereka akan hangus.');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-500 hover:text-red-700 transition transform hover:scale-110" title="Hapus Peserta">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                    </button>
                                                </form>
                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
            
            <div class="mt-4">
                <a href="{{ route('admin.events.index') }}" class="text-gray-600 hover:text-blue-600 font-medium transition">&larr; Kembali ke Daftar Event</a>
            </div>

        </div>
    </div>
</x-app-layout>