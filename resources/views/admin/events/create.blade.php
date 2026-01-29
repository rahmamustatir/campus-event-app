<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-white leading-tight">
                {{ __('Tambah Event Baru') }}
            </h2>
            <a href="{{ route('admin.events.index') }}" class="text-gray-300 hover:text-white text-sm flex items-center gap-1">
                &larr; Batal & Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-900 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-8">
                    
                    @if ($errors->any())
                        <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                            <strong class="font-bold">Oops! Ada kesalahan:</strong>
                            <ul class="mt-2 list-disc list-inside text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.events.store') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Nama Event</label>
                            <input type="text" name="title" value="{{ old('title') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Contoh: Seminar AI 2026" required>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Kategori (Opsional)</label>
                            <input type="text" name="category" value="{{ old('category') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Contoh: Teknologi / Workshop">
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Deskripsi Lengkap</label>
                            <textarea name="description" rows="5" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>{{ old('description') }}</textarea>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">Tanggal Pelaksanaan</label>
                                <input type="date" name="date" value="{{ old('date') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                            </div>
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">Jam Mulai</label>
                                <input type="time" name="time" value="{{ old('time') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Lokasi Acara</label>
                            <input type="text" name="location" value="{{ old('location') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Contoh: Aula Gedung E" required>
                        </div>

                        <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                            <label class="block text-blue-800 text-sm font-bold mb-2">Batas Kuota Peserta</label>
                            <input type="number" 
                                   name="quota" 
                                   value="{{ old('quota') }}" 
                                   placeholder="Contoh: 100 (Isi angka 0 untuk Tanpa Batas)" 
                                   class="shadow appearance-none border border-blue-300 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring focus:ring-blue-200" 
                                   required>
                            <p class="text-blue-600 text-xs italic mt-2">
                                ℹ️ Isi dengan angka <strong>0</strong> jika event ini <strong>Tanpa Batas (Unlimited)</strong>.
                            </p>
                        </div>

                        <div class="flex items-center justify-end gap-3">
                            <a href="{{ route('admin.events.index') }}" class="text-gray-500 hover:text-gray-800 font-bold py-2 px-4 rounded">
                                Batal
                            </a>
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded shadow-lg transform transition hover:-translate-y-1">
                                Simpan Event
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>