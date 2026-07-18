<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen">

    <!-- NAVBAR -->
    <nav class="bg-white border-b border-gray-200 px-8 py-4 flex items-center justify-between">
    
    <!-- 1. Kiri: Logo -->
    <div class="flex items-center gap-3">
        <img src="{{ asset('logo.png') }}" class="h-10" alt="Logo">
        <div>
            <h1 class="text-xl font-bold text-blue-800">CAMPUSEVENT</h1>
            <p class="text-[9px] text-gray-500 font-bold uppercase tracking-widest">MANAGEMENT SYSTEM</p>
        </div>
    </div>

    <!-- 2. Tengah: Menu (Menggunakan gap agar rapi) -->
    <div class="flex items-center gap-10 text-sm font-semibold text-gray-700">
        <a href="{{ route('mahasiswa.dashboard') }}" class="text-black border-b-2 border-black pb-1">Dashboard</a>
        <a href="{{ route('explore') }}" class="hover:text-gray-900 transition">Jelajah Event</a>
        <a href="{{ route('history') }}" class="hover:text-gray-900 transition">Riwayat</a>
        <a href="{{ route('biodata') }}" class="hover:text-gray-900 transition">Biodata</a>
        
    </div>

    <!-- 3. Kanan: Profil & Logout -->
    <div class="text-right">
        <p class="text-sm font-bold text-gray-900 leading-tight">Rahma Yunita</p>
        <p class="text-[11px] text-gray-500 font-bold uppercase">MAHASISWA</p>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="text-red-600 text-xs font-bold hover:underline mt-1">Logout</button>
        </form>
    </div>

</nav>

    <!-- KONTEN -->
    <main class="p-8 max-w-6xl mx-auto">
        <h2 class="text-xl font-medium text-gray-700 mb-6">Dashboard</h2>

        <!-- CARD GRADIENT -->
        <div class="bg-gradient-to-r from-blue-900 to-indigo-600 p-8 rounded-xl shadow-lg flex items-center justify-between text-white">
            <div class="max-w-2xl">
                <h2 class="text-3xl font-bold mb-2">Halo, {{ $user->name }}! 👋</h2>
                <p class="text-blue-100 italic mb-6">
                    "Pendidikan bukan hanya tentang gelar, tapi tentang memperluas wawasan. 
                    Temukan event inspiratif di kampus, asah potensimu, dan jadilah versi terbaik dari dirimu hari ini!"
                </p>
                <button class="bg-yellow-400 text-blue-900 px-6 py-2 rounded font-bold hover:bg-yellow-300 transition flex items-center gap-2">
                    🚀 Mulai Jelajah Event
                </button>
            </div>
            <!-- ICON BOX -->
            <div class="bg-white/10 p-6 rounded-full">
                <svg class="w-16 h-16 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517l-2.387-.477a2 2 0 00-1.022.547M12 21a9 9 0 100-18 9 9 0 000 18z"></path></svg>
            </div>
        </div>
    </main>

</body>
</html>