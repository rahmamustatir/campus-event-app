<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Dashboard Biro Akademik</title>
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
            <a href="#" class="hover:text-blue-600 transition underline decoration-2">Dashboard</a>
            <a href="#" class="hover:text-blue-600 transition">Validasi Event</a>
            <a href="#" class="hover:text-blue-600 transition">Data Mahasiswa</a>
            <a href="#" class="hover:text-blue-600 transition">Laporan</a>
        </div>

        <div class="flex items-center gap-4 text-sm font-bold text-gray-800">
            <span>Biro Akademik</span>
            <span class="text-gray-300">|</span>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="text-red-600 hover:underline">Logout</button>
            </form>
        </div>
    </nav>

    <div class="p-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Dashboard Pengawas: Biro Akademik</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="bg-white p-6 border border-gray-200 shadow-sm rounded-lg">
                <p class="text-gray-500 font-bold uppercase text-xs">Total</p>
                <h3 class="font-bold text-lg text-gray-800">Pendaftaran Masuk</h3>
            </div>
            <div class="bg-white p-6 border border-gray-200 shadow-sm rounded-lg">
                <p class="text-gray-500 font-bold uppercase text-xs">Total</p>
                <h3 class="font-bold text-lg text-gray-800">Pengajuan Event</h3>
            </div>
            <div class="bg-white p-6 border border-gray-200 shadow-sm rounded-lg">
                <p class="text-gray-500 font-bold uppercase text-xs">Rating Event</p>
                <h3 class="font-bold text-lg text-gray-800">⭐⭐⭐⭐</h3>
            </div>
            <div class="bg-white p-6 border border-gray-200 shadow-sm rounded-lg">
                <p class="text-gray-500 font-bold uppercase text-xs">Ringkasan</p>
                <h3 class="font-bold text-lg text-gray-800">Aktivitas</h3>
            </div>
        </div>
    </div>
</body>
</html>