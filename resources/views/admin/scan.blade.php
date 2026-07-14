<x-app-layout>
    <div class="py-12">
        <div class="max-w-xl mx-auto bg-white p-8 rounded-2xl shadow-lg border border-gray-100">
            <div class="text-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Aktivitas Tiket</h2>
                <p class="text-gray-500">Pilih Mode dan Arahkan Kamera</p>
            </div>

            <video id="preview" class="w-full h-64 bg-black rounded-xl mb-6 object-cover border-4 border-blue-500"></video>

            <form action="{{ route('admin.scan.process') }}" method="POST" class="flex gap-3">
                @csrf
                <input type="text" name="ticket_code" placeholder="Kode tiket..." 
                       class="flex-grow border border-gray-300 rounded-lg p-4 focus:ring-2 focus:ring-blue-400 outline-none">
                
                <button type="submit" name="action" value="checkin" 
                        class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-lg transition duration-200">
                    Check<br>In
                </button>
                
                <button type="submit" name="action" value="checkout" 
                        class="bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-6 rounded-lg transition duration-200">
                    Check<br>Out
                </button>
            </form>
        </div>
    </div>

    <script src="{{ asset('js/instascan.min.js') }}"></script>

<script>
    // Pastikan kode inisialisasi tetap ada di bawahnya
    window.addEventListener('load', function () {
        if (typeof Instascan === 'undefined') {
            console.error('Library Instascan tidak ditemukan di folder public/js/');
            return;
        }
        
        let scanner = new Instascan.Scanner({ video: document.getElementById('preview') });
        
        Instascan.Camera.getCameras().then(function (cameras) {
            if (cameras.length > 0) {
                scanner.start(cameras[0]);
            } else {
                alert('Kamera tidak ditemukan!');
            }
        }).catch(function (e) {
            console.error(e);
        });

        scanner.addListener('scan', function (content) {
            document.querySelector('input[name="ticket_code"]').value = content;
        });
    });
</script>
</x-app-layout>