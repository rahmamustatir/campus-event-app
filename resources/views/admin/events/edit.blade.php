<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Event (Mode Admin)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <form action="{{ route('admin.events.update', $event->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 gap-6">
                            <div>
                                <label class="block font-medium text-sm text-gray-700">Judul Event</label>
                                <input type="text" name="title" value="{{ old('title', $event->title) }}" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full mt-1" required>
                            </div>

                            <div>
                                <label class="block font-medium text-sm text-gray-700">Deskripsi</label>
                                <textarea name="description" rows="4" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full mt-1" required>{{ old('description', $event->description) }}</textarea>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block font-medium text-sm text-gray-700">Tanggal</label>
                                    <input type="date" name="date" value="{{ old('date', $event->date) }}" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full mt-1" required>
                                </div>
                                <div>
                                    <label class="block font-medium text-sm text-gray-700">Waktu</label>
                                    <input type="time" name="time" value="{{ old('time', $event->time) }}" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full mt-1" required>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block font-medium text-sm text-gray-700">Lokasi</label>
                                    <input type="text" name="location" value="{{ old('location', $event->location) }}" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full mt-1" required>
                                </div>
                                <div>
                                    <label class="block font-medium text-sm text-gray-700">Kuota Peserta</label>
                                    <input type="number" name="quota" value="{{ old('quota', $event->quota) }}" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full mt-1" required>
                                </div>
                            </div>

                            <div class="flex justify-end gap-3 mt-4">
                                <a href="{{ route('admin.events.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">Batal</a>
                                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Simpan Perubahan</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>