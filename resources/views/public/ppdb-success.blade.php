@extends('layouts.app')

@section('title', 'PPDB Berhasil Dikirim')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-[#1c3115] via-[#2d4a22] to-[#3d6030] flex items-center justify-center p-4">
    <div class="text-center max-w-md w-full">

        {{-- Success animation --}}
        <div class="relative inline-flex items-center justify-center w-28 h-28 mb-6">
            <div class="absolute inset-0 bg-[#e67e22]/20 rounded-full animate-ping"></div>
            <div class="relative w-24 h-24 bg-[#e67e22] rounded-full flex items-center justify-center shadow-2xl">
                <i class="fa-solid fa-check text-white text-4xl"></i>
            </div>
        </div>

        <h1 class="text-3xl font-black text-white mb-3">Pendaftaran Terkirim!</h1>
        <p class="text-[#a3c585] text-base mb-2">Formulir PPDB Anda telah berhasil diterima.</p>
        <p class="text-white/60 text-sm mb-8">Tim kami akan menghubungi Anda dalam 1-3 hari kerja untuk konfirmasi lebih lanjut.</p>

        <div class="bg-white/10 backdrop-blur-xl border border-white/20 rounded-2xl p-5 mb-8 text-left">
            <h3 class="text-white font-bold text-sm mb-3 flex items-center gap-2">
                <i class="fa-solid fa-circle-info text-[#e67e22]"></i>
                Langkah Selanjutnya
            </h3>
            <ol class="space-y-2 text-sm text-white/70">
                <li class="flex items-start gap-2"><span class="text-[#e67e22] font-bold">1.</span> Tunggu konfirmasi dari tim SQR via WhatsApp/telepon</li>
                <li class="flex items-start gap-2"><span class="text-[#e67e22] font-bold">2.</span> Ikuti tes seleksi dan wawancara</li>
                <li class="flex items-start gap-2"><span class="text-[#e67e22] font-bold">3.</span> Setelah diterima, akun portal wali akan dikirimkan</li>
            </ol>
        </div>

        <div class="flex flex-col sm:flex-row gap-3 justify-center">
            <a href="{{ route('home') }}"
               class="inline-flex items-center justify-center gap-2 bg-[#e67e22] hover:bg-[#cf6d17] text-white font-bold px-6 py-3 rounded-xl transition-all shadow-lg text-sm">
                <i class="fa-solid fa-home"></i>
                Kembali ke Beranda
            </a>
            <a href="{{ route('ppdb.create') }}"
               class="inline-flex items-center justify-center gap-2 bg-white/10 hover:bg-white/20 border border-white/20 text-white font-bold px-6 py-3 rounded-xl transition-all text-sm">
                <i class="fa-solid fa-user-plus"></i>
                Daftarkan Santri Lain
            </a>
        </div>
    </div>
</div>
@endsection
