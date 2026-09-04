@extends('layouts.dashboard')

@section('title', 'Notifikasi Ustadz / Ustadzah')

@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-4">
        <div>
            <h3 class="font-title font-bold text-lg text-sqr-green flex items-center gap-2">
                <i class="fa-solid fa-bell text-sqr-orange"></i> Notifikasi & Pengumuman Ustadz
            </h3>
            <p class="text-xs text-gray-500 mt-0.5">Daftar notifikasi internal pengajar Saung Quran Rabbani</p>
        </div>
        <form method="POST" action="{{ route('ustadz.notifications.readAll') }}">
            @csrf @method('PATCH')
            <button type="submit" class="bg-sqr-green hover:bg-sqr-dark text-white font-bold text-xs px-4 py-2.5 rounded-xl transition shadow-sm flex items-center gap-1.5">
                <i class="fa-solid fa-check-double"></i> Tandai Semua Dibaca
            </button>
        </form>
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden divide-y divide-gray-100">
        @forelse($notifications as $notif)
        <div class="p-5 flex items-start justify-between gap-4 {{ $notif->is_read ? 'bg-white' : 'bg-amber-50/40 font-semibold' }} hover:bg-sqr-bg/30 transition">
            <div class="flex items-start gap-3.5">
                <div class="w-10 h-10 rounded-2xl {{ $notif->is_read ? 'bg-gray-100 text-gray-500' : 'bg-sqr-orange/20 text-sqr-orange border border-sqr-orange/30' }} flex items-center justify-center font-bold text-base shrink-0 mt-0.5">
                    <i class="fa-solid {{ $notif->is_read ? 'fa-envelope-open' : 'fa-envelope' }}"></i>
                </div>
                <div class="space-y-1">
                    <h4 class="font-bold text-sm text-sqr-green">{{ $notif->title }}</h4>
                    <p class="text-xs text-gray-600 leading-relaxed">{{ $notif->message }}</p>
                    <span class="text-[10px] text-gray-400 font-medium block pt-1">
                        <i class="fa-regular fa-clock mr-1"></i> {{ $notif->created_at->diffForHumans() }} ({{ $notif->created_at->format('d M Y H:i') }})
                    </span>
                </div>
            </div>

            @if(!$notif->is_read)
            <form method="POST" action="{{ route('ustadz.notifications.read', $notif) }}">
                @csrf @method('PATCH')
                <button type="submit" class="text-[11px] font-bold text-sqr-green hover:underline shrink-0">
                    Tandai Dibaca
                </button>
            </form>
            @endif
        </div>
        @empty
        <div class="p-12 text-center text-gray-400">
            <i class="fa-solid fa-bell-slash text-4xl block mb-2 opacity-30"></i>
            <p class="font-bold text-sm text-gray-600">Belum Ada Notifikasi</p>
            <p class="text-xs text-gray-400 mt-1">Notifikasi baru untuk pengajar akan muncul di halaman ini.</p>
        </div>
        @endforelse
    </div>

    <div>
        {{ $notifications->links() }}
    </div>
</div>
@endsection
