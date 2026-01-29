<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail & Peserta Event') }}
            </h2>
            <a href="{{ route('admin.events.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg text-sm font-bold hover:bg-gray-600">
                &larr; Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="md:flex md:justify-between md:items-start">
                        <div class="mb-4 md:mb-0">
                            <h1 class="text-3xl font-black text-blue-900 mb-2">{{ $event->title }}</h1>
                            <div class="flex flex-col gap-2 text-sm text-gray-600">
                                <span class="flex items-center gap-2">
                                    🗓️ <strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($event->date)->format('d F Y') }}
                                </span>
                                <span class="flex items-center gap-2">
                                    ⏰ <strong>Waktu:</strong> {{ $event->time }} WIB
                                </span>
                                <span class="flex items-center gap-2">
                                    📍 <strong>Lokasi:</strong> {{ $event->location }}
                                </span>
                            </div>
                            <div class="mt-4 p-4 bg-gray-50 rounded-lg border border-gray-200 text-gray-700">
                                <h3 class="font-bold mb-1">Deskripsi Event:</h3>
                                <p>{{ $event->description }}</p>
                            </div>
                        </div>

                        <div class="bg-blue-50 p-5 rounded-xl border border-blue-100 text-center min-w-[200px]">
                            <h3 class="text-sm font-bold text-blue-800 uppercase tracking-widest">Sisa Kuota</h3>
                            <div class="text-4xl font-black text-blue-600 my-2">
                                {{ $event->sisaKuota() }}
                            </div>
                            <p class="text-xs text-blue-500 font-medium">dari {{ $event->quota }} kursi</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4 flex items-center gap-2">
                        👥 Daftar Peserta Terdaftar
                        <span class="bg-gray-200 text-gray-700 text-xs px-2 py-1 rounded-full">Total: {{ $event->registrations->count() }}</span>
                    </h3>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 border">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider w-10">No</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Nama Mahasiswa</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Email</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Waktu Daftar</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($event->registrations as $index => $registration)
                                <tr>
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ $index + 1 }}</td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-bold text-gray-900">
                                            {{ $registration->user->name ?? 'User Terhapus' }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        {{ $registration->user->email ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        {{ $registration->created_at->format('d M Y, H:i') }} WIB
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                            Terdaftar
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-10 text-center text-gray-400">
                                        <div class="flex flex-col items-center">
                                            <span class="text-4xl mb-2">📂</span>
                                            <span>Belum ada peserta yang mendaftar event ini.</span>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>