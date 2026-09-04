@extends('layouts.dashboard')

@section('title', 'Overview Dashboard Admin')

@section('content')
<div class="space-y-8">

    <!-- Quick Actions Banner -->
    <div class="bg-gradient-to-r from-sqr-green via-sqr-dark to-sqr-green text-white rounded-3xl p-5 shadow-lg flex flex-col sm:flex-row items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <div class="w-11 h-11 rounded-2xl bg-white/20 flex items-center justify-center text-2xl font-bold shrink-0">
                📅
            </div>
            <div>
                <h3 class="font-title font-bold text-sm text-white">Kalender & Jadwal Kegiatan Akademik SQR</h3>
                <p class="text-xs text-sqr-light-green">Kelola hari libur yayasan, jam masuk/pulang, acara khusus, dan kelas online</p>
            </div>
        </div>
        <a href="{{ route('admin.jadwal.index') }}" class="bg-sqr-orange hover:bg-orange-600 text-white font-title font-bold text-xs px-5 py-3 rounded-2xl transition shadow-md shrink-0 flex items-center gap-2">
            <i class="fa-solid fa-calendar-days"></i> Buka Kalender Akademik →
        </a>
    </div>

    <!-- Metric Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <div class="bg-white rounded-3xl p-5 shadow-sm border border-gray-100 flex items-center justify-between hover:shadow-md transition">
            <div>
                <p class="text-xs text-gray-500 font-medium uppercase tracking-wider">Santri Aktif</p>
                <h3 class="font-title font-black text-2xl text-sqr-green mt-1">{{ $stats['total_santri'] }}</h3>
                <span class="text-[10px] text-sqr-orange font-bold">Terdaftar di sistem SQR</span>
            </div>
            <div class="w-12 h-12 bg-sqr-green/10 rounded-2xl flex items-center justify-center text-sqr-green text-xl font-bold">
                <i class="fa-solid fa-user-graduate"></i>
            </div>
        </div>

        <div class="bg-white rounded-3xl p-5 shadow-sm border border-gray-100 flex items-center justify-between hover:shadow-md transition">
            <div>
                <p class="text-xs text-gray-500 font-medium uppercase tracking-wider">Pengajar (Ustadz)</p>
                <h3 class="font-title font-black text-2xl text-sqr-green mt-1">{{ $stats['total_ustadz'] }}</h3>
                <span class="text-[10px] text-sqr-orange font-bold">Pengampu Kelas</span>
            </div>
            <div class="w-12 h-12 bg-sqr-orange/10 rounded-2xl flex items-center justify-center text-sqr-orange text-xl font-bold">
                <i class="fa-solid fa-chalkboard-user"></i>
            </div>
        </div>

        <div class="bg-white rounded-3xl p-5 shadow-sm border border-gray-100 flex items-center justify-between hover:shadow-md transition">
            <div>
                <p class="text-xs text-gray-500 font-medium uppercase tracking-wider">Pendaftaran PPDB</p>
                <h3 class="font-title font-black text-2xl text-sqr-orange mt-1">{{ $stats['ppdb_pending'] }}</h3>
                <span class="text-[10px] text-gray-400 font-bold">Menunggu Verifikasi (Total: {{ $stats['ppdb_total'] }})</span>
            </div>
            <div class="w-12 h-12 bg-amber-50 rounded-2xl flex items-center justify-center text-amber-600 text-xl font-bold">
                <i class="fa-solid fa-file-signature"></i>
            </div>
        </div>

        <div class="bg-white rounded-3xl p-5 shadow-sm border border-gray-100 flex items-center justify-between hover:shadow-md transition">
            <div>
                <p class="text-xs text-gray-500 font-medium uppercase tracking-wider">Verifikasi SPP</p>
                <h3 class="font-title font-black text-2xl text-sqr-green mt-1">{{ $stats['spp_pending'] }}</h3>
                <span class="text-[10px] text-sqr-orange font-bold">Bukti Transfer Masuk</span>
            </div>
            <div class="w-12 h-12 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-600 text-xl font-bold">
                <i class="fa-solid fa-receipt"></i>
            </div>
        </div>
    </div>

    <!-- ── 📅 JADWAL & KALENDER AKADEMIK WIDGET FOR ADMIN ── -->
    <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 space-y-5">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-gray-100 pb-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-sqr-green/10 text-sqr-green flex items-center justify-center font-bold text-xl shrink-0">
                    📅
                </div>
                <div>
                    <h3 class="font-title font-black text-base text-sqr-green">Jadwal & Kalender Akademik TPQ SQR</h3>
                    <p class="text-xs text-gray-500">Status harian KBM ({{ $jamMasuk }} - {{ $jamPulang }} WIB) dan agenda 7 hari ke depan</p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.jadwal.index') }}"
                   class="bg-sqr-green hover:bg-sqr-dark text-white font-title font-bold text-xs px-4 py-2 rounded-2xl transition shadow-md flex items-center gap-1.5">
                    <i class="fa-solid fa-pen-to-square"></i> Kelola Kalender & Jam →
                </a>
            </div>
        </div>

        <!-- Today Info Banner -->
        <div class="p-4 rounded-2xl flex flex-col md:flex-row items-center justify-between gap-4 border
            {{ $isSchoolDay ? 'bg-gradient-to-r from-emerald-50 to-teal-50 border-emerald-100 text-emerald-900' : 'bg-gradient-to-r from-red-50 to-orange-50 border-red-100 text-red-900' }}">
            <div class="flex items-center gap-3">
                <div class="text-2xl">{{ $isSchoolDay ? '📚' : '🏖️' }}</div>
                <div>
                    <div class="font-bold text-sm">
                        Status Hari Ini ({{ today()->translatedFormat('l, d F Y') }}): {{ $isSchoolDay ? 'KBM Belajar Aktif' : 'Tidak Ada Kegiatan KBM (Libur)' }}
                    </div>
                    @if($isSchoolDay)
                    <div class="text-xs opacity-80 mt-0.5">
                        Jam Operasional: <strong>{{ $jamMasuk }} WIB</strong> s/d <strong>{{ $jamPulang }} WIB</strong> · Libur Rutin: <strong>Sabtu & Minggu</strong>
                    </div>
                    @else
                    <div class="text-xs opacity-80 mt-0.5">Hari ini diliburkan dari kegiatan belajar mengajar rutin.</div>
                    @endif
                </div>
            </div>

            @if($todayEvents->isNotEmpty())
            <div class="flex flex-wrap gap-2">
                @foreach($todayEvents as $event)
                <span class="text-xs px-3 py-1 rounded-xl font-bold border shadow-xs
                    @if($event->type === 'libur') bg-red-100 text-red-800 border-red-200
                    @elseif($event->type === 'online') bg-blue-100 text-blue-800 border-blue-200
                    @elseif($event->type === 'acara') bg-amber-100 text-amber-800 border-amber-200
                    @else bg-purple-100 text-purple-800 border-purple-200 @endif">
                    {{ $event->type_icon }} {{ $event->title }}
                </span>
                @endforeach
            </div>
            @endif
        </div>

        <!-- 7 Days Strip -->
        <div class="space-y-2">
            <div class="text-xs font-bold text-gray-400 uppercase tracking-wider">Pratinjau Agenda 7 Hari Ke Depan</div>
            <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-7 gap-2">
                @foreach($next7Days as $dayItem)
                @php
                    $d = $dayItem['date'];
                @endphp
                <div class="rounded-2xl p-3 text-center border transition flex flex-col justify-between min-h-[95px]
                    {{ $dayItem['is_today'] ? 'ring-2 ring-sqr-green bg-sqr-green/5 border-sqr-green' : 'bg-gray-50/70 border-gray-100' }}
                    {{ $dayItem['is_off'] || $dayItem['has_holiday'] ? 'bg-red-50/50 border-red-100' : '' }}">
                    <div>
                        <div class="text-[10px] font-bold uppercase tracking-wider {{ $dayItem['is_off'] ? 'text-red-500' : 'text-gray-400' }}">
                            {{ $d->translatedFormat('D') }}
                        </div>
                        <div class="text-base font-black {{ $dayItem['is_today'] ? 'text-sqr-green' : 'text-gray-800' }}">
                            {{ $d->format('d M') }}
                        </div>
                    </div>

                    <div class="mt-2">
                        @if($dayItem['is_off'] && !$dayItem['has_holiday'])
                        <span class="inline-block text-[9px] font-bold px-1.5 py-0.5 rounded bg-red-100 text-red-700">
                            Libur Rutin
                        </span>
                        @elseif($dayItem['events']->isNotEmpty())
                            @foreach($dayItem['events']->take(1) as $ev)
                            <span class="inline-block text-[9px] font-bold px-1.5 py-0.5 rounded truncate max-w-full
                                @if($ev->type === 'libur') bg-red-100 text-red-700
                                @elseif($ev->type === 'online') bg-blue-100 text-blue-700
                                @elseif($ev->type === 'acara') bg-amber-100 text-amber-700
                                @else bg-purple-100 text-purple-700 @endif">
                                {{ $ev->title }}
                            </span>
                            @endforeach
                        @else
                        <span class="inline-block text-[9px] font-bold px-1.5 py-0.5 rounded bg-emerald-100 text-emerald-700">
                            KBM Aktif
                        </span>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- ── END JADWAL & KALENDER AKADEMIK WIDGET FOR ADMIN ── -->

    <!-- Section 1: Tables Grid (PPDB Terbaru & Status Kuota Kelas SQR) -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        
        <!-- Widget 1: Pendaftaran PPDB Terbaru (Fixed Data Properties) -->
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between border-b border-gray-100 pb-4 mb-4">
                <h3 class="font-title font-bold text-base text-sqr-green flex items-center gap-2">
                    <i class="fa-solid fa-file-signature text-sqr-orange"></i> Pendaftaran PPDB Online Terbaru
                </h3>
                <a href="{{ route('admin.ppdb.index') }}" class="text-xs text-sqr-orange font-bold hover:underline">Kelola Pendaftar →</a>
            </div>
            <div class="space-y-3">
                @forelse($recentPpdb as $p)
                @php
                    $wa = $p->no_hp_ayah ?? $p->no_hp_ibu ?? $p->no_telephone ?? '-';
                @endphp
                <div class="flex items-center justify-between p-3.5 rounded-2xl border border-gray-100 hover:bg-sqr-bg/30 transition text-xs">
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="font-bold text-gray-800 text-sm">{{ $p->nama_lengkap }}</span>
                            <span class="text-[10px] text-gray-400">({{ $p->gender }})</span>
                        </div>
                        <p class="text-[11px] text-sqr-green font-semibold mt-0.5">
                            Kelas: {{ $p->kelasDiminati?->class_name ?? 'Kelas SQR' }}
                        </p>
                        <p class="text-[10px] text-gray-400">Wali: {{ $p->nama_ayah ?? $p->nama_ibu ?? 'Wali' }} · WA: {{ $wa }}</p>
                    </div>
                    <div class="text-right">
                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase {{ $p->status === 'Pending' ? 'bg-amber-100 text-amber-800' : ($p->status === 'Diterima' ? 'bg-emerald-100 text-emerald-800' : 'bg-red-100 text-red-800') }}">
                            {{ $p->status }}
                        </span>
                        <span class="text-[9px] text-gray-400 block mt-1">{{ $p->created_at->diffForHumans() }}</span>
                    </div>
                </div>
                @empty
                <div class="py-8 text-center text-gray-400 font-semibold text-xs">
                    <i class="fa-solid fa-inbox text-3xl mb-2 block opacity-40"></i>
                    Belum ada pendaftaran PPDB online baru.
                </div>
                @endforelse
            </div>
        </div>

        <!-- Widget 2: Status Kuota Bangku Belajar Kelas SQR -->
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 space-y-4">
            <div class="flex items-center justify-between border-b border-gray-100 pb-4">
                <h3 class="font-title font-bold text-base text-sqr-green flex items-center gap-2">
                    <i class="fa-solid fa-chair text-sqr-orange"></i> Kapasitas Bangku Belajar Per Kelas
                </h3>
                <a href="{{ route('admin.classes.index') }}" class="text-xs text-sqr-orange font-bold hover:underline">Atur Kuota →</a>
            </div>

            <div class="space-y-4">
                @foreach($classes as $c)
                <div class="bg-sqr-bg/30 p-4 rounded-2xl border border-sqr-green/10 space-y-2">
                    <div class="flex justify-between items-center text-xs font-bold">
                        <div class="flex items-center gap-2">
                            <span class="font-title text-sqr-green">{{ $c->class_name }}</span>
                            @if(!$c->is_active)
                                <span class="bg-gray-200 text-gray-700 text-[9px] px-2 py-0.2 rounded-full">🔒 DITUTUP</span>
                            @elseif($c->isQuotaFull())
                                <span class="bg-red-100 text-red-700 text-[9px] px-2 py-0.2 rounded-full">🔴 FULL</span>
                            @else
                                <span class="bg-emerald-100 text-emerald-700 text-[9px] px-2 py-0.2 rounded-full">🟢 BUKA</span>
                            @endif
                        </div>
                        <span class="text-sqr-orange">{{ $c->active_santri_count }} / {{ $c->quota }} Santri (Sisa {{ $c->remaining_quota }})</span>
                    </div>

                    <div class="w-full bg-gray-200 h-2.5 rounded-full overflow-hidden">
                        <div class="{{ $c->isQuotaFull() ? 'bg-red-500' : 'bg-sqr-green' }} h-2.5 rounded-full transition-all duration-1000" style="width: {{ $c->quota_percentage }}%"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Section 2: Extra Useful Widgets (Program SQR Berbagi & System Alerts) -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        
        <!-- Widget 3: Program SQR Berbagi / Campaign Progress -->
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 space-y-4">
            <div class="flex items-center justify-between border-b border-gray-100 pb-4">
                <h3 class="font-title font-bold text-base text-sqr-green flex items-center gap-2">
                    <i class="fa-solid fa-hand-holding-heart text-sqr-orange"></i> Progres Infaq & Program SQR Berbagi
                </h3>
                <a href="{{ route('admin.campaigns.index') }}" class="text-xs text-sqr-orange font-bold hover:underline">Update Dana →</a>
            </div>

            <div class="space-y-3">
                @forelse($campaigns as $cmp)
                <div class="p-3.5 rounded-2xl border border-gray-100 space-y-2 text-xs">
                    <div class="flex items-center justify-between font-bold">
                        <span class="text-sqr-green line-clamp-1">{{ $cmp->title }}</span>
                        <span class="text-sqr-orange">{{ round($cmp->percentage_progress) }}%</span>
                    </div>
                    <div class="w-full bg-gray-100 h-2 rounded-full overflow-hidden">
                        <div class="bg-sqr-orange h-full rounded-full" style="width: {{ $cmp->percentage_progress }}%;"></div>
                    </div>
                    <div class="flex justify-between text-[10px] text-gray-500 font-semibold">
                        <span>Terkumpul: <strong>{{ $cmp->formatted_current }}</strong></span>
                        <span>Target: <strong>{{ $cmp->formatted_target }}</strong></span>
                    </div>
                </div>
                @empty
                <div class="py-6 text-center text-gray-400 font-semibold text-xs">
                    Belum ada program campaign aktif.
                </div>
                @endforelse
            </div>
        </div>

        <!-- Widget 4: Notifikasi Sistem Terbaru -->
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 space-y-4">
            <div class="flex items-center justify-between border-b border-gray-100 pb-4">
                <h3 class="font-title font-bold text-base text-sqr-green flex items-center gap-2">
                    <i class="fa-solid fa-bell text-sqr-orange"></i> Notifikasi Masuk Terbaru Admin
                </h3>
                <a href="{{ route('admin.notifications.index') }}" class="text-xs text-sqr-orange font-bold hover:underline">Semua Notifikasi →</a>
            </div>

            <div class="space-y-3">
                @forelse($notifications as $notif)
                <div class="p-3 rounded-2xl bg-sqr-bg/30 border border-sqr-green/10 text-xs space-y-1">
                    <div class="flex items-center justify-between">
                        <span class="font-bold text-sqr-green line-clamp-1">{{ $notif->title }}</span>
                        <span class="text-[9px] text-gray-400 font-semibold">{{ $notif->created_at->diffForHumans() }}</span>
                    </div>
                    <p class="text-[11px] text-gray-600 line-clamp-2">{{ $notif->message }}</p>
                </div>
                @empty
                <div class="py-6 text-center text-gray-400 font-semibold text-xs">
                    Tidak ada notifikasi baru.
                </div>
                @endforelse
            </div>
        </div>

    </div>

</div>
@endsection
