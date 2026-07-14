<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Riwayat Pendaftaran Event') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th>Event</th><th>Status</th><th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($registrations as $reg)
                            <tr>
                                <td>{{ $reg->event->title }}</td>
                                <td>{{ strtoupper($reg->status_presence) }}</td>
                                <td>
                                    @if($reg->status_presence == 'registered')
                                        <form action="{{ route('mahasiswa.checkin', $reg->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="bg-blue-500 text-white px-2 py-1 rounded">Check-In</button>
                                        </form>
                                    
                                    @elseif($reg->status_presence == 'check-in')
                                        <form action="{{ route('mahasiswa.checkout', $reg->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="bg-yellow-500 text-white px-2 py-1 rounded">Check-Out</button>
                                        </form>
                                    
                                    @elseif($reg->status_presence == 'check-out')
                                        <a href="{{ route('certificate.download', $reg->event_id) }}" class="bg-green-600 text-white px-2 py-1 rounded">Download Sertifikat</a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>