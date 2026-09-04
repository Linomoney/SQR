@extends('errors.layout')

@section('title', '429 – Terlalu Banyak Permintaan')

@section('content')
<div class="text-center max-w-2xl mx-auto w-full">

    <!-- Speed/Throttle Icon -->
    <div class="float-bob mb-8 slide-up slide-up-d1">
        <div class="inline-flex items-center justify-center w-32 h-32 sm:w-40 sm:h-40 bg-purple-900/30 backdrop-blur-xl border border-purple-500/30 rounded-[2.5rem] shadow-2xl mx-auto relative"
             style="box-shadow: 0 0 30px rgba(168,85,247,0.3), 0 0 80px rgba(168,85,247,0.15); animation: glow-pulse 2s ease-in-out infinite;">
            <span class="text-6xl sm:text-7xl select-none">🚦</span>
            <div class="absolute -top-3 -right-3 w-8 h-8 bg-purple-500 rounded-xl flex items-center justify-center shadow-lg animate-bounce">
                <i class="fa-solid fa-gauge-high text-white text-sm"></i>
            </div>
        </div>
    </div>

    <!-- Error Number -->
    <div class="slide-up slide-up-d2 mb-4">
        <h1 id="errorNumber" class="font-title font-black text-[120px] sm:text-[180px] leading-none text-transparent bg-clip-text bg-gradient-to-b from-purple-400 via-purple-500 to-violet-700 cursor-pointer select-none drop-shadow-2xl"
            title="Klik untuk animasi!">
            429
        </h1>
    </div>

    <!-- Divider -->
    <div class="slide-up slide-up-d2 flex items-center gap-3 justify-center mb-6">
        <div class="flex-1 h-px bg-gradient-to-r from-transparent to-purple-500/50"></div>
        <span class="text-purple-300 font-bold text-xs sm:text-sm uppercase tracking-[4px]">Terlalu Banyak Permintaan</span>
        <div class="flex-1 h-px bg-gradient-to-l from-transparent to-purple-500/50"></div>
    </div>

    <!-- Description -->
    <div class="slide-up slide-up-d3 mb-8 space-y-3">
        <p class="text-white/90 text-base sm:text-lg font-semibold leading-relaxed">
            Anda mengirim terlalu banyak permintaan dalam waktu singkat.
        </p>
        <p class="text-white/60 text-sm leading-relaxed max-w-md mx-auto">
            Sistem kami membatasi jumlah permintaan untuk menjaga keamanan dan kestabilan layanan. Tunggu beberapa menit sebelum mencoba lagi.
        </p>

        <!-- Cooldown Info -->
        <div class="bg-purple-900/20 border border-purple-500/20 rounded-2xl px-5 py-4 inline-flex items-center gap-3 mt-3">
            <i class="fa-solid fa-hourglass-half text-purple-400 text-2xl shrink-0 animate-spin" style="animation-duration: 3s;"></i>
            <div class="text-left">
                <p class="text-purple-300 font-bold text-xs uppercase tracking-wide">Harap Tunggu</p>
                <p class="text-white/60 text-xs mt-0.5">Coba kembali dalam beberapa menit</p>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="slide-up slide-up-d4 flex flex-col sm:flex-row items-center justify-center gap-3">
        <a href="/"
           class="w-full sm:w-auto flex items-center justify-center gap-2 px-6 py-3.5 bg-gradient-to-r from-sqr-orange to-amber-500 hover:from-amber-500 hover:to-sqr-orange text-white font-title font-bold text-sm rounded-2xl transition-all duration-300 hover:-translate-y-1 shadow-lg">
            <i class="fa-solid fa-house"></i>
            Ke Beranda
        </a>
        <a href="javascript:history.back()"
           class="w-full sm:w-auto flex items-center justify-center gap-2 px-6 py-3.5 bg-white/10 hover:bg-white/20 backdrop-blur border border-white/20 text-white font-bold text-sm rounded-2xl transition-all duration-300 hover:-translate-y-1">
            <i class="fa-solid fa-arrow-left text-sqr-orange"></i>
            Kembali
        </a>
    </div>
</div>
@endsection
