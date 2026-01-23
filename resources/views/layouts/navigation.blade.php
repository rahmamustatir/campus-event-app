@php
    // Cek Role User untuk menentukan Tema Navbar
    // Jika role tidak ada di database (user lama), anggap 'user' biasa
    $userRole = Auth::user()->role ?? 'user';
    $isAdmin = $userRole === 'admin';
    
    // TEMA WARNA
    // Admin: Putih (Profesional)
    // User: Dark Navy (Sesuai tema Neon Dashboard)
    $navClass = $isAdmin ? 'bg-white border-b border-gray-100' : 'bg-[#0f172a] border-b border-gray-800 shadow-lg';
    $textLogo = $isAdmin ? 'text-blue-600' : 'text-blue-400';
    $textEvent = $isAdmin ? 'text-gray-800' : 'text-white';
    $hamburgerClass = $isAdmin ? 'text-gray-400 hover:text-gray-500 hover:bg-gray-100' : 'text-gray-200 hover:text-white hover:bg-gray-800';
    
    // STYLE LINK MENU
    // Admin: Style Standar Laravel (Garis Bawah)
    // User: Style Tombol/Pill Modern
    $linkClassAdmin = "inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium leading-5 transition duration-150 ease-in-out focus:outline-none ";
    $linkClassUser  = "inline-flex items-center px-3 py-2 rounded-md text-sm font-medium leading-5 transition duration-150 ease-in-out focus:outline-none ";
@endphp

<nav x-data="{ open: false }" class="{{ $navClass }} transition-colors duration-300" style="font-family: 'Poppins', sans-serif;">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
                        @if(file_exists(public_path('logo.png')))
                            <img src="{{ asset('logo.png') }}" class="block h-10 w-auto" alt="Logo">
                        @else
                            <x-application-logo class="block h-10 w-auto fill-current text-gray-800" />
                        @endif
                        
                        <span class="font-black text-xl tracking-tighter {{ $textLogo }}">
                            CAMPUS<span class="{{ $textEvent }}">EVENT</span>
                        </span>
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex items-center">
                    
                    @if($isAdmin)
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                            {{ __('Dashboard') }}
                        </x-nav-link>
                    @else
                        <a href="{{ route('dashboard') }}" 
                           class="{{ $linkClassUser }} {{ request()->routeIs('dashboard') ? 'bg-blue-600 text-white shadow-[0_0_15px_rgba(37,99,235,0.5)]' : 'text-gray-300 hover:text-white hover:bg-gray-800' }}">
                           Dashboard
                        </a>
                    @endif

                    @if($isAdmin)
                        <x-nav-link :href="route('admin.events.index')" :active="request()->routeIs('admin.events.*')">
                            {{ __('Kelola Event') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')">
                            {{ __('Data Mahasiswa') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.scan.index')" :active="request()->routeIs('admin.scan.index')">
                            {{ __('Scan Tiket') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.reports.index')" :active="request()->routeIs('admin.reports.index')">
                            {{ __('Laporan') }}
                        </x-nav-link>
                    @endif

                    @if(!$isAdmin)
                        <a href="/#events" 
                           class="{{ $linkClassUser }} text-gray-300 hover:text-white hover:bg-gray-800">
                           🔍 Jelajah Event
                        </a>

                        <a href="{{ route('history') }}" 
                           class="{{ $linkClassUser }} {{ request()->routeIs('history') ? 'bg-blue-600 text-white shadow-[0_0_15px_rgba(37,99,235,0.5)]' : 'text-gray-300 hover:text-white hover:bg-gray-800' }}">
                           📜 Riwayat
                        </a>

                        <a href="{{ route('biodata') }}" 
                           class="{{ $linkClassUser }} {{ request()->routeIs('biodata') ? 'bg-blue-600 text-white shadow-[0_0_15px_rgba(37,99,235,0.5)]' : 'text-gray-300 hover:text-white hover:bg-gray-800' }}">
                           👤 Biodata
                        </a>

                        <a href="{{ route('help') }}" 
                           class="{{ $linkClassUser }} {{ request()->routeIs('help') ? 'bg-blue-600 text-white shadow-[0_0_15px_rgba(37,99,235,0.5)]' : 'text-gray-300 hover:text-white hover:bg-gray-800' }}">
                           ❓ Bantuan
                        </a>
                    @endif

                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md {{ $isAdmin ? 'text-gray-500 bg-white hover:text-gray-700' : 'text-gray-200 bg-gray-800 hover:text-white hover:bg-gray-700 border border-gray-700' }} transition ease-in-out duration-150 shadow-sm">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        @if(!$isAdmin)
                            <x-dropdown-link :href="route('biodata')">
                                {{ __('Biodata Diri') }}
                            </x-dropdown-link>
                        @endif

                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile Akun') }}
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md {{ $hamburgerClass }} focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden {{ $isAdmin ? 'bg-white' : 'bg-gray-900 border-t border-gray-800' }}">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>

            @if($isAdmin)
                <x-responsive-nav-link :href="route('admin.events.index')" :active="request()->routeIs('admin.events.*')">
                    {{ __('Kelola Event') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')">
                    {{ __('Data Mahasiswa') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.scan.index')" :active="request()->routeIs('admin.scan.index')">
                    {{ __('Scan Tiket') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.reports.index')" :active="request()->routeIs('admin.reports.index')">
                    {{ __('Laporan') }}
                </x-responsive-nav-link>
            @else
                <x-responsive-nav-link href="/#events">
                    🔍 {{ __('Jelajah Event') }}
                </x-responsive-nav-link>
                
                <x-responsive-nav-link :href="route('history')" :active="request()->routeIs('history')">
                    📜 {{ __('Riwayat') }}
                </x-responsive-nav-link>
                
                <x-responsive-nav-link :href="route('biodata')" :active="request()->routeIs('biodata')">
                    👤 {{ __('Biodata') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('help')" :active="request()->routeIs('help')">
                    ❓ {{ __('Bantuan') }}
                </x-responsive-nav-link>
            @endif
        </div>

        <div class="pt-4 pb-1 border-t {{ $isAdmin ? 'border-gray-200' : 'border-gray-800' }}">
            <div class="px-4">
                <div class="font-medium text-base {{ $isAdmin ? 'text-gray-800' : 'text-gray-200' }}">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>