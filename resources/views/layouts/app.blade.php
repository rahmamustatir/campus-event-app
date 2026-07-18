<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel="icon" href="{{ asset('logo.png') }}" type="image/png">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 flex">
            
            <aside class="w-64 bg-white shadow-md hidden md:block">
                @include('layouts.sidebar')
            </aside>

            <div class="flex-1">
                @include('layouts.navigation')

                <main class="w-full py-6 px-4 sm:px-6 lg:px-8">
    {{ $slot }}
</main>
            </div>
            
        </div>
    </body>
</html>