<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen">

    <nav class="bg-white border-b border-gray-200 px-8 py-4 flex items-center justify-between">
    <div class="flex items-center gap-4">
        <img src="{{ asset('logo.png') }}" class="h-10" alt="Logo">
        <div>
            <h1 class="text-xl font-bold text-blue-800">CAMPUSEVENT</h1>
            <p class="text-[9px] text-gray-500 font-bold uppercase tracking-widest">MANAGEMENT SYSTEM</p>
        </div>
    </div>

    <div class="flex gap-8 text-sm font-semibold text-gray-700">
        <a href="#" class="text-blue-600 border-b-2 border-blue-600 pb-1">Dashboard</a>
        <a href="#" class="hover:text-blue-600 transition">Validasi Event</a>
        <a href="#" class="hover:text-blue-600 transition">Data Mahasiswa</a>
    
    </div>

    <div class="flex items-center gap-4">
        <div class="text-right">
            <p class="text-sm font-bold text-gray-800">{{ $user->name }}</p>
            <p class="text-[10px] text-blue-600 font-bold uppercase">{{ $user->role }}</p>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="text-red-600 font-bold text-sm hover:underline">Logout</button>
        </form>
    </div>
</nav>

    <main class="p-8 max-w-7xl mx-auto">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Dashboard Pengawas: Prodi</h2>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 text-center">
                <p class="text-sm font-bold text-gray-500 uppercase">Total Pendaftaran Masuk</p>
                <p class="text-4xl font-bold mt-4 text-blue-800">{{ $totalPendaftaran ?? 0 }}</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 text-center">
                <p class="text-sm font-bold text-gray-500 uppercase">Total Pengajuan Event</p>
                <p class="text-4xl font-bold mt-4 text-blue-800">{{ $totalEvent ?? 0 }}</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 text-center">
                <p class="text-sm font-bold text-gray-500 uppercase mb-2">Rating Event</p>
                <p class="text-2xl text-yellow-500">★★★★</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 text-center">
                <p class="text-sm font-bold text-gray-500 uppercase">Ringkasan Aktivitas</p>
                <p class="text-lg font-bold mt-4 text-green-600">Aktif</p>
            </div>
        </div>
    </main>

</body>
</html>