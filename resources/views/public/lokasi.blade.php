@extends('layouts.app')

@section('title', 'Lokasi SQR – Saung Quran Rabbani')

@section('content')
<div class="min-h-screen flex flex-col bg-sqr-bg pt-16 sm:pt-20">

    @include('partials.navbar')
    @include('partials.mobile-sidebar')

    <!-- Hero Banner -->
    <div class="bg-gradient-to-br from-sqr-dark via-sqr-green to-[#3d6030] text-white py-12 px-4 text-center">
        <div class="inline-flex items-center gap-2 bg-sqr-orange/20 border border-sqr-orange/40 text-sqr-orange px-4 py-1.5 rounded-full text-xs font-bold mb-3">
            <i class="fa-solid fa-location-dot"></i> Lokasi Aktif Pengajikan
        </div>
        <h1 class="text-3xl sm:text-4xl font-title font-black text-white">Lokasi Saung Quran Rabbani</h1>
        <p class="text-sm text-sqr-light-green mt-2">Temukan lokasi kami & bergabunglah dalam kegiatan belajar Al-Qur'an</p>
    </div>

    <!-- Main Content -->
    <div class="max-w-5xl mx-auto px-4 py-8 flex-1 w-full">
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">

            <!-- Info Kontak & Petunjuk -->
            <div class="lg:col-span-2 space-y-4">
                <div class="bg-white p-5 rounded-3xl shadow-sm border border-gray-100">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-9 h-9 bg-sqr-bg rounded-xl flex items-center justify-center text-sqr-green">
                            <i class="fa-solid fa-location-dot text-base text-sqr-orange"></i>
                        </div>
                        <h3 class="font-title font-bold text-sqr-green text-sm">Alamat Lengkap</h3>
                    </div>
                    <p class="text-xs text-gray-600 leading-relaxed">
                        Jl. Saung Quran Rabbani, Depok, Jawa Barat<br>
                        (Detail alamat dan patokan lengkap dapat ditanyakan via WhatsApp Admin)
                    </p>
                    <a href="https://maps.google.com" target="_blank" class="inline-flex items-center gap-1.5 text-xs text-sqr-orange font-bold hover:underline mt-3">
                        <i class="fa-solid fa-map-location-dot"></i> Buka di Google Maps →
                    </a>
                </div>

                <div class="bg-white p-5 rounded-3xl shadow-sm border border-gray-100">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-9 h-9 bg-sqr-bg rounded-xl flex items-center justify-center text-sqr-green">
                            <i class="fa-solid fa-clock text-base text-sqr-orange"></i>
                        </div>
                        <h3 class="font-title font-bold text-sqr-green text-sm">Jam Operasional</h3>
                    </div>
                    <div class="space-y-2 text-xs text-gray-600">
                        <div class="flex justify-between py-1 border-b border-gray-50">
                            <span class="font-semibold">Kelas Anak</span>
                            <span class="text-sqr-green font-bold">Sen–Kam 15.30 · Sab 08.00</span>
                        </div>
                        <div class="flex justify-between py-1 border-b border-gray-50">
                            <span class="font-semibold">Kelas Remaja</span>
                            <span class="text-sqr-green font-bold">Sel & Kam 16.00 · Sab 10.00</span>
                        </div>
                        <div class="flex justify-between py-1">
                            <span class="font-semibold">Kelas Dewasa</span>
                            <span class="text-sqr-green font-bold">Rab & Jum 19.30 · Ahd 08.30</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Map -->
            <div class="lg:col-span-3">
                <div class="bg-white p-3 rounded-3xl shadow-sm border border-gray-100 h-full flex flex-col">
                    <h3 class="font-title font-bold text-sqr-green text-sm mb-3 px-2 flex items-center gap-2">
                        <i class="fa-solid fa-map text-sqr-orange"></i> Peta Lokasi
                    </h3>
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.0975!2d106.8757012!3d-6.3936950!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69eb70e83f9d27%3A0xbda34da948e4806a!2sSQR!5e0!3m2!1sid!2sid!4v1700000000000!5m2!1sid!2sid"
                        class="w-full flex-1 min-h-[350px] rounded-2xl border border-gray-200"
                        allowfullscreen="" loading="lazy"></iframe>
                </div>
            </div>

        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-sqr-dark text-white py-6 text-center text-xs text-white/50 border-t border-white/10 mt-auto">
        © {{ date('Y') }} Saung Quran Rabbani · Yayasan Bina Cahaya Ilmu Rabbani
    </footer>
</div>
@endsection
