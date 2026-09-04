@extends('layouts.dashboard')

@section('title', 'Notifikasi & Pengumuman Wali')

@section('content')
<div class="max-w-3xl mx-auto bg-white rounded-3xl p-6 shadow-sm border border-gray-100">
    <div class="border-b pb-4 mb-5">
        <h3 class="font-title font-bold text-lg text-sqr-green">Notifikasi & Informasi SQR</h3>
        <p class="text-xs text-gray-500">Pesan dan pengumuman resmi dari pengurus Saung Quran Rabbani</p>
    </div>

    <div class="space-y-3">
        @forelse($notifications as $n)
        <div class="p-4 rounded-2xl border border-gray-100 transition {{ $n->is_read ? 'bg-white' : 'bg-sqr-bg/50 border-sqr-orange/30' }}">
            <div class="flex items-center justify-between mb-1">
                <span class="px-2.5 py-0.5 rounded-full text-[9px] font-bold uppercase bg-sqr-orange/10 text-sqr-orange">{{ $n->type }}</span>
                <span class="text-[10px] text-gray-400 font-semibold">{{ $n->created_at->format('d M Y H:i') }}</span>
            </div>
            <h4 class="font-bold text-xs text-gray-800">{{ $n->title }}</h4>
            <div class="text-xs text-gray-600 mt-1 leading-relaxed">{!! $n->formatted_message_html !!}</div>

            @if(!$n->is_read)
            <form method="POST" action="{{ route('wali.notifications.read', $n) }}" class="mt-2 text-right">
                @csrf @method('PATCH')
                <button type="submit" class="text-[10px] text-sqr-green font-bold hover:underline">Tandai Dibaca ✓</button>
            </form>
            @endif
        </div>
        @empty
        <p class="text-xs text-gray-400 text-center py-10">Belum ada notifikasi baru.</p>
        @endforelse
    </div>

    <div class="mt-4">
        {{ $notifications->links() }}
    </div>
</div>
@endsection
