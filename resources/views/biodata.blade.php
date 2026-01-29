<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Biodata Diri Mahasiswa') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <form method="POST" action="{{ route('biodata.store') }}" class="mt-6 space-y-6">
                        @csrf

                        <div>
                            <x-input-label for="name" :value="__('Nama Lengkap')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full bg-gray-100 cursor-not-allowed" :value="auth()->user()->name" readonly />
                            <p class="text-sm text-gray-500 mt-1">Nama diambil dari data akun.</p>
                        </div>

                        <div>
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" name="email" type="text" class="mt-1 block w-full bg-gray-100 cursor-not-allowed" :value="auth()->user()->email" readonly />
                        </div>

                        <div>
                            <x-input-label for="nim" :value="__('NIM')" />
                            <x-text-input id="nim" name="nim" type="text" class="mt-1 block w-full" :value="old('nim', $biodata->nim ?? '')" placeholder="Masukkan NIM Anda" required />
                            <x-input-error class="mt-2" :messages="$errors->get('nim')" />
                        </div>

                        <div>
                            <x-input-label for="prodi" :value="__('Program Studi')" />
                            <x-text-input id="prodi" name="prodi" type="text" class="mt-1 block w-full" :value="old('prodi', $biodata->prodi ?? '')" placeholder="Contoh: Teknik Informatika" required />
                            <x-input-error class="mt-2" :messages="$errors->get('prodi')" />
                        </div>

                        <div>
                            <x-input-label for="fakultas" :value="__('Fakultas')" />
                            <x-text-input id="fakultas" name="fakultas" type="text" class="mt-1 block w-full" :value="old('fakultas', $biodata->fakultas ?? '')" placeholder="Contoh: Ilmu Komputer" />
                        </div>

                        <div>
                            <x-input-label for="phone" :value="__('No. Telepon / WhatsApp')" />
                            <x-text-input id="phone" name="phone" type="number" class="mt-1 block w-full" :value="old('phone', $biodata->phone ?? '')" placeholder="08xxxxxxxxxx" required />
                            <x-input-error class="mt-2" :messages="$errors->get('phone')" />
                        </div>

                        <div>
                            <x-input-label for="address" :value="__('Alamat Lengkap')" />
                            <textarea id="address" name="address" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="3" placeholder="Masukkan alamat domisili saat ini">{{ old('address', $biodata->address ?? '') }}</textarea>
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Simpan Biodata') }}</x-primary-button>

                            @if (session('status') === 'biodata-updated')
                                <p
                                    x-data="{ show: true }"
                                    x-show="show"
                                    x-transition
                                    x-init="setTimeout(() => show = false, 2000)"
                                    class="text-sm text-gray-600"
                                >{{ __('Tersimpan.') }}</p>
                            @endif
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>