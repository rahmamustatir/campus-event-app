<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Tambah Event</title>
</head>
<body class="bg-gray-50 p-10">

    <div class="max-w-3xl mx-auto bg-white p-8 rounded-xl shadow-md border border-gray-100">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Tambah Event Baru</h2>

        <form action="{{ route('admin.events.store') }}" method="POST">
            @csrf
            
            <div class="mb-5">
                <label class="block text-sm font-bold text-gray-700 mb-2">Nama Event</label>
                <input type="text" name="title" class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 outline-none" required>
            </div>

            <div class="mb-5">
                <label class="block text-sm font-bold text-gray-700 mb-2">Deskripsi</label>
                <textarea name="description" rows="4" class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 outline-none" required></textarea>
            </div>

            <div class="grid grid-cols-2 gap-6 mb-5">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Tanggal</label>
                    <input type="date" name="date" class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 outline-none" required>
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Kuota Peserta</label>
                    <input type="number" name="quota" class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 outline-none" required>
                </div>
            </div>

            <div class="mb-8">
                <label class="block text-sm font-bold text-gray-700 mb-2">Lokasi</label>
                <input type="text" name="location" class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 outline-none" required>
            </div>

            <div class="mt-4">
        <label class="block text-sm font-medium text-gray-700">Upload Proposal (PDF)</label>
        <input type="file" name="proposal" accept=".pdf" class="mt-1 block w-full border-gray-300 rounded-md" required>
        <p class="text-xs text-gray-500 mt-1">Format file harus PDF (Max 2MB)</p>
    </div>

            <div class="flex items-center gap-4 mt-6">
    <!-- Tombol Simpan -->
    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg font-semibold hover:bg-blue-700 transition duration-200">
        Simpan & Ajukan
    </button>

    <!-- Tombol Batal -->
    <a href="{{ route('admin.events.index') }}" class="text-gray-600 hover:text-gray-900 font-medium px-4 py-2 rounded-lg border border-gray-300 hover:bg-gray-50 transition duration-200">
        Batal
    </a>
</div>
        </form>
    </div>

</body>
</html>