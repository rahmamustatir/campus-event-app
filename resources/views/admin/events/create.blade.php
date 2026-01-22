<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Buat Event Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form method="POST" action="{{ route('admin.events.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-4">
                            <x-input-label for="title" :value="__('Judul Event')" />
                            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" required autofocus placeholder="Contoh: Workshop Laravel 11" />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="description" :value="__('Deskripsi Singkat')" />
                            <textarea id="description" name="description" rows="4" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" placeholder="Jelaskan detail acara..." required>{{ old('description') }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="location" :value="__('Lokasi Acara')" />
                            <x-text-input id="location" class="block mt-1 w-full" type="text" name="location" :value="old('location')" required placeholder="Contoh: Aula Gedung B / Zoom Meeting" />
                            <x-input-error :messages="$errors->get('location')" class="mt-2" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <x-input-label for="event_date" :value="__('Tanggal & Jam Acara')" />
                                <x-text-input id="event_date" class="block mt-1 w-full" type="datetime-local" name="event_date" :value="old('event_date')" required />
                                <x-input-error :messages="$errors->get('event_date')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="registration_end" :value="__('Batas Akhir Pendaftaran')" />
                                <x-text-input id="registration_end" class="block mt-1 w-full" type="datetime-local" name="registration_end" :value="old('registration_end')" required />
                                <p class="text-xs text-gray-500 mt-1">*Harus sebelum tanggal acara</p>
                                <x-input-error :messages="$errors->get('registration_end')" class="mt-2" />
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <x-input-label for="quota" :value="__('Kuota Peserta')" />
                                <x-text-input id="quota" class="block mt-1 w-full" type="number" name="quota" :value="old('quota', 50)" required min="1" />
                                <x-input-error :messages="$errors->get('quota')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="poster" :value="__('Poster Event (Opsional)')" />
                                <input id="poster" type="file" name="poster" class="block mt-1 w-full text-sm text-gray-500
                                  file:mr-4 file:py-2 file:px-4
                                  file:rounded-md file:border-0
                                  file:text-sm file:font-semibold
                                  file:bg-indigo-50 file:text-indigo-700
                                  hover:file:bg-indigo-100" accept="image/*" />
                                <x-input-error :messages="$errors->get('poster')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6 pt-4 border-t border-gray-100">
                            <a href="{{ route('admin.events.index') }}" class="text-gray-600 hover:text-gray-900 mr-4 text-sm font-semibold underline">
                                Batal
                            </a>
                            <x-primary-button>
                                {{ __('Simpan Event') }}
                            </x-primary-button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>