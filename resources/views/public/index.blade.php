@extends('layouts.app')

@section('title', 'SQR - Pondasi Quran Generasi Rabbani')
@section('meta_description', 'Saung Quran Rabbani - Sistem Manajemen Lembaga Pendidikan Quran Terpadu')

@push('styles')
<style>
    .slide-section {
        min-height: 100vh;
        min-height: 100svh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 6rem 1.5rem 5rem;
        position: relative;
        overflow: hidden;
    }
    .nav-btn { transition: all 0.25s ease; }
    .nav-btn.active {
        background-color: #2d4a22 !important;
        color: white !important;
        border-color: #2d4a22 !important;
    }
    .floating-element {
        animation: floatAnim 4s ease-in-out infinite alternate;
    }
    @keyframes floatAnim {
        0%   { transform: translateY(0px) rotate(0deg); }
        100% { transform: translateY(-15px) rotate(3deg); }
    }
    .glass-panel {
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(12px);
        border: 2px solid rgba(255, 255, 255, 0.7);
    }
    .glass-panel-dark {
        background: rgba(28, 49, 21, 0.88);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.12);
    }
    .jadwal-card { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
    .jadwal-card:hover { transform: translateY(-4px); box-shadow: 0 20px 40px rgba(0,0,0,0.15); }
    .timeline-item { position: relative; padding-left: 2rem; }
    .timeline-item::before { content: ''; position: absolute; left: 0.45rem; top: 1.5rem; bottom: -1rem; width: 2px; background: linear-gradient(to bottom, #a3c585, transparent); }
    .timeline-item:last-child::before { display: none; }
    .timeline-dot { position: absolute; left: 0; top: 0.35rem; width: 0.9rem; height: 0.9rem; border-radius: 50%; background: #e67e22; border: 2px solid #f0f8d3; box-shadow: 0 0 0 3px rgba(230,126,34,0.3); }
    .faq-answer { max-height: 0; overflow: hidden; transition: max-height 0.4s ease; }
    .faq-answer.open { max-height: 300px; }
    .faq-icon { transition: transform 0.3s ease; }
    .faq-icon.rotated { transform: rotate(45deg); }
    .bg-pattern-dots { background-image: radial-gradient(circle, rgba(255,255,255,0.12) 1px, transparent 1px); background-size: 20px 20px; }
    .bg-pattern-lines { background-image: repeating-linear-gradient(45deg, rgba(255,255,255,0.04) 0, rgba(255,255,255,0.04) 1px, transparent 0, transparent 50%); background-size: 16px 16px; }

</style>
@endpush

@section('content')

@include('partials.navbar')
@include('partials.mobile-sidebar')

<!-- ===== FLOATING NAV CONTROLLER ===== -->
<div class="fixed bottom-6 right-4 z-50 flex flex-col gap-2 shadow-xl rounded-2xl bg-white p-2 border border-gray-100">
    <button onclick="window.scrollTo({top: 0, behavior: 'smooth'})" class="w-10 h-10 bg-sqr-green text-white rounded-xl hover:bg-sqr-orange transition flex items-center justify-center">
        <i class="fa-solid fa-chevron-up text-sm"></i>
    </button>
</div>

<!-- ==================== SLIDE 1: PPDB ==================== -->
<section id="slide-ppdb" class="slide-section border-b-4 border-dashed border-sqr-light-green" style="position:relative; overflow:hidden; padding:0;">

    <!-- Video Background Cloudinary -->
    <video autoplay muted loop playsinline id="ppdbBgVideo"
           style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); min-width: 100%; min-height: 100%; width: auto; height: auto; object-fit: cover; z-index: 0; pointer-events: none;">
        <source src="https://res.cloudinary.com/ddh5nkwv7/video/upload/v1782638338/sample_ztpd9h.mp4" type="video/mp4">
    </video>

    <!-- Overlay gradient -->
    <div style="position: absolute; inset: 0; z-index: 1; pointer-events: none; background: linear-gradient(135deg, rgba(28,49,21,0.88) 0%, rgba(28,49,21,0.70) 50%, rgba(44,74,34,0.85) 100%);"></div>

    <!-- Floating dekoratif -->
    <div class="absolute top-20 left-6 text-white/10 text-8xl floating-element pointer-events-none" style="z-index:2;"><i class="fa-solid fa-cloud"></i></div>
    <div class="absolute bottom-20 right-6 text-sqr-orange/20 text-9xl floating-element pointer-events-none" style="animation-delay:1s; z-index:2;"><i class="fa-solid fa-sun"></i></div>

    <!-- Konten PPDB -->
    <div class="max-w-5xl w-full grid md:grid-cols-12 gap-8 items-center" style="position:relative; z-index:3; padding: 6rem 1.5rem 5rem;">

        <!-- Kiri: Hero -->
        <div class="md:col-span-5 text-center md:text-left">
            <h1 class="font-title text-5xl md:text-6xl font-black text-sqr-orange mt-4 tracking-tight">PPDB</h1>
            <p class="font-title text-xl md:text-2xl font-bold text-white -mt-1">{{ $content->get('home_tagline', 'Saung Quran Rabbani') }}</p>
            <div class="bg-sqr-orange text-white font-title text-sm inline-block px-4 py-1 rounded-md mt-2 font-bold">
                Tahun Ajaran 2025/2026
            </div>

            <!-- Stats dari ContentManager -->
            <div class="flex gap-4 mt-5 justify-center md:justify-start">
                <div class="text-center">
                    <p class="font-title font-black text-2xl text-sqr-orange">{{ $content->get('stat_total_santri', '150+') }}</p>
                    <p class="text-[10px] text-white/70">Santri Aktif</p>
                </div>
                <div class="w-px bg-white/20"></div>
                <div class="text-center">
                    <p class="font-title font-black text-2xl text-sqr-orange">{{ $content->get('stat_pengajar', '8+') }}</p>
                    <p class="text-[10px] text-white/70">Pengajar</p>
                </div>
                <div class="w-px bg-white/20"></div>
                <div class="text-center">
                    <p class="font-title font-black text-2xl text-sqr-orange">{{ $content->get('stat_tahun', '7th') }}</p>
                    <p class="text-[10px] text-white/70">Tahun Berdiri</p>
                </div>
            </div>

            <div class="mt-6 space-y-3">
                <a href="{{ route('ppdb.create') }}"
                   class="relative inline-flex items-center gap-3 bg-emerald-600 hover:bg-emerald-700 text-white font-title font-bold text-sm px-6 py-3.5 rounded-full shadow-xl transition-all transform hover:-translate-y-1 w-full sm:w-auto justify-center animate__animated animate__pulse animate__infinite">
                    <i class="fa-solid fa-paper-plane text-lg"></i> DAFTAR SANTRI BARU (PPDB)
                </a>
            </div>
        </div>

        <!-- Kanan: Cards -->
        <div class="md:col-span-7 grid sm:grid-cols-2 gap-4">

            <!-- Keunggulan -->
            <div class="bg-white/10 backdrop-blur-md text-white p-6 rounded-[28px] shadow-xl jadwal-card border border-white/20">
                <h3 class="font-title font-bold text-base text-sqr-bg mb-3">
                    <i class="fa-solid fa-award mr-2 text-sqr-orange"></i>Keunggulan SQR
                </h3>
                <ul class="text-xs space-y-2 opacity-90 leading-relaxed">
                    <li class="flex gap-2"><i class="fa-solid fa-check text-sqr-orange mt-0.5"></i> Kurikulum Terpadu & Berkelanjutan</li>
                    <li class="flex gap-2"><i class="fa-solid fa-check text-sqr-orange mt-0.5"></i> Pengajar Berpengalaman & Amanah</li>
                    <li class="flex gap-2"><i class="fa-solid fa-check text-sqr-orange mt-0.5"></i> Pemantauan Progress Hafalan Real-Time</li>
                    <li class="flex gap-2"><i class="fa-solid fa-check text-sqr-orange mt-0.5"></i> Sertifikat & Surat Rekomendasi Resmi</li>
                </ul>
            </div>

            <!-- Profil Pengajar -->
            <div class="bg-white/10 backdrop-blur-md text-white p-6 rounded-[28px] shadow-xl border border-white/20 jadwal-card">
                <h3 class="font-title font-bold text-base text-sqr-bg mb-3">
                    <i class="fa-solid fa-graduation-cap mr-2 text-sqr-orange"></i>Profil Pengajar
                </h3>
                <ul class="text-xs space-y-2 text-white/80 font-medium">
                    <li class="flex gap-2"><i class="fa-solid fa-circle-dot text-sqr-light-green"></i> Mahasiswa LIPIA & IOU</li>
                    <li class="flex gap-2"><i class="fa-solid fa-circle-dot text-sqr-light-green"></i> Alumni Pesantren Babussalam</li>
                    <li class="flex gap-2"><i class="fa-solid fa-circle-dot text-sqr-light-green"></i> Alumni Pesantren Al Wafa</li>
                </ul>
            </div>

            <!-- Syarat & Tombol Aksi -->
            <div class="sm:col-span-2 bg-white p-6 rounded-[28px] shadow-xl border-l-8 border-sqr-orange">
                <h3 class="font-title font-bold text-base text-sqr-green mb-2">
                    <i class="fa-solid fa-file-signature text-sqr-orange mr-2"></i>Pendaftaran Peserta Didik Baru
                </h3>
                <p class="text-xs text-gray-500 mb-4">Daftarkan putra/putri Anda secara online melalui sistem PPDB terpadu SQR.</p>
                <a href="{{ route('ppdb.create') }}"
                   class="w-full bg-sqr-green hover:bg-green-900 text-white font-bold py-3.5 px-6 rounded-xl transition flex items-center justify-center gap-2 text-sm shadow-md">
                    <i class="fa-solid fa-arrow-right"></i> Buka Formulir Pendaftaran PPDB
                </a>
            </div>

        </div>
    </div>
</section>

<!-- ==================== SLIDE 2: SANLAT ==================== -->
<section id="slide-sanlat" class="slide-section bg-sqr-green text-white bg-pattern-dots">
    <div class="max-w-5xl w-full grid md:grid-cols-2 gap-8 items-center z-10">
        <div>
            <h2 class="font-title text-4xl md:text-5xl font-black text-sqr-bg mt-4">{{ $content->get('sanlat_title', 'YOOK GASS IKUT!!') }}</h2>
            <p class="text-base italic font-bold text-sqr-light-green mt-2">{{ $content->get('sanlat_subtitle', '"Ramadhan Ceria Ala Para Ulama"') }}</p>
            <div class="mt-5 bg-white/10 p-5 rounded-3xl border border-white/20">
                <p class="text-xs font-bold text-sqr-orange mb-1"><i class="fa-solid fa-user-tie mr-1"></i> Bersama Pemateri:</p>
                <p class="text-base font-bold">{{ $content->get('sanlat_pemateri', 'Ust. Raisya Rahman Aspian') }}</p>
                <p class="text-xs opacity-70">{{ $content->get('sanlat_pemateri_desc', 'Mahasiswa Jurusan Sastra Arab LIPIA Jakarta') }}</p>
            </div>
            <div class="mt-4 flex gap-3 flex-wrap">
                <div class="flex items-center gap-2 bg-white/10 px-3 py-2 rounded-xl text-xs font-bold">
                    <i class="fa-solid fa-child text-sqr-orange"></i> Usia 7–15 tahun
                </div>
                <div class="flex items-center gap-2 bg-white/10 px-3 py-2 rounded-xl text-xs font-bold">
                    <i class="fa-solid fa-users text-sqr-orange"></i> Umum & Santri SQR
                </div>
            </div>
        </div>
        <div class="space-y-4">
            <div class="bg-white text-sqr-green p-6 rounded-[28px] shadow-2xl">
                <h4 class="font-title font-bold text-sm border-b pb-2 mb-4 text-sqr-orange"><i class="fa-solid fa-star-and-crescent mr-1"></i> Rangkaian Kegiatan Sanlat</h4>
                <div class="grid grid-cols-2 gap-2 text-xs font-semibold text-sqr-dark">
                    <div class="bg-sqr-bg p-2.5 rounded-xl flex items-center gap-2"><i class="fa-solid fa-star text-sqr-orange text-[10px]"></i> Tahsin Al-Qur'an</div>
                    <div class="bg-sqr-bg p-2.5 rounded-xl flex items-center gap-2"><i class="fa-solid fa-star text-sqr-orange text-[10px]"></i> Story Telling Ulama</div>
                    <div class="bg-sqr-bg p-2.5 rounded-xl flex items-center gap-2"><i class="fa-solid fa-star text-sqr-orange text-[10px]"></i> Fun Games & Quiz</div>
                    <div class="bg-sqr-bg p-2.5 rounded-xl flex items-center gap-2"><i class="fa-solid fa-star text-sqr-orange text-[10px]"></i> Buka Puasa Bersama</div>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div class="bg-sqr-orange p-4 rounded-2xl text-center shadow-lg">
                    <p class="text-[9px] uppercase tracking-wider font-bold opacity-80 mb-1"><i class="fa-solid fa-calendar-day mr-1"></i>Waktu & Tempat</p>
                    <p class="text-xs font-bold leading-relaxed">Sabtu, 7 Maret 2026<br>10.00 – 17.30 WIB<br>SQR Pusat</p>
                </div>
                <div class="bg-white text-sqr-green p-4 rounded-2xl text-center shadow-lg flex flex-col justify-center">
                    <p class="text-[9px] uppercase tracking-wider font-bold text-gray-400 mb-1"><i class="fa-solid fa-hand-holding-dollar mr-1"></i>Infaq Sanlat</p>
                    <p class="text-xs font-bold">Umum: <span class="text-sqr-orange text-base font-black">35rb</span></p>
                    <p class="text-xs font-bold">Santri: <span class="text-sqr-orange text-base font-black">15rb</span></p>
                </div>
            </div>
            <a href="https://wa.me/6289677082002" target="_blank"
               class="flex items-center justify-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs py-3 rounded-2xl transition shadow-lg">
                <i class="fa-brands fa-whatsapp text-base"></i> Daftar Sanlat via WhatsApp
            </a>
        </div>
    </div>
</section>

<!-- ==================== SLIDE 3: JADWAL ==================== -->
<section id="slide-jadwal" class="slide-section border-b-4 border-dashed border-sqr-green/30">
    <div class="max-w-5xl w-full z-10">
        <div class="text-center mb-8">
            <h2 class="font-title text-2xl md:text-3xl font-black text-sqr-green mt-4">Jadwal & Program Belajar SQR</h2>
            <p class="text-sm text-gray-500 mt-1">Kelas tersedia untuk semua usia — dari anak-anak hingga dewasa</p>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-5">
            <!-- Kelas Anak -->
            <div class="glass-panel rounded-[28px] p-5 shadow-lg jadwal-card border-t-4 border-sqr-orange">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-12 h-12 bg-sqr-orange/10 rounded-2xl flex items-center justify-center"><i class="fa-solid fa-child text-sqr-orange text-xl"></i></div>
                    <div><h3 class="font-title font-bold text-sm text-sqr-green">Kelas Anak</h3><p class="text-[10px] text-gray-400">Usia 5–12 tahun</p></div>
                </div>
                <div class="space-y-2 text-xs text-gray-700">
                    <div class="flex justify-between py-1 border-b border-gray-100"><span>Senin – Kamis</span><span class="font-bold text-sqr-green">15.30 WIB</span></div>
                    <div class="flex justify-between py-1"><span>Sabtu</span><span class="font-bold text-sqr-green">08.00 WIB</span></div>
                </div>
                <div class="mt-4 pt-3 border-t border-gray-100 text-[10px] text-gray-500 space-y-1">
                    <p><i class="fa-solid fa-book-open mr-1 text-sqr-orange"></i> Materi: Iqro / Jilid UMMI + Tajwid Dasar</p>
                    <p><i class="fa-solid fa-memo-circle-check mr-1 text-sqr-orange"></i> Hafalan: Juz Amma & Doa Harian</p>
                </div>
            </div>
            <!-- Kelas Remaja -->
            <div class="glass-panel rounded-[28px] p-5 shadow-lg jadwal-card border-t-4 border-sqr-green relative">
                <div class="absolute -top-3 left-1/2 -translate-x-1/2 bg-sqr-green text-white text-[9px] font-bold px-3 py-0.5 rounded-full">POPULER</div>
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-12 h-12 bg-sqr-green/10 rounded-2xl flex items-center justify-center"><i class="fa-solid fa-person text-sqr-green text-xl"></i></div>
                    <div><h3 class="font-title font-bold text-sm text-sqr-green">Kelas Remaja</h3><p class="text-[10px] text-gray-400">Usia 13–17 tahun</p></div>
                </div>
                <div class="space-y-2 text-xs text-gray-700">
                    <div class="flex justify-between py-1 border-b border-gray-100"><span>Selasa & Kamis</span><span class="font-bold text-sqr-green">16.00 WIB</span></div>
                    <div class="flex justify-between py-1"><span>Sabtu</span><span class="font-bold text-sqr-green">10.00 WIB</span></div>
                </div>
                <div class="mt-4 pt-3 border-t border-gray-100 text-[10px] text-gray-500 space-y-1">
                    <p><i class="fa-solid fa-book-open mr-1 text-sqr-orange"></i> Materi: Al-Quran + Tajwid Lanjutan</p>
                    <p><i class="fa-solid fa-memo-circle-check mr-1 text-sqr-orange"></i> Hafalan: Juz 29–30 + Surah Pilihan</p>
                </div>
            </div>
            <!-- Kelas Dewasa -->
            <div class="glass-panel rounded-[28px] p-5 shadow-lg jadwal-card border-t-4 border-sqr-light-green">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-12 h-12 bg-sqr-light-green/20 rounded-2xl flex items-center justify-center"><i class="fa-solid fa-person-cane text-sqr-light-green text-xl"></i></div>
                    <div><h3 class="font-title font-bold text-sm text-sqr-green">Kelas Dewasa</h3><p class="text-[10px] text-gray-400">18 tahun ke atas</p></div>
                </div>
                <div class="space-y-2 text-xs text-gray-700">
                    <div class="flex justify-between py-1 border-b border-gray-100"><span>Rabu & Jumat</span><span class="font-bold text-sqr-green">19.30 WIB</span></div>
                    <div class="flex justify-between py-1"><span>Ahad</span><span class="font-bold text-sqr-green">08.30 WIB</span></div>
                </div>
                <div class="mt-4 pt-3 border-t border-gray-100 text-[10px] text-gray-500 space-y-1">
                    <p><i class="fa-solid fa-book-open mr-1 text-sqr-orange"></i> Materi: Tahsin Al-Quran + Tajwid</p>
                    <p><i class="fa-solid fa-memo-circle-check mr-1 text-sqr-orange"></i> Khusus: Kajian Fiqih & Tafsir</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ==================== SLIDE 4: KAJIAN ==================== -->
<section id="slide-kajian" class="slide-section bg-sqr-dark text-white bg-pattern-lines">
    <div class="absolute inset-0 bg-gradient-to-br from-sqr-dark via-sqr-green/40 to-black pointer-events-none"></div>
    <div class="max-w-5xl w-full z-10 grid md:grid-cols-12 gap-8 items-start">
        <div class="md:col-span-6 space-y-5">
            <h2 class="font-title text-3xl md:text-4xl font-black text-sqr-bg">Mengapa Memilih<br>Belajar Al-Quran<br><span class="text-sqr-orange">di SQR?</span></h2>
            <p class="text-xs text-gray-300">{{ $content->get('mengapa_sqr', 'Saung Quran Rabbani (SQR) dikelola di bawah Yayasan Bina Cahaya Ilmu Rabbani.') }}</p>
            <div class="space-y-3 pt-2">
                <p class="text-[10px] uppercase tracking-widest text-sqr-light-green">Milestone SQR</p>
                <div class="space-y-3">
                    <div class="timeline-item"><div class="timeline-dot"></div><p class="text-xs font-bold text-white">2019 — Pendirian Saung Quran Rabbani</p></div>
                    <div class="timeline-item"><div class="timeline-dot"></div><p class="text-xs font-bold text-white">2021 — Pengembangan Kelas Tahfiz & Tahsin</p></div>
                    <div class="timeline-item"><div class="timeline-dot"></div><p class="text-xs font-bold text-white">2026 — Peluncuran Portal Manajemen Digital SQR</p></div>
                </div>
            </div>
        </div>
        <div class="md:col-span-6 space-y-4">
            <div class="glass-panel-dark p-6 rounded-[36px] shadow-2xl border border-white/10">
                <span class="bg-sqr-orange text-white text-[10px] font-bold px-3 py-1 rounded-full uppercase">Kajian Islam Tematik Online</span>
                <h3 class="font-title text-lg md:text-xl font-extrabold text-white mt-4">{{ $content->get('kajian_judul', '"Hidayah Bukan Di Tangan Kita"') }}</h3>
                <div class="space-y-2.5 mt-3 text-left bg-white/5 p-4 rounded-2xl text-xs">
                    <p><i class="fa-solid fa-user text-sqr-orange mr-2"></i><b>Pemateri:</b> {{ $content->get('kajian_pemateri', 'Ustaz Hendri') }}</p>
                    <p><i class="fa-solid fa-calendar-days text-sqr-orange mr-2"></i><b>Waktu:</b> {{ $content->get('kajian_waktu', 'Jumat, 16 Mei 2025 · 19.30 WIB') }}</p>
                    <p><i class="fa-solid fa-video text-sqr-orange mr-2"></i><b>Media:</b> {{ $content->get('kajian_media', 'Google Meet') }}</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ==================== GALERI KEGIATAN SQR ==================== -->
<section id="slide-galeri" class="slide-section bg-[#eef8d8] border-b-4 border-dashed border-sqr-light-green">
    <div class="max-w-6xl w-full z-10 text-center">
        <span class="bg-sqr-green/10 text-sqr-green border border-sqr-green/20 text-[10px] font-bold px-3.5 py-1 rounded-full uppercase tracking-wider inline-block">
            📸 Dokumentasi Kegiatan
        </span>
        <h2 class="font-title text-2xl md:text-4xl font-black text-sqr-green mt-2">Galeri Kegiatan Santri SQR</h2>
        <p class="text-xs text-gray-600 mt-1 max-w-xl mx-auto">Lihat momen suasana bimbingan Al-Quran, wisuda santri, pesantren kilat, dan aksi sosial SQR.</p>

        <!-- Gallery Cards Carousel/Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 mt-8 text-left">
            @forelse($galleries->take(6) as $gal)
            <div class="bg-white rounded-3xl overflow-hidden shadow-lg border border-sqr-green/10 transition-all duration-300 hover:-translate-y-1.5 group">
                <div class="relative h-48 overflow-hidden cursor-pointer">
                    <img src="{{ $gal->image_url }}" alt="{{ $gal->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    <span class="absolute top-3 left-3 bg-sqr-dark/90 text-sqr-bg text-[9px] font-bold px-2.5 py-0.5 rounded-full border border-white/20">
                        {{ $gal->category }}
                    </span>
                </div>
                <div class="p-4">
                    <span class="text-[9px] font-semibold text-sqr-orange block mb-1"><i class="fa-solid fa-calendar-day mr-1"></i> {{ $gal->event_date?->format('d M Y') }}</span>
                    <h3 class="font-title font-bold text-sm text-sqr-green line-clamp-1 group-hover:text-sqr-orange transition">{{ $gal->title }}</h3>
                    <p class="text-[11px] text-gray-600 line-clamp-2 mt-1">{{ $gal->description }}</p>
                </div>
            </div>
            @empty
            <div class="col-span-full py-8 text-center text-gray-400 text-xs font-semibold">
                Belum ada foto galeri dipublikasikan.
            </div>
            @endforelse
        </div>

        <div class="mt-8">
            <a href="{{ route('galeri') }}" class="inline-flex items-center gap-2 bg-sqr-green hover:bg-sqr-dark text-white font-title font-bold text-xs px-6 py-3 rounded-2xl shadow-md transition transform hover:-translate-y-0.5">
                <i class="fa-solid fa-images"></i> Lihat Seluruh Galeri Foto →
            </a>
        </div>
    </div>
</section>

<!-- ==================== MEDIA SOSIAL SQR (INSTAGRAM & YOUTUBE) ==================== -->
<section id="slide-social" class="slide-section bg-gradient-to-b from-[#1c3115] to-[#2d4a22] text-white py-16 px-4 relative overflow-hidden">
    <div class="max-w-6xl w-full mx-auto z-10 text-center space-y-8">
        <div>
            <span class="bg-sqr-orange/20 text-sqr-orange border border-sqr-orange/40 text-[10px] font-bold px-4 py-1.5 rounded-full uppercase tracking-wider inline-block mb-2">
                📲 Media Sosial Resmi SQR
            </span>
            <h2 class="font-title text-3xl md:text-4xl font-black text-sqr-bg">Ikuti Kegiatan & Dokumentasi SQR</h2>
            <p class="text-xs text-gray-300 max-w-xl mx-auto mt-2">Dapatkan video kajian terbaru, dokumentasi wisuda santri, dan postingan inspiratif melalui channel Instagram & YouTube resmi Saung Quran Rabbani.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 text-left max-w-5xl mx-auto">
            <!-- Instagram Card -->
            <div class="bg-white/10 backdrop-blur-xl border border-white/20 rounded-[32px] p-6 sm:p-8 space-y-6 shadow-2xl flex flex-col justify-between group hover:border-sqr-orange/50 transition duration-300">
                <div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-14 h-14 rounded-2xl bg-gradient-to-tr from-amber-500 via-rose-500 to-purple-600 p-0.5 shadow-lg">
                                <div class="w-full h-full bg-sqr-dark rounded-[14px] flex items-center justify-center text-white">
                                    <i class="fa-brands fa-instagram text-2xl"></i>
                                </div>
                            </div>
                            <div>
                                <h3 class="font-title font-bold text-lg text-white group-hover:text-sqr-orange transition">@saungquranrabbani</h3>
                                <p class="text-xs text-gray-300">Instagram Official SQR</p>
                            </div>
                        </div>
                        <span class="bg-rose-500/20 text-rose-300 text-[10px] font-bold px-3 py-1 rounded-full border border-rose-500/30">
                            📸 Photos & Reels
                        </span>
                    </div>

                    <div class="grid grid-cols-3 gap-2 my-5">
                        <div class="h-24 rounded-2xl overflow-hidden bg-white/10 relative group/img">
                            <img src="https://res.cloudinary.com/ddh5nkwv7/image/upload/v1782638700/logo_sqr_atzzpb.png" class="w-full h-full object-contain p-2 bg-sqr-dark/60">
                        </div>
                        <div class="h-24 rounded-2xl overflow-hidden bg-sqr-green/40 flex items-center justify-center text-center p-2 border border-white/10">
                            <span class="text-[10px] font-bold text-sqr-light-green"><i class="fa-solid fa-graduation-cap block text-lg mb-1 text-sqr-orange"></i>Wisuda Santri</span>
                        </div>
                        <div class="h-24 rounded-2xl overflow-hidden bg-sqr-green/40 flex items-center justify-center text-center p-2 border border-white/10">
                            <span class="text-[10px] font-bold text-sqr-light-green"><i class="fa-solid fa-heart block text-lg mb-1 text-sqr-orange"></i>SQR Berbagi</span>
                        </div>
                    </div>

                    <p class="text-xs text-gray-300 leading-relaxed">
                        Update foto kegiatan KBM harian santri, pesan nasehat para pengajar, serta pengumuman pendaftaran PPDB terbaru.
                    </p>
                </div>

                <a href="https://instagram.com/saungquranrabbani" target="_blank" 
                   class="w-full bg-gradient-to-r from-rose-600 to-amber-600 hover:from-rose-700 hover:to-amber-700 text-white font-title font-bold text-xs py-3.5 px-6 rounded-2xl shadow-xl transition-all duration-300 flex items-center justify-center gap-2 transform hover:-translate-y-0.5">
                    <i class="fa-brands fa-instagram text-base"></i> Follow Instagram @saungquranrabbani
                </a>
            </div>

            <!-- YouTube Card -->
            <div class="bg-white/10 backdrop-blur-xl border border-white/20 rounded-[32px] p-6 sm:p-8 space-y-6 shadow-2xl flex flex-col justify-between group hover:border-red-500/50 transition duration-300">
                <div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-14 h-14 rounded-2xl bg-red-600 flex items-center justify-center text-white shadow-lg">
                                <i class="fa-brands fa-youtube text-2xl"></i>
                            </div>
                            <div>
                                <h3 class="font-title font-bold text-lg text-white group-hover:text-red-400 transition">Saung Quran Rabbani</h3>
                                <p class="text-xs text-gray-300">Official YouTube Channel</p>
                            </div>
                        </div>
                        <span class="bg-red-500/20 text-red-300 text-[10px] font-bold px-3 py-1 rounded-full border border-red-500/30">
                            🎥 Video Kajian
                        </span>
                    </div>

                    <div class="my-5 bg-black/40 rounded-2xl p-4 border border-white/10 flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-red-600/30 flex items-center justify-center text-red-500 shrink-0">
                            <i class="fa-solid fa-play text-xl"></i>
                        </div>
                        <div>
                            <h4 class="font-title font-bold text-xs text-white line-clamp-1">Kajian Tematik & Dokumentasi SQR</h4>
                            <p class="text-[10px] text-gray-400 mt-0.5">Tonton video rekaman kajian, murottal santri, & ceramah ustadz.</p>
                        </div>
                    </div>

                    <p class="text-xs text-gray-300 leading-relaxed">
                        Saksikan tayangan lengkap kajian Islam tematik, video hafalan santri berprestasi, dan dokumentasi program dakwah SQR.
                    </p>
                </div>

                <a href="https://youtube.com/@saungquranrabbani" target="_blank" 
                   class="w-full bg-gradient-to-r from-red-600 to-red-800 hover:from-red-700 hover:to-red-900 text-white font-title font-bold text-xs py-3.5 px-6 rounded-2xl shadow-xl transition-all duration-300 flex items-center justify-center gap-2 transform hover:-translate-y-0.5">
                    <i class="fa-brands fa-youtube text-base"></i> Subscribe YouTube Saung Quran Rabbani
                </a>
            </div>
        </div>
    </div>
</section>

<!-- ==================== SLIDE 5: SQR BERBAGI (CAMPAIGN DONASI) ==================== -->
<section id="slide-berbagi" class="slide-section bg-[#f7fce8] border-b-4 border-dashed border-sqr-orange">
    <div class="max-w-6xl w-full z-10 text-center">
        <span class="bg-sqr-orange/20 text-sqr-orange border border-sqr-orange/30 text-[10px] font-bold px-3.5 py-1 rounded-full uppercase tracking-wider inline-block">
            ❤️ Ta'awun & Infaq
        </span>
        <h2 class="font-title text-2xl md:text-4xl font-black text-sqr-green mt-2">SQR Berbagi & Program Donasi</h2>
        <p class="text-xs text-gray-600 mt-1 max-w-xl mx-auto">Bantu fasilitas santri, pengadaan Al-Quran hafalan, dan konsumsi Jumat berkah melalui campaign donasi resmi SQR.</p>

        <!-- Campaign Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8 text-left">
            @forelse($campaigns as $cmp)
            <div class="bg-white rounded-3xl overflow-hidden shadow-xl border border-sqr-green/10 flex flex-col justify-between transition-all duration-300 hover:-translate-y-1.5 group">
                <div>
                    <div class="relative h-44 overflow-hidden">
                        <img src="{{ $cmp->image_url }}" alt="{{ $cmp->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <span class="absolute top-3 left-3 bg-sqr-orange text-white text-[9px] font-bold px-2.5 py-1 rounded-full uppercase shadow-md">
                            {{ $cmp->category }}
                        </span>
                    </div>
                    <div class="p-5 space-y-3">
                        <h3 class="font-title font-bold text-sm text-sqr-green line-clamp-2 leading-snug group-hover:text-sqr-orange transition">{{ $cmp->title }}</h3>
                        <p class="text-[11px] text-gray-600 line-clamp-2 leading-relaxed">{{ $cmp->excerpt }}</p>

                        <!-- Progress Bar -->
                        <div class="space-y-1.5 pt-2 border-t border-gray-100">
                            <div class="flex justify-between items-center text-[10px] font-bold">
                                <span class="text-sqr-green">{{ $cmp->formatted_current }}</span>
                                <span class="text-gray-400">Target: {{ $cmp->formatted_target }}</span>
                            </div>
                            <div class="w-full bg-gray-100 h-2.5 rounded-full overflow-hidden shadow-inner">
                                <div class="bg-gradient-to-r from-sqr-orange to-amber-500 h-full rounded-full transition-all duration-1000" style="width: {{ $cmp->percentage_progress }}%;"></div>
                            </div>
                            <div class="flex justify-between items-center text-[9px] font-semibold text-gray-500">
                                <span class="text-sqr-orange font-bold"><i class="fa-solid fa-chart-line mr-1"></i>{{ $cmp->percentage_progress }}% Terkumpul</span>
                                <span>30 hari lagi</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="p-5 pt-0">
                    <a href="{{ route('berbagi.detail', $cmp->slug) }}" class="w-full bg-sqr-green hover:bg-sqr-dark text-white font-title font-bold text-xs py-2.5 rounded-xl shadow-md transition flex items-center justify-center gap-1.5">
                        <i class="fa-solid fa-hand-holding-dollar"></i> Donasikan & Detail
                    </a>
                </div>
            </div>
            @empty
            <div class="col-span-full py-8 text-center text-gray-400 text-xs font-semibold">
                Belum ada campaign donasi dipublikasikan.
            </div>
            @endforelse
        </div>

        <div class="bg-sqr-green text-white p-4 rounded-2xl mt-8 text-xs sm:text-sm flex flex-col sm:flex-row items-center justify-between gap-3 shadow-lg">
            <div class="flex items-center gap-2 text-left">
                <i class="fa-solid fa-building-columns text-sqr-orange text-2xl"></i>
                <div>
                    <p class="font-bold text-white">Transfer Donasi & Infaq Langsung</p>
                    <p class="text-[11px] text-sqr-bg">Bank BSI: <strong>7289-0123-45</strong> a.n. Yayasan Bina Cahaya Ilmu Rabbani</p>
                </div>
            </div>
            <a href="https://wa.me/6281293721163?text=Halo%20Admin%20SQR%2C%20saya%20ingin%20berdonasi" target="_blank" class="bg-sqr-orange hover:bg-orange-600 text-white font-bold text-xs px-4 py-2 rounded-xl transition shrink-0 shadow-md">
                <i class="fa-brands fa-whatsapp text-sm mr-1"></i> Konfirmasi Admin
            </a>
        </div>
    </div>
</section>

<!-- ==================== SLIDE 6: FAQ ==================== -->
<section id="slide-faq" class="slide-section bg-sqr-green text-white">
    <div class="max-w-4xl w-full text-center">
        <h2 class="font-title text-3xl font-black mt-4 text-sqr-bg">Pertanyaan Umum (FAQ)</h2>
        <div class="mt-6 space-y-3 text-left">
            @php
                $faqData = json_decode(\App\Models\ContentManager::where('key','faq_list')->value('value') ?? '[]', true) ?? [];
                // Fallback default FAQ if empty
                if (empty($faqData)) {
                    $faqData = [
                        ['question' => 'Berapa usia minimal untuk mendaftar santri SQR?', 'answer' => 'Usia minimal pendaftaran santri adalah 5 tahun untuk Kelas Anak. Kami juga membuka kelas Remaja dan Dewasa tanpa batasan usia maksimal.'],
                        ['question' => 'Apakah wali santri bisa memantau hafalan anak?', 'answer' => 'Ya! Setiap wali santri mendapatkan akses ke Dashboard Wali untuk memantau progress hafalan harian, persentase target 30 juz, serta fitur download Sertifikat & Surat Rekomendasi.'],
                        ['question' => 'Bagaimana sistem pembayaran SPP harian/bulanan?', 'answer' => 'Pembayaran dapat dilakukan melalui transfer ke rekening BSI yayasan lalu mengupload bukti transfer di menu Pembayaran Dashboard Wali untuk diverifikasi admin.'],
                    ];
                }
            @endphp

            @foreach($faqData as $fi => $faq)
            <div class="bg-white/10 rounded-2xl p-4">
                <button onclick="toggleFaq(this)" class="w-full text-left flex justify-between items-center font-bold text-sm">
                    <span>{{ $faq['question'] }}</span>
                    <i class="fa-solid fa-plus text-sqr-orange faq-icon shrink-0 ml-3"></i>
                </button>
                <div class="faq-answer text-xs text-gray-200 mt-2 leading-relaxed">
                    {{ $faq['answer'] }}
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- ==================== SLIDE 7: LAPORAN KEUANGAN ==================== -->
<section id="slide-laporan" class="slide-section bg-[#eaf4c3]">
    @php
        $laporanData = json_decode(\App\Models\ContentManager::where('key','laporan_donasi')->value('value') ?? '[]', true) ?? [];
        // Fallback if no data
        if (empty($laporanData)) {
            $laporanData = [
                [
                    'bulan' => 'Februari 2026',
                    'total_masuk' => '423.500',
                    'total_keluar' => '375.000',
                    'saldo' => '48.500',
                    'detail' => [
                        ['label' => 'Dana bulan lalu', 'nominal' => '48.500'],
                        ['label' => "Uang ta'awun Februari", 'nominal' => '375.000'],
                        ['label' => 'Somay', 'nominal' => '250.000'],
                        ['label' => 'Hadiah', 'nominal' => '86.000'],
                    ],
                ],
            ];
        }
        $activeLap = $laporanData[0] ?? null;
    @endphp
    <div class="max-w-5xl w-full text-center">
        <span class="bg-sqr-green/10 text-sqr-green border border-sqr-green/20 text-[10px] font-bold px-3.5 py-1 rounded-full uppercase tracking-wider inline-block">
            💰 Transparansi Keuangan
        </span>
        <h2 class="font-title text-2xl font-black text-sqr-green mt-2">Laporan Donasi Jumat Berbagi</h2>
        <p class="text-xs text-gray-500 mt-1">Laporan keuangan program infaq & sedekah rutin santri SQR yang diperbarui setiap bulan.</p>

        @if(count($laporanData) > 0)
        {{-- Tab buttons --}}
        <div class="flex gap-2 justify-center mt-5 flex-wrap" id="reportButtons">
            @foreach($laporanData as $lpi => $lap)
            <button onclick="switchLaporanTab({{ $lpi }})"
                    id="lapBtn-{{ $lpi }}"
                    class="lap-tab-btn px-3 py-1.5 rounded-xl text-xs font-bold transition border
                           {{ $lpi === 0 ? 'bg-sqr-green text-white border-sqr-green' : 'bg-white text-sqr-green border-sqr-green/30 hover:bg-sqr-green/10' }}">
                {{ $lap['bulan'] }}
            </button>
            @endforeach
        </div>

        {{-- Report cards --}}
        @foreach($laporanData as $lpi => $lap)
        <div id="lapCard-{{ $lpi }}" class="glass-panel p-6 rounded-3xl mt-5 text-left {{ $lpi > 0 ? 'hidden' : '' }}">
            <div class="flex items-center justify-between mb-5">
                <h4 class="font-bold text-sqr-orange text-base">{{ $lap['bulan'] }}</h4>
                <div class="flex gap-4 text-xs font-bold">
                    <span class="text-green-600">📥 Rp {{ $lap['total_masuk'] }}</span>
                    <span class="text-red-500">📤 Rp {{ $lap['total_keluar'] }}</span>
                </div>
            </div>

            @if(!empty($lap['detail']))
            <div class="grid md:grid-cols-2 gap-6">
                {{-- Pemasukan items (those without matching pengeluaran labels) --}}
                <div>
                    <h5 class="text-sm font-bold text-green-700 mb-2">📥 Pemasukan</h5>
                    <ul class="text-xs space-y-1">
                        @php $pemasukanItems = collect($lap['detail'])->filter(fn($d) => !str_contains(strtolower($d['label']), 'somay') && !str_contains(strtolower($d['label']), 'hadiah') && !str_contains(strtolower($d['label']), 'pengeluaran') && !str_contains(strtolower($d['label']), 'beli') && !str_contains(strtolower($d['label']), 'bayar')); @endphp
                        @forelse($pemasukanItems as $di => $det)
                        <li class="flex justify-between py-1 border-b border-gray-100">
                            <span>{{ $det['label'] }}</span><span>Rp {{ $det['nominal'] }}</span>
                        </li>
                        @empty
                        @foreach($lap['detail'] as $det)
                        <li class="flex justify-between py-1 border-b border-gray-100">
                            <span>{{ $det['label'] }}</span><span>Rp {{ $det['nominal'] }}</span>
                        </li>
                        @endforeach
                        @endforelse
                        <li class="flex justify-between py-1 font-bold text-sqr-green">
                            <span>Total Pemasukan</span><span>Rp {{ $lap['total_masuk'] }}</span>
                        </li>
                    </ul>
                </div>
                <div>
                    <h5 class="text-sm font-bold text-red-600 mb-2">📤 Pengeluaran</h5>
                    <ul class="text-xs space-y-1">
                        @php $pengeluaranItems = collect($lap['detail'])->filter(fn($d) => str_contains(strtolower($d['label']), 'somay') || str_contains(strtolower($d['label']), 'hadiah') || str_contains(strtolower($d['label']), 'beli') || str_contains(strtolower($d['label']), 'bayar')); @endphp
                        @forelse($pengeluaranItems as $det)
                        <li class="flex justify-between py-1 border-b border-gray-100">
                            <span>{{ $det['label'] }}</span><span>Rp {{ $det['nominal'] }}</span>
                        </li>
                        @empty
                        <li class="py-1 text-gray-400 italic">Tidak ada rincian pengeluaran.</li>
                        @endforelse
                        <li class="flex justify-between py-1 font-bold text-red-600">
                            <span>Total Pengeluaran</span><span>Rp {{ $lap['total_keluar'] }}</span>
                        </li>
                    </ul>
                </div>
            </div>
            @endif

            <div class="mt-5 text-center bg-sqr-green text-white py-2.5 px-4 rounded-xl font-bold">
                💰 Sisa Saldo: Rp {{ $lap['saldo'] }}
            </div>
        </div>
        @endforeach

        @else
        <div class="glass-panel p-8 rounded-3xl mt-5 text-center text-gray-400">
            <i class="fa-solid fa-receipt text-3xl mb-2 block opacity-30"></i>
            <p class="text-xs font-semibold">Laporan donasi belum tersedia. Admin akan segera memperbarui.</p>
        </div>
        @endif
    </div>
</section>

<!-- ===== FOOTER ===== -->
<footer class="bg-sqr-dark text-sqr-bg text-center py-8 border-t border-white/10">
    <div class="max-w-3xl mx-auto px-4">
        <div class="w-12 h-12 bg-sqr-orange rounded-full flex items-center justify-center mx-auto mb-3 shadow-md text-white">
            <i class="fa-solid fa-book-quran text-2xl"></i>
        </div>
        <p class="font-title font-black tracking-wide text-sm">SAUNG QURAN RABBANI</p>
        <p class="text-[10px] opacity-50 mt-1">Yayasan Bina Cahaya Ilmu Rabbani</p>
        <p class="text-[10px] opacity-30 mt-4">Sistem Manajemen Terpadu SQR &copy; {{ date('Y') }} · Saung Quran Rabbani</p>
    </div>
</footer>

@endsection

@push('scripts')
<script>
    function toggleMobileSidebar() {
        var overlay = document.getElementById('mobileSidebarOverlay');
        var panel   = document.getElementById('mobileSidebarPanel');
        if (!overlay || !panel) return;
        
        var isOpen = panel.classList.contains('open');
        if (isOpen) {
            overlay.classList.remove('open');
            panel.classList.remove('open');
            document.body.style.overflow = '';
        } else {
            overlay.classList.add('open');
            panel.classList.add('open');
            document.body.style.overflow = 'hidden';
        }
    }

    function toggleFaq(btn) {
        var answer = btn.nextElementSibling;
        var icon   = btn.querySelector('.faq-icon');
        answer.classList.toggle('open');
        icon.classList.toggle('rotated');
    }

    function switchLaporanTab(activeIdx) {
        document.querySelectorAll('[id^="lapCard-"]').forEach(function(card) {
            card.classList.add('hidden');
        });
        document.querySelectorAll('.lap-tab-btn').forEach(function(btn) {
            btn.classList.remove('bg-sqr-green', 'text-white', 'border-sqr-green');
            btn.classList.add('bg-white', 'text-sqr-green', 'border-sqr-green/30');
        });
        var activeCard = document.getElementById('lapCard-' + activeIdx);
        if (activeCard) activeCard.classList.remove('hidden');
        var activeBtn = document.getElementById('lapBtn-' + activeIdx);
        if (activeBtn) {
            activeBtn.classList.remove('bg-white', 'text-sqr-green', 'border-sqr-green/30');
            activeBtn.classList.add('bg-sqr-green', 'text-white', 'border-sqr-green');
        }
    }
</script>
@endpush
