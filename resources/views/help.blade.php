<x-app-layout>
    <style>
        body { background-color: #0f172a !important; color: white !important; }
        .min-h-screen { background-color: #0f172a !important; }
        .neon-bg {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: -1;
            background: radial-gradient(circle at 50% 10%, rgba(59, 130, 246, 0.15) 0%, transparent 40%),
                        radial-gradient(circle at 90% 90%, rgba(139, 92, 246, 0.15) 0%, transparent 40%);
        }
        
        /* Kartu FAQ */
        .faq-card {
            background: rgba(30, 41, 59, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            transition: all 0.3s ease;
            overflow: hidden;
        }
        .faq-card:hover {
            border-color: #3b82f6;
            background: rgba(30, 41, 59, 0.8);
        }
        
        /* Kontak Admin Card */
        .contact-card {
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            border: 1px solid #3b82f6;
        }
    </style>

    <div class="neon-bg"></div>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <div class="text-center mb-12">
                <h2 class="text-3xl font-black text-white mb-2">Pusat Bantuan 💡</h2>
                <p class="text-gray-400">Temukan jawaban atas pertanyaanmu atau hubungi admin.</p>
            </div>

            <div class="space-y-4 mb-12" x-data="{ active: null }">
                
                <div class="faq-card">
                    <button @click="active = (active === 1 ? null : 1)" class="w-full text-left px-6 py-4 flex justify-between items-center focus:outline-none">
                        <span class="font-bold text-lg text-white">Bagaimana cara mendaftar event?</span>
                        <svg class="w-5 h-5 text-blue-400 transform transition-transform" :class="active === 1 ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="active === 1" x-collapse class="px-6 pb-4 text-gray-400 text-sm leading-relaxed border-t border-gray-700 pt-3">
                        Caranya sangat mudah! Buka menu <a href="/#events" class="text-blue-400 hover:underline">Jelajah Event</a>, pilih event yang kamu suka, lalu klik tombol "Daftar". Tiket akan otomatis muncul di Dashboard kamu.
                    </div>
                </div>

                <div class="faq-card">
                    <button @click="active = (active === 2 ? null : 2)" class="w-full text-left px-6 py-4 flex justify-between items-center focus:outline-none">
                        <span class="font-bold text-lg text-white">Dimana saya bisa melihat tiket saya?</span>
                        <svg class="w-5 h-5 text-blue-400 transform transition-transform" :class="active === 2 ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="active === 2" x-collapse class="px-6 pb-4 text-gray-400 text-sm leading-relaxed border-t border-gray-700 pt-3">
                        Tiket elektronik (E-Ticket) tersimpan aman di menu <a href="{{ route('dashboard') }}" class="text-blue-400 hover:underline">Dashboard</a>. Kamu bisa mendownloadnya sebagai PDF atau cukup tunjukkan QR Code saat masuk ke lokasi event.
                    </div>
                </div>

                <div class="faq-card">
                    <button @click="active = (active === 3 ? null : 3)" class="w-full text-left px-6 py-4 flex justify-between items-center focus:outline-none">
                        <span class="font-bold text-lg text-white">Apakah event ini berbayar?</span>
                        <svg class="w-5 h-5 text-blue-400 transform transition-transform" :class="active === 3 ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="active === 3" x-collapse class="px-6 pb-4 text-gray-400 text-sm leading-relaxed border-t border-gray-700 pt-3">
                        Sebagian besar event kampus bersifat <b>GRATIS</b> untuk mahasiswa. Jika ada biaya pendaftaran, informasi tersebut akan tertera jelas di deskripsi event.
                    </div>
                </div>

                <div class="faq-card">
                    <button @click="active = (active === 4 ? null : 4)" class="w-full text-left px-6 py-4 flex justify-between items-center focus:outline-none">
                        <span class="font-bold text-lg text-white">Saya batal ikut, apakah bisa membatalkan?</span>
                        <svg class="w-5 h-5 text-blue-400 transform transition-transform" :class="active === 4 ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="active === 4" x-collapse class="px-6 pb-4 text-gray-400 text-sm leading-relaxed border-t border-gray-700 pt-3">
                        Saat ini fitur pembatalan mandiri belum tersedia. Silakan hubungi Admin Kampus melalui kontak di bawah jika kamu berhalangan hadir agar slot bisa diberikan ke orang lain.
                    </div>
                </div>

            </div>

            <div class="contact-card p-8 rounded-2xl text-center shadow-lg relative overflow-hidden group">
                <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-blue-500 rounded-full opacity-20 blur-xl group-hover:scale-150 transition duration-700"></div>
                
                <h3 class="text-xl font-bold text-white mb-2">Masih butuh bantuan?</h3>
                <p class="text-gray-400 mb-6">Jangan ragu untuk menghubungi tim support kami.</p>
                
                <div class="contact-card p-8 rounded-2xl text-center shadow-lg relative overflow-hidden group">
    <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-blue-500 rounded-full opacity-20 blur-xl group-hover:scale-150 transition duration-700"></div>
    
    <h3 class="text-xl font-bold text-white mb-2">Masih butuh bantuan?</h3>
    <p class="text-gray-400 mb-6">Jangan ragu untuk menghubungi tim support kami.</p>
    
    <div class="flex flex-col md:flex-row justify-center gap-4">
        
        <a href="https://wa.me/6283814132406?text=Halo%20Admin,%20saya%20ingin%20bertanya%20seputar%20Campus%20Event" 
           target="_blank" 
           class="bg-green-600 hover:bg-green-500 text-white px-6 py-3 rounded-full font-bold flex items-center justify-center gap-2 transition transform hover:-translate-y-1 shadow-lg shadow-green-900/50">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
            WhatsApp Admin
        </a>

        <a href="mailto:admin@kampus.ac.id?subject=Bantuan%20Campus%20Event" 
           class="bg-gray-700 hover:bg-gray-600 text-white px-6 py-3 rounded-full font-bold flex items-center justify-center gap-2 transition transform hover:-translate-y-1 shadow-lg shadow-gray-900/50">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
            Email Support
        </a>

    </div>
</div>
            </div>

        </div>
    </div>
</x-app-layout>