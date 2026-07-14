<table class="w-full text-left text-sm">
    <thead class="bg-gray-50 text-gray-500">
        <tr>
            <th class="py-3 px-6">Name</th>
            <th class="py-3 px-6">Role</th>
            <th class="py-3 px-6">Status</th>
            <th class="py-3 px-6">Aksi</th> 
        </tr>
    </thead>
    <tbody class="divide-y">
        @foreach($allUsers as $u)
        <tr>
            <td class="py-3 px-6">{{ $u->name }}</td>
            <td class="py-3 px-6 uppercase font-bold text-blue-600">{{ $u->role }}</td>
            <td class="py-3 px-6">{{ $u->is_verified ? 'Aktif' : 'Pending' }}</td>
            
            <td class="py-3 px-6">
                <a href="{{ route('admin.users.edit', $u->id) }}" class="text-orange-600 font-bold hover:underline">Edit Role</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>