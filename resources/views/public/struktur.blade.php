@extends('layouts.app')

@section('title', 'Struktur Pengurus SQR – Saung Quran Rabbani')

@section('content')
<div class="min-h-screen flex flex-col bg-sqr-bg pt-16 sm:pt-20">

    @include('partials.navbar')
    @include('partials.mobile-sidebar')

    <!-- Hero -->
    <div class="bg-gradient-to-br from-sqr-dark via-sqr-green to-[#3d6030] text-white py-12 px-4 text-center">
        <h1 class="text-3xl sm:text-4xl font-title font-black text-white">Struktur Pengurus SQR</h1>
        <p class="text-sm text-sqr-light-green mt-2">Yayasan Bina Cahaya Ilmu Rabbani</p>
    </div>

    <!-- Org Chart -->
    <div class="max-w-5xl mx-auto px-4 py-12 flex-1 w-full space-y-8">

        <!-- Level 0 -->
        <div class="flex justify-center">
            <div class="bg-sqr-green text-white p-6 rounded-3xl shadow-xl border-2 border-sqr-orange text-center max-w-md w-full">
                <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-2 text-sqr-orange text-2xl">
                    <i class="fa-solid fa-building-columns"></i>
                </div>
                <h2 class="font-title font-black text-lg">Yayasan Bina Cahaya Ilmu Rabbani</h2>
                <p class="text-xs text-sqr-light-green mt-1 font-semibold">Lembaga Induk Saung Quran Rabbani</p>
            </div>
        </div>

        <!-- Connector Line -->
        <div class="w-0.5 h-8 bg-sqr-green mx-auto"></div>

        <!-- Level 1 -->
        <div class="flex justify-center">
            <div class="bg-sqr-orange text-white p-5 rounded-2xl shadow-md text-center max-w-xs w-full">
                <div class="w-10 h-10 bg-white/25 rounded-full flex items-center justify-center mx-auto mb-2 text-xl">
                    <i class="fa-solid fa-star"></i>
                </div>
                <h3 class="font-title font-bold text-base">Pimpinan SQR</h3>
                <p class="text-xs text-orange-100 mt-0.5">Pengasuh & Penanggung Jawab</p>
            </div>
        </div>

        <!-- Connector Line -->
        <div class="w-0.5 h-8 bg-sqr-green mx-auto"></div>

        <!-- Level 2 -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            @php
                $divisi = [
                    ['title' => 'Divisi Pendidikan', 'desc' => 'Kurikulum & Pembimbingan Tahfiz', 'icon' => 'fa-book-open'],
                    ['title' => 'Divisi Keuangan',   'desc' => 'Manajemen SPP & Kas Lembaga',      'icon' => 'fa-wallet'],
                    ['title' => 'Divisi Humas',      'desc' => 'Komunikasi & Publikasi',          'icon' => 'fa-bullhorn'],
                    ['title' => 'Divisi Program',    'desc' => 'Acara & Kegiatannya',              'icon' => 'fa-calendar-check'],
                ];
            @endphp

            @foreach($divisi as $d)
            <div class="bg-white p-5 rounded-3xl shadow-sm border border-gray-100 text-center hover:border-sqr-orange transition">
                <div class="w-10 h-10 bg-sqr-bg rounded-xl flex items-center justify-center mx-auto mb-3 text-sqr-green text-lg">
                    <i class="fa-solid {{ $d['icon'] }}"></i>
                </div>
                <h4 class="font-title font-bold text-sqr-green text-sm">{{ $d['title'] }}</h4>
                <p class="text-xs text-gray-500 mt-1">{{ $d['desc'] }}</p>
            </div>
            @endforeach
        </div>

    </div>

    <!-- Footer -->
    <footer class="bg-sqr-dark text-white py-6 text-center text-xs text-white/50 border-t border-white/10 mt-auto">
        © {{ date('Y') }} Saung Quran Rabbani · Yayasan Bina Cahaya Ilmu Rabbani
    </footer>
</div>
@endsection
