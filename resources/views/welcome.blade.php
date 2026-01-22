<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Campus Event') }}</title>
    
    <link rel="icon" href="{{ asset('logo.png') }}" type="image/png">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Poppins', sans-serif; }
        html { scroll-behavior: smooth; } /* Agar scroll ke bawah halus */
    </style>
</head>
<body class="antialiased bg-gray-50 text-gray-800">

    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <div class="flex items-center gap-3">
                    @if(file_exists(public_path('logo.png')))
                        <img src="{{ asset('logo.png') }}" class="h-12 w-auto" alt="Logo">
                    @endif
                    <span class="text-2xl font-black text-blue-700 tracking-tight">CAMPUS<span class="text-gray-800">EVENT</span></span>
                </div>

                <div class="flex items-center gap-4">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="text-sm font-bold text-gray-700 hover:text-blue-600 transition">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="text-sm font-bold text-gray-600 hover:text-blue-600 transition">Masuk</a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="bg-blue-600 text-white px-5 py-2.5 rounded-full text-sm font-bold shadow-md hover:bg-blue-700 hover:shadow-lg transition transform hover:-translate-y-0.5">
                                    Daftar Sekarang
                                </a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <section class="relative bg-gradient-to-br from-blue-900 via-blue-700 to-indigo-800 text-white overflow-hidden">
        <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(#ffffff 1px, transparent 1px); background-size: 30px 30px;"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-28 relative z-10">
            <div class="text-center max-w-3xl mx-auto">
                <span class="bg-blue-500/30 text-blue-100 py-1 px-4 rounded-full text-sm font-bold tracking-wide uppercase mb-4 inline-block backdrop-blur-sm border border-blue-400/30">
                    Platform Event Kampus No. #1
                </span>
                <h1 class="text-4xl md:text-6xl font-extrabold leading-tight mb-6 tracking-tight">
                    Jelajahi Event Seru <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-yellow-300 to-orange-400">Tanpa Batas!</span>
                </h1>
                <p class="text-lg md:text-xl text-blue-100 mb-10 font-light leading-relaxed">
                    Sistem pendaftaran event mahasiswa yang praktis, cepat, dan modern. 
                    Dapatkan tiket QR Code instan langsung ke emailmu.
                </p>
                <div class="flex justify-center gap-4">
                    <a href="#events" class="bg-white text-blue-800 px-8 py-4 rounded-full font-bold shadow-xl hover:bg-gray-100 transition transform hover:-translate-y-1">
                        Lihat Event Terbaru
                    </a>
                </div>
            </div>
        </div>
        
        <div class="absolute bottom-0 w-full leading-none text-gray-50">
            <svg class="relative block w-full h-16 md:h-24" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
                <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z" fill="currentColor"></path>
            </svg>
        </div>
    </section>

    <section class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                
                <a href="#events" class="block bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-lg hover:border-blue-200 hover:-translate-y-1 transition transform duration-300 text-center group cursor-pointer">
                    <div class="w-14 h-14 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mx-auto mb-4 text-2xl group-hover:scale-110 transition">⚡</div>
                    <h3 class="font-bold text-lg mb-2 text-gray-800 group-hover:text-blue-600">Pendaftaran Cepat</h3>
                    <p class="text-gray-500 text-sm">Klik disini untuk melihat daftar event dan mendaftar dalam hitungan detik.</p>
                </a>

                <a href="{{ route('dashboard') }}" class="block bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-lg hover:border-purple-200 hover:-translate-y-1 transition transform duration-300 text-center group cursor-pointer">
                    <div class="w-14 h-14 bg-purple-100 text-purple-600 rounded-full flex items-center justify-center mx-auto mb-4 text-2xl group-hover:scale-110 transition">🎟️</div>
                    <h3 class="font-bold text-lg mb-2 text-gray-800 group-hover:text-purple-600">E-Ticket QR Code</h3>
                    <p class="text-gray-500 text-sm">Tiket otomatis masuk ke Dashboard Anda. Klik untuk cek tiket.</p>
                </a>

                <a href="{{ route('dashboard') }}" class="block bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-lg hover:border-green-200 hover:-translate-y-1 transition transform duration-300 text-center group cursor-pointer">
                    <div class="w-14 h-14 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-4 text-2xl group-hover:scale-110 transition">📱</div>
                    <h3 class="font-bold text-lg mb-2 text-gray-800 group-hover:text-green-600">Check-in Digital</h3>
                    <p class="text-gray-500 text-sm">Masuk venue cukup scan QR Code dari HP Anda. Siapkan tiket Anda disini.</p>
                </a>

            </div>
        </div>
    </section>

    <section id="events" class="py-16 bg-white scroll-mt-20"> <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="flex justify-between items-end mb-10">
                <div>
                    <h2 class="text-3xl font-extrabold text-gray-900">Event Terbaru 🔥</h2>
                    <p class="text-gray-500 mt-2">Jangan sampai ketinggalan kegiatan seru bulan ini.</p>
                </div>
            </div>

            @if($events->isEmpty())
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-6 rounded-r-lg text-center">
                    <p class="text-yellow-700 font-bold text-lg">Oops! Belum ada event yang tersedia saat ini.</p>
                    <p class="text-yellow-600 text-sm mt-1">Nantikan update selanjutnya dari admin kampus.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($events as $event)
                        <div class="group bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden hover:shadow-2xl transition duration-300 flex flex-col h-full transform hover:-translate-y-2">
                            
                            <div class="relative h-48 bg-gray-200 overflow-hidden">
                                @if($event->poster)
                                    <img src="{{ asset('storage/' . $event->poster) }}" class="w-full h-full object-cover transform group-hover:scale-110 transition duration-500" alt="{{ $event->title }}">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center">
                                        <span class="text-white font-bold text-2xl opacity-50">{{ Str::limit($event->title, 2) }}</span>
                                    </div>
                                @endif
                                
                                <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-lg shadow-sm font-bold text-gray-800 text-center text-xs">
                                    <span class="block text-blue-600 text-lg leading-tight">{{ \Carbon\Carbon::parse($event->event_date)->format('d') }}</span>
                                    <span class="uppercase tracking-wide">{{ \Carbon\Carbon::parse($event->event_date)->format('M') }}</span>
                                </div>
                            </div>

                            <div class="p-6 flex-1 flex flex-col">
                                <div class="flex items-center text-xs text-gray-500 mb-3 space-x-2">
                                    <span class="flex items-center">
                                        <svg class="w-3 h-3 mr-1 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                        {{ Str::limit($event->location, 20) }}
                                    </span>
                                    <span>&bull;</span>
                                    <span class="flex items-center text-green-600 font-bold bg-green-50 px-2 py-0.5 rounded-full">
                                        {{ $event->quota - $event->registrations_count }} Slot
                                    </span>
                                </div>

                                <h3 class="text-xl font-bold text-gray-900 mb-2 leading-snug group-hover:text-blue-600 transition">
                                    {{ $event->title }}
                                </h3>
                                
                                <p class="text-gray-600 text-sm mb-6 line-clamp-2 flex-1">
                                    {{ $event->description }}
                                </p>

                                <div class="mt-auto pt-4 border-t border-gray-100 flex items-center justify-between">
                                    <div class="text-xs text-gray-500">
                                        {{ $event->registrations_count }} Pendaftar
                                    </div>
                                    
                                    @auth
                                        <form action="{{ route('event.register', $event->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" 
                                                class="bg-blue-600 text-white px-5 py-2 rounded-lg text-sm font-bold shadow-md hover:bg-blue-700 transition flex items-center gap-1 disabled:opacity-50 disabled:cursor-not-allowed"
                                                {{ $event->sisaKuota() <= 0 ? 'disabled' : '' }}>
                                                
                                                @if($event->sisaKuota() <= 0)
                                                    Penuh 🔒
                                                @else
                                                    Daftar 🚀
                                                @endif
                                            </button>
                                        </form>
                                    @else
                                        <a href="{{ route('login') }}" class="text-blue-600 font-bold text-sm hover:underline">
                                            Login untuk Daftar &rarr;
                                        </a>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    <footer class="bg-gray-900 text-white py-12 border-t border-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="mb-6 md:mb-0">
                    <span class="text-2xl font-black text-white tracking-tight">CAMPUS<span class="text-blue-500">EVENT</span></span>
                    <p class="text-gray-400 text-sm mt-2 max-w-xs">
                        Sistem manajemen event kampus terbaik untuk memudahkan mahasiswa berkarya dan berprestasi.
                    </p>
                </div>
                <div class="flex space-x-6">
                    <a href="#" class="text-gray-400 hover:text-white transition">Instagram</a>
                    <a href="#" class="text-gray-400 hover:text-white transition">Twitter</a>
                    <a href="#" class="text-gray-400 hover:text-white transition">LinkedIn</a>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-sm text-gray-500">
                &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved. Made with ❤️ by Laravel.
            </div>
        </div>
    </footer>

</body>
</html>