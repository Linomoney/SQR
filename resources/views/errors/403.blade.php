@extends('errors.layout')

@section('title', '403 – Akses Ditolak')

@section('content')
<div class="text-center max-w-2xl mx-auto w-full">

    <!-- Lock Icon -->
    <div class="float-bob mb-8 slide-up slide-up-d1">
        <div class="inline-flex items-center justify-center w-32 h-32 sm:w-40 sm:h-40 bg-amber-900/30 backdrop-blur-xl border border-amber-500/30 rounded-[2.5rem] shadow-2xl mx-auto relative"
             style="box-shadow: 0 0 30px rgba(245,158,11,0.3), 0 0 80px rgba(245,158,11,0.15); animation: glow-pulse 2.5s ease-in-out infinite;">
            <span class="text-6xl sm:text-7xl select-none">🔒</span>
            <div class="absolute -top-3 -right-3 w-8 h-8 bg-amber-500 rounded-xl flex items-center justify-center shadow-lg">
                <i class="fa-solid fa-ban text-white text-sm"></i>
            </div>
        </div>
    </div>

    <!-- Error Number -->
    <div class="slide-up slide-up-d2 mb-4">
        <h1 id="errorNumber" class="font-title font-black text-[120px] sm:text-[180px] leading-none text-transparent bg-clip-text bg-gradient-to-b from-amber-400 via-amber-500 to-orange-600 cursor-pointer select-none drop-shadow-2xl"
            title="Klik untuk animasi!">
            403
        </h1>
    </div>

    <!-- Divider -->
    <div class="slide-up slide-up-d2 flex items-center gap-3 justify-center mb-6">
        <div class="flex-1 h-px bg-gradient-to-r from-transparent to-amber-500/50"></div>
        <span class="text-amber-300 font-bold text-xs sm:text-sm uppercase tracking-[4px]">Akses Ditolak</span>
        <div class="flex-1 h-px bg-gradient-to-l from-transparent to-amber-500/50"></div>
    </div>

    <!-- Description -->
    <div class="slide-up slide-up-d3 mb-8 space-y-3">
        <p class="text-white/90 text-base sm:text-lg font-semibold leading-relaxed">
            Anda tidak memiliki izin untuk mengakses halaman ini.
        </p>
        <p class="text-white/60 text-sm leading-relaxed max-w-md mx-auto">
            Halaman ini memerlukan hak akses khusus. Silakan login dengan akun yang memiliki wewenang atau hubungi administrator.
        </p>

        <!-- Info Card -->
        <div class="bg-amber-900/20 border border-amber-500/20 rounded-2xl px-5 py-4 inline-flex items-center gap-3 mt-3">
            <i class="fa-solid fa-shield-halved text-amber-400 text-2xl shrink-0"></i>
            <div class="text-left">
                <p class="text-amber-300 font-bold text-xs uppercase tracking-wide">Sistem Keamanan SQR</p>
                <p class="text-white/60 text-xs mt-0.5">Akses dibatasi untuk menjaga privasi data santri</p>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="slide-up slide-up-d4 flex flex-col sm:flex-row items-center justify-center gap-3">
        <a href="javascript:history.back()"
           class="w-full sm:w-auto flex items-center justify-center gap-2 px-6 py-3.5 bg-white/10 hover:bg-white/20 backdrop-blur border border-white/20 text-white font-bold text-sm rounded-2xl transition-all duration-300 hover:-translate-y-1">
            <i class="fa-solid fa-arrow-left text-sqr-orange"></i>
            Kembali
        </a>
        @auth
        <a href="/redirect"
           class="w-full sm:w-auto flex items-center justify-center gap-2 px-6 py-3.5 bg-gradient-to-r from-sqr-orange to-amber-500 hover:from-amber-500 hover:to-sqr-orange text-white font-title font-bold text-sm rounded-2xl transition-all duration-300 hover:-translate-y-1 shadow-lg">
            <i class="fa-solid fa-gauge-high"></i>
            Ke Dashboard Saya
        </a>
        @else
        <a href="/login"
           class="w-full sm:w-auto flex items-center justify-center gap-2 px-6 py-3.5 bg-gradient-to-r from-sqr-orange to-amber-500 hover:from-amber-500 hover:to-sqr-orange text-white font-title font-bold text-sm rounded-2xl transition-all duration-300 hover:-translate-y-1 shadow-lg">
            <i class="fa-solid fa-right-to-bracket"></i>
            Login Terlebih Dulu
        </a>
        @endauth
        <a href="/"
           class="w-full sm:w-auto flex items-center justify-center gap-2 px-6 py-3.5 bg-sqr-light-green/20 hover:bg-sqr-light-green/30 backdrop-blur border border-sqr-light-green/30 text-sqr-bg font-bold text-sm rounded-2xl transition-all duration-300 hover:-translate-y-1">
            <i class="fa-solid fa-house text-sqr-orange"></i>
            Ke Beranda
        </a>
    </div>
</div>
@endsection
