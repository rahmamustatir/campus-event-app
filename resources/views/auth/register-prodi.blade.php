<form method="POST" action="{{ route('register.prodi') }}" class="p-8 max-w-md mx-auto bg-white shadow rounded">
    @csrf
    <h2 class="text-xl font-bold mb-4">Tambah Akun Kaprodi</h2>
    
    <div class="mb-4">
        <label>Nama Prodi (Contoh: Kaprodi Informatika)</label>
        <input type="text" name="name" class="w-full border p-2" required>
    </div>
    <div class="mb-4">
        <label>Email</label>
        <input type="email" name="email" class="w-full border p-2" required>
    </div>
    <div class="mb-4">
        <label>Password</label>
        <input type="password" name="password" class="w-full border p-2" required>
    </div>
    <input type="hidden" name="role" value="prodi"> <!-- Otomatis jadi role prodi -->
    
    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Simpan Akun</button>
</form>