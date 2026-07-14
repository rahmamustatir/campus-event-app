<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Jelajah Event Kampus</h2>
            <form action="{{ route('explore') }}" method="GET" class="mb-8 flex gap-4 items-center">
    <select name="fakultas" class="border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
        <option value="UMUM" {{ request('fakultas') == 'UMUM' ? 'selected' : '' }}>SEMUA FAKULTAS</option>
        <option value="FASTEK" {{ request('fakultas') == 'FASTEK' ? 'selected' : '' }}>FASTEK</option>
        <option value="FKIP" {{ request('fakultas') == 'FKIP' ? 'selected' : '' }}>FKIP</option>
        <option value="FP3" {{ request('fakultas') == 'FP3' ? 'selected' : '' }}>FP3</option>
        <option value="FEB" {{ request('fakultas') == 'FEB' ? 'selected' : '' }}>FEB</option>
    </select>
    <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded-lg hover:bg-gray-900">
        Filter
    </button>
</form>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($events as $event)
                <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition">
                    <img class="h-48 w-full object-cover" src="{{ asset('storage/' . $event->image) }}" alt="Event">
                    
                    <div class="p-6">
                        <h3 class="text-lg font-bold text-gray-900">{{ $event->title }}</h3>
                        <p class="text-gray-600 mt-2 text-sm">{{ Str::limit($event->description, 100) }}</p>
                        
                        <div class="mt-4 flex justify-between items-center">
                            <span class="text-blue-600 font-semibold">{{ $event->date }}</span>
                            <form action="{{ route('mahasiswa.daftar', $event->id) }}" method="POST">
    @csrf
    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 relative z-10">
        Daftar Sekarang
    </button>
</form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>