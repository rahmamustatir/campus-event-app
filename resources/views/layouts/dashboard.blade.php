<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">{{ $title }}</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                {{ $slot }}
            </div>
        </div>
    </div>
</x-app-layout>