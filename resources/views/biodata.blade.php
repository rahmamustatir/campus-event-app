<x-app-layout>
    <style>
        body { background-color: #0f172a !important; color: white !important; }
        .neon-card {
            background: rgba(30, 41, 59, 0.7);
            border: 1px solid rgba(59, 130, 246, 0.3);
            box-shadow: 0 0 15px rgba(59, 130, 246, 0.1);
        }
        .neon-input {
            background-color: #1e293b;
            border: 1px solid #334155;
            color: white;
        }
        .neon-input:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 5px #3b82f6;
        }
    </style>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            
            <div class="flex items-center gap-3 mb-6">
                <div class="p-3 bg-blue-600 rounded-lg shadow-lg shadow-blue-500/50">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-white">Biodata Peserta</h2>
                    <p class="text-gray-400 text-sm">Lengkapi data diri untuk keperluan sertifikat & event.</p>
                </div>
            </div>

            @if(session('success'))
                <div class="mb-4 p-4 bg-green-900/50 border border-green-500 text-green-200 rounded-lg flex items-center gap-2">
                    ✅ {{ session('success') }}
                </div>
            @endif

            <div class="neon-card p-8 rounded-2xl">
                <form method="POST" action="{{ route('biodata.update') }}" class="space-y-6">
                    @csrf
                    @method('PATCH')

                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-1">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" class="neon-input w-full rounded-lg px-4 py-2" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-1">Email (Akun Login)</label>
                        <input type="email" value="{{ $user->email }}" class="w-full rounded-lg px-4 py-2 bg-gray-800 border border-gray-700 text-gray-500 cursor-not-allowed" disabled>
                        <p class="text-xs text-gray-500 mt-1">*Email tidak dapat diubah.</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-1">NIM / NPM</label>
                            <input type="text" name="nim" value="{{ old('nim', $user->nim) }}" placeholder="Contoh: 12345678" class="neon-input w-full rounded-lg px-4 py-2">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-1">Jurusan / Prodi</label>
                            <input type="text" name="jurusan" value="{{ old('jurusan', $user->jurusan) }}" placeholder="Contoh: Teknik Informatika" class="neon-input w-full rounded-lg px-4 py-2">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-1">No. WhatsApp</label>
                        <div class="flex">
                            <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-600 bg-gray-700 text-gray-300 text-sm">
                                +62
                            </span>
                            <input type="text" name="no_hp" value="{{ old('no_hp', $user->no_hp) }}" placeholder="812xxxxx" class="neon-input w-full rounded-r-lg px-4 py-2">
                        </div>
                    </div>

                    <div class="pt-4 border-t border-gray-700 flex justify-end">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-500 text-white font-bold py-2 px-6 rounded-full shadow-[0_0_15px_rgba(37,99,235,0.5)] transition transform hover:scale-105">
                            Simpan Perubahan 💾
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>