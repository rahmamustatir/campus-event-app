<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Data Mahasiswa
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    {{-- TOMBOL KEMBALI --}}
                    <div class="mb-6">
                        <a href="{{ route('admin.users.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                            &larr; Kembali ke Daftar
                        </a>
                    </div>

                    {{-- INFORMASI PRIBADI --}}
                    <h3 class="text-lg font-bold mb-4 border-b pb-2">Informasi Pribadi</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
                        <div>
                            <p class="text-gray-600">Nama Lengkap:</p>
                            <p class="font-semibold text-lg">{{ $user->name }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600">Email:</p>
                            <p class="font-semibold">{{ $user->email }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600">Role:</p>
                            <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded text-sm">
                                {{ $user->usertype ?? 'Mahasiswa' }}
                            </span>
                        </div>
                        <div>
                            <p class="text-gray-600">Bergabung Sejak:</p>
                            <p class="font-semibold">{{ $user->created_at->format('d M Y') }}</p>
                        </div>
                    </div>

                    {{-- BIODATA TAMBAHAN (Jika Ada) --}}
                    @if($user->biodata)
                    <h3 class="text-lg font-bold mb-4 border-b pb-2 mt-6">Biodata Akademik</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
                        <div>
                            <p class="text-gray-600">NIM:</p>
                            <p class="font-semibold">{{ $user->biodata->nim ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600">Program Studi:</p>
                            <p class="font-semibold">{{ $user->biodata->prodi ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600">Fakultas:</p>
                            <p class="font-semibold">{{ $user->biodata->fakultas ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600">No. WhatsApp:</p>
                            <p class="font-semibold">{{ $user->biodata->whatsapp ?? '-' }}</p>
                        </div>
                    </div>
                    @else
                        <div class="p-4 bg-yellow-100 text-yellow-800 rounded mb-6">
                            Mahasiswa ini belum melengkapi biodata.
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>