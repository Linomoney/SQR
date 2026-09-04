@extends('layouts.app')

@section('title', 'Login Sistem Management')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-[#1c3115] via-[#2d4a22] to-[#12230d] flex flex-col justify-between p-4 sm:p-6 relative overflow-hidden font-poppins">

    <!-- Ambient Glow Background Effects -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-40 -right-40 w-[500px] h-[500px] bg-sqr-orange/15 rounded-full blur-[120px]"></div>
        <div class="absolute -bottom-40 -left-40 w-[500px] h-[500px] bg-sqr-light-green/15 rounded-full blur-[120px]"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-white/5 rounded-full blur-[90px]"></div>
    </div>

    <!-- Header Navigation Back to Landing Page -->
    <div class="w-full max-w-5xl mx-auto flex items-center justify-between z-20 pt-2">
        <a href="{{ route('home') }}" 
           class="inline-flex items-center gap-2 px-4 py-2.5 rounded-2xl bg-white/10 hover:bg-white/20 backdrop-blur-md text-white font-title font-bold text-xs border border-white/20 transition-all duration-300 transform hover:-translate-x-1 shadow-lg group">
            <i class="fa-solid fa-arrow-left text-sqr-orange group-hover:-translate-x-1 transition-transform"></i> Kembali ke Beranda SQR
        </a>

        <div class="hidden sm:flex items-center gap-2 text-xs font-semibold text-white/80">
            <i class="fa-solid fa-shield-halved text-sqr-orange"></i> Portal Akses Terenkripsi SSL
        </div>
    </div>

    <!-- Center Card Section -->
    <div class="w-full max-w-md mx-auto my-auto py-8 z-20 relative">

        <!-- Logo & Header Title -->
        <div class="text-center mb-6">
            <div class="inline-flex items-center justify-center w-24 h-24 bg-white/10 backdrop-blur-xl border border-white/20 rounded-3xl shadow-2xl p-3 mb-4 ring-4 ring-white/10 transform hover:scale-105 transition-transform duration-300">
                <img src="https://res.cloudinary.com/ddh5nkwv7/image/upload/v1782638700/logo_sqr_atzzpb.png" alt="SQR Logo" class="w-full h-full object-contain filter drop-shadow-md">
            </div>
            <h1 class="font-title text-2xl sm:text-3xl font-black text-white tracking-tight">Saung Quran Rabbani</h1>
            <p class="text-sqr-light-green font-bold text-xs mt-1">Portal Log In Sistem Informasi & Manajemen</p>
        </div>

        <!-- Login Card Form -->
        <div class="bg-white/10 backdrop-blur-2xl border border-white/20 rounded-[32px] p-6 sm:p-8 shadow-2xl space-y-5">
            <div class="border-b border-white/10 pb-4 text-center">
                <h2 class="font-title font-bold text-lg text-white">Masuk ke Akun Anda</h2>
                <p class="text-[11px] text-white/60 mt-0.5">Masukkan email & kata sandi resmi yang telah terdaftar</p>
            </div>

            <!-- Error Alerts -->
            @if($errors->any())
            <div class="bg-red-500/20 border border-red-400/50 text-red-100 rounded-2xl p-3.5 text-xs font-semibold flex items-start gap-2.5 animate__animated animate__fadeIn">
                <i class="fa-solid fa-triangle-exclamation text-red-400 text-base shrink-0 mt-0.5"></i>
                <div>
                    <span class="font-bold block text-white">Gagal Masuk!</span>
                    <span>{{ $errors->first() }}</span>
                </div>
            </div>
            @endif

            @if(session('status'))
            <div class="bg-emerald-500/20 border border-emerald-400/50 text-emerald-100 rounded-2xl p-3.5 text-xs font-semibold flex items-center gap-2">
                <i class="fa-solid fa-circle-check text-emerald-400 text-base"></i>
                <span>{{ session('status') }}</span>
            </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf

                <!-- Email Input -->
                <div>
                    <label for="email" class="block text-xs font-bold text-white/90 mb-1.5">
                        <i class="fa-solid fa-envelope text-sqr-orange mr-1.5"></i>Alamat Email *
                    </label>
                    <div class="relative">
                        <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                               placeholder="contoh: admin@sqr.id"
                               class="w-full bg-white/10 border border-white/20 rounded-2xl px-4 py-3 text-white placeholder-white/40 text-xs font-semibold outline-none focus:ring-2 focus:ring-sqr-orange focus:border-transparent transition-all shadow-inner">
                    </div>
                </div>

                <!-- Password Input with Toggle -->
                <div>
                    <label for="password" class="block text-xs font-bold text-white/90 mb-1.5">
                        <i class="fa-solid fa-lock text-sqr-orange mr-1.5"></i>Kata Sandi (Password) *
                    </label>
                    <div class="relative">
                        <input id="password" name="password" type="password" required autocomplete="current-password"
                               placeholder="••••••••"
                               class="w-full bg-white/10 border border-white/20 rounded-2xl px-4 py-3 text-white placeholder-white/40 text-xs font-semibold pr-11 outline-none focus:ring-2 focus:ring-sqr-orange focus:border-transparent transition-all shadow-inner">
                        <button type="button" onclick="togglePasswordVisibility()" class="absolute right-3.5 top-1/2 -translate-y-1/2 text-white/60 hover:text-white transition focus:outline-none" title="Lihat Sandi">
                            <i id="togglePassIcon" class="fa-solid fa-eye text-sm"></i>
                        </button>
                    </div>
                </div>

                <!-- Remember Me Checkbox -->
                <div class="flex items-center justify-between pt-1">
                    <label class="flex items-center gap-2 text-xs font-bold text-white/80 cursor-pointer select-none">
                        <input type="checkbox" name="remember" class="w-4 h-4 text-sqr-orange bg-white/10 border-white/30 rounded focus:ring-sqr-orange">
                        Ingat Saya di Perangkat Ini
                    </label>
                </div>

                <!-- Submit Button -->
                <button type="submit"
                        class="w-full bg-gradient-to-r from-sqr-orange to-amber-600 hover:from-amber-600 hover:to-sqr-orange text-white font-title font-bold text-xs sm:text-sm py-3.5 px-6 rounded-2xl shadow-xl transition-all duration-300 transform hover:-translate-y-0.5 active:translate-y-0 flex items-center justify-center gap-2">
                    <i class="fa-solid fa-right-to-bracket text-base"></i> Masuk Ke Sistem SQR
                </button>
            </form>

            <!-- Quick Demo Credentials Box -->
            <div class="mt-6 pt-4 border-t border-white/10">
                <p class="text-center text-[10px] text-white/60 font-semibold mb-2.5">
                    💡 Klik untuk Auto-Fill Akun Demo (Password: <code class="bg-white/10 px-1.5 py-0.5 rounded text-sqr-orange">password</code>)
                </p>
                <div class="grid grid-cols-3 gap-2">
                    <button type="button" onclick="fillDemo('admin@sqr.id')" class="bg-white/5 hover:bg-white/15 border border-white/10 rounded-2xl p-2 text-center transition cursor-pointer group">
                        <i class="fa-solid fa-shield-halved text-sqr-orange text-sm block mb-1 group-hover:scale-110 transition-transform"></i>
                        <span class="text-white/80 text-[10px] font-bold block">Admin</span>
                    </button>
                    <button type="button" onclick="fillDemo('ustadz@sqr.id')" class="bg-white/5 hover:bg-white/15 border border-white/10 rounded-2xl p-2 text-center transition cursor-pointer group">
                        <i class="fa-solid fa-chalkboard-user text-sqr-orange text-sm block mb-1 group-hover:scale-110 transition-transform"></i>
                        <span class="text-white/80 text-[10px] font-bold block">Ustadz</span>
                    </button>
                    <button type="button" onclick="fillDemo('wali@sqr.id')" class="bg-white/5 hover:bg-white/15 border border-white/10 rounded-2xl p-2 text-center transition cursor-pointer group">
                        <i class="fa-solid fa-user-tie text-sqr-orange text-sm block mb-1 group-hover:scale-110 transition-transform"></i>
                        <span class="text-white/80 text-[10px] font-bold block">Wali Santri</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Footer Copyright -->
        <div class="text-center text-white/40 text-[11px] font-semibold mt-6">
            © {{ date('Y') }} Saung Quran Rabbani · All Rights Reserved
        </div>
    </div>

    <!-- Bottom Security Indicator -->
    <div class="w-full max-w-5xl mx-auto text-center z-20 pb-2">
        <p class="text-[10px] text-white/30 font-semibold">
            🔒 Protected by SQR Authentication & Session Encryption
        </p>
    </div>
</div>

<script>
    function togglePasswordVisibility() {
        var input = document.getElementById('password');
        var icon = document.getElementById('togglePassIcon');
        if (input && icon) {
            if (input.type === 'password') {
                input.type = 'text';
                icon.className = 'fa-solid fa-eye-slash text-sm text-sqr-orange';
            } else {
                input.type = 'password';
                icon.className = 'fa-solid fa-eye text-sm text-white/60';
            }
        }
    }

    function fillDemo(email) {
        var emailInput = document.getElementById('email');
        var passInput = document.getElementById('password');
        if (emailInput && passInput) {
            emailInput.value = email;
            passInput.value = 'password';
        }
    }
</script>
@endsection
