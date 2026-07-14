<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Dashboard Admin</title>
</head>
<body class="bg-gray-50 min-h-screen">

    <!-- Navbar Admin -->
<nav class="bg-white border-b border-gray-200 px-8 py-4 flex items-center justify-between">
    
    <div class="flex items-center gap-3">
        <img src="{{ asset('logo.png') }}" class="h-10" alt="Logo">
        <div>
            <h1 class="text-xl font-bold text-blue-800">CAMPUSEVENT</h1>
            <p class="text-[9px] text-gray-500 font-bold uppercase tracking-widest">MANAGEMENT SYSTEM</p>
        </div>
    </div>

    <div class="flex flex-grow items-center justify-center gap-8 text-sm font-semibold text-gray-700">
        <a href="{{ route('admin.dashboard') }}" class="text-blue-600 border-b-2 border-blue-600 pb-1">Dashboard</a>
        <a href="{{ route('admin.events.index') }}" class="hover:text-blue-600 transition">Kelola Event</a>
        <a href="#" class="hover:text-blue-600 transition">Data Mahasiswa</a>
        <a href="#" class="hover:text-blue-600 transition">Scan Tiket</a>
        <a href="#" class="hover:text-blue-600 transition">Laporan</a>
    </div>

    <div class="flex items-center gap-4">
        <span class="font-bold text-gray-800 text-sm">ADMIN</span>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="text-red-600 font-bold text-sm hover:underline">Logout</button>
        </form>
    </div>
</nav>

        <main class="p-8 max-w-7xl mx-auto">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Dashboard Admin</h2>

        <div class="bg-white p-8 rounded-lg shadow-sm border border-gray-200 mb-6">
            <h3 class="text-lg text-gray-700">Selamat Datang, Admin!</h3>
        </div>

        <!-- Statistik -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <!-- Total Event -->
    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
        <p class="text-xs font-bold text-gray-500 uppercase">Total Event</p>
        <p class="text-4xl font-bold mt-2 text-blue-800">{{ $totalEvent ?? 0 }}</p>
    </div>
    
    <!-- Total Mahasiswa -->
    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
        <p class="text-xs font-bold text-gray-500 uppercase">Total Mahasiswa</p>
        <p class="text-4xl font-bold mt-2 text-blue-800">0</p>
    </div>
    
    <!-- Pendaftaran Masuk -->
    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
        <p class="text-xs font-bold text-gray-500 uppercase">Pendaftaran Masuk</p>
        <p class="text-4xl font-bold mt-2 text-blue-800">0</p>
    </div>
</div>
    </main>

</body>
</html>