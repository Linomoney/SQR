@extends('layouts.dashboard')

@section('title', 'Pusat Notifikasi & Broadcast System')

@section('content')
<div class="space-y-6">

    <!-- Header Bar -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white p-6 rounded-3xl shadow-sm border border-gray-100">
        <div>
            <span class="bg-sqr-green/10 text-sqr-green font-bold text-[10px] px-3 py-1 rounded-full uppercase tracking-wider inline-block mb-1">
                🔔 Broadcast & Notifikasi Masuk
            </span>
            <h1 class="font-title text-xl font-bold text-sqr-green">Pusat Notifikasi & Broadcast Pengumuman</h1>
            <p class="text-xs text-gray-500 mt-1">Kirim broadcast pesan ke role tertentu (Semua Wali, Ustadz, atau Pengguna) dan kelola log notifikasi</p>
        </div>
        <form method="POST" action="{{ route('admin.notifications.read-all') }}">
            @csrf
            @method('PATCH')
            <button type="submit" class="bg-sqr-bg text-sqr-green hover:bg-sqr-green hover:text-white font-title font-bold text-xs px-4 py-2.5 rounded-xl transition flex items-center gap-2 border border-sqr-green/20">
                <i class="fa-solid fa-check-double text-sqr-orange"></i> Tandai Notifikasi Admin Dibaca
            </button>
        </form>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <!-- Left: Form Broadcast Notifikasi Baru -->
        <div class="lg:col-span-4 bg-white rounded-3xl p-6 shadow-sm border border-gray-100 h-fit space-y-4">
            <div class="border-b border-gray-100 pb-3">
                <h3 class="font-title font-bold text-base text-sqr-green flex items-center gap-2">
                    <i class="fa-solid fa-bullhorn text-sqr-orange"></i> Broadcast Pesan Baru
                </h3>
                <p class="text-[11px] text-gray-500 mt-0.5">Pilih role target atau penerima spesifik</p>
            </div>

            <form method="POST" action="{{ route('admin.notifications.store') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1.5">Target Penerima (Role / User) *</label>
                    <select name="target" required class="w-full bg-gray-50/80 border border-gray-200 rounded-xl p-2.5 text-xs font-semibold outline-none focus:ring-2 focus:ring-sqr-green/30 focus:border-sqr-green">
                        <optgroup label="📌 Berdasarkan Role">
                            <option value="all">🌐 Semua Pengguna (Ustadz & Wali)</option>
                            <option value="wali">👨‍👩‍👧 Semua Wali Santri</option>
                            <option value="ustadz">👨‍🏫 Semua Ustadz / Pengajar</option>
                        </optgroup>
                        <optgroup label="👤 Pengguna Spesifik">
                            @foreach($users as $u)
                            <option value="user_{{ $u->id }}">{{ $u->name }} ({{ strtoupper($u->getRoleNames()->first() ?? 'user') }})</option>
                            @endforeach
                        </optgroup>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1.5">Tipe Notifikasi *</label>
                    <select name="type" required class="w-full bg-gray-50/80 border border-gray-200 rounded-xl p-2.5 text-xs font-semibold outline-none focus:ring-2 focus:ring-sqr-green/30 focus:border-sqr-green">
                        <option value="Pengumuman">Pengumuman Umum</option>
                        <option value="PPDB">Informasi PPDB</option>
                        <option value="SPP">Informasi SPP</option>
                        <option value="Progress">Informasi Hafalan</option>
                        <option value="Prestasi">Penghargaan / Sertifikat</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1.5">Judul Notifikasi *</label>
                    <input type="text" name="title" required placeholder="Contoh: Pengumuman Libur Ramadhan 1447H" class="w-full bg-gray-50/80 border border-gray-200 rounded-xl p-2.5 text-xs font-semibold outline-none focus:ring-2 focus:ring-sqr-green/30 focus:border-sqr-green">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1.5">Pesan Notifikasi *</label>
                    <textarea name="message" rows="4" required placeholder="Tuliskan isi pesan pengumuman..." class="w-full bg-gray-50/80 border border-gray-200 rounded-xl p-3 text-xs font-semibold outline-none focus:ring-2 focus:ring-sqr-green/30 focus:border-sqr-green"></textarea>
                </div>

                <button type="submit" class="w-full bg-gradient-to-r from-sqr-green to-sqr-dark hover:from-sqr-dark hover:to-sqr-green text-white font-title font-bold text-xs py-3.5 rounded-2xl shadow-lg transition flex items-center justify-center gap-2">
                    <i class="fa-solid fa-paper-plane text-sqr-orange"></i> Kirim Broadcast Sekarang
                </button>
            </form>
        </div>

        <!-- Right: Tabs / Logs Notifikasi -->
        <div class="lg:col-span-8 space-y-6">
            
            <!-- Section 1: Log Broadcast yang Sudah Dikirut Admin -->
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 space-y-4">
                <div class="border-b border-gray-100 pb-3 flex items-center justify-between">
                    <div>
                        <h3 class="font-title font-bold text-base text-sqr-green flex items-center gap-2">
                            <i class="fa-solid fa-paper-plane text-sqr-orange"></i> Riwayat Broadcast Pesan (Sent Logs)
                        </h3>
                        <p class="text-[11px] text-gray-500">Daftar notifikasi pengumuman yang telah dibroadcast oleh Admin ke role atau pengguna</p>
                    </div>
                    <span class="bg-sqr-bg text-sqr-green text-[10px] font-bold px-3 py-1 rounded-full uppercase">
                        {{ $broadcastLogs->total() }} Broadcast
                    </span>
                </div>

                <div class="space-y-3">
                    @forelse($broadcastLogs as $b)
                    <div class="p-4 rounded-2xl border border-gray-100 text-xs hover:bg-sqr-bg/20 transition flex items-start justify-between gap-4">
                        <div class="space-y-1">
                            <div class="flex items-center gap-2 flex-wrap">
                                <span class="px-2.5 py-0.5 rounded-full text-[9px] font-bold bg-sqr-orange text-white uppercase">{{ $b->type }}</span>
                                <span class="px-2.5 py-0.5 rounded-full text-[9px] font-bold bg-sqr-green/10 text-sqr-green border border-sqr-green/20">
                                    <i class="fa-solid fa-users text-[9px] mr-1"></i> Target: {{ $b->target_label }}
                                </span>
                                <span class="text-[10px] text-gray-400 font-semibold">{{ $b->created_at->diffForHumans() }}</span>
                            </div>
                            <h4 class="font-title font-bold text-sqr-green text-sm mt-1">{{ $b->title }}</h4>
                            <p class="text-xs text-gray-600 leading-relaxed">{{ $b->message }}</p>
                            <span class="text-[10px] text-gray-400 block font-medium">Dikirim pada: {{ $b->created_at->format('d M Y H:i') }}</span>
                        </div>
                        <form method="POST" action="{{ route('admin.notifications.destroy', $b->id) }}" onsubmit="return confirm('Hapus log broadcast ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="p-2 text-red-400 hover:text-red-600 hover:bg-red-50 rounded-xl transition" title="Hapus"><i class="fa-solid fa-trash"></i></button>
                        </form>
                    </div>
                    @empty
                    <div class="py-8 text-center text-gray-400 font-semibold text-xs">
                        <i class="fa-solid fa-bullhorn text-3xl mb-2 block opacity-40"></i>
                        Belum ada pesan broadcast dikirimkan.
                    </div>
                    @endforelse
                </div>

                @if($broadcastLogs->hasPages())
                <div class="pt-3 border-t border-gray-100">
                    {{ $broadcastLogs->appends(request()->except('broadcast_page'))->links() }}
                </div>
                @endif
            </div>

            <!-- Section 2: Notifikasi Masuk Khusus Admin (PPDB & Verification) -->
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 space-y-4">
                <div class="border-b border-gray-100 pb-3 flex items-center justify-between">
                    <div>
                        <h3 class="font-title font-bold text-base text-sqr-green flex items-center gap-2">
                            <i class="fa-solid fa-inbox text-sqr-orange"></i> Notifikasi Masuk Khusus Admin (PPDB & SPP)
                        </h3>
                        <p class="text-[11px] text-gray-500">Notifikasi pendaftaran PPDB baru & verifikasi SPP</p>
                    </div>
                    <span class="bg-amber-100 text-amber-800 text-[10px] font-bold px-3 py-1 rounded-full uppercase">
                        {{ $adminNotifications->total() }} Masuk
                    </span>
                </div>

                <div class="space-y-3">
                    @forelse($adminNotifications as $n)
                    <div class="p-4 rounded-2xl border border-gray-100 text-xs hover:bg-sqr-bg/30 transition flex items-start justify-between gap-4 {{ !$n->is_read ? 'bg-amber-50/50 border-amber-200' : '' }}">
                        <div class="space-y-1">
                            <div class="flex items-center gap-2">
                                <span class="px-2.5 py-0.5 rounded-full text-[9px] font-bold uppercase bg-sqr-green/10 text-sqr-green">{{ $n->type }}</span>
                                @if(!$n->is_read)
                                <span class="bg-red-500 text-white text-[9px] font-bold px-2 py-0.2 rounded-full animate-pulse">BARU</span>
                                @endif
                                <span class="text-[10px] text-gray-400 font-semibold">{{ $n->created_at->diffForHumans() }}</span>
                            </div>
                            <h4 class="font-title font-bold text-sqr-green text-sm mt-1">{{ $n->title }}</h4>
                            <p class="text-xs text-gray-600 leading-relaxed">{{ $n->message }}</p>
                            <span class="text-[10px] text-gray-400 block font-medium">{{ $n->created_at->format('d M Y H:i') }}</span>
                        </div>
                        <form method="POST" action="{{ route('admin.notifications.destroy', $n->id) }}" onsubmit="return confirm('Hapus notifikasi ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="p-2 text-red-400 hover:text-red-600 hover:bg-red-50 rounded-xl transition" title="Hapus"><i class="fa-solid fa-trash"></i></button>
                        </form>
                    </div>
                    @empty
                    <div class="py-8 text-center text-gray-400 font-semibold text-xs">
                        <i class="fa-solid fa-bell-slash text-3xl mb-2 block opacity-40"></i>
                        Belum ada notifikasi khusus admin.
                    </div>
                    @endforelse
                </div>

                @if($adminNotifications->hasPages())
                <div class="pt-3 border-t border-gray-100">
                    {{ $adminNotifications->appends(request()->except('admin_page'))->links() }}
                </div>
                @endif
            </div>

        </div>

    </div>
</div>
@endsection
