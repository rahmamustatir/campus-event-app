<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                    {{ __('Database Mahasiswa') }}
                </h2>
                <p class="text-sm text-gray-500 mt-1">Data detail akademik dan kontak mahasiswa.</p>
            </div>
            <div class="flex gap-3">
                <span class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg font-semibold text-xs text-gray-700 shadow-sm">
                    Total: {{ $users->count() }} Mahasiswa
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50">
        <div class="max-w-[95%] mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl border border-gray-200">
                
                <div class="overflow-x-auto pb-4">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider sticky left-0 bg-gray-50 z-20 shadow-sm">Mahasiswa</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider whitespace-nowrap">NIM</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider whitespace-nowrap">Program Studi</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider whitespace-nowrap">Fakultas</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider whitespace-nowrap">No. WhatsApp</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider w-48">Alamat Domisili</th>
                                <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Status Data</th>
                                <th scope="col" class="px-6 pr-12 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
    @forelse($users as $user)
    <tr class="hover:bg-blue-50/50 transition-colors duration-200">
        
        <td class="px-6 py-4 whitespace-nowrap sticky left-0 bg-white z-10 border-r border-gray-100 shadow-sm group-hover:bg-blue-50">
            <div class="flex items-center">
                <div class="flex-shrink-0 h-10 w-10">
                    @if(!empty($user->avatar))
                        <img class="h-10 w-10 rounded-full object-cover border border-gray-300" src="{{ asset('storage/' . $user->avatar) }}" alt="">
                    @else
                        <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold text-sm border border-blue-200">{{ substr($user->name, 0, 1) }}</div>
                    @endif
                </div>
                <div class="ml-4">
                    <div class="text-sm font-bold text-gray-900">{{ $user->name }}</div>
                    <div class="text-xs text-gray-500">{{ $user->email }}</div>
                </div>
            </div>
        </td>

        <td class="px-6 py-4 whitespace-nowrap">
            @if($user->biodata && $user->biodata->nim)
                <span class="font-mono text-sm font-semibold text-gray-700 bg-gray-100 px-2 py-1 rounded">{{ $user->biodata->nim }}</span>
            @else <span class="text-gray-300 text-sm">-</span> @endif
        </td>
        
        <td class="px-6 py-4 whitespace-nowrap"><div class="text-sm text-gray-700">{{ $user->biodata->prodi ?? '-' }}</div></td>
        
        <td class="px-6 py-4 whitespace-nowrap"><div class="text-sm text-gray-700">{{ $user->biodata->fakultas ?? '-' }}</div></td>
        
        <td class="px-6 py-4 whitespace-nowrap">
            @if($user->biodata && $user->biodata->phone)
                <div class="text-sm text-green-700 flex items-center gap-1"><span>📱</span> {{ $user->biodata->phone }}</div>
            @else <span class="text-gray-300 text-sm">-</span> @endif
        </td>

        <td class="px-6 py-4 whitespace-normal"><div class="text-sm text-gray-600 leading-snug">{{ $user->biodata->address ?? '-' }}</div></td>

        <td class="px-6 py-4 whitespace-nowrap text-center">
            @if($user->biodata && $user->biodata->nim)
                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 border border-green-200">✔ Lengkap</span>
            @else
                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 border border-red-200 animate-pulse">⚠ Belum Isi</span>
            @endif
        </td>

        <td class="px-6 pr-12 py-4 whitespace-nowrap text-center">
            <a href="{{ route('admin.users.show', $user->id) }}" class="inline-flex items-center justify-center px-3 py-1.5 bg-blue-600 text-white rounded-md text-xs font-bold hover:bg-blue-700 transition shadow-sm">
                👁️ Detail
            </a>
        </td>

    </tr>
    @empty
    <tr><td colspan="8" class="px-6 py-10 text-center text-gray-500">Belum ada data mahasiswa.</td></tr>
    @endforelse
</tbody>
                    </table>
                </div>
                
                <div class="bg-gray-50 px-6 py-3 border-t border-gray-200 text-right">
                    <p class="text-xs text-gray-400">Geser tabel ke samping ➡</p>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>