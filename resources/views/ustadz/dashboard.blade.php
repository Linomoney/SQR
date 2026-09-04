@extends('layouts.dashboard')

@section('title', 'Dashboard Pengajar – Ust. ' . auth()->user()->name)

@section('content')
<div class="space-y-6">

    <!-- WELCOME BANNER USTADZ -->
    <div class="bg-gradient-to-r from-sqr-dark via-sqr-green to-[#2d4a22] text-white rounded-3xl p-6 sm:p-8 shadow-xl relative overflow-hidden flex flex-col md:flex-row items-start md:items-center justify-between gap-6 border border-white/10">
        <div class="absolute -right-8 -bottom-8 opacity-10 text-9xl pointer-events-none">
            <i class="fa-solid fa-book-quran"></i>
        </div>
        <div class="z-10 space-y-2">
            <div class="flex items-center gap-2 flex-wrap">
                <span class="bg-sqr-orange text-white text-[10px] font-black px-3 py-1 rounded-full uppercase tracking-wider shadow-sm">
                    Pengajar SQR
                </span>
                <span class="bg-white/20 text-sqr-bg text-[10px] font-bold px-3 py-1 rounded-full border border-white/20">
                    <i class="fa-solid fa-chalkboard-user mr-1 text-sqr-orange"></i> Kelas: {{ $sqrClass?->name ?? 'Semua Kelas' }}
                </span>
            </div>
            <h3 class="font-title font-black text-2xl sm:text-3xl text-sqr-bg">Ahlan wa Sahlan, {{ auth()->user()->name }}</h3>
            <p class="text-xs text-sqr-light-green max-w-xl">
                Semoga Allah memberkahi bimbingan hafalan dan tahsin santri Saung Quran Rabbani hari ini.
            </p>
        </div>

        <div class="z-10 flex gap-3 flex-wrap">
            <a href="{{ route('ustadz.progress.index') }}" class="bg-sqr-orange hover:bg-orange-600 text-white font-title font-bold text-xs px-5 py-3 rounded-2xl transition shadow-xl inline-flex items-center gap-2 transform hover:-translate-y-0.5">
                <i class="fa-solid fa-plus text-sm"></i> Input Progress Hafalan Santri
            </a>
            <a href="{{ route('ustadz.attendance.index') }}" class="bg-white/10 hover:bg-white/20 text-white border border-white/20 font-bold text-xs px-4 py-3 rounded-2xl transition inline-flex items-center gap-2">
                <i class="fa-solid fa-calendar-check text-sqr-orange"></i> Absensi Kelas
            </a>
        </div>
    </div>

    <!-- ── 📅 JADWAL & KALENDER AKADEMIK WIDGET FOR USTADZ ── -->
    <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 space-y-4">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b pb-3">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-sqr-green/10 text-sqr-green flex items-center justify-center font-bold text-xl shrink-0">
                    📅
                </div>
                <div>
                    <h3 class="font-title font-black text-base text-sqr-green">Jadwal & Kalender Kegiatan SQR</h3>
                    <p class="text-xs text-gray-500">Status KBM hari ini dan agenda akademik terbaru</p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold shadow-sm
                    {{ $isSchoolDay ? 'bg-emerald-100 text-emerald-800 border border-emerald-200' : 'bg-red-100 text-red-800 border border-red-200' }}">
                    {{ $isSchoolDay ? '🟢 Hari Belajar Aktif' : '🏖️ Hari Libur / Tidak Ada KBM' }}
                </span>
            </div>
        </div>

        <div class="p-4 rounded-2xl flex flex-col md:flex-row items-center justify-between gap-4 border
            {{ $isSchoolDay ? 'bg-gradient-to-r from-emerald-50 to-teal-50 border-emerald-100 text-emerald-900' : 'bg-gradient-to-r from-red-50 to-orange-50 border-red-100 text-red-900' }}">
            <div class="flex items-center gap-3">
                <div class="text-2xl">{{ $isSchoolDay ? '📚' : '🏖️' }}</div>
                <div>
                    <div class="font-bold text-sm">
                        {{ today()->translatedFormat('l, d F Y') }} — {{ $isSchoolDay ? 'KBM Tatap Muka Berlangsung' : 'KBM Libur' }}
                    </div>
                    @if($isSchoolDay)
                    <div class="text-xs opacity-80 mt-0.5">
                        Jam Masuk Pengajar: <strong>{{ $jamMasuk }} WIB</strong> · Selesai: <strong>{{ $jamPulang }} WIB</strong>
                    </div>
                    @else
                    <div class="text-xs opacity-80 mt-0.5">Semoga waktu luang penuh keberkahan.</div>
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

        @if($upcomingEvents->isNotEmpty())
        <div class="space-y-2 pt-1">
            <div class="text-xs font-bold text-gray-400 uppercase tracking-wider">Agenda / Event Akademik Mendatang</div>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                @foreach($upcomingEvents->take(3) as $uEv)
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

    <!-- STAT METRIC WIDGETS -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Widget 1: Santri Kelas -->
        <div class="bg-white p-5 rounded-3xl border border-gray-100 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-[10px] font-bold uppercase tracking-wider text-gray-400">Santri Kelas Pengampuan</p>
                <h4 class="font-title font-black text-2xl text-sqr-green mt-1">{{ $santriCount }} <span class="text-xs text-gray-400 font-semibold">Santri</span></h4>
                <p class="text-[10px] text-gray-400 mt-1 font-medium">{{ $sqrClass?->name ?? 'Kelas SQR' }}</p>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-sqr-green/10 text-sqr-green flex items-center justify-center text-xl font-bold">
                <i class="fa-solid fa-user-graduate"></i>
            </div>
        </div>

        <!-- Widget 2: Presensi Ustadz Hari Ini -->
        <div class="bg-white p-5 rounded-3xl border border-gray-100 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-[10px] font-bold uppercase tracking-wider text-gray-400">Presensi Ustadz Hari Ini</p>
                <div class="mt-1 flex items-center gap-2">
                    @if($todayAttendance)
                    <span class="px-3 py-1 rounded-full text-xs font-black uppercase {{ $todayAttendance->statusBadgeClass }}">
                        {{ $todayAttendance->status }}
                    </span>
                    @else
                    <span class="px-3 py-1 rounded-full text-xs font-black uppercase bg-red-100 text-red-700 animate-pulse">
                        Belum Presensi
                    </span>
                    @endif
                </div>
                <p class="text-[10px] text-gray-400 mt-1 font-medium">{{ date('d M Y') }}</p>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-sqr-orange/10 text-sqr-orange flex items-center justify-center text-xl font-bold">
                <i class="fa-solid fa-user-check"></i>
            </div>
        </div>

        <!-- Widget 3: Total Setoran Bulan Ini -->
        <div class="bg-white p-5 rounded-3xl border border-gray-100 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-[10px] font-bold uppercase tracking-wider text-gray-400">Setoran Hafalan (Bulan Ini)</p>
                <h4 class="font-title font-black text-2xl text-emerald-600 mt-1">{{ $monthlySetoranCount }} <span class="text-xs text-gray-400 font-semibold">Sesi</span></h4>
                <p class="text-[10px] text-emerald-600 font-bold mt-1">Tahfiz: {{ $tahfizCount }} · Murojaah: {{ $murojaahCount }}</p>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-emerald-100 text-emerald-700 flex items-center justify-center text-xl font-bold">
                <i class="fa-solid fa-book-bookmark"></i>
            </div>
        </div>

        <!-- Widget 4: Presensi Santri Hari Ini -->
        <div class="bg-white p-5 rounded-3xl border border-gray-100 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-[10px] font-bold uppercase tracking-wider text-gray-400">Presensi Santri Hari Ini</p>
                <h4 class="font-title font-black text-2xl text-sqr-green mt-1">
                    {{ $todaySantriHadirCount }} <span class="text-xs text-gray-400 font-semibold">/ {{ $santriCount }} Hadir</span>
                </h4>
                <p class="text-[10px] text-sqr-orange font-bold mt-1">
                    {{ $santriCount > 0 ? round(($todaySantriHadirCount / $santriCount) * 100) : 0 }}% Kehadiran Kelas
                </p>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-blue-100 text-blue-700 flex items-center justify-center text-xl font-bold">
                <i class="fa-solid fa-clipboard-user"></i>
            </div>
        </div>
    </div>

    <!-- ALERT CHECK-IN PRESENSI USTADZ HARI INI -->
    @if(!$todayAttendance)
    <div class="bg-amber-50 border-2 border-amber-200 rounded-3xl p-5 shadow-sm flex flex-col sm:flex-row items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <div class="w-12 h-12 rounded-2xl bg-amber-500 text-white flex items-center justify-center text-2xl font-bold shadow-md shrink-0">
                <i class="fa-solid fa-clock-pulse"></i>
            </div>
            <div>
                <h4 class="font-title font-bold text-sm text-amber-900">Anda belum mencatat presensi kehadiran ustadz hari ini!</h4>
                <p class="text-xs text-amber-700 mt-0.5">Check-in <strong>HADIR</strong> diperlukan untuk membuka akses pengisian absensi santri kelas.</p>
            </div>
        </div>
        <form method="POST" action="{{ route('ustadz.attendance.self') }}">
            @csrf
            <input type="hidden" name="status" value="Hadir">
            <button type="submit" class="bg-amber-600 hover:bg-amber-700 text-white font-title font-bold text-xs px-6 py-3 rounded-2xl transition shadow-lg shrink-0 flex items-center gap-2">
                <i class="fa-solid fa-check-double"></i> Check-In HADIR Sekarang
            </button>
        </form>
    </div>
    @endif

    <!-- WIDGET DISTRIBUSI SETORAN & TOP PERFORMERS -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Breakdown Tipe Setoran (Tahfiz vs Murojaah vs Tahsin) -->
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 space-y-4">
            <h4 class="font-title font-bold text-sm text-sqr-green flex items-center gap-2 border-b pb-3">
                <i class="fa-solid fa-chart-pie text-sqr-orange"></i> Rekap Jenis Setoran (Bulan Ini)
            </h4>

            <div class="space-y-3">
                <!-- Tahfiz -->
                <div>
                    <div class="flex justify-between text-xs font-bold mb-1">
                        <span class="text-emerald-700">🟢 Tahfiz (Hafalan Baru)</span>
                        <span class="text-gray-600">{{ $tahfizCount }} Sesi ({{ $monthlySetoranCount > 0 ? round(($tahfizCount/$monthlySetoranCount)*100) : 0 }}%)</span>
                    </div>
                    <div class="w-full bg-gray-100 h-2.5 rounded-full overflow-hidden">
                        <div class="bg-emerald-600 h-full rounded-full" style="width: {{ $monthlySetoranCount > 0 ? max(5, round(($tahfizCount/$monthlySetoranCount)*100)) : 0 }}%;"></div>
                    </div>
                </div>

                <!-- Murojaah -->
                <div>
                    <div class="flex justify-between text-xs font-bold mb-1">
                        <span class="text-amber-700">🟠 Murojaah (Pengulangan)</span>
                        <span class="text-gray-600">{{ $murojaahCount }} Sesi ({{ $monthlySetoranCount > 0 ? round(($murojaahCount/$monthlySetoranCount)*100) : 0 }}%)</span>
                    </div>
                    <div class="w-full bg-gray-100 h-2.5 rounded-full overflow-hidden">
                        <div class="bg-amber-500 h-full rounded-full" style="width: {{ $monthlySetoranCount > 0 ? max(5, round(($murojaahCount/$monthlySetoranCount)*100)) : 0 }}%;"></div>
                    </div>
                </div>

                <!-- Tahsin -->
                <div>
                    <div class="flex justify-between text-xs font-bold mb-1">
                        <span class="text-blue-700">🔵 Tahsin (Perbaikan Bacaan)</span>
                        <span class="text-gray-600">{{ $tahsinCount }} Sesi ({{ $monthlySetoranCount > 0 ? round(($tahsinCount/$monthlySetoranCount)*100) : 0 }}%)</span>
                    </div>
                    <div class="w-full bg-gray-100 h-2.5 rounded-full overflow-hidden">
                        <div class="bg-blue-500 h-full rounded-full" style="width: {{ $monthlySetoranCount > 0 ? max(5, round(($tahsinCount/$monthlySetoranCount)*100)) : 0 }}%;"></div>
                    </div>
                </div>
            </div>

            <div class="p-3 bg-sqr-bg/50 rounded-2xl border border-sqr-green/10 text-[11px] text-sqr-dark font-medium leading-relaxed">
                ℹ️ <strong>Catatan Algoritma:</strong> Setoran <strong>Tahfiz</strong> & <strong>Murojaah</strong> menambah persentase (%) progres hafalan & membuka sertifikat. Setoran <strong>Tahsin</strong> bersifat perbaikan bacaan (tidak menambah % hafalan).
            </div>
        </div>

        <!-- Top 5 Santri Hafalan Tertinggi -->
        <div class="lg:col-span-2 bg-white rounded-3xl p-6 shadow-sm border border-gray-100 space-y-4">
            <div class="flex items-center justify-between border-b pb-3">
                <h4 class="font-title font-bold text-sm text-sqr-green flex items-center gap-2">
                    <i class="fa-solid fa-trophy text-amber-500"></i> Santri Capaian Hafalan Tertinggi (Top 5)
                </h4>
                <a href="{{ route('ustadz.progress.index') }}" class="text-xs text-sqr-orange font-bold hover:underline">Kelola Semua Santri →</a>
            </div>

            <div class="space-y-3">
                @forelse($topSantriList as $idx => $s)
                <div class="p-3.5 rounded-2xl border border-gray-100 bg-gray-50/50 hover:bg-white hover:shadow-md transition flex items-center justify-between gap-3 text-xs">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-xl font-black text-xs flex items-center justify-center shrink-0
                            {{ $idx === 0 ? 'bg-amber-400 text-sqr-dark shadow-md' : ($idx === 1 ? 'bg-gray-300 text-gray-800' : ($idx === 2 ? 'bg-amber-700 text-white' : 'bg-gray-100 text-gray-600')) }}">
                            #{{ $idx + 1 }}
                        </div>
                        <div>
                            <p class="font-bold text-gray-800">{{ $s->full_name }}</p>
                            <p class="text-[10px] text-gray-400">NIS: {{ $s->nis }} · {{ $s->sqrClass?->name }}</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-4">
                        <div class="text-right">
                            <span class="font-title font-black text-sm text-sqr-green">{{ $s->total_juz_memorised }} / 30 Juz</span>
                            <p class="text-[10px] text-sqr-orange font-bold">{{ $s->progress_percentage }}% Target</p>
                        </div>
                        <a href="{{ route('ustadz.progress.create', $s) }}" class="bg-sqr-green hover:bg-sqr-dark text-white font-bold text-xs px-3 py-1.5 rounded-xl transition shadow-sm">
                            + Input
                        </a>
                    </div>
                </div>
                @empty
                <p class="text-xs text-gray-400 text-center py-6">Belum ada santri aktif terdaftar.</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- TABEL MONITORING HAFALAN SANTRI KELAS -->
    <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 space-y-4">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b pb-4">
            <div>
                <h4 class="font-title font-bold text-base text-sqr-green flex items-center gap-2">
                    <i class="fa-solid fa-users-rectangle text-sqr-orange"></i> Monitoring Santri & Capaian Hafalan Kelas
                </h4>
                <p class="text-xs text-gray-500 mt-0.5">Klik tombol "Input Progress" pada santri untuk mencatat setoran baru</p>
            </div>
            <a href="{{ route('ustadz.progress.index') }}" class="text-xs text-sqr-green font-bold hover:underline flex items-center gap-1">
                Kelola Semua Kelas →
            </a>
        </div>

        <div class="overflow-x-auto rounded-2xl border border-gray-100">
            <table class="w-full text-left text-xs">
                <thead class="bg-sqr-dark text-white font-title text-[10px] uppercase tracking-wider">
                    <tr>
                        <th class="p-3.5 pl-4">Santri</th>
                        <th class="p-3.5 text-center">Progress Hafalan</th>
                        <th class="p-3.5">Setoran Terakhir</th>
                        <th class="p-3.5 text-center pr-4">Aksi Input</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-white">
                    @forelse($classSantriList as $santri)
                    @php
                        $latest = $santri->studentProgress->first();
                        $pct = $santri->progress_percentage;
                        $juz = $santri->total_juz_memorised;
                    @endphp
                    <tr class="hover:bg-sqr-bg/20 transition">
                        <td class="p-3.5 pl-4">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl bg-sqr-green/10 text-sqr-green font-black text-sm flex items-center justify-center shrink-0">
                                    {{ strtoupper(substr($santri->full_name, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="font-bold text-gray-800 text-xs">{{ $santri->full_name }}</p>
                                    <p class="text-[10px] text-gray-400">NIS: {{ $santri->nis }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="p-3.5 text-center w-48">
                            <div class="flex items-center justify-between text-[10px] font-bold mb-1">
                                <span class="text-sqr-green">{{ $juz }} / 30 Juz</span>
                                <span class="text-sqr-orange">{{ $pct }}%</span>
                            </div>
                            <div class="w-full bg-gray-100 h-2 rounded-full overflow-hidden">
                                <div class="bg-sqr-green h-full rounded-full" style="width: {{ max(5, $pct) }}%;"></div>
                            </div>
                        </td>
                        <td class="p-3.5">
                            @if($latest)
                            <span class="px-2 py-0.5 rounded text-[9px] font-bold uppercase {{ $latest->type === 'Tahfiz' ? 'bg-emerald-100 text-emerald-800' : ($latest->type === 'Tahsin' ? 'bg-blue-100 text-blue-800' : 'bg-amber-100 text-amber-800') }}">
                                {{ $latest->type }}
                            </span>
                            <p class="font-bold text-gray-700 text-xs mt-0.5">{{ $latest->materi_summary }}</p>
                            <p class="text-[10px] text-gray-400">{{ $latest->date?->format('d M Y') }}</p>
                            @else
                            <span class="text-gray-400 italic text-[11px]">Belum ada setoran</span>
                            @endif
                        </td>
                        <td class="p-3.5 text-center pr-4">
                            <a href="{{ route('ustadz.progress.create', $santri) }}" class="bg-sqr-green hover:bg-sqr-dark text-white font-bold text-xs px-3.5 py-2 rounded-xl transition shadow-sm inline-flex items-center gap-1.5">
                                <i class="fa-solid fa-plus text-sqr-orange"></i> Input Progress
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="p-8 text-center text-gray-400">
                            Tidak ada santri aktif di kelas pengampuan ini.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- RIWAYAT INPUT SETORAN RECENT FEED -->
    <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 space-y-4">
        <div class="flex items-center justify-between border-b pb-4">
            <h4 class="font-title font-bold text-base text-sqr-green flex items-center gap-2">
                <i class="fa-solid fa-clock-rotate-left text-sqr-orange"></i> Riwayat Input Hafalan Terbaru oleh Anda
            </h4>
            <a href="{{ route('ustadz.progress.index') }}" class="text-xs text-sqr-orange font-bold hover:underline">Lihat Semua →</a>
        </div>

        <div class="space-y-3">
            @forelse($recentProgress as $pr)
            <div class="p-4 rounded-2xl border border-gray-100 hover:bg-sqr-bg/20 transition flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 text-xs">
                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center font-bold text-base shrink-0 shadow-sm
                        {{ $pr->type === 'Tahfiz' ? 'bg-emerald-100 text-emerald-700' : ($pr->type === 'Tahsin' ? 'bg-blue-100 text-blue-700' : 'bg-amber-100 text-amber-700') }}">
                        <i class="fa-solid {{ $pr->type === 'Tahfiz' ? 'fa-book-bookmark' : ($pr->type === 'Tahsin' ? 'fa-spell-check' : 'fa-rotate-right') }}"></i>
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="px-2.5 py-0.5 rounded-full text-[9px] font-bold uppercase {{ $pr->type === 'Tahfiz' ? 'bg-emerald-100 text-emerald-800' : ($pr->type === 'Tahsin' ? 'bg-blue-100 text-blue-800' : 'bg-amber-100 text-amber-800') }}">
                                {{ $pr->type }}
                            </span>
                            <span class="font-bold text-gray-800">{{ $pr->santri?->full_name }}</span>
                            <span class="text-gray-400 text-[10px]">({{ $pr->santri?->sqrClass?->name }})</span>
                        </div>
                        <p class="font-bold text-sqr-green text-sm mt-1">{{ $pr->materi_summary }}</p>
                        @if($pr->notes)<p class="text-[11px] text-gray-500 italic mt-0.5">{{ $pr->notes }}</p>@endif
                    </div>
                </div>

                <div class="text-right self-end sm:self-center shrink-0">
                    <p class="font-semibold text-gray-400 text-[11px]">{{ $pr->date?->format('d M Y') }}</p>
                    <form method="POST" action="{{ route('ustadz.progress.destroy', $pr) }}" onsubmit="return confirm('Hapus entri progress ini?')" class="mt-1">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-red-500 hover:text-red-700 font-bold text-[10px] bg-red-50 px-2.5 py-1 rounded-lg border border-red-100 transition">
                            <i class="fa-solid fa-trash-can mr-1"></i> Hapus
                        </button>
                    </form>
                </div>
            </div>
            @empty
            <div class="text-center py-8 text-gray-400 text-xs">
                <i class="fa-solid fa-newspaper text-3xl mb-2 block opacity-30"></i>
                Belum ada entri hafalan santri yang Anda catat hari ini.
            </div>
            @endforelse
        </div>
    </div>

</div>
@endsection
