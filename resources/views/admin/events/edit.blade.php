<x-app-layout>
    <div class="py-12">
        <div class="max-w-3xl mx-auto bg-white p-8 rounded-xl shadow-md">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Edit Event</h2>

            <form action="{{ route('admin.events.update', $event->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-5">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Judul Event</label>
                    <input type="text" name="title" value="{{ $event->title }}" class="w-full border rounded-lg p-3" required>
                </div>

                <div class="mb-5">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Deskripsi</label>
                    <textarea name="description" rows="4" class="w-full border rounded-lg p-3" required>{{ $event->description }}</textarea>
                </div>

                <div class="grid grid-cols-2 gap-6 mb-5">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Tanggal</label>
                        <input type="date" name="date" value="{{ \Carbon\Carbon::parse($event->date)->format('Y-m-d') }}" class="w-full border rounded-lg p-3" required>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Waktu</label>
                        <input type="time" name="time_start" value="{{ \Carbon\Carbon::parse($event->time_start)->format('H:i') }}" class="w-full border rounded-lg p-3" required>
                    </div>
                </div>

                <button type="submit" class="bg-blue-600 text-white px-8 py-3 rounded-lg font-bold">Update Event</button>
            </form>
        </div>
    </div>
</x-app-layout>