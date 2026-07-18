<x-app-layout>
    <div class="py-6 px-4 sm:px-6 lg:px-8 w-full">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            
            <!-- Judul dan Tombol Tambah -->
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-bold text-gray-800">Daftar Event</h2>
                <a href="{{ route('admin.events.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg font-bold hover:bg-blue-700 transition">
                    + Tambah Event
                </a>
            </div>

            <!-- Tabel Data Event -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul Event</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jadwal</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Progress Kuota</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($events as $event)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">
                                    {{ $event->title }}
                                    <div class="text-sm text-gray-500">{{ $event->location }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $event->date }} <br>
                                    <span class="text-blue-600">{{ $event->time }} WIB</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <!-- Perbaikan DivisionByZeroError -->
                                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                                        <div class="bg-blue-600 h-2.5 rounded-full" 
                                             style="width: {{ $event->max_quota > 0 ? ($event->registered_users / $event->max_quota) * 100 : 0 }}%">
                                        </div>
                                    </div>
                                    {{ $event->registered_users }} Peserta / Max: {{ $event->max_quota }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        {{ $event->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('admin.events.show', $event->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Detail</a>
                                    <a href="{{ route('admin.events.edit', $event->id) }}" class="text-yellow-600 hover:text-yellow-900 mr-3">Edit</a>
                                    
                                    <!-- Tombol Ajukan -->
                                    @if($event->status == 'draft')
        <form action="{{ route('admin.events.ajukan', $event->id) }}" method="POST" class="inline">
    @csrf
    <input type="hidden" name="action" value="approve">
    <button type="submit" class="text-orange-600 hover:text-orange-900 font-bold">
        Ajukan
    </button>
</form>
    @endif
</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>