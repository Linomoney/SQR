@extends('layouts.dashboard')

@section('title', 'Dashboard Wali Santri')

@section('content')
<div class="space-y-6">

    <!-- Hero Header -->
    <div class="bg-gradient-to-r from-sqr-green via-sqr-dark to-sqr-green text-white rounded-3xl p-6 sm:p-8 shadow-xl relative overflow-hidden">
        <div class="absolute -top-10 -right-10 w-48 h-48 bg-white/5 rounded-full"></div>
        <div class="absolute -bottom-10 -left-10 w-52 h-52 bg-sqr-orange/10 rounded-full"></div>

        <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-4 text-center md:text-left">
                <div class="w-16 h-16 rounded-2xl bg-sqr-orange/20 border-2 border-sqr-orange flex items-center justify-center text-sqr-orange text-3xl font-black shrink-0">
                    👨‍👩‍👧
                </div>
                <div>
                    <div class="inline-flex items-center gap-2 bg-white/10 px-3 py-1 rounded-full text-xs font-bold text-sqr-light-green mb-1">
                        <i class="fa-solid fa-house-heart"></i> Portal Resmi Wali Santri SQR
                    </div>
                    <h1 class="font-title font-black text-2xl">Assalamu'alaikum, {{ auth()->user()->formatted_wali_greeting }}</h1>
                    <p class="text-white/70 text-xs mt-1">Pantau perkembangan hafalan Al-Qur'an ananda, jadwal kelas online, sertifikat, dan pembayaran SPP</p>
                </div>
            </div>
            <div class="flex items-center gap-2 shrink-0">
                <a href="{{ route('wali.payments.index') }}" class="bg-sqr-orange hover:bg-orange-600 text-white font-title font-bold text-xs px-5 py-3 rounded-2xl transition shadow-lg flex items-center gap-2">
                    <i class="fa-solid fa-receipt"></i> Status Pembayaran SPP
                </a>
            </div>
        </div>
    </div>

    @if(session('success'))
    <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-semibold rounded-2xl px-5 py-3.5 flex items-center gap-2">
        <i class="fa-solid fa-circle-check text-emerald-500"></i> {{ session('success') }}
    </div>
    @endif

    <!-- SPP Payment Banner Warning -->
    @if(auth()->user()->has_current_month_unpaid_spp)
    <div class="bg-amber-500 text-white rounded-3xl p-5 shadow-lg flex flex-col sm:flex-row items-center justify-between gap-3 animate-pulse">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-white/20 text-white flex items-center justify-center font-bold text-lg shrink-0">
                <i class="fa-solid fa-bell"></i>
            </div>
            <div>
                <h4 class="font-title font-bold text-sm text-white">Pengingat Pembayaran SPP {{ now()->translatedFormat('F Y') }}</h4>
                <p class="text-xs text-amber-100">
                    SPP bulan ini belum diverifikasi. Silakan lakukan pembayaran dan unggah bukti transfer.
                </p>
            </div>
        </div>
        <a href="{{ route('wali.payments.index') }}" class="bg-white text-amber-800 hover:bg-amber-100 font-bold text-xs px-4 py-2.5 rounded-xl transition shrink-0">
            Upload Bukti Transfer →
        </a>
    </div>
    @endif

    <!-- ── 🎥 LIVE KELAS ONLINE WIDGET ── -->
    @if($todayOnlineClasses->isNotEmpty())
    <div class="bg-gradient-to-r from-blue-700 via-indigo-800 to-blue-900 text-white rounded-3xl p-6 shadow-2xl border-2 border-blue-400 relative overflow-hidden">
        <div class="absolute -top-12 -right-12 w-48 h-48 bg-white/10 rounded-full blur-xl"></div>
        <div class="relative z-10 space-y-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-2xl bg-white/20 text-white flex items-center justify-center font-bold text-2xl shrink-0 animate-bounce">
                        🎥
                    </div>
                    <div>
                        <span class="bg-red-500 text-white text-[9px] font-black px-2.5 py-0.5 rounded-full uppercase tracking-wider animate-pulse">
                            🔴 KELAS ONLINE HARI INI
                        </span>
                        <h3 class="font-title font-black text-lg text-white mt-1">Pembelajaran Online (Zoom / Google Meet) Available</h3>
                    </div>
                </div>
            </div>

            @foreach($todayOnlineClasses as $online)
            <div class="bg-white/10 backdrop-blur-md rounded-2xl p-4 border border-white/20 flex flex-col md:flex-row items-center justify-between gap-4">
                <div class="space-y-1 text-center md:text-left">
                    <p class="text-xs font-bold text-blue-200 uppercase tracking-wider">
                        <i class="fa-solid fa-chalkboard-user"></i> {{ $online->sqrClass?->name ?? 'Kelas Tahfiz SQR' }}
                    </p>
                    <p class="font-black text-base text-white">
                        Pengampu: {{ $online->ustadz?->formatted_name ?? $online->ustadz?->name }}
                    </p>
                    <p class="text-xs text-blue-100 flex items-center justify-center md:justify-start gap-2">
                        <span><i class="fa-solid fa-clock"></i> Jam Mulai: <strong>{{ $online->online_start_time ?? 'Sesuai Sesi' }} WIB</strong></span>
                        @if($online->notes)
                        <span>· Catatan: {{ $online->notes }}</span>
                        @endif
                    </p>
                </div>
                <a href="{{ $online->online_meeting_link }}" target="_blank" class="bg-emerald-500 hover:bg-emerald-600 text-white font-title font-black text-xs px-6 py-3.5 rounded-2xl transition shadow-xl shrink-0 flex items-center gap-2 transform hover:-translate-y-0.5">
                    <i class="fa-solid fa-video text-base"></i> Masuk Kelas Online (Zoom / Meet) →
                </a>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- ── 📅 JADWAL & KALENDER AKADEMIK WIDGET ── -->
    <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 space-y-5">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-sqr-green/10 text-sqr-green flex items-center justify-center font-bold text-xl shrink-0">
                    📅
                </div>
                <div>
                    <h3 class="font-title font-black text-base text-sqr-green">Jadwal & Kalender Kegiatan SQR</h3>
                    <p class="text-xs text-gray-500">Status harian, jam masuk/pulang, dan agenda 7 hari ke depan</p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold shadow-sm
                    {{ $isSchoolDay ? 'bg-emerald-100 text-emerald-800 border border-emerald-200' : 'bg-red-100 text-red-800 border border-red-200' }}">
                    {{ $isSchoolDay ? '🟢 Hari Ini Belajar Aktif' : '🏖️ Hari Ini Libur / Tidak Masuk' }}
                </span>
            </div>
        </div>

        <!-- Today Info Banner -->
        <div class="p-4 rounded-2xl flex flex-col md:flex-row items-center justify-between gap-4 border
            {{ $isSchoolDay ? 'bg-gradient-to-r from-emerald-50 to-teal-50 border-emerald-100 text-emerald-900' : 'bg-gradient-to-r from-red-50 to-orange-50 border-red-100 text-red-900' }}">
            <div class="flex items-center gap-3">
                <div class="text-2xl">{{ $isSchoolDay ? '📚' : '🏖️' }}</div>
                <div>
                    <div class="font-bold text-sm">
                        {{ today()->translatedFormat('l, d F Y') }} — {{ $isSchoolDay ? 'Kegiatan KBM Berlangsung' : 'Tidak Ada Kegiatan KBM' }}
                    </div>
                    @if($isSchoolDay)
                    <div class="text-xs opacity-80 mt-0.5">
                        Jam Masuk: <strong>{{ $jamMasuk }} WIB</strong> · Jam Pulang: <strong>{{ $jamPulang }} WIB</strong>
                    </div>
                    @else
                    <div class="text-xs opacity-80 mt-0.5">Selamat beristirahat bersama keluarga.</div>
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

        <!-- Admin Online Class Events Banner (if present) -->
        @if($todayOnlineEvents->isNotEmpty())
        <div class="space-y-3">
            @foreach($todayOnlineEvents as $oEv)
            <div class="bg-gradient-to-r from-blue-600 to-indigo-700 text-white rounded-2xl p-4 shadow-md flex flex-col sm:flex-row items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center text-xl shrink-0">💻</div>
                    <div>
                        <span class="bg-white/20 text-white text-[10px] font-bold px-2 py-0.5 rounded-full uppercase">Kelas Online</span>
                        <div class="font-bold text-sm mt-0.5">{{ $oEv->title }}</div>
                        <div class="text-xs text-blue-100">Jam: {{ $oEv->online_start_time ? substr($oEv->online_start_time, 0, 5) : $jamMasuk }} WIB</div>
                    </div>
                </div>
                @if($oEv->online_link)
                <a href="{{ $oEv->online_link }}" target="_blank" class="bg-white text-blue-700 hover:bg-blue-50 font-bold text-xs px-4 py-2.5 rounded-xl transition shrink-0 flex items-center gap-1.5 shadow">
                    <i class="fa-solid fa-video"></i> Gabung Ruang Online →
                </a>
                @endif
            </div>
            @endforeach
        </div>
        @endif

        <!-- 7 Days Strip -->
        <div class="space-y-2">
            <div class="text-xs font-bold text-gray-400 uppercase tracking-wider">Jadwal 7 Hari Ke Depan</div>
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

                    <div class="mt-2 space-y-1">
                        @if($dayItem['is_off'] && !$dayItem['has_holiday'])
                        <span class="inline-block text-[9px] font-bold px-1.5 py-0.5 rounded bg-red-100 text-red-700">
                            Libur Mingguan
                        </span>
                        @elseif(isset($dayItem['santri_statuses']) && $dayItem['santri_statuses']->where('is_online', true)->isNotEmpty())
                            @foreach($dayItem['santri_statuses']->where('is_online', true) as $st)
                            <span class="inline-block text-[8px] font-black px-1.5 py-0.5 rounded bg-gradient-to-r from-blue-600 to-indigo-600 text-white truncate max-w-full shadow-xs">
                                🔴 Online: {{ strtok($st['santri']->full_name, ' ') }}
                            </span>
                            @endforeach
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
                            KBM Active
                        </span>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Upcoming Events List -->
        @if($upcomingEvents->isNotEmpty())
        <div class="pt-2 border-t border-gray-100 space-y-2">
            <div class="text-xs font-bold text-gray-400 uppercase tracking-wider">Agenda / Event SQR Mendatang</div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                @foreach($upcomingEvents->take(4) as $uEv)
                <div class="p-3 rounded-2xl bg-gray-50 border border-gray-100 flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-white border border-gray-200 flex flex-col items-center justify-center shrink-0">
                        <span class="text-xs font-black text-sqr-green leading-none">{{ $uEv->date->format('d') }}</span>
                        <span class="text-[8px] font-bold text-gray-400 uppercase">{{ $uEv->date->translatedFormat('M') }}</span>
                    </div>
                    <div class="min-w-0 flex-1">
                        <div class="font-bold text-xs text-gray-800 truncate">{{ $uEv->title }}</div>
                        <div class="text-[10px] text-gray-500 truncate">{{ $uEv->type_label }} {{ $uEv->sqrClass ? '· '.$uEv->sqrClass->name : '' }}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
    <!-- ── END JADWAL & KALENDER AKADEMIK WIDGET ── -->
    <div class="space-y-4">
        <div class="flex items-center justify-between">
            <h3 class="font-title font-bold text-base text-sqr-green flex items-center gap-2">
                <i class="fa-solid fa-child-reaching text-sqr-orange"></i> Progress Hafalan Ananda Santri
            </h3>
            <span class="text-xs font-bold text-gray-400">Total: {{ $santriList->count() }} Santri</span>
        </div>

        <div class="grid grid-cols-1 {{ $santriList->count() > 1 ? 'lg:grid-cols-2' : '' }} gap-6">
            @foreach($santriList as $santri)
            @php
                $summary    = $santri->progress_summary;
                $canCert    = $santri->isEligibleForCertificate();
                $canRec     = $santri->isEligibleForRecommendation();
                $certTarget = $santri->certificate_target;
                $recTarget  = $santri->recommendation_target;
            @endphp
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 space-y-5 transition hover:shadow-md">
                <!-- Santri Header Info -->
                <div class="flex items-center justify-between border-b border-gray-100 pb-4">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-2xl bg-sqr-green text-white font-black text-xl flex items-center justify-center shadow-md">
                            {{ strtoupper(substr($santri->full_name, 0, 1)) }}
                        </div>
                        <div>
                            <h4 class="font-title font-black text-base text-sqr-green">{{ $santri->full_name }}</h4>
                            <p class="text-xs text-gray-500 font-semibold">NIS: {{ $santri->nis }} · {{ $santri->sqrClass?->name ?? 'Kelas SQR' }}</p>
                        </div>
                    </div>
                    <span class="text-xs font-black px-3 py-1 rounded-full {{ $santri->is_active ? 'bg-emerald-100 text-emerald-800' : 'bg-gray-100 text-gray-500' }}">
                        {{ $santri->is_active ? 'Aktif' : 'Non-Aktif' }}
                    </span>
                </div>

                <!-- Status Pembelajaran Hari Ini per Ananda -->
                @if($santri->today_attendance)
                    @if($santri->today_attendance->status === 'Hadir Online')
                    <div class="p-4 rounded-2xl bg-gradient-to-r from-blue-700 via-indigo-800 to-blue-900 text-white shadow-xl border-2 border-blue-400 space-y-2.5">
                        <div class="flex items-center justify-between">
                            <span class="bg-red-500 text-white text-[9px] font-black px-2.5 py-0.5 rounded-full uppercase tracking-wider animate-pulse">
                                🔴 KELAS DARING (ONLINE)
                            </span>
                            <span class="text-[11px] text-blue-100 font-bold">Jam: {{ $santri->today_attendance->online_start_time ?? '16:00' }} WIB</span>
                        </div>
                        <div class="font-bold text-xs text-white">
                            💻 Kelas <strong>{{ $santri->sqrClass?->name }}</strong> Hari Ini Berlangsung Online
                        </div>
                        <p class="text-[11px] text-blue-100">
                            Pengampu: Ust. {{ $santri->today_attendance->ustadz?->formatted_name ?? $santri->today_attendance->ustadz?->name }}
                            @if($santri->today_attendance->notes) · {{ $santri->today_attendance->notes }} @endif
                        </p>
                        @if($santri->today_attendance->online_meeting_link)
                        <div class="pt-1">
                            <a href="{{ $santri->today_attendance->online_meeting_link }}" target="_blank" rel="noopener noreferrer" class="block w-full bg-emerald-500 hover:bg-emerald-600 text-white text-center font-title font-black text-xs py-3 rounded-xl transition shadow-lg flex items-center justify-center gap-2 transform hover:-translate-y-0.5">
                                <i class="fa-solid fa-video text-sm"></i> Masuk Kelas Online {{ $santri->full_name }} (Zoom/Meet) →
                            </a>
                        </div>
                        @endif
                    </div>
                    @elseif($santri->today_attendance->status === 'Hadir')
                    <div class="p-3.5 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-900 flex items-center justify-between gap-3 text-xs">
                        <div class="flex items-center gap-2.5">
                            <span class="text-xl">🟢</span>
                            <div>
                                <strong class="font-bold text-emerald-800">Kelas Tatap Muka (Offline)</strong>
                                <p class="text-[11px] text-emerald-700">Ust. {{ $santri->today_attendance->ustadz?->formatted_name }} mengajar fisik di Gedung TPQ SQR</p>
                            </div>
                        </div>
                        <span class="bg-emerald-600 text-white text-[9px] font-black px-2.5 py-1 rounded-full uppercase shrink-0">OFFLINE</span>
                    </div>
                    @else
                    <div class="p-3.5 rounded-2xl bg-amber-50 border border-amber-200 text-amber-900 flex items-center justify-between text-xs">
                        <div class="flex items-center gap-2">
                            <span>ℹ️</span>
                            <span>Status Pengajar: <strong>{{ $santri->today_attendance->status }}</strong></span>
                        </div>
                        <span class="text-[10px] text-amber-700 font-bold">{{ $santri->sqrClass?->name }}</span>
                    </div>
                    @endif
                @else
                <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200 text-slate-600 flex items-center justify-between text-xs">
                    <div class="flex items-center gap-2">
                        <span>🏫</span>
                        <span>Presensi Ustadz Kelas <strong>{{ $santri->sqrClass?->name }}</strong> Belum Dimulai</span>
                    </div>
                    <span class="text-[10px] text-slate-400 font-semibold">Tatap Muka</span>
                </div>
                @endif

                <!-- Progress Bar -->
                <div>
                    <div class="flex justify-between text-xs font-bold mb-1.5">
                        <span class="text-gray-700">Capaian Hafalan Target {{ $summary['target_juz'] }} Juz</span>
                        <span class="text-sqr-orange font-black">{{ round($summary['percentage']) }}% ({{ $summary['total_juz'] }} Juz)</span>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-3.5 overflow-hidden p-0.5 border border-gray-200">
                        <div class="h-2.5 rounded-full bg-gradient-to-r from-sqr-green to-sqr-orange transition-all duration-1000" style="width: {{ min(100, $summary['percentage']) }}%"></div>
                    </div>
                </div>

                <!-- Mini Stats Grid -->
                <div class="grid grid-cols-3 gap-2.5 text-center">
                    <div class="bg-sqr-bg/50 rounded-2xl p-2.5 border border-sqr-green/10">
                        <p class="font-black text-sqr-green text-base">{{ $summary['total_sessions'] }}</p>
                        <p class="text-[9px] text-gray-400 font-bold uppercase">Sesi Belajar</p>
                    </div>
                    <div class="bg-sqr-bg/50 rounded-2xl p-2.5 border border-sqr-green/10">
                        <p class="font-black text-blue-600 text-base">{{ $summary['tahfiz_sessions'] }}</p>
                        <p class="text-[9px] text-gray-400 font-bold uppercase">Sesi Tahfiz</p>
                    </div>
                    <div class="bg-sqr-bg/50 rounded-2xl p-2.5 border border-sqr-green/10">
                        <p class="font-black text-purple-600 text-base">{{ $summary['murojaah_sessions'] }}</p>
                        <p class="text-[9px] text-gray-400 font-bold uppercase">Sesi Murojaah</p>
                    </div>
                </div>

                <!-- Award Eligibility Badges -->
                <div class="grid grid-cols-2 gap-3 pt-1">
                    <a href="{{ route('wali.certificate.show', $santri) }}" class="rounded-2xl p-3 border text-center transition block {{ $canCert ? 'bg-emerald-50 border-emerald-300 hover:bg-emerald-100' : 'bg-gray-50 border-gray-200 hover:bg-gray-100' }}">
                        <div class="flex items-center justify-center gap-1.5 text-xs font-bold {{ $canCert ? 'text-emerald-800' : 'text-gray-500' }}">
                            <span>🎓 Sertifikat</span>
                            <span class="text-[9px] font-black px-1.5 py-0.5 rounded-full {{ $canCert ? 'bg-emerald-600 text-white' : 'bg-gray-200 text-gray-500' }}">
                                {{ $canCert ? 'OPEN' : $certTarget.'%' }}
                            </span>
                        </div>
                    </a>

                    <a href="{{ route('wali.recommendation.show', $santri) }}" class="rounded-2xl p-3 border text-center transition block {{ $canRec ? 'bg-amber-50 border-amber-300 hover:bg-amber-100' : 'bg-gray-50 border-gray-200 hover:bg-gray-100' }}">
                        <div class="flex items-center justify-center gap-1.5 text-xs font-bold {{ $canRec ? 'text-amber-800' : 'text-gray-500' }}">
                            <span>📜 Rekomendasi</span>
                            <span class="text-[9px] font-black px-1.5 py-0.5 rounded-full {{ $canRec ? 'bg-amber-600 text-white' : 'bg-gray-200 text-gray-500' }}">
                                {{ $canRec ? 'OPEN' : $recTarget.'%' }}
                            </span>
                        </div>
                    </a>
                </div>

                <!-- Action Button -->
                <a href="{{ route('wali.santri.progress', $santri) }}" class="block w-full bg-sqr-green hover:bg-sqr-dark text-white font-title font-bold text-xs py-3 rounded-2xl text-center transition shadow-sm">
                    <i class="fa-solid fa-chart-line mr-1"></i> Detail Progress Hafalan Ananda →
                </a>
            </div>
            @endforeach
        </div>
    </div>

    <!-- ── PENGUMUMAN & NOTIFIKASI WIDGET ── -->
    <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 space-y-4">
        <div class="flex items-center justify-between border-b border-gray-100 pb-3">
            <h3 class="font-title font-bold text-base text-sqr-green flex items-center gap-2">
                <i class="fa-solid fa-bullhorn text-sqr-orange"></i> Pengumuman & Broadcast Notifikasi Terbaru
            </h3>
            <a href="{{ route('wali.notifications') }}" class="text-xs text-sqr-orange font-bold hover:underline">
                Lihat Semua Notifikasi ({{ $unreadCount }})
            </a>
        </div>

        <div class="space-y-3">
            @forelse($notifications as $notif)
            <div class="p-4 rounded-2xl border transition flex items-start gap-3.5 {{ $notif->is_read ? 'bg-gray-50 border-gray-100' : 'bg-amber-50/60 border-amber-200' }}">
                <div class="w-9 h-9 rounded-xl {{ $notif->is_read ? 'bg-gray-200 text-gray-600' : 'bg-amber-500 text-white' }} flex items-center justify-center text-sm font-bold shrink-0 mt-0.5">
                    <i class="fa-solid fa-bell"></i>
                </div>
                <div class="flex-1 space-y-1">
                    <div class="flex items-center justify-between">
                        <h4 class="font-bold text-xs text-gray-800">{{ $notif->title }}</h4>
                        <span class="text-[10px] text-gray-400">{{ $notif->created_at?->diffForHumans() }}</span>
                    </div>
                    <div class="text-xs text-gray-600 leading-relaxed">{!! $notif->formatted_message_html !!}</div>
                </div>
            </div>
            @empty
            <div class="py-8 text-center text-gray-400">
                <i class="fa-solid fa-bell-slash text-3xl block mb-2 opacity-30"></i>
                <p class="text-xs">Belum ada pengumuman terbaru untuk Wali Santri</p>
            </div>
            @endforelse
        </div>
    </div>

</div>
@endsection
