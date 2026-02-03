<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Admin') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    Selamat Datang, <strong>{{ Auth::user()->name }}</strong>! <br>
                    Anda login sebagai Administrator.
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-blue-500 rounded-lg p-6 text-white shadow-lg">
                    <h3 class="text-lg font-bold">Total Event</h3>
                    <p class="text-4xl font-bold mt-2">{{ \App\Models\Event::count() }}</p>
                </div>

                <div class="bg-green-500 rounded-lg p-6 text-white shadow-lg">
                    <h3 class="text-lg font-bold">Total Mahasiswa</h3>
                    <p class="text-4xl font-bold mt-2">{{ \App\Models\User::where('usertype', '!=', 'admin')->count() }}</p>
                </div>

                <div class="bg-purple-500 rounded-lg p-6 text-white shadow-lg">
                    <h3 class="text-lg font-bold">Pendaftaran Masuk</h3>
                    <p class="text-4xl font-bold mt-2">{{ \App\Models\Registration::count() }}</p>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>