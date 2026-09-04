<!-- MOBILE RIGHT NAVIGATION DRAWER -->
<div id="mobileSidebarOverlay" class="fixed inset-0 bg-black/70 backdrop-blur-sm z-[119] hidden transition-opacity duration-300">
    <div onclick="toggleMobileSidebar()" class="absolute inset-0"></div>
</div>

<aside id="mobileSidebarPanel" class="fixed top-0 right-0 h-full w-[80vw] max-w-[320px] bg-[#1c3115] text-white p-5 shadow-2xl flex flex-col justify-between transform transition-transform duration-300 translate-x-full z-[120] overflow-y-auto" style="background-color: #1c3115 !important; color: #ffffff !important;">
    <div>
        <!-- Header -->
        <div class="flex items-center justify-between border-b border-white/15 pb-4 mb-5">
            <div class="flex items-center gap-3">
                <img src="https://res.cloudinary.com/ddh5nkwv7/image/upload/v1782638700/logo_sqr_atzzpb.png" alt="Logo SQR" class="w-10 h-10 rounded-full object-cover shadow-md">
                <div class="leading-none">
                    <span class="font-title font-bold text-sm text-sqr-bg block">Saung Quran</span>
                    <span class="text-[10px] text-sqr-orange font-bold block mt-0.5 uppercase tracking-wider">Rabbani Bogor</span>
                </div>
            </div>
            <button onclick="toggleMobileSidebar()" class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center text-white hover:bg-white/20 transition">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>

        <!-- Menu Navigation Links -->
        <nav class="space-y-1 text-xs font-bold">
            <a href="{{ route('home') }}" onclick="toggleMobileSidebar()" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl hover:bg-sqr-green transition text-white">
                <i class="fa-solid fa-house text-sqr-orange w-4"></i> <span>Beranda Utama</span>
            </a>

            <div class="py-2 border-t border-white/10 mt-2">
                <p class="text-[10px] uppercase tracking-widest text-sqr-orange font-bold px-3.5 mb-2">Program & Informasi SQR</p>
                <a href="{{ route('home') }}#slide-ppdb" onclick="toggleMobileSidebar()" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl hover:bg-sqr-green transition text-white">
                    <i class="fa-solid fa-graduation-cap text-sqr-orange w-4"></i> <span>PPDB Santri Baru</span>
                </a>
                <a href="{{ route('home') }}#slide-sanlat" onclick="toggleMobileSidebar()" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl hover:bg-sqr-green transition text-white">
                    <i class="fa-solid fa-star-and-crescent text-sqr-orange w-4"></i> <span>Sanlat Ramadhan</span>
                </a>
                <a href="{{ route('home') }}#slide-jadwal" onclick="toggleMobileSidebar()" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl hover:bg-sqr-green transition text-white">
                    <i class="fa-solid fa-calendar-days text-sqr-orange w-4"></i> <span>Jadwal Pengajian</span>
                </a>
                <a href="{{ route('home') }}#slide-kajian" onclick="toggleMobileSidebar()" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl hover:bg-sqr-green transition text-white">
                    <i class="fa-solid fa-video text-sqr-orange w-4"></i> <span>Kajian Tematik</span>
                </a>
                <a href="{{ route('home') }}#slide-berbagi" onclick="toggleMobileSidebar()" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl hover:bg-sqr-green transition text-white">
                    <i class="fa-solid fa-hand-holding-heart text-sqr-orange w-4"></i> <span>SQR Berbagi</span>
                </a>
                <a href="{{ route('home') }}#slide-faq" onclick="toggleMobileSidebar()" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl hover:bg-sqr-green transition text-white">
                    <i class="fa-solid fa-circle-question text-sqr-orange w-4"></i> <span>Pertanyaan (FAQ)</span>
                </a>
                <a href="{{ route('home') }}#slide-laporan" onclick="toggleMobileSidebar()" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl hover:bg-sqr-green transition text-white">
                    <i class="fa-solid fa-chart-pie text-sqr-orange w-4"></i> <span>Laporan Keuangan</span>
                </a>
            </div>

            <div class="border-t border-white/10 pt-2 space-y-1">
                <p class="text-[10px] uppercase tracking-widest text-sqr-orange font-bold px-3.5 mb-2">Halaman Terpisah</p>
                <a href="{{ route('lokasi') }}" onclick="toggleMobileSidebar()" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl hover:bg-sqr-green transition text-white">
                    <i class="fa-solid fa-location-dot text-sqr-orange w-4"></i> <span>Lokasi Pengajian</span>
                </a>
                <a href="{{ route('kontak') }}" onclick="toggleMobileSidebar()" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl hover:bg-sqr-green transition text-white">
                    <i class="fa-solid fa-envelope text-sqr-orange w-4"></i> <span>Kontak SQR</span>
                </a>
                <a href="{{ route('struktur') }}" onclick="toggleMobileSidebar()" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl hover:bg-sqr-green transition text-white">
                    <i class="fa-solid fa-sitemap text-sqr-orange w-4"></i> <span>Struktur Pengurus</span>
                </a>
                <a href="{{ route('galeri') }}" onclick="toggleMobileSidebar()" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl hover:bg-sqr-green transition text-white">
                    <i class="fa-solid fa-images text-sqr-orange w-4"></i> <span>Galeri Foto Kegiatan</span>
                </a>
                <a href="{{ route('artikel') }}" onclick="toggleMobileSidebar()" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl hover:bg-sqr-green transition text-white">
                    <i class="fa-solid fa-newspaper text-sqr-orange w-4"></i> <span>Artikel & Kegiatan</span>
                </a>
            </div>
        </nav>
    </div>

    <!-- Sidebar Footer -->
    <div class="pt-4 border-t border-white/10 space-y-2 mt-4">
        @auth
            <a href="{{ route('redirect') }}" class="w-full bg-sqr-orange hover:bg-orange-600 text-white font-bold text-xs py-3 rounded-xl transition shadow-md block text-center">
                <i class="fa-solid fa-user-circle mr-1.5"></i> Dashboard Portal
            </a>
        @else
            <a href="{{ route('login') }}" class="w-full bg-sqr-orange hover:bg-orange-600 text-white font-bold text-xs py-3 rounded-xl transition shadow-md block text-center">
                <i class="fa-solid fa-right-to-bracket mr-1.5"></i> Masuk Dashboard
            </a>
        @endauth
        <p class="text-[10px] text-center text-white/50">&copy; {{ date('Y') }} Saung Quran Rabbani</p>
    </div>
</aside>

<script>
    function toggleMobileSidebar() {
        var overlay = document.getElementById('mobileSidebarOverlay');
        var panel   = document.getElementById('mobileSidebarPanel');
        if (!overlay || !panel) return;
        
        var isOpen = panel.classList.contains('open') || !panel.classList.contains('translate-x-full');
        if (isOpen) {
            overlay.classList.add('hidden');
            overlay.classList.remove('open');
            panel.classList.add('translate-x-full');
            panel.classList.remove('open');
            document.body.style.overflow = '';
        } else {
            overlay.classList.remove('hidden');
            overlay.classList.add('open');
            panel.classList.remove('translate-x-full');
            panel.classList.add('open');
            document.body.style.overflow = 'hidden';
        }
    }
</script>
