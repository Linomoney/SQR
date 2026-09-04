@extends('layouts.app')

@section('title', 'Kontak SQR – Saung Quran Rabbani')

@section('content')
<div class="min-h-screen flex flex-col bg-sqr-bg pt-16 sm:pt-20">

    @include('partials.navbar')
    @include('partials.mobile-sidebar')

    <!-- Hero Banner -->
    <div class="bg-gradient-to-br from-sqr-dark via-sqr-green to-[#3d6030] text-white py-12 px-4 text-center">
        <h1 class="text-3xl sm:text-4xl font-title font-black text-white">Hubungi Saung Quran Rabbani</h1>
        <p class="text-sm text-sqr-light-green mt-2">Kami siap melayani pertanyaan, pendaftaran, dan informasi seputar kegiatan SQR</p>
    </div>

    <!-- Main Content -->
    <div class="max-w-4xl mx-auto px-4 py-10 flex-1 w-full space-y-8">
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            <a href="https://wa.me/6289677082002" target="_blank" class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 text-center hover:border-sqr-orange transition group">
                <div class="w-12 h-12 bg-emerald-100 text-emerald-600 rounded-2xl flex items-center justify-center mx-auto mb-3 text-2xl group-hover:scale-110 transition">
                    <i class="fa-brands fa-whatsapp"></i>
                </div>
                <h3 class="font-title font-bold text-sqr-green text-sm">WhatsApp Resmi</h3>
                <p class="text-xs text-gray-500 mt-1">+62 896-7708-2002</p>
            </a>

            <a href="mailto:info@sqr.id" class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 text-center hover:border-sqr-orange transition group">
                <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center mx-auto mb-3 text-2xl group-hover:scale-110 transition">
                    <i class="fa-solid fa-envelope"></i>
                </div>
                <h3 class="font-title font-bold text-sqr-green text-sm">Email Lembaga</h3>
                <p class="text-xs text-gray-500 mt-1">info@sqr.id</p>
            </a>

            <a href="{{ route('lokasi') }}" class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 text-center hover:border-sqr-orange transition group">
                <div class="w-12 h-12 bg-sqr-bg text-sqr-orange rounded-2xl flex items-center justify-center mx-auto mb-3 text-2xl group-hover:scale-110 transition">
                    <i class="fa-solid fa-location-dot"></i>
                </div>
                <h3 class="font-title font-bold text-sqr-green text-sm">Lokasi Saung</h3>
                <p class="text-xs text-gray-500 mt-1">Bogor / Depok, Jawa Barat</p>
            </a>
        </div>

    </div>

    <!-- Footer -->
    <footer class="bg-sqr-dark text-white py-6 text-center text-xs text-white/50 border-t border-white/10 mt-auto">
        © {{ date('Y') }} Saung Quran Rabbani · Yayasan Bina Cahaya Ilmu Rabbani
    </footer>
</div>
@endsection
