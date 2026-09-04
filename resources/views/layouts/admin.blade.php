@extends('layouts.app')

@section('content')
<div class="min-h-screen flex" x-data="{ sidebarOpen: window.innerWidth >= 1024 }">

    {{-- ===== SIDEBAR ADMIN ===== --}}
    <aside
        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
        class="fixed inset-y-0 left-0 z-40 w-64 bg-[#2d4a22] text-white flex flex-col transition-transform duration-300 ease-in-out lg:relative lg:translate-x-0 lg:flex-shrink-0">

        {{-- Logo --}}
        <a href="{{ route('home') }}" class="flex items-center gap-3 px-5 py-5 border-b border-white/10 group">
            <div class="w-10 h-10 bg-white rounded-2xl p-1 shadow-md border border-white/20 flex items-center justify-center shrink-0 overflow-hidden group-hover:scale-105 transition-transform duration-200">
                <img src="/logo_sqr.png" alt="Logo SQR" class="w-full h-full object-contain">
            </div>
            <div>
                <div class="font-black text-sm leading-tight text-white">Saung Quran</div>
                <div class="text-[10px] text-[#a3c585] font-medium">Rabbani · Admin Panel</div>
            </div>
        </a>

        {{-- Nav --}}
        <nav class="flex-1 overflow-y-auto py-4 space-y-0.5 px-3">
            @php
                $navItems = [
                    ['route' => 'admin.dashboard',          'icon' => 'fa-chart-line',           'label' => 'Dashboard'],
                    ['route' => 'admin.ppdb.index',         'icon' => 'fa-file-signature',        'label' => 'PPDB Santri'],
                    ['route' => 'admin.santri.index',       'icon' => 'fa-users',                'label' => 'Data Santri'],
                    ['route' => 'admin.users.index',        'icon' => 'fa-user-gear',            'label' => 'Manajemen User'],
                    ['route' => 'admin.jadwal.index',       'icon' => 'fa-calendar-days',        'label' => 'Jadwal & Kalender'],
                    ['route' => 'admin.verifikasi.index',   'icon' => 'fa-clipboard-check',      'label' => 'Verifikasi SPP'],
                    ['route' => 'admin.attendance.index',   'icon' => 'fa-calendar-check',       'label' => 'Absensi'],
                    ['route' => 'admin.finance.index',      'icon' => 'fa-wallet',               'label' => 'Keuangan & Kas'],
                    ['route' => 'admin.content.index',      'icon' => 'fa-pen-to-square',        'label' => 'Konten Website'],
                    ['route' => 'admin.artikel.index',      'icon' => 'fa-newspaper',            'label' => 'Artikel'],
                    ['route' => 'admin.notifications.index','icon' => 'fa-bell',                 'label' => 'Notifikasi'],
                ];
            @endphp


            @foreach($navItems as $item)
                @if(Route::has($item['route']))
                <a href="{{ route($item['route']) }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200
                          {{ request()->routeIs(str_replace('.index', '.*', $item['route'])) || request()->routeIs($item['route'])
                             ? 'bg-white/15 text-white'
                             : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                    <i class="fa-solid {{ $item['icon'] }} w-4 text-center {{ request()->routeIs(str_replace('.index', '.*', $item['route'])) ? 'text-[#e67e22]' : '' }}"></i>
                    {{ $item['label'] }}
                </a>
                @endif
            @endforeach
        </nav>

        {{-- User info --}}
        <div class="border-t border-white/10 p-4">
            <div class="flex items-center gap-3">
                <img src="{{ auth()->user()->avatar_url }}" class="w-9 h-9 rounded-full object-cover border-2 border-[#a3c585]" alt="">
                <div class="flex-1 min-w-0">
                    <div class="text-xs font-bold truncate">{{ auth()->user()->name }}</div>
                    <div class="text-[10px] text-[#a3c585]">Administrator</div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-white/60 hover:text-red-400 transition" title="Logout">
                        <i class="fa-solid fa-sign-out-alt"></i>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    {{-- Sidebar overlay (mobile) --}}
    <div x-show="sidebarOpen" @click="sidebarOpen = false"
         class="fixed inset-0 bg-black/40 z-30 lg:hidden" x-cloak></div>

    {{-- ===== MAIN CONTENT ===== --}}
    <div class="flex-1 flex flex-col min-w-0">

        {{-- Top Navbar --}}
        <header class="bg-white border-b border-gray-200 px-4 py-3 flex items-center justify-between sticky top-0 z-20 shadow-sm">
            <div class="flex items-center gap-3">
                <button @click="sidebarOpen = !sidebarOpen"
                        class="p-2 rounded-lg text-gray-600 hover:bg-gray-100 transition lg:hidden">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <div>
                    <h1 class="text-sm font-bold text-[#2d4a22]">@yield('page_title', 'Dashboard')</h1>
                    <p class="text-[11px] text-gray-500 hidden sm:block">@yield('page_subtitle', 'Admin Panel SQR')</p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('home') }}" target="_blank"
                   class="hidden sm:flex items-center gap-1.5 text-xs text-gray-500 hover:text-[#2d4a22] transition px-3 py-1.5 rounded-lg hover:bg-gray-100">
                    <i class="fa-solid fa-arrow-up-right-from-square text-xs"></i> Lihat Website
                </a>
                <div class="w-8 h-8 rounded-full overflow-hidden border-2 border-[#a3c585]">
                    <img src="{{ auth()->user()->avatar_url }}" class="w-full h-full object-cover" alt="">
                </div>
            </div>
        </header>

        {{-- Page Content --}}
        <main class="flex-1 overflow-auto p-4 lg:p-6">
            @yield('content_inner')
        </main>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('alpine:init', () => {});
</script>
@endpush
