@extends('errors.layout')

@section('title', '404 – Halaman Tidak Ditemukan')

@section('content')
<div class="text-center max-w-2xl mx-auto w-full">

    <!-- Floating Quran Icon -->
    <div class="float-bob mb-8 slide-up slide-up-d1">
        <div class="inline-flex items-center justify-center w-32 h-32 sm:w-40 sm:h-40 bg-white/10 backdrop-blur-xl border border-white/20 rounded-[2.5rem] shadow-2xl glow-pulse mx-auto relative">
            <span class="text-6xl sm:text-7xl select-none">🕌</span>
            <div class="absolute -top-3 -right-3 w-8 h-8 bg-sqr-orange rounded-xl flex items-center justify-center shadow-lg">
                <i class="fa-solid fa-magnifying-glass text-white text-sm"></i>
            </div>
        </div>
    </div>

    <!-- Error Number -->
    <div class="slide-up slide-up-d2 mb-4">
        <h1 id="errorNumber" class="font-title font-black text-[120px] sm:text-[180px] leading-none text-transparent bg-clip-text bg-gradient-to-b from-sqr-orange via-amber-400 to-sqr-orange cursor-pointer select-none drop-shadow-2xl"
            title="Klik untuk animasi!">
            404
        </h1>
    </div>

    <!-- Arabic calligraphy style divider -->
    <div class="slide-up slide-up-d2 flex items-center gap-3 justify-center mb-6">
        <div class="flex-1 h-px bg-gradient-to-r from-transparent to-sqr-orange/50"></div>
        <span class="text-sqr-light-green font-bold text-xs sm:text-sm uppercase tracking-[4px]">Halaman Tidak Ditemukan</span>
        <div class="flex-1 h-px bg-gradient-to-l from-transparent to-sqr-orange/50"></div>
    </div>

    <!-- Description -->
    <div class="slide-up slide-up-d3 mb-8 space-y-3">
        <p class="text-white/90 text-base sm:text-lg font-semibold leading-relaxed">
            Halaman yang Anda cari tidak tersedia.
        </p>
        <p class="text-white/60 text-sm leading-relaxed max-w-md mx-auto">
            Mungkin halaman telah dipindahkan, dihapus, atau Anda memasukkan alamat yang salah.
        </p>
        <div class="bg-white/5 backdrop-blur border border-white/10 rounded-2xl px-5 py-3 inline-block mt-2">
            <p class="text-sqr-light-green text-xs font-bold font-mono break-all">
                {{ request()->path() !== '/' ? '/' . request()->path() : request()->url() }}
            </p>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="slide-up slide-up-d4 flex flex-col sm:flex-row items-center justify-center gap-3">
        <a href="javascript:history.back()"
           class="w-full sm:w-auto flex items-center justify-center gap-2 px-6 py-3.5 bg-white/10 hover:bg-white/20 backdrop-blur border border-white/20 text-white font-bold text-sm rounded-2xl transition-all duration-300 hover:-translate-y-1 hover:shadow-xl">
            <i class="fa-solid fa-arrow-left text-sqr-orange"></i>
            Kembali
        </a>
        <a href="/"
           class="w-full sm:w-auto flex items-center justify-center gap-2 px-6 py-3.5 bg-gradient-to-r from-sqr-orange to-amber-500 hover:from-amber-500 hover:to-sqr-orange text-white font-title font-bold text-sm rounded-2xl transition-all duration-300 hover:-translate-y-1 shadow-lg hover:shadow-sqr-orange/30 hover:shadow-2xl">
            <i class="fa-solid fa-house"></i>
            Ke Beranda
        </a>
        <a href="/ppdb"
           class="w-full sm:w-auto flex items-center justify-center gap-2 px-6 py-3.5 bg-sqr-light-green/20 hover:bg-sqr-light-green/30 backdrop-blur border border-sqr-light-green/30 text-sqr-bg font-bold text-sm rounded-2xl transition-all duration-300 hover:-translate-y-1">
            <i class="fa-solid fa-graduation-cap text-sqr-orange"></i>
            PPDB Online
        </a>
    </div>

    <!-- Helpful Links -->
    <div class="slide-up slide-up-d4 mt-10 pt-6 border-t border-white/10">
        <p class="text-white/40 text-xs font-semibold mb-4 uppercase tracking-wider">Mungkin Anda Mencari:</p>
        <div class="flex flex-wrap items-center justify-center gap-2">
            @foreach([
                ['href' => '/galeri',    'label' => 'Galeri',   'icon' => 'fa-images'],
                ['href' => '/artikel',   'label' => 'Artikel',  'icon' => 'fa-newspaper'],
                ['href' => '/lokasi',    'label' => 'Lokasi',   'icon' => 'fa-location-dot'],
                ['href' => '/kontak',    'label' => 'Kontak',   'icon' => 'fa-envelope'],
                ['href' => '/login',     'label' => 'Login',    'icon' => 'fa-right-to-bracket'],
            ] as $link)
            <a href="{{ $link['href'] }}"
               class="flex items-center gap-1.5 px-4 py-2 bg-white/5 hover:bg-white/15 border border-white/10 hover:border-white/30 text-white/70 hover:text-white text-xs font-semibold rounded-xl transition-all duration-200">
                <i class="fa-solid {{ $link['icon'] }} text-sqr-orange text-xs"></i>
                {{ $link['label'] }}
            </a>
            @endforeach
        </div>
    </div>
</div>
@endsection
