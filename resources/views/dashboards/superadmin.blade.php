<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen">

    <nav class="bg-white border-b border-gray-200 px-8 py-3 flex items-center justify-between">
        <div class="flex items-center gap-4">
            <img src="{{ asset('logo.png') }}" class="h-10" alt="Logo">
            <div>
                <h1 class="text-xl font-bold text-blue-800">CAMPUSEVENT</h1>
                <p class="text-[9px] text-gray-500 font-bold uppercase tracking-widest">MANAGEMENT SYSTEM</p>
            </div>
        </div>

        <div class="flex gap-6 text-sm font-semibold text-gray-700">
            <a href="#" class="text-blue-600 border-b-2 border-blue-600 pb-1">Dashboard</a>
            <a href="#" class="hover:text-blue-600">User Management</a>
            <a href="#" class="hover:text-blue-600">System Config</a>
            <a href="#" class="hover:text-blue-600">Logs</a>
            <a href="#" class="hover:text-blue-600">Reports</a>
        </div>
        <div class="flex items-center gap-4">
    <div class="text-right">
        <p class="font-bold text-gray-800 uppercase text-sm">SUPER ADMIN</p>
    </div>
    <!-- Tombol Logout yang hilang -->
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="text-red-600 font-bold text-sm hover:underline">Logout</button>
    </form>
</div>
    </nav>

    <main class="p-8 max-w-7xl mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
            <div class="bg-white p-6 rounded-lg shadow-sm border">
                <h3 class="font-bold text-gray-700 mb-4">Distribusi Pengguna</h3>
                <div class="space-y-4">
                    <div>
                        <div class="flex justify-between text-xs font-bold mb-1"><span>Mahasiswa</span><span>70%</span></div>
                        <div class="w-full bg-gray-200 h-3 rounded"><div class="bg-green-500 h-3 rounded" style="width: 70%"></div></div>
                    </div>
                    <div>
                        <div class="flex justify-between text-xs font-bold mb-1"><span>Admin</span><span>20%</span></div>
                        <div class="w-full bg-gray-200 h-3 rounded"><div class="bg-blue-500 h-3 rounded" style="width: 20%"></div></div>
                    </div>
                </div>
            </div>
            <div class="bg-blue-900 p-6 rounded-lg shadow-sm text-white flex flex-col justify-center">
                <p class="text-sm opacity-75">Total Pengguna Terdaftar</p>
                <p class="text-5xl font-bold">{{ $allUsers->count() }}</p>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border">
            <div class="p-4 border-b font-bold text-gray-700">Daftar Pengguna & Hak Akses</div>
            <table class="w-full text-left text-sm">
                <thead class="bg-gray-50 text-gray-500">
                    <tr>
                        <th class="py-3 px-6">Name</th>
                        <th class="py-3 px-6">Role</th>
                        <th class="py-3 px-6">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @foreach($allUsers as $u)
                    <tr>
                        <td class="py-3 px-6">{{ $u->name }}</td>
                        <td class="py-3 px-6 uppercase font-bold text-blue-600">{{ $u->role }}</td>
                        <td class="py-3 px-6">{{ $u->is_verified ? 'Aktif' : 'Pending' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>