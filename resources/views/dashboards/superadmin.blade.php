<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Dashboard Super Admin</title>
</head>
<body class="bg-gray-50 min-h-screen">

    <nav class="bg-white border-b border-gray-200 px-8 py-4 flex items-center justify-between">
        <div class="flex items-center gap-4">
            <img src="{{ asset('logo.png') }}" class="h-10" alt="Logo">
            <div>
                <h1 class="text-xl font-bold text-blue-800">CAMPUSEVENT</h1>
                <p class="text-[10px] text-gray-500 font-bold uppercase tracking-widest">Management System</p>
            </div>
        </div>
        
        <div class="flex gap-8 text-md font-bold text-gray-800">
            <a href="#" class="hover:text-blue-600 transition">User Management</a>
            <a href="#" class="hover:text-blue-600 transition">System Config</a>
            <a href="#" class="hover:text-blue-600 transition">Logs</a>
            <a href="#" class="hover:text-blue-600 transition">Reports</a>
        </div>

        <div class="flex items-center gap-4 text-sm font-bold text-gray-800">
            <span>SUPER ADMIN</span>
            <span class="text-gray-300">|</span>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="text-red-600 hover:underline">Logout</button>
            </form>
        </div>
    </nav>

    <div class="p-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Dashboard Kontrol Sistem: Super Admin</h2>
        
        <div class="bg-white border border-gray-200 p-6 shadow-sm">
            <h3 class="font-bold text-md mb-4 uppercase text-gray-700">TABEL MATRIKS MANAJEMEN PENGGUNA & HAK AKSES (RBAC)</h3>
            
            <div class="overflow-x-auto">
                <table class="min-w-full border border-gray-200">
                    <thead class="bg-gray-100">
                        <tr class="text-left">
                            <th class="px-6 py-3 border-b text-sm font-bold uppercase">User ID/Name</th>
                            <th class="px-6 py-3 border-b text-sm font-bold uppercase">Faculty/Unit</th>
                            <th class="px-6 py-3 border-b text-sm font-bold uppercase">Current Role</th>
                            <th class="px-6 py-3 border-b text-sm font-bold uppercase">Details/Event</th>
                            <th class="px-6 py-3 border-b text-sm font-bold uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
    @foreach($users as $user)
    <tr>
        <td class="px-6 py-4 text-sm">{{ $user->name }}</td>
        <td class="px-6 py-4 text-sm">UNU Lampung</td>
        <td class="px-6 py-4 text-sm">{{ $user->role }}</td>
        
        <td class="px-6 py-4 text-sm">{{ $user->details }}</td>
        
        <td class="px-6 py-4 text-sm">
            <a href="{{ url('/admin/users/'.$user->id.'/edit') }}" class="text-blue-600 font-bold hover:underline">Edit</a>
        </td>
    </tr>
    @endforeach
</tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>