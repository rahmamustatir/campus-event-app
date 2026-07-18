<nav class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20 items-center">
            
            <!-- Logo & Title -->
            <div class="flex items-center">
                <img src="{{ asset('logo.png') }}" class="h-12 w-auto" alt="Logo">
                <div class="ml-3">
                    <h1 class="font-bold text-blue-900 text-xl">CAMPUSEVENT</h1>
                    <p class="text-xs text-gray-500 uppercase tracking-wide">Management System</p>
                </div>
            </div>

            <!-- Menu Tengah (Sesuai Screenshot Anda) -->
            <div class="hidden sm:flex space-x-8 items-center">
            <a href="{{ route('mahasiswa.dashboard') }}" class="{{ request()->routeIs('mahasiswa.dashboard') ? 'text-blue-600 font-bold border-b-2 border-blue-600' : 'text-gray-600' }} pb-1">Dashboard</a>
            <a href="{{ route('explore') }}" class="{{ request()->routeIs('explore') ? 'text-blue-600 font-bold border-b-2 border-blue-600' : 'text-gray-600' }} pb-1">Jelajah Event</a>
            <a href="{{ route('history') }}" class="{{ request()->routeIs('history') ? 'text-blue-600 font-bold border-b-2 border-blue-600' : 'text-gray-600' }} pb-1">Riwayat</a>
            <a href="{{ route('biodata') }}" class="{{ request()->routeIs('biodata') ? 'text-blue-600 font-bold border-b-2 border-blue-600' : 'text-gray-600' }} pb-1">Biodata</a>
        </div>

            <!-- Admin & Logout -->
            <div class="flex items-center space-x-6">
                <span class="font-bold text-gray-800 uppercase">ADMIN</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-red-600 font-bold hover:text-red-800">Logout</button>
                </form>
            </div>

        </div>
    </div>
</nav>