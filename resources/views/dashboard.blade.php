<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="relative bg-gradient-to-br from-blue-900 via-indigo-800 to-blue-900 rounded-2xl p-8 mb-10 shadow-2xl overflow-hidden border-b-4 border-yellow-400">
                
                <div class="absolute top-0 right-0 -mr-20 -mt-20 w-80 h-80 rounded-full bg-blue-500 opacity-10 blur-3xl"></div>
                <div class="absolute bottom-0 left-0 -ml-10 -mb-10 w-40 h-40 rounded-full bg-yellow-400 opacity-10 blur-2xl"></div>

                <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-8">
                    
                    <div class="w-full md:w-3/4 text-center md:text-left">
                        <h1 class="text-3xl md:text-4xl font-extrabold text-white mb-4 tracking-tight">
                            Halo, <span class="text-transparent bg-clip-text bg-gradient-to-r from-yellow-300 to-yellow-500">{{ Auth::user()->name }}</span>! 👋
                        </h1>
                        
                        <p class="text-lg text-blue-100 font-light leading-relaxed italic mb-6">
                            "Pendidikan bukan hanya tentang gelar, tapi tentang memperluas wawasan. 
                            Temukan event inspiratif di kampus, asah potensimu, dan jadilah versi terbaik dari dirimu hari ini!"
                        </p>
                        
                        <div class="flex flex-wrap justify-center md:justify-start gap-4">
                            <a href="{{ route('explore') }}" class="bg-yellow-400 hover:bg-yellow-300 text-blue-900 font-bold py-3 px-6 rounded-lg shadow-lg transform transition hover:-translate-y-1">
                                🚀 Mulai Jelajah Event
                            </a>
                        </div>
                    </div>

                    <div class="hidden md:block">
                        <div class="bg-white/10 p-6 rounded-full border border-white/10 backdrop-blur-md shadow-inner">
                            <svg class="w-24 h-24 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                            </svg>
                        </div>
                    </div>

                </div>
            </div>
            </div>
    </div>
</x-app-layout>