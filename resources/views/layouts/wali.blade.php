@extends('layouts.app')

@section('content')
<div class="min-h-screen flex flex-col">

    {{-- ===== NAVBAR WALI ===== --}}
    <nav class="bg-[#2d4a22] shadow-lg px-4 py-3 flex justify-between items-center sticky top-0 z-50">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 bg-[#e67e22] rounded-lg flex items-center justify-center">
                <i class="fa-solid fa-book-quran text-white text-sm"></i>
            </div>
            <div>
                <h1 class="text-white font-bold text-sm leading-tight">Dashboard Wali Santri</h1>
                <p class="text-[#a3c585] text-[10px]">{{ auth()->user()->name }}</p>
            </div>
        </div>

        <div class="flex items-center gap-3">
            @php $unreadCount = auth()->user()->sqrNotifications()->unread()->count(); @endphp
            <a href="{{ route('wali.notifications') }}" class="relative p-2 text-white hover:text-[#e67e22] transition">
                <i class="fa-solid fa-bell text-lg"></i>
                @if($unreadCount > 0)
                <span class="absolute -top-0.5 -right-0.5 bg-red-500 text-white text-[9px] font-bold rounded-full min-w-[16px] h-4 flex items-center justify-center px-1">
                    {{ $unreadCount > 99 ? '99+' : $unreadCount }}
                </span>
                @endif
            </a>

            <img src="{{ auth()->user()->avatar_url }}" class="w-8 h-8 rounded-full object-cover border-2 border-white/30">

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1.5 rounded-lg text-xs font-bold transition flex items-center gap-1.5">
                    <i class="fa-solid fa-sign-out-alt"></i>
                    <span class="hidden sm:inline">Logout</span>
                </button>
            </form>
        </div>
    </nav>

    {{-- ===== TAB NAVIGATION ===== --}}
    <div class="bg-white border-b border-gray-200 shadow-sm sticky top-[57px] z-40">
        <div class="max-w-4xl mx-auto px-3">
            <div class="flex overflow-x-auto no-scrollbar gap-1 py-2">
                @php
                    $tabs = [
                        ['route' => 'wali.dashboard',          'icon' => 'fa-child-reaching', 'label' => 'Progress & SPP'],
                        ['route' => 'wali.payments.index',     'icon' => 'fa-credit-card',    'label' => 'Pembayaran'],
                        ['route' => 'wali.notifications',      'icon' => 'fa-bell',           'label' => 'Notifikasi'],
                    ];
                @endphp
                @foreach($tabs as $tab)
                @if(Route::has($tab['route']))
                <a href="{{ route($tab['route']) }}"
                   class="flex-shrink-0 flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-bold transition-all whitespace-nowrap
                          {{ request()->routeIs($tab['route']) || request()->routeIs(str_replace('.index', '.*', $tab['route']))
                             ? 'bg-[#2d4a22] text-white shadow-sm'
                             : 'text-gray-600 hover:bg-gray-100' }}">
                    <i class="fa-solid {{ $tab['icon'] }} {{ request()->routeIs($tab['route']) ? '' : 'text-[#e67e22]' }}"></i>
                    {{ $tab['label'] }}
                    @if($tab['route'] === 'wali.notifications' && $unreadCount > 0)
                        <span class="bg-red-500 text-white text-[9px] font-bold rounded-full px-1.5 py-0.5">{{ $unreadCount }}</span>
                    @endif
                </a>
                @endif
                @endforeach
            </div>
        </div>
    </div>

    {{-- ===== PAGE CONTENT ===== --}}
    <main class="flex-1 max-w-4xl mx-auto w-full px-3 sm:px-5 py-5">
        @yield('content_inner')
    </main>
</div>
@endsection
