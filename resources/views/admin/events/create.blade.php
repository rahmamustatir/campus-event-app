<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Buat Event Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <form action="{{ route('admin.events.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Judul Event</label>
                            <input type="text" name="title" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required placeholder="Contoh: Seminar Teknologi 2026">
                        </div>

                        <div class="mb-6 p-4 bg-blue-50 rounded-lg border border-blue-100">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Target Peserta Event</label>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <select name="kategori_peserta" id="kategori_select" onchange="cekKategori()"
                                        class="shadow border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
                                        <option value="umum">🌍 Untuk Umum (Semua Mahasiswa)</option>
                                        <option value="fakultas">🏢 Fakultas Tertentu</option>
                                    </select>
                                </div>

                                <div id="target_input_box" style="display: none;">
                                    <select name="target_peserta" id="target_input"
                                        class="shadow border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
                                        <option value="" disabled selected>-- Pilih Nama Fakultas --</option>
                                        
                                        <option value="Fastek">Fastek</option>
                                        <option value="FP3">FP3</option>
                                        <option value="FEB">FEB</option>
                                        <option value="FKIP">FKIP</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Deskripsi Singkat</label>
                            <textarea name="description" rows="4" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required></textarea>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">Tanggal Pelaksanaan</label>
                                <input type="date" name="date" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                            </div>
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">Jam Mulai</label>
                                <input type="time" name="time" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Lokasi / Tempat</label>
                            <input type="text" name="location" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required placeholder="Contoh: Aula Utama Lt. 3">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">Kuota Peserta (Orang)</label>
                                <input type="number" name="quota" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                            </div>
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">Harga Tiket (Rp)</label>
                                <input type="number" name="price" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="0" required>
                                <p class="text-xs text-gray-500 mt-1">*Isi 0 jika Gratis</p>
                            </div>
                        </div>

                        <div class="mb-6 border-2 border-dashed border-gray-300 p-4 rounded-lg bg-gray-50 text-center">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Upload Banner Event</label>
                            <input type="file" name="image" class="block w-full text-sm text-gray-500
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-full file:border-0
                                file:text-sm file:font-semibold
                                file:bg-blue-50 file:text-blue-700
                                hover:file:bg-blue-100 cursor-pointer"
                            >
                            <p class="text-xs text-gray-400 mt-2">Format: JPG, PNG, JPEG. Max: 2MB</p>
                        </div>

                        <div class="flex items-center justify-end border-t pt-4">
                            <a href="{{ route('admin.events.index') }}" class="text-gray-600 hover:text-gray-900 font-bold mr-4 text-sm">
                                Batal
                            </a>
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg shadow-lg transform transition hover:scale-105 focus:outline-none focus:shadow-outline">
                                Simpan Event 💾
                            </button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>

    <script>
        function cekKategori() {
            var kategori = document.getElementById("kategori_select").value;
            var inputBox = document.getElementById("target_input_box");
            var inputField = document.getElementById("target_input");

            if (kategori === "umum") {
                // Sembunyikan jika UMUM
                inputBox.style.display = "none";
                inputField.value = ""; 
                inputField.removeAttribute('required');
            } else {
                // Munculkan jika FAKULTAS
                inputBox.style.display = "block";
                inputField.setAttribute('required', 'required');
            }
        }
    </script>
</x-app-layout>