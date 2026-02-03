<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-24">
            <div class="flex">
                
                <div class="shrink-0 flex items-center my-2">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-4 group">
                        <img src="{{ asset('logo.png') }}" 
                             class="block h-16 w-auto transition transform group-hover:scale-105 duration-300 filter drop-shadow-sm" 
                             alt="Logo"
                             onerror="this.style.display='none'">
                        
                        <div class="flex flex-col leading-none justify-center">
                            <span class="font-black text-3xl md:text-4xl text-blue-900 tracking-tighter drop-shadow-sm" style="line-height: 0.9;">
                                CAMPUS<span class="text-blue-600">EVENT</span>
                            </span>
                            <span class="text-[10px] md:text-xs font-extrabold text-gray-400 tracking-[0.2em] uppercase mt-1 ml-1">
                                MANAGEMENT SYSTEM
                            </span>
                        </div>
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    
                    @if(Auth::user()->usertype == 'admin')
                        
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                            {{ __('Dashboard') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.events.index')" :active="request()->routeIs('admin.events.*')">
                            {{ __('Kelola Event') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')">
                            {{ __('Data Mahasiswa') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.scan.index')" :active="request()->routeIs('admin.scan.*')">
                            {{ __('Scan Tiket') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.reports.index')" :active="request()->routeIs('admin.reports.*')">
                            {{ __('Laporan') }}
                        </x-nav-link>

                    @else
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                            {{ __('Dashboard') }}
                        </x-nav-link>

                        <x-nav-link :href="route('explore')" :active="request()->routeIs('explore')">
                            {{ __('Jelajah Event') }}
                        </x-nav-link>

                        <x-nav-link :href="route('history')" :active="request()->routeIs('history')">
                            {{ __('Riwayat') }}
                        </x-nav-link>

                        <x-nav-link :href="route('biodata')" :active="request()->routeIs('biodata')">
                            {{ __('Biodata') }}
                        </x-nav-link>

                        <x-nav-link :href="route('help')" :active="request()->routeIs('help')">
                            {{ __('Bantuan') }}
                        </x-nav-link>

                    @endif

                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div class="flex flex-col items-end">
                                <span class="font-bold text-gray-800">{{ Auth::user()->name }}</span>
                                @if(Auth::user()->usertype == 'admin')
                                    <span class="text-[10px] text-blue-600 font-black uppercase tracking-wider">ADMINISTRATOR</span>
                                @else
                                    <span class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">MAHASISWA</span>
                                @endif
                            </div>
                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        @if(class_exists(App\Http\Controllers\ProfileController::class))
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profile') }}
                            </x-dropdown-link>
                        @endif
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</nav>