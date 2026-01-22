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
                    <table class="min-w-full bg-white/50 rounded-lg">
                        <thead>
                            <tr class="bg-gray-100/80 text-left uppercase text-sm text-gray-700">
                                <th class="py-3 px-4 border-b">Nama</th>
                                <th class="py-3 px-4 border-b">Email</th>
                                <th class="py-3 px-4 border-b">Bergabung Sejak</th>
                                <th class="py-3 px-4 border-b text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <tr class="hover:bg-white/80 border-b transition">
                                    <td class="py-3 px-4 font-bold text-gray-800">{{ $user->name }}</td>
                                    <td class="py-3 px-4 text-gray-600">{{ $user->email }}</td>
                                    <td class="py-3 px-4 text-sm">{{ $user->created_at->format('d M Y') }}</td>
                                    <td class="py-3 px-4 text-center">
                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Hapus user ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="text-red-500 hover:text-red-700 font-bold text-sm bg-red-50 px-3 py-1 rounded hover:bg-red-100 transition">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>