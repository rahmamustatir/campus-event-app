<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Event</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <form action="{{ route('admin.events.update', $event->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT') <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2">Judul Event</label>
                        <input type="text" name="title" value="{{ old('title', $event->title) }}" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2">Deskripsi</label>
                        <textarea name="description" rows="4" class="w-full border-gray-300 rounded-md shadow-sm" required>{{ old('description', $event->description) }}</textarea>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-gray-700 font-bold mb-2">Lokasi</label>
                            <input type="text" name="location" value="{{ old('location', $event->location) }}" class="w-full border-gray-300 rounded-md" required>
                        </div>
                        <div>
                            <label class="block text-gray-700 font-bold mb-2">Kuota Peserta</label>
                            <input type="number" name="quota" value="{{ old('quota', $event->quota) }}" class="w-full border-gray-300 rounded-md" required>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-gray-700 font-bold mb-2">Tanggal Acara</label>
                            <input type="datetime-local" name="event_date" value="{{ old('event_date', $event->event_date) }}" class="w-full border-gray-300 rounded-md" required>
                        </div>
                        <div>
                            <label class="block text-gray-700 font-bold mb-2">Batas Pendaftaran</label>
                            <input type="datetime-local" name="registration_end" value="{{ old('registration_end', $event->registration_end) }}" class="w-full border-gray-300 rounded-md" required>
                        </div>
                    </div>

                    <div class="mb-6">
                        <label class="block text-gray-700 font-bold mb-2">Ganti Poster (Opsional)</label>
                        @if($event->poster)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $event->poster) }}" class="h-20 w-auto rounded border">
                                <span class="text-xs text-gray-500">Poster Saat Ini</span>
                            </div>
                        @endif
                        <input type="file" name="poster" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    </div>

                    <div class="flex justify-end gap-2">
                        <a href="{{ route('admin.events.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">Batal</a>
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Simpan Perubahan</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>