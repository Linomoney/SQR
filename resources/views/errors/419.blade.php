@extends('errors.layout')

@section('title', '419 – Sesi Kadaluarsa')

@section('content')
<div class="text-center max-w-2xl mx-auto w-full">

    <!-- Clock/Timer Icon -->
    <div class="float-bob mb-8 slide-up slide-up-d1">
        <div class="inline-flex items-center justify-center w-32 h-32 sm:w-40 sm:h-40 bg-blue-900/30 backdrop-blur-xl border border-blue-500/30 rounded-[2.5rem] shadow-2xl mx-auto relative"
             style="box-shadow: 0 0 30px rgba(59,130,246,0.3), 0 0 80px rgba(59,130,246,0.15); animation: glow-pulse 2.5s ease-in-out infinite;">
            <span class="text-6xl sm:text-7xl select-none">⏰</span>
            <div class="absolute -top-3 -right-3 w-8 h-8 bg-blue-500 rounded-xl flex items-center justify-center shadow-lg">
                <i class="fa-solid fa-clock-rotate-left text-white text-sm"></i>
            </div>
        </div>
    </div>

    <!-- Error Number -->
    <div class="slide-up slide-up-d2 mb-4">
        <h1 id="errorNumber" class="font-title font-black text-[120px] sm:text-[180px] leading-none text-transparent bg-clip-text bg-gradient-to-b from-blue-400 via-blue-500 to-indigo-600 cursor-pointer select-none drop-shadow-2xl"
            title="Klik untuk animasi!">
            419
        </h1>
    </div>

    <!-- Divider -->
    <div class="slide-up slide-up-d2 flex items-center gap-3 justify-center mb-6">
        <div class="flex-1 h-px bg-gradient-to-r from-transparent to-blue-500/50"></div>
        <span class="text-blue-300 font-bold text-xs sm:text-sm uppercase tracking-[4px]">Sesi Kadaluarsa</span>
        <div class="flex-1 h-px bg-gradient-to-l from-transparent to-blue-500/50"></div>
    </div>

    <!-- Description -->
    <div class="slide-up slide-up-d3 mb-8 space-y-3">
        <p class="text-white/90 text-base sm:text-lg font-semibold leading-relaxed">
            Sesi Anda telah habis masa berlakunya.
        </p>
        <p class="text-white/60 text-sm leading-relaxed max-w-md mx-auto">
            Token keamanan halaman Anda sudah kadaluarsa. Ini terjadi karena halaman terlalu lama tidak digunakan atau dibuka di tab lain.
        </p>

        <!-- CSRF Info Card -->
        <div class="bg-blue-900/20 border border-blue-500/20 rounded-2xl px-5 py-4 inline-flex items-center gap-3 mt-3">
            <i class="fa-solid fa-rotate text-blue-400 text-2xl shrink-0"></i>
            <div class="text-left">
                <p class="text-blue-300 font-bold text-xs uppercase tracking-wide">Solusi Cepat</p>
                <p class="text-white/60 text-xs mt-0.5">Kembali ke halaman sebelumnya dan coba lagi formulirnya</p>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="slide-up slide-up-d4 flex flex-col sm:flex-row items-center justify-center gap-3">
        <a href="javascript:history.back()"
           class="w-full sm:w-auto flex items-center justify-center gap-2 px-6 py-3.5 bg-gradient-to-r from-sqr-orange to-amber-500 hover:from-amber-500 hover:to-sqr-orange text-white font-title font-bold text-sm rounded-2xl transition-all duration-300 hover:-translate-y-1 shadow-lg hover:shadow-sqr-orange/30">
            <i class="fa-solid fa-arrow-left"></i>
            Kembali & Coba Lagi
        </a>
        <a href="javascript:location.reload()"
           class="w-full sm:w-auto flex items-center justify-center gap-2 px-6 py-3.5 bg-blue-600/20 hover:bg-blue-600/30 backdrop-blur border border-blue-500/30 text-blue-300 font-bold text-sm rounded-2xl transition-all duration-300 hover:-translate-y-1">
            <i class="fa-solid fa-rotate-right"></i>
            Muat Ulang Halaman
        </a>
        <a href="/"
           class="w-full sm:w-auto flex items-center justify-center gap-2 px-6 py-3.5 bg-white/10 hover:bg-white/20 backdrop-blur border border-white/20 text-white font-bold text-sm rounded-2xl transition-all duration-300 hover:-translate-y-1">
            <i class="fa-solid fa-house text-sqr-orange"></i>
            Ke Beranda
        </a>
    </div>
</div>
@endsection
