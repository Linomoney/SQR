<!-- UNIFIED HEADER NAVBAR -->
<header class="fixed top-0 left-0 right-0 z-50 bg-sqr-green/95 backdrop-blur-md border-b border-sqr-light-green/20 text-white shadow-lg transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 sm:h-20 flex items-center justify-between gap-3">
        
        <!-- Logo & Brand Name -->
        <a href="{{ route('home') }}" class="flex items-center gap-2.5 group shrink-0 whitespace-nowrap">
            <img src="https://res.cloudinary.com/ddh5nkwv7/image/upload/v1782638700/logo_sqr_atzzpb.png" alt="Logo SQR" class="h-10 sm:h-11 w-auto object-contain group-hover:scale-105 transition-transform duration-300">
            <div class="leading-none">
                <span class="font-title font-black text-sm sm:text-base text-sqr-bg tracking-wide block">SAUNG QURAN</span>
                <span class="text-[9px] sm:text-[10px] font-bold text-sqr-orange uppercase tracking-widest block mt-0.5">RABBANI BOGOR</span>
            </div>
        </a>

        <!-- Desktop Navigation Links (Single Row, No Wrap) -->
        <nav class="hidden lg:flex items-center gap-1 xl:gap-2.5 text-xs font-semibold whitespace-nowrap flex-nowrap shrink">
            <a href="{{ route('home') }}" class="px-3 py-2 rounded-xl text-sqr-bg hover:text-white hover:bg-white/10 transition whitespace-nowrap {{ request()->routeIs('home') ? 'bg-white/15 font-bold text-white' : '' }}">
                Beranda
            </a>

            <!-- Program & Informasi Dropdown -->
            <div class="relative inline-block text-left whitespace-nowrap" id="programDropdownWrapper">
                <button type="button" onclick="toggleProgramDropdown(event)" class="px-3 py-2 rounded-xl text-sqr-bg hover:text-white hover:bg-white/10 transition flex items-center gap-1.5 focus:outline-none whitespace-nowrap">
                    <span>Program</span>
                    <i class="fa-solid fa-chevron-down text-[10px] text-sqr-orange transition-transform duration-200" id="programDropdownArrow"></i>
                </button>
                <div id="programDropdownMenu" class="hidden absolute left-0 top-full mt-2 w-64 bg-[#1c3115] border border-sqr-light-green/20 rounded-2xl shadow-2xl p-2 z-50 space-y-1">
                    <a href="{{ route('home') }}#slide-ppdb" onclick="closeProgramDropdown()" class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-gray-200 hover:bg-sqr-green hover:text-white transition whitespace-nowrap">
                        <i class="fa-solid fa-graduation-cap text-sqr-orange w-4"></i> Pendaftaran PPDB
                    </a>
                    <a href="{{ route('home') }}#slide-sanlat" onclick="closeProgramDropdown()" class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-gray-200 hover:bg-sqr-green hover:text-white transition whitespace-nowrap">
                        <i class="fa-solid fa-star-and-crescent text-sqr-orange w-4"></i> Sanlat Ramadhan
                    </a>
                    <a href="{{ route('home') }}#slide-jadwal" onclick="closeProgramDropdown()" class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-gray-200 hover:bg-sqr-green hover:text-white transition whitespace-nowrap">
                        <i class="fa-solid fa-calendar-days text-sqr-orange w-4"></i> Jadwal Pengajian SQR
                    </a>
                    <a href="{{ route('home') }}#slide-kajian" onclick="closeProgramDropdown()" class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-gray-200 hover:bg-sqr-green hover:text-white transition whitespace-nowrap">
                        <i class="fa-solid fa-video text-sqr-orange w-4"></i> Kajian Tematik Online
                    </a>
                    <a href="{{ route('home') }}#slide-galeri" onclick="closeProgramDropdown()" class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-gray-200 hover:bg-sqr-green hover:text-white transition whitespace-nowrap">
                        <i class="fa-solid fa-images text-sqr-orange w-4"></i> Galeri Foto Kegiatan
                    </a>
                    <a href="{{ route('home') }}#slide-berbagi" onclick="closeProgramDropdown()" class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-gray-200 hover:bg-sqr-green hover:text-white transition whitespace-nowrap">
                        <i class="fa-solid fa-hand-holding-heart text-sqr-orange w-4"></i> SQR Berbagi Donasi
                    </a>
                    <a href="{{ route('home') }}#slide-faq" onclick="closeProgramDropdown()" class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-gray-200 hover:bg-sqr-green hover:text-white transition whitespace-nowrap">
                        <i class="fa-solid fa-circle-question text-sqr-orange w-4"></i> Tanya Jawab (FAQ)
                    </a>
                    <a href="{{ route('home') }}#slide-laporan" onclick="closeProgramDropdown()" class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-gray-200 hover:bg-sqr-green hover:text-white transition whitespace-nowrap">
                        <i class="fa-solid fa-file-contract text-sqr-orange w-4"></i> Laporan Keuangan
                    </a>
                </div>
            </div>

            <a href="{{ route('galeri') }}" class="px-3 py-2 rounded-xl text-sqr-bg hover:text-white hover:bg-white/10 transition whitespace-nowrap {{ request()->routeIs('galeri') ? 'bg-white/15 font-bold text-white' : '' }}">
                Galeri
            </a>
            <a href="{{ route('artikel') }}" class="px-3 py-2 rounded-xl text-sqr-bg hover:text-white hover:bg-white/10 transition whitespace-nowrap {{ request()->routeIs('artikel*') ? 'bg-white/15 font-bold text-white' : '' }}">
                Artikel
            </a>
            <a href="{{ route('lokasi') }}" class="px-3 py-2 rounded-xl text-sqr-bg hover:text-white hover:bg-white/10 transition whitespace-nowrap {{ request()->routeIs('lokasi') ? 'bg-white/15 font-bold text-white' : '' }}">
                Lokasi
            </a>
            <a href="{{ route('struktur') }}" class="px-3 py-2 rounded-xl text-sqr-bg hover:text-white hover:bg-white/10 transition whitespace-nowrap {{ request()->routeIs('struktur') ? 'bg-white/15 font-bold text-white' : '' }}">
                Struktur
            </a>
            <a href="{{ route('kontak') }}" class="px-3 py-2 rounded-xl text-sqr-bg hover:text-white hover:bg-white/10 transition whitespace-nowrap {{ request()->routeIs('kontak') ? 'bg-white/15 font-bold text-white' : '' }}">
                Kontak
            </a>
        </nav>

        <!-- Right Action Buttons -->
        <div class="hidden sm:flex items-center gap-2.5 shrink-0 whitespace-nowrap">
            <a href="{{ route('ppdb.create') }}" class="bg-sqr-orange hover:bg-orange-600 text-white font-bold text-xs px-3.5 py-2.5 rounded-xl transition shadow-md flex items-center gap-1.5 whitespace-nowrap">
                <i class="fa-solid fa-pen-to-square"></i> PPDB Online
            </a>
            @auth
                <a href="{{ route('redirect') }}" class="bg-sqr-bg text-sqr-green hover:bg-white font-bold text-xs px-3.5 py-2.5 rounded-xl transition shadow-md flex items-center gap-1.5 whitespace-nowrap">
                    <i class="fa-solid fa-user-circle text-base"></i> Dashboard Portal
                </a>
            @else
                <a href="{{ route('login') }}" class="bg-white/10 hover:bg-white/20 text-white font-bold text-xs px-3.5 py-2.5 rounded-xl transition flex items-center gap-1.5 border border-white/20 whitespace-nowrap">
                    <i class="fa-solid fa-right-to-bracket"></i> Login Portal
                </a>
            @endauth
        </div>

        <!-- Mobile Right Menu Trigger -->
        <div class="flex items-center gap-2 lg:hidden shrink-0">
            <button onclick="toggleMobileSidebar()" class="p-2.5 rounded-xl bg-white/10 text-white hover:bg-white/20 transition">
                <i class="fa-solid fa-bars text-xl"></i>
            </button>
        </div>
    </div>
</header>

<script>
    function toggleProgramDropdown(e) {
        if (e) e.stopPropagation();
        var menu  = document.getElementById('programDropdownMenu');
        var arrow = document.getElementById('programDropdownArrow');
        if (!menu) return;
        var isHidden = menu.classList.contains('hidden');
        if (isHidden) {
            menu.classList.remove('hidden');
            if (arrow) arrow.style.transform = 'rotate(180deg)';
        } else {
            menu.classList.add('hidden');
            if (arrow) arrow.style.transform = 'rotate(0deg)';
        }
    }

    function closeProgramDropdown() {
        var menu  = document.getElementById('programDropdownMenu');
        var arrow = document.getElementById('programDropdownArrow');
        if (menu) menu.classList.add('hidden');
        if (arrow) arrow.style.transform = 'rotate(0deg)';
    }

    document.addEventListener('click', function(e) {
        var wrapper = document.getElementById('programDropdownWrapper');
        if (wrapper && !wrapper.contains(e.target)) {
            closeProgramDropdown();
        }
    });
</script>
