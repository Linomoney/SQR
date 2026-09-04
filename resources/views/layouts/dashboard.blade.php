<!DOCTYPE html>
<html lang="id" class="h-full bg-gray-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') – Saung Quran Rabbani</title>

    <!-- Google Fonts: Montserrat & Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700;800;900&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Tom Select -->
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet">

    <!-- Tailwind Script -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'sqr-bg':          '#f0f8d3',
                        'sqr-green':       '#2d4a22',
                        'sqr-orange':      '#e67e22',
                        'sqr-light-green': '#a3c585',
                        'sqr-dark':        '#1c3115'
                    },
                    fontFamily: {
                        'montserrat': ['Montserrat', 'sans-serif'],
                        'poppins':    ['Poppins', 'sans-serif']
                    }
                }
            }
        }
    </script>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @stack('styles')

    <style>
        [x-cloak] { display: none !important; }
        body { font-family: 'Poppins', sans-serif; }
        .font-title { font-family: 'Montserrat', sans-serif; }
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: #f0f8d3; }
        ::-webkit-scrollbar-thumb { background: #a3c585; border-radius: 3px; }
        #dashMobileSidebarOverlay {
            position: fixed; inset: 0; z-index: 100;
            background: rgba(0,0,0,0.6); backdrop-filter: blur(4px);
            opacity: 0; pointer-events: none; transition: opacity 0.3s ease;
        }
        #dashMobileSidebarOverlay.open { opacity: 1; pointer-events: auto; }
        #dashMobileSidebarPanel {
            position: fixed; top: 0; left: 0; height: 100vh; height: 100dvh;
            background: #1c3115; color: white;
            width: 80vw; max-width: 300px;
            transform: translateX(-100%); transition: transform 0.35s cubic-bezier(.4,0,.2,1);
            display: flex; flex-direction: column; justify-content: space-between;
            box-shadow: 8px 0 40px rgba(0,0,0,0.35); z-index: 101; overflow-y: auto;
        }
        #dashMobileSidebarPanel.open { transform: translateX(0); }
    </style>

    @stack('styles')
</head>
<body class="min-h-full flex bg-gray-100 font-poppins">

    <!-- DESKTOP SIDEBAR NAV -->
    <aside class="w-64 bg-sqr-dark text-white flex flex-col shrink-0 shadow-2xl z-30 hidden md:flex sticky top-0 h-screen">
        <!-- Brand -->
        <div class="p-5 border-b border-white/10 flex items-center gap-3 bg-sqr-green/40">
            <div class="w-10 h-10 bg-sqr-orange rounded-xl flex items-center justify-center text-white shadow-md">
                <i class="fa-solid fa-book-quran text-xl"></i>
            </div>
            <div>
                <h1 class="font-title font-bold text-sm text-sqr-bg leading-none">Saung Quran</h1>
                <p class="text-[10px] text-sqr-orange font-semibold tracking-wider mt-0.5 uppercase">Dashboard Portal</p>
            </div>
        </div>

        <!-- Role Badge -->
        <div class="px-5 py-3 border-b border-white/10 bg-white/5 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-full bg-sqr-orange/20 border border-sqr-orange flex items-center justify-center text-sqr-orange font-bold text-xs">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div class="leading-tight">
                    <p class="text-xs font-bold text-white truncate max-w-[120px]">{{ auth()->user()->name }}</p>
                    <span class="text-[9px] text-sqr-light-green font-semibold uppercase">{{ auth()->user()->getRoleNames()->first() ?? 'User' }}</span>
                </div>
            </div>
        </div>

        <!-- Navigation Links -->
        <nav class="flex-1 p-4 space-y-2 overflow-y-auto text-xs font-semibold">
            @php
                $isGroup1Active = request()->routeIs(['admin.dashboard', 'admin.ppdb.*', 'admin.santri.*']);
                $isGroup2Active = request()->routeIs(['admin.classes.*', 'admin.users.*', 'admin.jadwal.*']);
                $isGroup3Active = request()->routeIs(['admin.verifikasi.*', 'admin.finance.*', 'admin.campaigns.*']);
                $isGroup4Active = request()->routeIs(['admin.content.*', 'admin.artikel.*', 'admin.galleries.*', 'admin.notifications.*']);
                $isGroup5Active = request()->routeIs(['admin.certificates.*']);
            @endphp

            @role('admin')
                <!-- Group 1: UTAMA & PPDB -->
                <div class="space-y-1">
                    <button type="button" onclick="toggleSidebarDropdown('groupUtamaDesktop')" class="w-full flex items-center justify-between px-3 py-2 rounded-xl text-sqr-orange font-bold text-[10px] uppercase tracking-wider hover:bg-white/10 transition">
                        <span class="flex items-center gap-2"><i class="fa-solid fa-compass"></i> 1. UTAMA & PPDB</span>
                        <i id="arrow-groupUtamaDesktop" class="fa-solid fa-chevron-down text-[10px] transition-transform duration-300 {{ $isGroup1Active ? 'rotate-180' : '' }}"></i>
                    </button>
                    <div id="groupUtamaDesktop" class="{{ $isGroup1Active ? '' : 'hidden' }} space-y-1 pl-2 border-l border-white/10 ml-3">
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl transition {{ request()->routeIs('admin.dashboard') ? 'bg-sqr-green text-white font-bold shadow-md' : 'text-gray-300 hover:bg-white/10' }}">
                            <i class="fa-solid fa-chart-line text-sqr-orange w-4"></i> Overview Dashboard
                        </a>
                        <a href="{{ route('admin.ppdb.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl transition {{ request()->routeIs('admin.ppdb.*') ? 'bg-sqr-green text-white font-bold shadow-md' : 'text-gray-300 hover:bg-white/10' }}">
                            <i class="fa-solid fa-file-signature text-sqr-orange w-4"></i> Data Pendaftaran PPDB
                        </a>
                        <a href="{{ route('admin.santri.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl transition {{ request()->routeIs('admin.santri.*') ? 'bg-sqr-green text-white font-bold shadow-md' : 'text-gray-300 hover:bg-white/10' }}">
                            <i class="fa-solid fa-user-graduate text-sqr-orange w-4"></i> Data Santri
                        </a>
                    </div>
                </div>

                <!-- Group 2: AKADEMIK & KELAS -->
                <div class="space-y-1">
                    <button type="button" onclick="toggleSidebarDropdown('groupAkademikDesktop')" class="w-full flex items-center justify-between px-3 py-2 rounded-xl text-sqr-orange font-bold text-[10px] uppercase tracking-wider hover:bg-white/10 transition">
                        <span class="flex items-center gap-2"><i class="fa-solid fa-school"></i> 2. AKADEMIK & KELAS</span>
                        <i id="arrow-groupAkademikDesktop" class="fa-solid fa-chevron-down text-[10px] transition-transform duration-300 {{ $isGroup2Active ? 'rotate-180' : '' }}"></i>
                    </button>
                    <div id="groupAkademikDesktop" class="{{ $isGroup2Active ? '' : 'hidden' }} space-y-1 pl-2 border-l border-white/10 ml-3">
                        <a href="{{ route('admin.jadwal.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl transition {{ request()->routeIs('admin.jadwal.*') ? 'bg-sqr-green text-white font-bold shadow-md' : 'text-gray-300 hover:bg-white/10' }}">
                            <i class="fa-solid fa-calendar-days text-sqr-orange w-4"></i> Jadwal & Kalender Akademik
                        </a>
                        <a href="{{ route('admin.classes.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl transition {{ request()->routeIs('admin.classes.*') ? 'bg-sqr-green text-white font-bold shadow-md' : 'text-gray-300 hover:bg-white/10' }}">
                            <i class="fa-solid fa-chalkboard-user text-sqr-orange w-4"></i> Kelas & Kuota PPDB
                        </a>
                        <a href="{{ route('admin.locations.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl transition {{ request()->routeIs('admin.locations.*') ? 'bg-sqr-green text-white font-bold shadow-md' : 'text-gray-300 hover:bg-white/10' }}">
                            <i class="fa-solid fa-map-location-dot text-sqr-orange w-4"></i> Lokasi Cabang SQR
                        </a>
                        <a href="{{ route('admin.users.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl transition {{ request()->routeIs('admin.users.*') ? 'bg-sqr-green text-white font-bold shadow-md' : 'text-gray-300 hover:bg-white/10' }}">
                            <i class="fa-solid fa-users text-sqr-orange w-4"></i> Ustadz & Wali Santri
                        </a>
                    </div>
                </div>

                <!-- Group 3: KEUANGAN & DONASI -->
                <div class="space-y-1">
                    <button type="button" onclick="toggleSidebarDropdown('groupKeuanganDesktop')" class="w-full flex items-center justify-between px-3 py-2 rounded-xl text-sqr-orange font-bold text-[10px] uppercase tracking-wider hover:bg-white/10 transition">
                        <span class="flex items-center gap-2"><i class="fa-solid fa-wallet"></i> 3. KEUANGAN & DONASI</span>
                        <i id="arrow-groupKeuanganDesktop" class="fa-solid fa-chevron-down text-[10px] transition-transform duration-300 {{ $isGroup3Active ? 'rotate-180' : '' }}"></i>
                    </button>
                    <div id="groupKeuanganDesktop" class="{{ $isGroup3Active ? '' : 'hidden' }} space-y-1 pl-2 border-l border-white/10 ml-3">
                        <a href="{{ route('admin.payroll.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl transition {{ request()->routeIs('admin.payroll.*') ? 'bg-sqr-green text-white font-bold shadow-md' : 'text-gray-300 hover:bg-white/10' }}">
                            <i class="fa-solid fa-money-check-dollar text-sqr-orange w-4"></i> Penggajian Ustadz SQR
                        </a>
                        <a href="{{ route('admin.verifikasi.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl transition {{ request()->routeIs('admin.verifikasi.*') ? 'bg-sqr-green text-white font-bold shadow-md' : 'text-gray-300 hover:bg-white/10' }}">
                            <i class="fa-solid fa-file-invoice-dollar text-sqr-orange w-4"></i> Verifikasi Transfer SPP
                        </a>
                        <a href="{{ route('admin.finance.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl transition {{ request()->routeIs('admin.finance.*') ? 'bg-sqr-green text-white font-bold shadow-md' : 'text-gray-300 hover:bg-white/10' }}">
                            <i class="fa-solid fa-coins text-sqr-orange w-4"></i> Kas Yayasan SQR
                        </a>
                        <a href="{{ route('admin.campaigns.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl transition {{ request()->routeIs('admin.campaigns.*') ? 'bg-sqr-green text-white font-bold shadow-md' : 'text-gray-300 hover:bg-white/10' }}">
                            <i class="fa-solid fa-hand-holding-heart text-sqr-orange w-4"></i> Program SQR Berbagi
                        </a>
                    </div>
                </div>

                <!-- Group 4: WEBSITE & PUBLIK -->
                <div class="space-y-1">
                    <button type="button" onclick="toggleSidebarDropdown('groupWebsiteDesktop')" class="w-full flex items-center justify-between px-3 py-2 rounded-xl text-sqr-orange font-bold text-[10px] uppercase tracking-wider hover:bg-white/10 transition">
                        <span class="flex items-center gap-2"><i class="fa-solid fa-globe"></i> 4. WEBSITE & PUBLIK</span>
                        <i id="arrow-groupWebsiteDesktop" class="fa-solid fa-chevron-down text-[10px] transition-transform duration-300 {{ $isGroup4Active ? 'rotate-180' : '' }}"></i>
                    </button>
                    <div id="groupWebsiteDesktop" class="{{ $isGroup4Active ? '' : 'hidden' }} space-y-1 pl-2 border-l border-white/10 ml-3">
                        <a href="{{ route('admin.content.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl transition {{ request()->routeIs('admin.content.*') ? 'bg-sqr-green text-white font-bold shadow-md' : 'text-gray-300 hover:bg-white/10' }}">
                            <i class="fa-solid fa-sliders text-sqr-orange w-4"></i> Content Web Manager
                        </a>
                        <a href="{{ route('admin.artikel.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl transition {{ request()->routeIs('admin.artikel.*') ? 'bg-sqr-green text-white font-bold shadow-md' : 'text-gray-300 hover:bg-white/10' }}">
                            <i class="fa-solid fa-newspaper text-sqr-orange w-4"></i> Kelola Artikel & News
                        </a>
                        <a href="{{ route('admin.galleries.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl transition {{ request()->routeIs('admin.galleries.*') ? 'bg-sqr-green text-white font-bold shadow-md' : 'text-gray-300 hover:bg-white/10' }}">
                            <i class="fa-solid fa-images text-sqr-orange w-4"></i> Galeri Foto Activity
                        </a>
                        <a href="{{ route('admin.notifications.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl transition {{ request()->routeIs('admin.notifications.*') ? 'bg-sqr-green text-white font-bold shadow-md' : 'text-gray-300 hover:bg-white/10' }}">
                            <i class="fa-solid fa-bullhorn text-sqr-orange w-4"></i> Broadcast Notifikasi
                        </a>
                    </div>
                </div>

                <!-- Group 5: SERTIFIKAT & PENGHARGAAN -->
                <div class="space-y-1">
                    <button type="button" onclick="toggleSidebarDropdown('groupSertifikatDesktop')" class="w-full flex items-center justify-between px-3 py-2 rounded-xl text-sqr-orange font-bold text-[10px] uppercase tracking-wider hover:bg-white/10 transition">
                        <span class="flex items-center gap-2"><i class="fa-solid fa-award"></i> 5. SERTIFIKAT & PENGHARGAAN</span>
                        <i id="arrow-groupSertifikatDesktop" class="fa-solid fa-chevron-down text-[10px] transition-transform duration-300 {{ $isGroup5Active ? 'rotate-180' : '' }}"></i>
                    </button>
                    <div id="groupSertifikatDesktop" class="{{ $isGroup5Active ? '' : 'hidden' }} space-y-1 pl-2 border-l border-white/10 ml-3">
                        <a href="{{ route('admin.certificates.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl transition {{ request()->routeIs('admin.certificates.index') ? 'bg-sqr-green text-white font-bold shadow-md' : 'text-gray-300 hover:bg-white/10' }}">
                            <i class="fa-solid fa-graduation-cap text-sqr-orange w-4"></i> Daftar Sertifikat Santri
                        </a>
                        <a href="{{ route('admin.certificates.settings') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl transition {{ request()->routeIs('admin.certificates.settings*') ? 'bg-sqr-green text-white font-bold shadow-md' : 'text-gray-300 hover:bg-white/10' }}">
                            <i class="fa-solid fa-signature text-sqr-orange w-4"></i> Pengaturan TTD & Cap
                        </a>
                    </div>
                </div>
            @endrole

            @role('ustadz')
                @php
                    $uPrefix = auth()->user()->teacher_route_prefix ?? 'ustadz';
                    $uTitle  = auth()->user()->title_prefix;
                @endphp
                <p class="text-[9px] uppercase tracking-widest text-white/40 px-3 mt-2 mb-1">Portal {{ $uTitle }}</p>
                <a href="{{ route($uPrefix . '.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-sqr-green transition {{ request()->routeIs('*.dashboard') ? 'bg-sqr-green text-white font-bold' : 'text-gray-300' }}">
                    <i class="fa-solid fa-house-user text-sqr-orange w-4"></i> Dashboard {{ $uTitle }}
                </a>
                <a href="{{ route('kalender') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-sqr-green transition {{ request()->routeIs('kalender') ? 'bg-sqr-green text-white font-bold' : 'text-gray-300' }}">
                    <i class="fa-solid fa-calendar-days text-sqr-orange w-4"></i> Kalender Akademik SQR
                </a>
                <a href="{{ route($uPrefix . '.progress.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-sqr-green transition {{ request()->routeIs('*.progress.*') ? 'bg-sqr-green text-white font-bold' : 'text-gray-300' }}">
                    <i class="fa-solid fa-book-open-reader text-sqr-orange w-4"></i> Input Progress Hafalan
                </a>
                <a href="{{ route($uPrefix . '.attendance.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-sqr-green transition {{ request()->routeIs('*.attendance.*') ? 'bg-sqr-green text-white font-bold' : 'text-gray-300' }}">
                    <i class="fa-solid fa-user-check text-sqr-orange w-4"></i> Presensi Kehadiran
                </a>
                <a href="{{ route($uPrefix . '.payroll.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-sqr-green transition {{ request()->routeIs('*.payroll.*') ? 'bg-sqr-green text-white font-bold' : 'text-gray-300' }}">
                    <i class="fa-solid fa-wallet text-sqr-orange w-4"></i> Slip Gaji & Honorarium
                </a>
                <a href="{{ route($uPrefix . '.notifications.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-sqr-green transition {{ request()->routeIs('*.notifications.*') ? 'bg-sqr-green text-white font-bold' : 'text-gray-300' }}">
                    <i class="fa-solid fa-bell text-sqr-orange w-4"></i> Notifikasi Masuk
                </a>
                <a href="{{ route($uPrefix . '.profile') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-sqr-green transition {{ request()->routeIs('*.profile*') ? 'bg-sqr-green text-white font-bold' : 'text-gray-300' }}">
                    <i class="fa-solid fa-id-card text-sqr-orange w-4"></i> Biodata KTP/KK & Akun
                    @if(auth()->user()->is_profile_deadline_passed)
                    <span class="bg-red-500 text-white text-[9px] font-black px-1.5 py-0.5 rounded-full ml-auto animate-pulse">Wajib!</span>
                    @elseif(!auth()->user()->is_profile_completed)
                    <span class="bg-amber-500 text-white text-[9px] font-black px-1.5 py-0.5 rounded-full ml-auto">Lengkapi</span>
                    @endif
                </a>
            @endrole

            @role('wali')
                <p class="text-[9px] uppercase tracking-widest text-white/40 px-3 mt-2 mb-1">Portal Wali Santri</p>
                <a href="{{ route('wali.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-sqr-green transition {{ request()->routeIs('wali.dashboard') ? 'bg-sqr-green text-white font-bold' : 'text-gray-300' }}">
                    <i class="fa-solid fa-heart text-sqr-orange w-4"></i> Progress Hafalan Ananda
                </a>
                <a href="{{ route('wali.attendance.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-sqr-green transition {{ request()->routeIs('wali.attendance.*') ? 'bg-sqr-green text-white font-bold' : 'text-gray-300' }}">
                    <i class="fa-solid fa-calendar-check text-sqr-orange w-4"></i> Presensi Kehadiran Santri
                </a>
                <a href="{{ route('kalender') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-sqr-green transition {{ request()->routeIs('kalender') ? 'bg-sqr-green text-white font-bold' : 'text-gray-300' }}">
                    <i class="fa-solid fa-calendar-days text-sqr-orange w-4"></i> Kalender Kegiatan & Libur
                </a>
                <a href="{{ route('wali.payments.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-sqr-green transition {{ request()->routeIs('wali.payments.*') ? 'bg-sqr-green text-white font-bold' : 'text-gray-300' }}">
                    <i class="fa-solid fa-receipt text-sqr-orange w-4"></i> Pembayaran SPP Bulanan
                </a>
                <a href="{{ route('wali.notifications') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-sqr-green transition {{ request()->routeIs('wali.notifications') ? 'bg-sqr-green text-white font-bold' : 'text-gray-300' }}">
                    <i class="fa-solid fa-bell text-sqr-orange w-4"></i> Notifikasi & Pengumuman
                </a>
                <a href="{{ route('wali.profile') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-sqr-green transition {{ request()->routeIs('wali.profile*') ? 'bg-sqr-green text-white font-bold' : 'text-gray-300' }}">
                    <i class="fa-solid fa-id-card text-sqr-orange w-4"></i> Biodata KK/KTP & Akun
                    @if(auth()->user()->is_profile_deadline_passed)
                    <span class="bg-red-500 text-white text-[9px] font-black px-1.5 py-0.5 rounded-full ml-auto animate-pulse">Wajib!</span>
                    @elseif(!auth()->user()->is_profile_completed)
                    <span class="bg-amber-500 text-white text-[9px] font-black px-1.5 py-0.5 rounded-full ml-auto">Lengkapi</span>
                    @endif
                </a>
            @endrole
        </nav>

        <div class="p-4 border-t border-white/10 bg-white/5 text-center">
            <a href="{{ route('home') }}" class="text-xs text-sqr-orange font-bold hover:underline flex items-center justify-center gap-1.5">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Website Utama
            </a>
        </div>
    </aside>

    <!-- MOBILE SIDEBAR DRAWER -->
    <div id="dashMobileSidebarOverlay">
        <div onclick="toggleDashMobileSidebar()" class="absolute inset-0"></div>
        <div id="dashMobileSidebarPanel" class="p-5">
            <div>
                <div class="flex items-center justify-between border-b border-white/10 pb-4 mb-5">
                    <div class="flex items-center gap-2.5">
                        <div class="w-9 h-9 bg-sqr-orange rounded-xl flex items-center justify-center text-white">
                            <i class="fa-solid fa-book-quran"></i>
                        </div>
                        <div>
                            <p class="font-title font-bold text-sm text-sqr-bg">Saung Quran</p>
                            <p class="text-[10px] text-sqr-orange font-semibold">Rabbani Dashboard</p>
                        </div>
                    </div>
                    <button onclick="toggleDashMobileSidebar()" class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center text-white">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>

                <nav class="space-y-2 text-xs font-semibold">
                    @role('admin')
                        <!-- Group 1: UTAMA & PPDB -->
                        <div class="space-y-1">
                            <button type="button" onclick="toggleSidebarDropdown('groupUtamaMobile')" class="w-full flex items-center justify-between px-3 py-2 rounded-xl text-sqr-orange font-bold text-[10px] uppercase tracking-wider hover:bg-white/10 transition">
                                <span class="flex items-center gap-2"><i class="fa-solid fa-compass"></i> 1. UTAMA & PPDB</span>
                                <i id="arrow-groupUtamaMobile" class="fa-solid fa-chevron-down text-[10px] transition-transform duration-300 {{ $isGroup1Active ? 'rotate-180' : '' }}"></i>
                            </button>
                            <div id="groupUtamaMobile" class="{{ $isGroup1Active ? '' : 'hidden' }} space-y-1 pl-2 border-l border-white/10 ml-3">
                                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl transition {{ request()->routeIs('admin.dashboard') ? 'bg-sqr-green text-white font-bold shadow-md' : 'text-gray-300 hover:bg-white/10' }}">
                                    <i class="fa-solid fa-chart-line text-sqr-orange w-4"></i> Overview Dashboard
                                </a>
                                <a href="{{ route('admin.ppdb.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl transition {{ request()->routeIs('admin.ppdb.*') ? 'bg-sqr-green text-white font-bold shadow-md' : 'text-gray-300 hover:bg-white/10' }}">
                                    <i class="fa-solid fa-file-signature text-sqr-orange w-4"></i> Data Pendaftaran PPDB
                                </a>
                                <a href="{{ route('admin.santri.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl transition {{ request()->routeIs('admin.santri.*') ? 'bg-sqr-green text-white font-bold shadow-md' : 'text-gray-300 hover:bg-white/10' }}">
                                    <i class="fa-solid fa-user-graduate text-sqr-orange w-4"></i> Data Santri
                                </a>
                            </div>
                        </div>

                        <!-- Group 2: AKADEMIK & KELAS -->
                        <div class="space-y-1">
                            <button type="button" onclick="toggleSidebarDropdown('groupAkademikMobile')" class="w-full flex items-center justify-between px-3 py-2 rounded-xl text-sqr-orange font-bold text-[10px] uppercase tracking-wider hover:bg-white/10 transition">
                                <span class="flex items-center gap-2"><i class="fa-solid fa-school"></i> 2. AKADEMIK & KELAS</span>
                                <i id="arrow-groupAkademikMobile" class="fa-solid fa-chevron-down text-[10px] transition-transform duration-300 {{ $isGroup2Active ? 'rotate-180' : '' }}"></i>
                            </button>
                            <div id="groupAkademikMobile" class="{{ $isGroup2Active ? '' : 'hidden' }} space-y-1 pl-2 border-l border-white/10 ml-3">
                                <a href="{{ route('admin.jadwal.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl transition {{ request()->routeIs('admin.jadwal.*') ? 'bg-sqr-green text-white font-bold shadow-md' : 'text-gray-300 hover:bg-white/10' }}">
                                    <i class="fa-solid fa-calendar-days text-sqr-orange w-4"></i> Jadwal & Kalender Akademik
                                </a>
                                <a href="{{ route('admin.classes.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl transition {{ request()->routeIs('admin.classes.*') ? 'bg-sqr-green text-white font-bold shadow-md' : 'text-gray-300 hover:bg-white/10' }}">
                                    <i class="fa-solid fa-chalkboard-user text-sqr-orange w-4"></i> Kelas & Kuota PPDB
                                </a>
                                <a href="{{ route('admin.users.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl transition {{ request()->routeIs('admin.users.*') ? 'bg-sqr-green text-white font-bold shadow-md' : 'text-gray-300 hover:bg-white/10' }}">
                                    <i class="fa-solid fa-users text-sqr-orange w-4"></i> Ustadz & Wali Santri
                                </a>
                            </div>
                        </div>

                        <!-- Group 3: KEUANGAN & DONASI -->
                        <div class="space-y-1">
                            <button type="button" onclick="toggleSidebarDropdown('groupKeuanganMobile')" class="w-full flex items-center justify-between px-3 py-2 rounded-xl text-sqr-orange font-bold text-[10px] uppercase tracking-wider hover:bg-white/10 transition">
                                <span class="flex items-center gap-2"><i class="fa-solid fa-wallet"></i> 3. KEUANGAN & DONASI</span>
                                <i id="arrow-groupKeuanganMobile" class="fa-solid fa-chevron-down text-[10px] transition-transform duration-300 {{ $isGroup3Active ? 'rotate-180' : '' }}"></i>
                            </button>
                            <div id="groupKeuanganMobile" class="{{ $isGroup3Active ? '' : 'hidden' }} space-y-1 pl-2 border-l border-white/10 ml-3">
                                <a href="{{ route('admin.verifikasi.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl transition {{ request()->routeIs('admin.verifikasi.*') ? 'bg-sqr-green text-white font-bold shadow-md' : 'text-gray-300 hover:bg-white/10' }}">
                                    <i class="fa-solid fa-file-invoice-dollar text-sqr-orange w-4"></i> Verifikasi Transfer SPP
                                </a>
                                <a href="{{ route('admin.finance.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl transition {{ request()->routeIs('admin.finance.*') ? 'bg-sqr-green text-white font-bold shadow-md' : 'text-gray-300 hover:bg-white/10' }}">
                                    <i class="fa-solid fa-coins text-sqr-orange w-4"></i> Kas Yayasan SQR
                                </a>
                                <a href="{{ route('admin.campaigns.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl transition {{ request()->routeIs('admin.campaigns.*') ? 'bg-sqr-green text-white font-bold shadow-md' : 'text-gray-300 hover:bg-white/10' }}">
                                    <i class="fa-solid fa-hand-holding-heart text-sqr-orange w-4"></i> Program SQR Berbagi
                                </a>
                            </div>
                        </div>

                        <!-- Group 4: WEBSITE & PUBLIK -->
                        <div class="space-y-1">
                            <button type="button" onclick="toggleSidebarDropdown('groupWebsiteMobile')" class="w-full flex items-center justify-between px-3 py-2 rounded-xl text-sqr-orange font-bold text-[10px] uppercase tracking-wider hover:bg-white/10 transition">
                                <span class="flex items-center gap-2"><i class="fa-solid fa-globe"></i> 4. WEBSITE & PUBLIK</span>
                                <i id="arrow-groupWebsiteMobile" class="fa-solid fa-chevron-down text-[10px] transition-transform duration-300 {{ $isGroup4Active ? 'rotate-180' : '' }}"></i>
                            </button>
                            <div id="groupWebsiteMobile" class="{{ $isGroup4Active ? '' : 'hidden' }} space-y-1 pl-2 border-l border-white/10 ml-3">
                                <a href="{{ route('admin.content.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl transition {{ request()->routeIs('admin.content.*') ? 'bg-sqr-green text-white font-bold shadow-md' : 'text-gray-300 hover:bg-white/10' }}">
                                    <i class="fa-solid fa-sliders text-sqr-orange w-4"></i> Content Web Manager
                                </a>
                                <a href="{{ route('admin.artikel.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl transition {{ request()->routeIs('admin.artikel.*') ? 'bg-sqr-green text-white font-bold shadow-md' : 'text-gray-300 hover:bg-white/10' }}">
                                    <i class="fa-solid fa-newspaper text-sqr-orange w-4"></i> Kelola Artikel & News
                                </a>
                                <a href="{{ route('admin.galleries.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl transition {{ request()->routeIs('admin.galleries.*') ? 'bg-sqr-green text-white font-bold shadow-md' : 'text-gray-300 hover:bg-white/10' }}">
                                    <i class="fa-solid fa-images text-sqr-orange w-4"></i> Galeri Foto Activity
                                </a>
                                <a href="{{ route('admin.notifications.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl transition {{ request()->routeIs('admin.notifications.*') ? 'bg-sqr-green text-white font-bold shadow-md' : 'text-gray-300 hover:bg-white/10' }}">
                                    <i class="fa-solid fa-bullhorn text-sqr-orange w-4"></i> Broadcast Notifikasi
                                </a>
                            </div>
                        </div>

                        <!-- Group 5: SERTIFIKAT & PENGHARGAAN -->
                        <div class="space-y-1">
                            <button type="button" onclick="toggleSidebarDropdown('groupSertifikatMobile')" class="w-full flex items-center justify-between px-3 py-2 rounded-xl text-sqr-orange font-bold text-[10px] uppercase tracking-wider hover:bg-white/10 transition">
                                <span class="flex items-center gap-2"><i class="fa-solid fa-award"></i> 5. SERTIFIKAT & PENGHARGAAN</span>
                                <i id="arrow-groupSertifikatMobile" class="fa-solid fa-chevron-down text-[10px] transition-transform duration-300 {{ $isGroup5Active ? 'rotate-180' : '' }}"></i>
                            </button>
                            <div id="groupSertifikatMobile" class="{{ $isGroup5Active ? '' : 'hidden' }} space-y-1 pl-2 border-l border-white/10 ml-3">
                                <a href="{{ route('admin.certificates.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl transition {{ request()->routeIs('admin.certificates.index') ? 'bg-sqr-green text-white font-bold shadow-md' : 'text-gray-300 hover:bg-white/10' }}">
                                    <i class="fa-solid fa-graduation-cap text-sqr-orange w-4"></i> Daftar Sertifikat Santri
                                </a>
                                <a href="{{ route('admin.certificates.settings') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl transition {{ request()->routeIs('admin.certificates.settings*') ? 'bg-sqr-green text-white font-bold shadow-md' : 'text-gray-300 hover:bg-white/10' }}">
                                    <i class="fa-solid fa-signature text-sqr-orange w-4"></i> Pengaturan TTD & Cap
                                </a>
                            </div>
                        </div>
                    @endrole

                    @role('ustadz')
                        @php $uPrefix = auth()->user()->teacher_route_prefix ?? 'ustadz'; @endphp
                        <a href="{{ route($uPrefix . '.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-gray-200 hover:bg-sqr-green">
                            <i class="fa-solid fa-house-user text-sqr-orange w-4"></i> Dashboard Pengajar
                        </a>
                        <a href="{{ route($uPrefix . '.progress.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-gray-200 hover:bg-sqr-green">
                            <i class="fa-solid fa-book-open-reader text-sqr-orange w-4"></i> Input Progress Hafalan
                        </a>
                        <a href="{{ route($uPrefix . '.attendance.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-gray-200 hover:bg-sqr-green">
                            <i class="fa-solid fa-user-check text-sqr-orange w-4"></i> Presensi Kehadiran
                        </a>
                    @endrole

                    @role('wali')
                        <a href="{{ route('wali.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-gray-200 hover:bg-sqr-green">
                            <i class="fa-solid fa-heart text-sqr-orange w-4"></i> Progress Hafalan Ananda
                        </a>
                        <a href="{{ route('wali.payments.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-gray-200 hover:bg-sqr-green">
                            <i class="fa-solid fa-receipt text-sqr-orange w-4"></i> Pembayaran SPP Bulanan
                        </a>
                        <a href="{{ route('wali.notifications') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-gray-200 hover:bg-sqr-green">
                            <i class="fa-solid fa-bell text-sqr-orange w-4"></i> Notifikasi & Pengumuman
                        </a>
                        <a href="{{ route('wali.profile') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-gray-200 hover:bg-sqr-green">
                            <i class="fa-solid fa-id-card text-sqr-orange w-4"></i> Biodata KK/KTP & Akun
                        </a>
                    @endrole
                </nav>
            </div>

            <div class="pt-4 border-t border-white/10 mt-6">
                <a href="{{ route('home') }}" class="text-xs text-sqr-orange font-bold hover:underline block text-center">
                    ← Kembali ke Landing Page
                </a>
            </div>
        </div>
    </div>

    <!-- MAIN CONTENT AREA -->
    <div class="flex-1 flex flex-col min-w-0 bg-gray-100 min-h-screen">
        <!-- Top Navbar -->
        <header class="bg-white border-b border-gray-200 px-4 sm:px-6 py-4 flex items-center justify-between shadow-sm sticky top-0 z-20">
            <div class="flex items-center gap-3">
                <button onclick="toggleDashMobileSidebar()" class="md:hidden p-2 bg-gray-100 text-sqr-green rounded-xl hover:bg-sqr-bg">
                    <i class="fa-solid fa-bars text-lg"></i>
                </button>
                <h2 class="font-title font-bold text-base sm:text-lg text-sqr-green">@yield('title', 'Dashboard')</h2>
            </div>
            <div class="flex items-center gap-3 sm:gap-4">
                @php
                    $unreadNotifications = \App\Models\SqrNotification::forAdmin()->unread()->latest()->take(5)->get();
                    $unreadCount = \App\Models\SqrNotification::forAdmin()->unread()->count();
                @endphp

                <!-- Notification Bell Dropdown -->
                <div class="relative" id="adminNotifDropdownWrapper">
                    <button type="button" onclick="toggleAdminNotifDropdown(event)" class="relative p-2.5 rounded-xl bg-gray-100 hover:bg-gray-200 text-sqr-green transition focus:outline-none" title="Notifikasi Sistem">
                        <i class="fa-solid fa-bell text-lg"></i>
                        @if($unreadCount > 0)
                        <span id="adminNotifBadge" class="absolute -top-1 -right-1 bg-red-500 text-white text-[9px] font-black w-5 h-5 rounded-full flex items-center justify-center border-2 border-white shadow-md animate-pulse">
                            {{ $unreadCount > 9 ? '9+' : $unreadCount }}
                        </span>
                        @endif
                    </button>

                    <!-- Dropdown Menu -->
                    @php
                        $headerUser = auth()->user();
                        if ($headerUser->hasRole('admin')) {
                            $headerNotifUrl   = route('admin.notifications.index');
                            $headerReadAllUrl = route('admin.notifications.read-all');
                            $headerNotifText  = 'Halaman Notifikasi Admin →';
                        } elseif ($headerUser->hasRole('ustadz')) {
                            $uPrefix          = $headerUser->teacher_route_prefix ?? 'ustadz';
                            $headerNotifUrl   = route($uPrefix . '.notifications.index');
                            $headerReadAllUrl = route($uPrefix . '.notifications.readAll');
                            $headerNotifText  = 'Lihat Semua Notifikasi →';
                        } else {
                            $headerNotifUrl   = route('wali.notifications');
                            $headerReadAllUrl = '#';
                            $headerNotifText  = 'Lihat Semua Notifikasi Wali →';
                        }
                    @endphp
                    <div id="adminNotifDropdownMenu" class="hidden absolute right-0 top-full mt-2 w-80 sm:w-96 bg-white border border-gray-200 rounded-3xl shadow-2xl p-4 z-50 space-y-3">
                        <div class="flex items-center justify-between border-b border-gray-100 pb-2.5">
                            <div class="flex items-center gap-2">
                                <span class="font-title font-bold text-sm text-sqr-green">Notifikasi Masuk</span>
                                @if($unreadCount > 0)
                                <span id="adminNotifBadgeText" class="bg-sqr-orange text-white text-[9px] font-bold px-2 py-0.5 rounded-full">{{ $unreadCount }} Baru</span>
                                @endif
                            </div>
                            <a href="{{ $headerNotifUrl }}" class="text-[11px] text-sqr-green font-bold hover:underline">Lihat Semua</a>
                        </div>

                        <div class="max-h-72 overflow-y-auto divide-y divide-gray-100 text-xs">
                            @forelse($unreadNotifications as $notif)
                            <a href="{{ $headerNotifUrl }}" class="block p-3 rounded-2xl hover:bg-sqr-bg/40 transition space-y-1">
                                <div class="flex items-center justify-between">
                                    <span class="font-bold text-sqr-green line-clamp-1">{{ $notif->title }}</span>
                                    <span class="text-[9px] text-gray-400 font-semibold">{{ $notif->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="text-[11px] text-gray-600 line-clamp-2 leading-relaxed">{{ $notif->message }}</p>
                            </a>
                            @empty
                            <div class="py-6 text-center text-gray-400 font-semibold text-xs">
                                <i class="fa-solid fa-bell-slash text-2xl mb-1 block opacity-40"></i>
                                Belum ada notifikasi baru.
                            </div>
                            @endforelse
                        </div>

                        <div class="pt-2 border-t border-gray-100 text-center">
                            <a href="{{ $headerNotifUrl }}" class="w-full bg-sqr-bg hover:bg-sqr-green hover:text-white text-sqr-green font-title font-bold text-xs py-2 rounded-xl transition block">
                                {{ $headerNotifText }}
                            </a>
                        </div>
                    </div>
                </div>

                <span class="text-xs text-gray-500 font-medium hidden sm:inline">{{ auth()->user()->email }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="bg-red-50 hover:bg-red-100 text-red-600 text-xs font-bold px-3.5 py-2 rounded-xl border border-red-200 transition flex items-center gap-1.5">
                        <i class="fa-solid fa-power-off"></i> <span class="hidden sm:inline">Logout</span>
                    </button>
                </form>
            </div>
        </header>

        <script>
            function toggleAdminNotifDropdown(e) {
                if (e) e.stopPropagation();
                var menu = document.getElementById('adminNotifDropdownMenu');
                if (menu) menu.classList.toggle('hidden');

                // Clear badge on click
                var badge = document.getElementById('adminNotifBadge');
                if (badge) badge.style.display = 'none';

                var badgeText = document.getElementById('adminNotifBadgeText');
                if (badgeText) badgeText.style.display = 'none';

                // Send background fetch request to mark all notifications read
                if ('{{ $headerReadAllUrl }}' !== '#') {
                    fetch('{{ $headerReadAllUrl }}', {
                        method: 'PATCH',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        }
                    }).catch(function(err){});
                }
            }
            document.addEventListener('click', function(e) {
                var wrapper = document.getElementById('adminNotifDropdownWrapper');
                if (wrapper && !wrapper.contains(e.target)) {
                    var menu = document.getElementById('adminNotifDropdownMenu');
                    if (menu) menu.classList.add('hidden');
                }
            });
        </script>

        <!-- Main Body -->
        <main class="p-4 sm:p-6 flex-1">
            <!-- Toast Flash Messages -->
            @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs rounded-2xl p-4 mb-6 flex items-center justify-between font-semibold shadow-sm">
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-circle-check text-emerald-600 text-base"></i>
                    <span>{{ session('success') }}</span>
                </div>
                <button onclick="this.parentElement.remove()" class="text-emerald-600 hover:text-emerald-900 font-bold text-base">&times;</button>
            </div>
            @endif

            @if(session('error') || $errors->any())
            <div class="bg-red-50 border border-red-200 text-red-800 text-xs rounded-2xl p-4 mb-6 flex items-center justify-between font-semibold shadow-sm">
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-circle-exclamation text-red-600 text-base"></i>
                    <span>{{ session('error') ?? $errors->first() }}</span>
                </div>
                <button onclick="this.parentElement.remove()" class="text-red-600 hover:text-red-900 font-bold text-base">&times;</button>
            </div>
            @endif

            @yield('content')
        </main>

        <footer class="p-4 text-center text-xs text-gray-500 border-t border-gray-200 bg-gray-100 font-medium">
            &copy; {{ date('Y') }} Saung Quran Rabbani — Portal Manajemen Pendidikan Quran
        </footer>
    </div>

    <!-- Tom Select JS -->
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>
    <script>
        function toggleDashMobileSidebar() {
            var overlay = document.getElementById('dashMobileSidebarOverlay');
            var panel   = document.getElementById('dashMobileSidebarPanel');
            if (!overlay || !panel) return;
            overlay.classList.toggle('open');
            panel.classList.toggle('open');
        }

        function toggleSidebarDropdown(groupId) {
            var panel = document.getElementById(groupId);
            var arrow = document.getElementById('arrow-' + groupId);
            if (!panel) return;

            var isHidden = panel.classList.contains('hidden');

            if (isHidden) {
                // Show with smooth slide-down
                panel.classList.remove('hidden');
                panel.style.overflow = 'hidden';
                panel.style.maxHeight = '0';
                panel.style.opacity = '0';
                panel.style.transition = 'max-height 0.3s ease, opacity 0.25s ease';
                requestAnimationFrame(function() {
                    panel.style.maxHeight = panel.scrollHeight + 'px';
                    panel.style.opacity = '1';
                });
                if (arrow) arrow.classList.add('rotate-180');
            } else {
                // Hide with smooth slide-up
                panel.style.maxHeight = panel.scrollHeight + 'px';
                panel.style.overflow = 'hidden';
                panel.style.transition = 'max-height 0.25s ease, opacity 0.2s ease';
                requestAnimationFrame(function() {
                    panel.style.maxHeight = '0';
                    panel.style.opacity = '0';
                });
                setTimeout(function() {
                    panel.classList.add('hidden');
                    panel.style.maxHeight = '';
                    panel.style.opacity = '';
                    panel.style.overflow = '';
                }, 260);
                if (arrow) arrow.classList.remove('rotate-180');
            }
        }
    </script>
    @stack('scripts')
</body>
</html>
