<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Laporan Event Kampus') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-bold">Ringkasan Pelaksanaan Event</h3>
                        <a href="{{ route('admin.reports.bulanan') }}" 
                           class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-bold hover:bg-blue-700">
                            📄 Download Laporan Bulanan
                        </a>
                    </div>

                    <div class="overflow-x-auto border rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Nama Event</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Tanggal & Waktu</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Lokasi</th>
                                    <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Partisipasi</th>
                                    <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($events as $event)
                                <tr>
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-bold text-gray-900">{{ $event->title }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-600">
                                            {{ \Carbon\Carbon::parse($event->date)->format('d M Y') }}
                                        </div>
                                        <div class="text-xs text-gray-400">{{ $event->time }} WIB</div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        {{ $event->location }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="px-3 py-1 rounded-full text-xs font-bold {{ $event->registrations_count >= $event->quota ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                                            {{ $event->registrations_count }} / {{ $event->quota }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @if($event->date < now()->toDateString())
                                            <span class="text-xs font-bold text-gray-500 border border-gray-300 px-2 py-1 rounded">SELESAI</span>
                                        @else
                                            <span class="text-xs font-bold text-green-600 border border-green-200 bg-green-50 px-2 py-1 rounded">AKAN DATANG</span>
                                        @endif
                                    </td>
                                    
                                    <td class="px-6 py-4 text-center">
                                        <a href="{{ route('admin.reports.export_participants', $event->id) }}" 
                                           class="bg-red-600 text-white px-3 py-1 rounded text-xs font-bold hover:bg-red-700 block mb-1">
                                            Daftar Hadir
                                        </a>

                                        </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                        Belum ada data event untuk dilaporkan.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4 text-xs text-gray-400 text-right">
                        Dicetak otomatis oleh Sistem pada {{ now()->format('d M Y H:i') }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>