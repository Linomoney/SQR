@extends('errors.layout')

@section('title', '500 – Kesalahan Server')

@section('code-rain')
<div id="codeRainContainer" class="absolute inset-0 overflow-hidden pointer-events-none z-0 opacity-30"></div>
@endsection

@section('content')
<div class="text-center max-w-2xl mx-auto w-full">

    <!-- Animated Warning Icon -->
    <div class="float-bob mb-8 slide-up slide-up-d1">
        <div class="inline-flex items-center justify-center w-32 h-32 sm:w-40 sm:h-40 bg-red-900/30 backdrop-blur-xl border border-red-500/30 rounded-[2.5rem] shadow-2xl mx-auto relative"
             style="box-shadow: 0 0 30px rgba(239,68,68,0.3), 0 0 80px rgba(239,68,68,0.15); animation: glow-pulse 2s ease-in-out infinite;">
            <span class="text-6xl sm:text-7xl select-none">⚠️</span>
            <div class="absolute -top-3 -right-3 w-8 h-8 bg-red-500 rounded-xl flex items-center justify-center shadow-lg animate-pulse">
                <i class="fa-solid fa-bolt text-white text-sm"></i>
            </div>
        </div>
    </div>

    <!-- Error Number -->
    <div class="slide-up slide-up-d2 mb-4">
        <h1 id="errorNumber" class="font-title font-black text-[120px] sm:text-[180px] leading-none text-transparent bg-clip-text bg-gradient-to-b from-red-400 via-red-500 to-red-700 cursor-pointer select-none drop-shadow-2xl"
            title="Klik untuk animasi!">
            500
        </h1>
    </div>

    <!-- Divider -->
    <div class="slide-up slide-up-d2 flex items-center gap-3 justify-center mb-6">
        <div class="flex-1 h-px bg-gradient-to-r from-transparent to-red-500/50"></div>
        <span class="text-red-300 font-bold text-xs sm:text-sm uppercase tracking-[4px]">Kesalahan Internal Server</span>
        <div class="flex-1 h-px bg-gradient-to-l from-transparent to-red-500/50"></div>
    </div>

    <!-- Description -->
    <div class="slide-up slide-up-d3 mb-8 space-y-3">
        <p class="text-white/90 text-base sm:text-lg font-semibold leading-relaxed">
            Oops! Terjadi kesalahan pada server kami.
        </p>
        <p class="text-white/60 text-sm leading-relaxed max-w-md mx-auto">
            Kami sedang berusaha memperbaikinya. Coba beberapa saat lagi atau hubungi administrator jika masalah berlanjut.
        </p>

        <!-- Error Terminal Style Card -->
        <div class="bg-black/40 backdrop-blur border border-red-500/20 rounded-2xl p-4 text-left mt-4 font-mono max-w-lg mx-auto">
            <div class="flex items-center gap-2 mb-3 border-b border-white/10 pb-2">
                <span class="w-3 h-3 bg-red-500 rounded-full"></span>
                <span class="w-3 h-3 bg-yellow-500 rounded-full"></span>
                <span class="w-3 h-3 bg-green-500 rounded-full"></span>
                <span class="text-white/40 text-[10px] ml-2">error.log</span>
            </div>
            <p class="text-red-400 text-xs leading-relaxed">
                <span class="text-white/40">[{{ now()->format('Y-m-d H:i:s') }}]</span><br>
                ERROR: Internal Server Error (500)<br>
                <span class="text-white/40">URL: </span><span class="text-sqr-light-green">{{ request()->url() }}</span><br>
                <span class="text-white/40">STATUS: </span><span class="text-red-400 animate-pulse">● Server Exception</span>
            </p>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="slide-up slide-up-d4 flex flex-col sm:flex-row items-center justify-center gap-3">
        <a href="javascript:location.reload()"
           class="w-full sm:w-auto flex items-center justify-center gap-2 px-6 py-3.5 bg-white/10 hover:bg-white/20 backdrop-blur border border-white/20 text-white font-bold text-sm rounded-2xl transition-all duration-300 hover:-translate-y-1 hover:shadow-xl">
            <i class="fa-solid fa-rotate-right text-sqr-orange"></i>
            Coba Lagi
        </a>
        <a href="/"
           class="w-full sm:w-auto flex items-center justify-center gap-2 px-6 py-3.5 bg-gradient-to-r from-sqr-orange to-amber-500 hover:from-amber-500 hover:to-sqr-orange text-white font-title font-bold text-sm rounded-2xl transition-all duration-300 hover:-translate-y-1 shadow-lg hover:shadow-sqr-orange/30 hover:shadow-2xl">
            <i class="fa-solid fa-house"></i>
            Ke Beranda
        </a>
        <a href="https://wa.me/6289677082002" target="_blank"
           class="w-full sm:w-auto flex items-center justify-center gap-2 px-6 py-3.5 bg-emerald-600/20 hover:bg-emerald-600/30 backdrop-blur border border-emerald-500/30 text-emerald-300 font-bold text-sm rounded-2xl transition-all duration-300 hover:-translate-y-1">
            <i class="fa-brands fa-whatsapp"></i>
            Hubungi Admin
        </a>
    </div>

    <!-- Auto Retry Countdown -->
    <div class="slide-up slide-up-d4 mt-8">
        <p class="text-white/30 text-xs font-semibold">
            Halaman akan dimuat ulang otomatis dalam <span id="countdown" class="text-sqr-orange font-bold">30</span> detik.
        </p>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Code rain effect
(function() {
    var container = document.getElementById('codeRainContainer');
    if (!container) return;
    var snippets = ['Auth::attempt()', 'DB::select()', 'Response::500', 'Exception:', 'Stack trace:', 'PHP Fatal error', 'null pointer', 'dd($e)', 'abort(500)', 'Log::error()'];
    for (var i = 0; i < 10; i++) {
        var el = document.createElement('div');
        el.className = 'code-drop';
        el.style.left = (Math.random() * 100) + '%';
        el.style.animationDuration = (Math.random() * 8 + 6) + 's';
        el.style.animationDelay = (Math.random() * -15) + 's';
        el.textContent = snippets[Math.floor(Math.random() * snippets.length)];
        container.appendChild(el);
    }
})();

// Countdown & auto reload
var seconds = 30;
var countEl = document.getElementById('countdown');
var timer = setInterval(function() {
    seconds--;
    if (countEl) countEl.textContent = seconds;
    if (seconds <= 0) {
        clearInterval(timer);
        location.reload();
    }
}, 1000);
</script>
@endpush
