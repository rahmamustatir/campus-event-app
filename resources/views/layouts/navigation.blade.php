<nav class="bg-white border-b border-gray-100 relative z-[9999]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-24">
            <div class="flex items-center">
                <div class="shrink-0 flex items-center mr-10">
                    <a href="{{ route('mahasiswa.dashboard') }}">
                        <img src="{{ asset('logo.png') }}" class="block h-16 w-auto" alt="Logo">
                    </a>
                    <span class="ml-3 font-bold text-blue-800 text-xl">CAMPUSEVENT</span>
                </div>

                <div class="hidden sm:flex sm:ml-10 space-x-8">
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="text-gray-500 hover:text-gray-900 font-medium">Dashboard</a>
                        <a href="{{ route('admin.events.index') }}" class="text-gray-500 hover:text-gray-900 font-medium">Kelola Event</a>
                        <a href="{{ route('admin.users.index') }}" class="text-gray-500 hover:text-gray-900 font-medium">Data Mahasiswa</a>
                    @elseif(auth()->user()->role === 'mahasiswa')
                        <a href="{{ route('mahasiswa.dashboard') }}" class="text-gray-500 hover:text-gray-900 font-medium">Dashboard</a>
                        <a href="{{ route('explore') }}" class="text-gray-500 hover:text-gray-900 font-medium">Jelajah Event</a>
                        <a href="{{ route('history') }}" class="text-gray-500 hover:text-gray-900 font-medium">Riwayat</a>
                        <a href="{{ route('biodata') }}" class="text-gray-500 hover:text-gray-900 font-medium">Biodata</a>
                        <a href="{{ route('help') }}" class="text-gray-500 hover:text-gray-900 font-medium">Bantuan</a>
                    @endif
                </div>
            </div>

            <div class="flex items-center">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-red-600 hover:text-red-800 font-bold">Logout</button>
                </form>
            </div>
        </div>
    </div>
</nav>