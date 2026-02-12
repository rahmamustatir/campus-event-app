<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600 text-center">
        {{ __('Masukkan kode 6 digit yang dikirim ke WhatsApp Anda.') }}
    </div>

    @if (session('status'))
        <div class="mb-4 font-medium text-sm text-green-600 text-center">
            {{ session('status') }}
        </div>
    @endif
    
    @if ($errors->any())
        <div class="mb-4 font-medium text-sm text-red-600 text-center">
            @foreach ($errors->all() as $error)
                {{ $error }}<br>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('otp.check') }}">
        @csrf
        <div class="flex justify-center my-6">
            <input id="otp" class="block w-1/2 text-center text-2xl tracking-widest border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50" 
                   type="text" name="otp" required autofocus maxlength="6" placeholder="______" />
        </div>

        <div class="flex items-center justify-center mt-4">
            <button type="submit" class="px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                {{ __('Verifikasi') }}
            </button>
        </div>
    </form>

    <div class="mt-8 text-center border-t pt-4">
        
        <div id="timer-box">
            <p class="text-sm text-gray-500 mb-2">Mohon tunggu dalam:</p>
            <span id="timer" class="font-bold text-2xl text-gray-800">--:--</span>
        </div>

        <div id="resend-box" class="hidden">
            <p class="text-sm text-gray-500 mb-2">Tidak menerima kode?</p>
            <form method="POST" action="{{ route('otp.resend') }}">
                @csrf
                <button type="submit" class="underline text-sm text-indigo-600 hover:text-indigo-900 font-bold">
                    {{ __('Kirim Ulang Kode') }}
                </button>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Ambil sisa waktu dari Controller (angka detik)
            var timeLeft = {{ $timeLeft }};
            
            var timerElement = document.getElementById('timer');
            var timerBox = document.getElementById('timer-box');
            var resendBox = document.getElementById('resend-box');

            function updateTimer() {
                // Jika waktu habis
                if (timeLeft <= 0) {
                    timerBox.classList.add('hidden'); // Sembunyikan timer
                    resendBox.classList.remove('hidden'); // Munculkan tombol resend
                    return;
                }

                // Format Menit:Detik
                var minutes = Math.floor(timeLeft / 60);
                var seconds = timeLeft % 60;

                // Tambahkan nol di depan jika angka < 10 (contoh: 09, 05)
                var minString = minutes < 10 ? "0" + minutes : minutes;
                var secString = seconds < 10 ? "0" + seconds : seconds;

                timerElement.innerText = minString + ":" + secString;
                
                // Kurangi 1 detik
                timeLeft--;
            }

            // Jalankan pertama kali
            updateTimer();

            // Ulangi setiap 1 detik
            setInterval(updateTimer, 1000);
        });
    </script>
</x-guest-layout>