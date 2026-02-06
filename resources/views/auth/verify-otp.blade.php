<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Demi keamanan, silakan masukkan 6 digit kode OTP yang telah kami kirim ke WhatsApp Anda.') }}
    </div>

    <form method="POST" action="{{ route('otp.process') }}">
        @csrf

        <div>
            <x-input-label for="otp" :value="__('Kode OTP')" />
            <x-text-input id="otp" class="block mt-1 w-full text-center text-2xl tracking-widest" 
                            type="text" name="otp" required autofocus placeholder="123456" />
            <x-input-error :messages="$errors->get('otp')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button class="ml-4">
                {{ __('Verifikasi Sekarang') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>