<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight drop-shadow-md">
            {{ __('Data Mahasiswa') }}
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
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="glass-card overflow-hidden shadow-xl sm:rounded-lg p-6">
                
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-bold text-gray-800 flex items-center">
                        <span class="bg-blue-100 p-2 rounded-full mr-2">🎓</span> Daftar Akun Mahasiswa
                    </h3>
                    <span class="bg-blue-600 text-white px-3 py-1 rounded-full text-xs font-bold shadow">{{ $users->count() }} Mahasiswa</span>
                </div>

                <div class="overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Nama Mahasiswa
                </th>
                
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    NIM
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Jurusan
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    No. HP (WA)
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Email
                </th>
                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Aksi
                </th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse($users as $user)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10">
                                <img class="h-10 w-10 rounded-full bg-gray-200" src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=random" alt="">
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                <div class="text-xs text-gray-500">Joined: {{ $user->created_at->format('d M Y') }}</div>
                            </div>
                        </div>
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                        @if($user->nim)
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                {{ $user->nim }}
                            </span>
                        @else
                            <span class="text-gray-400 italic">- Kosong -</span>
                        @endif
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                        {{ $user->jurusan ?? '-' }}
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                        @if($user->no_hp)
                            <div class="flex items-center text-green-600">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654z"/></svg>
                                {{ $user->no_hp }}
                            </div>
                        @else
                            <span class="text-gray-400">-</span>
                        @endif
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $user->email }}
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus mahasiswa ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900 font-bold bg-red-100 hover:bg-red-200 px-3 py-1 rounded-md transition">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                        Belum ada data mahasiswa.
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