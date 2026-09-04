@extends('layouts.dashboard')

@section('title', 'Presensi Ustadz & Santri')

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
@media print {
    body { display: none !important; }
}
.unselectable {
    -webkit-touch-callout: none;
    -webkit-user-select: none;
    -khtml-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
}
#sqrMapCanvas {
    height: 260px !important;
    width: 100% !important;
    position: relative !important;
    overflow: hidden !important;
    border-radius: 1.25rem !important;
    z-index: 1 !important;
}
#sqrMapCanvas .leaflet-container {
    height: 100% !important;
    width: 100% !important;
    border-radius: 1.25rem !important;
}
</style>
@endpush

@section('content')
<div class="max-w-5xl mx-auto space-y-6">

    <!-- Header & Tab Toggle & Export Button -->
    <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-sqr-green rounded-2xl flex items-center justify-center text-white text-xl shadow-md shrink-0">
                <i class="fa-solid fa-calendar-check"></i>
            </div>
            <div>
                <h3 class="font-title font-bold text-lg text-sqr-green">Manajemen Presensi & Kalender Kelas</h3>
                <p class="text-xs text-gray-500 mt-0.5">Kelola presensi diri ustadz, absensi santri, ustadz pengganti, & export laporan</p>
            </div>
        </div>

        <div class="flex flex-wrap items-center gap-3 w-full md:w-auto">
            <!-- Navigation Tabs -->
            <div class="flex bg-gray-100 p-1.5 rounded-2xl flex-1 md:flex-none">
                <button onclick="switchTab('tab-santri')" id="btn-tab-santri" class="tab-btn flex-1 md:flex-none px-4 py-2 rounded-xl text-xs font-bold transition bg-sqr-green text-white shadow-sm flex items-center justify-center gap-2">
                    <i class="fa-solid fa-users text-sqr-orange"></i> Absen Santri
                </button>
                <button onclick="switchTab('tab-diri')" id="btn-tab-diri" class="tab-btn flex-1 md:flex-none px-4 py-2 rounded-xl text-xs font-bold transition text-gray-600 hover:text-sqr-green flex items-center justify-center gap-2">
                    <i class="fa-solid fa-user-check text-sqr-orange"></i> Presensi Diri
                </button>
            </div>

            <!-- Export Excel / CSV Button -->
            <a href="{{ route('ustadz.attendance.export', ['class_id' => $selectedClassId, 'month' => date('m'), 'year' => date('Y')]) }}" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs px-4 py-2.5 rounded-2xl transition shadow-md flex items-center justify-center gap-2 shrink-0">
                <i class="fa-solid fa-file-excel text-sm"></i> Export Excel/CSV
            </a>
        </div>
    </div>

    <!-- ================= TAB 1: PRESENSI SANTRI KELAS ================= -->
    <div id="section-tab-santri" class="space-y-6">

        <!-- CHECK-IN RULE ALERT BANNER IF NOT CHECKED IN TODAY -->
        @if(!$canRecordSantriAttendance)
        <div class="bg-amber-50 border-2 border-amber-200 rounded-3xl p-5 shadow-sm space-y-3">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-amber-500 text-white flex items-center justify-center text-xl font-bold shrink-0 shadow-md">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                </div>
                <div>
                    <h4 class="font-title font-bold text-sm text-amber-900">Perhatian: Syarat Check-In Presensi Ustadz</h4>
                    <p class="text-xs text-amber-800 leading-relaxed">
                        @if($todaySelf)
                        Status presensi diri Anda hari ini: <strong class="uppercase font-black bg-amber-200 text-amber-900 px-2 py-0.5 rounded">{{ $todaySelf->status }}</strong>. Utama ustadz wajib berkunjung/check-in <strong>HADIR</strong> untuk mengisi absen santri kelasnya sendiri.
                        @else
                        Anda <strong>belum check-in HADIR</strong> hari ini ({{ date('d M Y') }}). Silakan check-in HADIR terlebih dahulu di bawah, atau bertindak sebagai <strong>Ustadz Pengganti</strong> jika mengajar kelas ustadz lain.
                        @endif
                    </p>
                </div>
            </div>

            <div class="flex items-center gap-3 pt-1 border-t border-amber-200/60 flex-wrap">
                @if(!$todaySelf)
                <form method="POST" action="{{ route('ustadz.attendance.self') }}" class="inline">
                    @csrf
                    <input type="hidden" name="status" value="Hadir">
                    <button type="submit" class="bg-amber-600 hover:bg-amber-700 text-white font-title font-bold text-xs px-4 py-2 rounded-xl transition shadow-md flex items-center gap-2">
                        <i class="fa-solid fa-check-double"></i> Check-In HADIR Ustadz Sekarang
                    </button>
                </form>
                @endif
                <button type="button" onclick="switchTab('tab-diri')" class="text-xs font-bold text-amber-900 hover:underline">
                    Lihat Pengaturan Presensi Diri →
                </button>
            </div>
        </div>
        @endif

        <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-gray-100 space-y-6">
            <div class="border-b pb-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div>
                    <h4 class="font-title font-bold text-base text-sqr-green flex items-center gap-2">
                        <i class="fa-solid fa-clipboard-user text-sqr-orange"></i> Input & Update Presensi Santri Kelas
                    </h4>
                    <p class="text-xs text-gray-500 mt-0.5">Pilih kelas dan tanggal pada widget kalender untuk memuat/memperbarui data presensi</p>
                </div>
            </div>

            <!-- Quick Class Select Buttons -->
            <div class="flex flex-wrap items-center gap-2 bg-sqr-bg/40 p-3 rounded-2xl border border-sqr-green/10">
                <span class="text-xs font-bold text-sqr-green mr-1"><i class="fa-solid fa-hand-pointer text-sqr-orange mr-1"></i>Pilih Kelas Cepat:</span>
                @foreach($classes as $c)
                <button type="button" onclick="selectClassQuick('{{ $c->id }}')" class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition border {{ $selectedClassId == $c->id ? 'bg-sqr-green text-white border-sqr-green shadow-sm' : 'bg-white text-gray-700 border-gray-200 hover:bg-sqr-bg hover:border-sqr-green' }}">
                    <i class="fa-solid fa-chalkboard-user mr-1 text-sqr-orange"></i> {{ $c->name }}
                </button>
                @endforeach
            </div>

            <!-- Class & Date Selector Bar (KALENDER WIDGET) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 bg-sqr-bg/50 p-4 rounded-2xl border border-sqr-green/10">
                <div>
                    <label class="block text-xs font-bold text-sqr-green mb-1">1. Pilih Kelas Pengampuan <span class="text-red-500">*</span></label>
                    <select id="classSelector" onchange="fetchSantriAttendance()" class="w-full bg-white border border-gray-200 rounded-xl p-3 text-xs font-semibold text-gray-800 outline-none focus:ring-2 focus:ring-sqr-green/30 focus:border-sqr-green transition">
                        <option value="">-- Pilih Kelas --</option>
                        @foreach($classes as $c)
                        <option value="{{ $c->id }}" {{ $selectedClassId == $c->id ? 'selected' : '' }}>
                            {{ $c->name }} ({{ $c->category }})
                        </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-sqr-green mb-1">2. Tanggal Presensi (Kalender Widget) <span class="text-red-500">*</span></label>
                    <input type="date" id="datePicker" value="{{ $selectedDate }}" max="{{ date('Y-m-d') }}" onchange="fetchSantriAttendance()" class="w-full bg-white border border-gray-200 rounded-xl p-3 text-xs font-bold text-gray-800 outline-none focus:ring-2 focus:ring-sqr-green/30 focus:border-sqr-green transition">
                </div>

                <div>
                    <label class="block text-xs font-bold text-sqr-green mb-1">3. Ustadz Pengganti (Jika Ada)</label>
                    <select id="substituteSelector" name="substitute_ustadz_id" class="w-full bg-white border border-gray-200 rounded-xl p-3 text-xs font-semibold text-gray-800 outline-none focus:ring-2 focus:ring-sqr-green/30 focus:border-sqr-green transition">
                        <option value="">-- Ustadz Utama Kelas --</option>
                        @foreach($allUstadz as $u)
                        <option value="{{ $u->id }}" data-ustadz-id="{{ $u->id }}">
                            {{ $u->formatted_name }} (Pengganti)
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Status Banner Indicator -->
            <div id="attendanceStatusBanner" class="hidden p-4 rounded-2xl text-xs font-bold flex flex-col sm:flex-row sm:items-center justify-between gap-3 transition"></div>

            <!-- Loading indicator -->
            <div id="loadingIndicator" class="hidden text-center py-10 text-gray-400">
                <i class="fa-solid fa-spinner fa-spin text-3xl mb-2 block text-sqr-green"></i>
                <p class="text-xs font-semibold">Memuat daftar santri...</p>
            </div>

            <!-- Empty Placeholder -->
            <div id="emptyClassPlaceholder" class="text-center py-12 text-gray-400">
                <i class="fa-solid fa-user-clock text-4xl block mb-2 opacity-30"></i>
                <p class="text-xs font-bold text-gray-500">Pilih kelas di atas untuk memuat daftar santri.</p>
            </div>

            <!-- Attendance Form -->
            <form id="santriAttendanceForm" method="POST" action="{{ route('ustadz.attendance.santri') }}" class="hidden space-y-5">
                @csrf
                <input type="hidden" name="class_id" id="formClassId">
                <input type="hidden" name="date" id="formDate">

                <!-- Batch Actions -->
                <div class="flex flex-wrap items-center justify-between gap-3 bg-gray-50 p-3.5 rounded-2xl border border-gray-100">
                    <span class="text-xs font-bold text-gray-700"><i class="fa-solid fa-bolt text-sqr-orange mr-1"></i> Aksi Cepat Massal:</span>
                    <div class="flex gap-2 flex-wrap">
                        <button type="button" onclick="setAllStatus('Hadir')" class="px-3.5 py-1.5 bg-emerald-100 hover:bg-emerald-200 text-emerald-800 rounded-xl text-xs font-bold transition">
                            🟢 Semua Hadir
                        </button>
                        <button type="button" onclick="setAllStatus('Izin')" class="px-3.5 py-1.5 bg-blue-100 hover:bg-blue-200 text-blue-800 rounded-xl text-xs font-bold transition">
                            🔵 Semua Izin
                        </button>
                        <button type="button" onclick="setAllStatus('Sakit')" class="px-3.5 py-1.5 bg-amber-100 hover:bg-amber-200 text-amber-800 rounded-xl text-xs font-bold transition">
                            🟡 Semua Sakit
                        </button>
                    </div>
                </div>

                <!-- Santri Table -->
                <div class="overflow-x-auto rounded-2xl border border-gray-200">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-sqr-dark text-white font-title text-[10px] uppercase tracking-wider">
                            <tr>
                                <th class="p-3.5 pl-4">No & Nama Santri</th>
                                <th class="p-3.5 text-center">Status Kehadiran</th>
                                <th class="p-3.5 pr-4">Catatan Keterangan (Opsional)</th>
                            </tr>
                        </thead>
                        <tbody id="santriRows" class="divide-y divide-gray-100 bg-white"></tbody>
                    </table>
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full bg-sqr-green hover:bg-sqr-dark text-white font-title font-bold text-sm py-4 rounded-2xl transition shadow-xl flex items-center justify-center gap-2 transform hover:-translate-y-0.5">
                        <i class="fa-solid fa-floppy-disk text-sqr-orange text-base"></i> Simpan / Update Presensi Santri
                    </button>
                </div>
            </form>
        </div>

        <!-- FILTER & EXPORT REKAP PRESENSI FLEXIBLE (SINGLE DATE / DATE RANGE / MONTH) -->
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 space-y-4">
            <div class="border-b pb-3 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div>
                    <h4 class="font-title font-bold text-sm text-sqr-green flex items-center gap-2">
                        <i class="fa-solid fa-filter text-sqr-orange"></i> Filter Riwayat & Export Rekap Absensi
                    </h4>
                    <p class="text-xs text-gray-500 mt-0.5">Filter berdasarkan 1 tanggal spesifik, rentang tanggal (dari-sampai), atau per bulan untuk riwayat dan download Excel/CSV</p>
                </div>
            </div>

            <form method="GET" action="{{ route('ustadz.attendance.index') }}" id="historyFilterForm" class="bg-sqr-bg/40 p-4 rounded-2xl border border-sqr-green/10 space-y-3">
                <input type="hidden" name="class_id" value="{{ $selectedClassId }}">

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <div>
                        <label class="block text-[11px] font-bold text-sqr-green mb-1">Tipe Filter *</label>
                        <select name="filter_type" id="filterTypeSelect" onchange="toggleFilterInputs()" class="w-full bg-white border border-gray-200 rounded-xl p-2.5 text-xs font-bold text-gray-800 outline-none focus:border-sqr-green">
                            <option value="month" {{ request('filter_type', 'month') === 'month' ? 'selected' : '' }}>📅 Per Bulan & Tahun</option>
                            <option value="single" {{ request('filter_type') === 'single' ? 'selected' : '' }}>📌 1 Tanggal Spesifik</option>
                            <option value="range" {{ request('filter_type') === 'range' ? 'selected' : '' }}>🗓️ Rentang Tanggal (Dari - Sampai)</option>
                        </select>
                    </div>

                    <!-- Single Date Input -->
                    <div id="singleDateWrapper" class="{{ request('filter_type') === 'single' ? '' : 'hidden' }}">
                        <label class="block text-[11px] font-bold text-sqr-green mb-1">Pilih Tanggal Spesifik</label>
                        <input type="date" name="filter_date" value="{{ request('filter_date', date('Y-m-d')) }}" max="{{ date('Y-m-d') }}" class="w-full bg-white border border-gray-200 rounded-xl p-2.5 text-xs font-bold text-gray-800 outline-none">
                    </div>

                    <!-- Date Range Inputs -->
                    <div id="startDateWrapper" class="{{ request('filter_type') === 'range' ? '' : 'hidden' }}">
                        <label class="block text-[11px] font-bold text-sqr-green mb-1">Dari Tanggal</label>
                        <input type="date" name="start_date" value="{{ request('start_date', date('Y-m-01')) }}" max="{{ date('Y-m-d') }}" class="w-full bg-white border border-gray-200 rounded-xl p-2.5 text-xs font-bold text-gray-800 outline-none">
                    </div>
                    <div id="endDateWrapper" class="{{ request('filter_type') === 'range' ? '' : 'hidden' }}">
                        <label class="block text-[11px] font-bold text-sqr-green mb-1">Sampai Tanggal</label>
                        <input type="date" name="end_date" value="{{ request('end_date', date('Y-m-d')) }}" max="{{ date('Y-m-d') }}" class="w-full bg-white border border-gray-200 rounded-xl p-2.5 text-xs font-bold text-gray-800 outline-none">
                    </div>

                    <!-- Month & Year Selects -->
                    <div id="monthWrapper" class="{{ request('filter_type', 'month') === 'month' ? '' : 'hidden' }}">
                        <label class="block text-[11px] font-bold text-sqr-green mb-1">Bulan</label>
                        <select name="month" class="w-full bg-white border border-gray-200 rounded-xl p-2.5 text-xs font-bold text-gray-800 outline-none">
                            @for($m = 1; $m <= 12; $m++)
                            @php $mStr = sprintf('%02d', $m); @endphp
                            <option value="{{ $mStr }}" {{ request('month', date('m')) == $mStr ? 'selected' : '' }}>
                                {{ \Carbon\Carbon::create(null, $m)->translatedFormat('F') }}
                            </option>
                            @endfor
                        </select>
                    </div>
                    <div id="yearWrapper" class="{{ request('filter_type', 'month') === 'month' ? '' : 'hidden' }}">
                        <label class="block text-[11px] font-bold text-sqr-green mb-1">Tahun</label>
                        <select name="year" class="w-full bg-white border border-gray-200 rounded-xl p-2.5 text-xs font-bold text-gray-800 outline-none">
                            @for($y = date('Y'); $y >= 2024; $y--)
                            <option value="{{ $y }}" {{ request('year', date('Y')) == $y ? 'selected' : '' }}>{{ $y }}</option>
                            @endfor
                        </select>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-2 pt-2">
                    <button type="submit" class="bg-sqr-green hover:bg-sqr-dark text-white font-bold text-xs px-4 py-2.5 rounded-xl transition flex items-center gap-1.5 shadow-sm">
                        <i class="fa-solid fa-filter"></i> Terapkan Filter Riwayat
                    </button>
                    <button type="button" onclick="exportFilteredExcel()" class="bg-sqr-orange hover:bg-orange-600 text-white font-bold text-xs px-4 py-2.5 rounded-xl transition flex items-center gap-1.5 shadow-sm">
                        <i class="fa-solid fa-file-csv text-sm"></i> Download Rekap CSV/Excel
                    </button>
                </div>
            </form>

            <div class="space-y-3">
                @forelse($recentSantriAttendanceLogs as $groupKey => $logs)
                @php
                    $first = $logs->first();
                    $hadirCount = $logs->where('status', 'Hadir')->count();
                    $totalCount = $logs->count();
                @endphp
                <div class="p-4 rounded-2xl border border-gray-100 bg-gray-50/60 hover:bg-white hover:shadow-md transition flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 text-xs">
                    <div>
                        <div class="flex items-center gap-2 flex-wrap">
                            <span class="font-bold text-sqr-green">{{ $first->sqrClass?->name }}</span>
                            <span class="text-gray-400">•</span>
                            <span class="font-bold text-gray-700"><i class="fa-solid fa-calendar-day text-sqr-orange mr-1"></i>{{ $first->date?->format('d M Y') }}</span>
                            @if($first->substituteUstadz)
                            <span class="bg-amber-100 text-amber-800 text-[10px] font-bold px-2 py-0.5 rounded-full border border-amber-200">
                                🔄 Digantikan: {{ \Illuminate\Support\Str::startsWith($first->substituteUstadz->name, 'Ust.') ? $first->substituteUstadz->name : 'Ust. ' . $first->substituteUstadz->name }}
                            </span>
                            @endif
                        </div>
                        <p class="text-[11px] text-gray-500 mt-1">
                            Pencatat: <strong>{{ $first->recordedBy ? (\Illuminate\Support\Str::startsWith($first->recordedBy->name, 'Ust.') ? $first->recordedBy->name : 'Ust. ' . $first->recordedBy->name) : 'Admin' }}</strong> · Kehadiran: <strong class="text-emerald-600">{{ $hadirCount }} Hadir</strong> dari {{ $totalCount }} Santri
                        </p>
                    </div>

                    <button type="button" onclick="loadHistoricalDate('{{ $first->class_id }}', '{{ $first->date?->format('Y-m-d') }}')" class="bg-sqr-bg hover:bg-sqr-green hover:text-white text-sqr-green font-bold text-xs px-4 py-2 rounded-xl border border-sqr-green/20 transition flex items-center gap-1.5 shrink-0">
                        <i class="fa-solid fa-pen-to-square"></i> Lihat & Edit Presensi
                    </button>
                </div>
                @empty
                <p class="text-xs text-gray-400 text-center py-6">Belum ada sesi presensi santri yang tercatat.</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- ================= TAB 2: PRESENSI DIRI USTADZ ================= -->
    <div id="section-tab-diri" class="hidden space-y-6">

        <!-- Stat Cards Ustadz Attendance -->
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
            <div class="bg-white p-5 rounded-3xl border border-gray-100 shadow-sm text-center">
                <p class="text-[10px] font-bold uppercase text-gray-400">Total Hadir (Bulan Ini)</p>
                <p class="font-title font-black text-2xl text-emerald-600 mt-1">{{ $myStats['total_hadir'] }} Hari</p>
            </div>
            <div class="bg-white p-5 rounded-3xl border border-gray-100 shadow-sm text-center">
                <p class="text-[10px] font-bold uppercase text-gray-400">Total Izin</p>
                <p class="font-title font-black text-2xl text-blue-600 mt-1">{{ $myStats['total_izin'] }} Hari</p>
            </div>
            <div class="bg-white p-5 rounded-3xl border border-gray-100 shadow-sm text-center">
                <p class="text-[10px] font-bold uppercase text-gray-400">Total Sakit</p>
                <p class="font-title font-black text-2xl text-amber-600 mt-1">{{ $myStats['total_sakit'] }} Hari</p>
            </div>
            <div class="bg-white p-5 rounded-3xl border border-gray-100 shadow-sm text-center">
                <p class="text-[10px] font-bold uppercase text-gray-400">Persentase Kehadiran</p>
                <p class="font-title font-black text-2xl text-sqr-green mt-1">{{ $myStats['percentage'] }}%</p>
            </div>
        </div>

        <!-- Presensi Form / Card Today -->
        <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-gray-100 space-y-6">
            <div class="border-b pb-4">
                <h4 class="font-title font-bold text-base text-sqr-green flex items-center gap-2">
                    <i class="fa-solid fa-user-check text-sqr-orange"></i> Check-In Presensi Kehadiran Ustadz ({{ date('d M Y') }})
                </h4>
            </div>

            @if($todaySelf)
            <div class="p-5 rounded-2xl bg-emerald-50 border border-emerald-200 flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-600 text-white flex items-center justify-center font-bold text-xl shadow-md shrink-0">
                        <i class="fa-solid fa-circle-check"></i>
                    </div>
                    <div>
                        <p class="font-bold text-sm text-emerald-900">Anda sudah melakukan presensi hari ini!</p>
                        <p class="text-xs text-emerald-700 mt-0.5">
                            Status: <span class="uppercase font-black bg-emerald-600 text-white px-2.5 py-0.5 rounded-full text-[10px]">{{ $todaySelf->status }}</span>
                            @if($todaySelf->check_in_time) · Jam: <strong>{{ $todaySelf->check_in_time }}</strong> @endif
                        </p>
                        @if($todaySelf->notes)<p class="text-xs text-emerald-800 italic mt-1">Catatan: {{ $todaySelf->notes }}</p>@endif
                    </div>
                </div>

                <button type="button" onclick="toggleSelfUpdateForm()" class="bg-white hover:bg-emerald-100 text-emerald-800 font-bold text-xs px-4 py-2.5 rounded-xl border border-emerald-300 transition shadow-sm shrink-0">
                    <i class="fa-solid fa-pen-to-square"></i> Perbarui Status / Tunjuk Pengganti
                </button>
            </div>
            @endif

            <form method="POST" action="{{ route('ustadz.attendance.self') }}" id="updateSelfForm" class="{{ $todaySelf ? 'hidden' : '' }} space-y-4 bg-sqr-bg/40 p-5 rounded-2xl border border-sqr-green/10">
                @csrf
                <input type="hidden" name="latitude" id="userLatInput">
                <input type="hidden" name="longitude" id="userLngInput">

                <!-- 🗺️ GPS GEOLOCATION & MAPS SECTION -->
                <div class="space-y-3 p-4 rounded-2xl bg-white border border-gray-200 shadow-sm">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                        <div>
                            <h5 class="font-title font-bold text-xs text-sqr-green flex items-center gap-1.5">
                                <i class="fa-solid fa-map-location-dot text-sqr-orange"></i> Verifikasi Lokasi GPS TPQ SQR
                            </h5>
                            <p class="text-[11px] text-gray-500 mt-0.5">Sistem memverifikasi posisi Anda dengan lokasi SQR Sukatani, Tapos Depok</p>
                        </div>
                        <button type="button" onclick="requestUserGpsLocation()" class="px-3.5 py-1.5 rounded-xl bg-sqr-bg text-sqr-green hover:bg-sqr-green hover:text-white font-bold text-xs transition border border-sqr-green/20 shrink-0 flex items-center gap-1.5">
                            <i class="fa-solid fa-crosshairs text-sqr-orange"></i> 📍 Dapatkan Lokasi GPS Saya
                        </button>
                    </div>

                    <!-- Map Canvas -->
                    <div id="sqrMapCanvas"></div>

                    <!-- GPS Status Badge -->
                    <div id="gpsStatusBadge" class="p-3 rounded-xl text-xs font-bold bg-amber-50 text-amber-900 border border-amber-200 flex items-center justify-between">
                        <span class="flex items-center gap-2"><i class="fa-solid fa-circle-notch fa-spin text-sqr-orange"></i> Mendeteksi lokasi GPS browser Anda...</span>
                    </div>
                </div>

                <p class="text-xs font-bold text-sqr-green">Pilih Status Presensi Diri Hari Ini:</p>

                @if($todaySelf?->status === 'Hadir')
                <div class="p-3.5 rounded-2xl bg-emerald-50 border border-emerald-300 text-emerald-900 text-xs font-bold flex items-start gap-2.5">
                    <i class="fa-solid fa-circle-check text-emerald-600 text-base shrink-0 mt-0.5"></i>
                    <div>
                        <strong class="font-title">Presensi Hadir Tatap Muka Anda Hari Ini Sudah Final & Terkunci</strong>
                        <p class="text-[11px] font-normal text-emerald-800 mt-0.5">
                            Status presensi Hadir Tatap Muka tidak dapat diubah ke Daring (Online), Izin, atau Sakit.
                        </p>
                    </div>
                </div>
                @elseif($todaySelf?->status === 'Alpa')
                <div class="p-3.5 rounded-2xl bg-amber-50 border border-amber-300 text-amber-900 text-xs font-bold flex items-start gap-2.5">
                    <i class="fa-solid fa-triangle-exclamation text-sqr-orange text-base shrink-0 mt-0.5"></i>
                    <div>
                        <strong class="font-title">Status Presensi Hari Ini Ditandai ALPA oleh Sistem (Lewat Jam 16:15 WIB)</strong>
                        <p class="text-[11px] font-normal text-amber-800 mt-1">
                            Anda tidak dapat lagi melakukan Check-In <strong>Hadir Tatap Muka</strong> hari ini. Namun Anda dapat memilih <strong>Hadir Online (Daring)</strong> dengan menyertakan link Zoom/GMeet, atau memilih status <strong>Izin</strong> / <strong>Sakit</strong> dengan menyertakan catatan baru.
                        </p>
                    </div>
                </div>
                @elseif(in_array($todaySelf?->status, ['Izin', 'Sakit']))
                <div class="p-3.5 rounded-2xl bg-blue-50 border border-blue-300 text-blue-900 text-xs font-bold flex items-start gap-2.5">
                    <i class="fa-solid fa-info-circle text-blue-600 text-base shrink-0 mt-0.5"></i>
                    <div>
                        <strong class="font-title">Status Presensi Anda Hari Ini: {{ strtoupper($todaySelf->status) }}</strong>
                        <p class="text-[11px] font-normal text-blue-800 mt-0.5">
                            Anda tidak dapat mengembalikan status ke <strong>Hadir Tatap Muka</strong>, namun Anda dapat memperbarui data Daring, Izin, atau Sakit.
                        </p>
                    </div>
                </div>
                @endif

                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                    <label class="cursor-pointer">
                        <input type="radio" name="status" value="Hadir" onchange="toggleOnlineClassFields()" {{ in_array($todaySelf?->status, ['Alpa', 'Izin', 'Sakit']) ? 'disabled' : '' }} {{ old('status', $todaySelf?->status ?? 'Hadir') === 'Hadir' && !in_array($todaySelf?->status, ['Alpa', 'Izin', 'Sakit']) ? 'checked' : '' }} class="sr-only peer">
                        <div class="p-3 rounded-xl border-2 border-gray-200 text-center peer-checked:border-emerald-600 peer-checked:bg-emerald-50 peer-checked:text-emerald-800 font-bold text-xs hover:bg-gray-50 transition {{ in_array($todaySelf?->status, ['Alpa', 'Izin', 'Sakit']) ? 'opacity-40 cursor-not-allowed bg-gray-100' : '' }}">
                            🟢 Hadir Tatap Muka
                            @if(in_array($todaySelf?->status, ['Alpa', 'Izin', 'Sakit']))<span class="block text-[9px] text-red-500 font-normal mt-0.5">(Terkunci)</span>@endif
                        </div>
                    </label>
                    <label class="cursor-pointer">
                        <input type="radio" name="status" value="Hadir Online" onchange="toggleOnlineClassFields()" {{ $todaySelf?->status === 'Hadir' ? 'disabled' : '' }} {{ old('status', $todaySelf?->status) === 'Hadir Online' || ($todaySelf?->status === 'Alpa' && !old('status')) ? 'checked' : '' }} class="sr-only peer">
                        <div class="p-3 rounded-xl border-2 border-gray-200 text-center peer-checked:border-purple-600 peer-checked:bg-purple-50 peer-checked:text-purple-800 font-bold text-xs hover:bg-gray-50 transition {{ $todaySelf?->status === 'Hadir' ? 'opacity-40 cursor-not-allowed bg-gray-100' : '' }}">
                            💻 Hadir Online (Daring)
                        </div>
                    </label>
                    <label class="cursor-pointer">
                        <input type="radio" name="status" value="Izin" onchange="toggleOnlineClassFields()" {{ $todaySelf?->status === 'Hadir' ? 'disabled' : '' }} {{ old('status', $todaySelf?->status) === 'Izin' ? 'checked' : '' }} class="sr-only peer">
                        <div class="p-3 rounded-xl border-2 border-gray-200 text-center peer-checked:border-blue-600 peer-checked:bg-blue-50 peer-checked:text-blue-800 font-bold text-xs hover:bg-gray-50 transition {{ $todaySelf?->status === 'Hadir' ? 'opacity-40 cursor-not-allowed bg-gray-100' : '' }}">
                            🔵 Izin
                        </div>
                    </label>
                    <label class="cursor-pointer">
                        <input type="radio" name="status" value="Sakit" onchange="toggleOnlineClassFields()" {{ $todaySelf?->status === 'Hadir' ? 'disabled' : '' }} {{ old('status', $todaySelf?->status) === 'Sakit' ? 'checked' : '' }} class="sr-only peer">
                        <div class="p-3 rounded-xl border-2 border-gray-200 text-center peer-checked:border-amber-600 peer-checked:bg-amber-50 peer-checked:text-amber-800 font-bold text-xs hover:bg-gray-50 transition {{ $todaySelf?->status === 'Hadir' ? 'opacity-40 cursor-not-allowed bg-gray-100' : '' }}">
                            🟡 Sakit
                        </div>
                    </label>
                </div>

                <!-- Fields Khusus Kelas Daring / Online -->
                <div id="onlineClassFields" class="hidden p-4 rounded-2xl bg-purple-50 border border-purple-200 space-y-3">
                    <div class="flex items-center gap-2 text-purple-900 font-bold text-xs">
                        <i class="fa-solid fa-laptop-code text-sqr-orange text-sm"></i>
                        <span>Pengaturan Kelas Daring (Zoom / Google Meet)</span>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <div class="sm:col-span-2">
                            <label class="block text-[11px] font-bold text-purple-900 mb-1">Link Pertemuan (Zoom / GMeet) *</label>
                            <input type="url" name="online_meeting_link" value="{{ old('online_meeting_link', $todaySelf?->online_meeting_link ?? '') }}" placeholder="https://meet.google.com/abc-defg-hij atau link Zoom..." class="w-full bg-white border border-purple-300 rounded-xl p-2.5 text-xs font-bold text-gray-800 outline-none focus:ring-2 focus:ring-purple-400">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-purple-900 mb-1">Jam Mulai Daring *</label>
                            <input type="time" name="online_start_time" value="{{ old('online_start_time', $todaySelf?->online_start_time ?? '16:00') }}" class="w-full bg-white border border-purple-300 rounded-xl p-2.5 text-xs font-bold text-gray-800 outline-none focus:ring-2 focus:ring-purple-400">
                        </div>
                    </div>
                    <p class="text-[10px] text-purple-700 font-medium">
                        ℹ️ <strong>Catatan Sistem:</strong> Pengumuman & link akan otomatis dikirimkan ke Dashboard & Notifikasi Wali Santri. Hadir Online dihitung mengajar dengan penyesuaian/potongan honor non-tatap muka pada rekapitulasi penggajian.
                    </p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div id="substituteWrapper" class="hidden">
                        <label class="block text-xs font-bold text-gray-700 mb-1">Tunjuk Ustadz Pengganti (Khusus Izin/Sakit)</label>
                        <select name="substitute_ustadz_id" id="selfSubstituteSelect" class="w-full bg-white border border-gray-200 rounded-xl p-3 text-xs outline-none focus:border-sqr-orange transition">
                            <option value="">-- Tidak Ada Ustadz Pengganti --</option>
                            @foreach($allUstadz as $u)
                            @if($u->id !== auth()->id())
                            <option value="{{ $u->id }}" {{ $todaySelf?->substitute_ustadz_id == $u->id ? 'selected' : '' }}>
                                {{ $u->formatted_name }}
                            </option>
                            @endif
                            @endforeach
                        </select>
                    </div>

                    <div id="notesWrapper" class="w-full">
                        <label class="block text-xs font-bold text-gray-700 mb-1">Catatan Keterangan (Opsional)</label>
                        <input type="text" name="notes" value="{{ $todaySelf?->status === 'Alpa' ? '' : old('notes', $todaySelf?->notes ?? '') }}" placeholder="{{ $todaySelf?->status === 'Alpa' ? 'Tuliskan alasan/keterangan baru di sini...' : 'Catatan instruksi / keterangan keperluan...' }}" class="w-full bg-white border border-gray-200 rounded-xl p-3 text-xs outline-none focus:border-sqr-orange transition">
                    </div>
                </div>

                <button type="submit" class="bg-sqr-green hover:bg-sqr-dark text-white font-bold text-xs px-6 py-3 rounded-xl transition shadow-md">
                    Simpan Presensi Ustadz
                </button>
            </form>
        </div>

        <!-- History Log Ustadz -->
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 space-y-4">
            <h4 class="font-title font-bold text-sm text-sqr-green flex items-center gap-2 border-b pb-3">
                <i class="fa-solid fa-clock-rotate-left text-sqr-orange"></i> Riwayat Presensi Kehadiran Ustadz (30 Hari Terakhir)
            </h4>

            <div class="overflow-x-auto rounded-2xl border border-gray-100">
                <table class="w-full text-left text-xs">
                    <thead class="bg-sqr-bg/50 text-sqr-green font-title text-[10px] uppercase">
                        <tr>
                            <th class="p-3 pl-4">Tanggal</th>
                            <th class="p-3">Waktu Check-In</th>
                            <th class="p-3 text-center">Status</th>
                            <th class="p-3 pr-4">Catatan / Ustadz Pengganti</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white">
                        @forelse($myAttendanceHistory as $history)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="p-3 pl-4 font-bold text-gray-800">{{ $history->date?->format('d M Y') }}</td>
                            <td class="p-3 text-gray-500 font-semibold">{{ $history->check_in_time ?? '-' }}</td>
                            <td class="p-3 text-center">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase {{ $history->statusBadgeClass }}">
                                    {{ $history->status }}
                                </span>
                            </td>
                            <td class="p-3 pr-4 text-gray-500 italic">
                                {{ $history->notes ?? '-' }}
                                @if($history->substitute_ustadz_id)
                                <span class="block text-[10px] font-bold text-amber-700 not-italic">
                                    🔄 Digantikan: Ust. {{ \App\Models\User::find($history->substitute_ustadz_id)?->name }}
                                </span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="p-6 text-center text-gray-400">Belum ada riwayat presensi ustadz.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

@push('scripts')
<script>
    function switchTab(tabId) {
        document.getElementById('section-tab-santri').classList.add('hidden');
        document.getElementById('section-tab-diri').classList.add('hidden');

        document.getElementById('btn-tab-santri').className = 'tab-btn flex-1 md:flex-none px-4 py-2 rounded-xl text-xs font-bold transition text-gray-600 hover:text-sqr-green flex items-center justify-center gap-2';
        document.getElementById('btn-tab-diri').className = 'tab-btn flex-1 md:flex-none px-4 py-2 rounded-xl text-xs font-bold transition text-gray-600 hover:text-sqr-green flex items-center justify-center gap-2';

        document.getElementById('section-' + tabId).classList.remove('hidden');
        document.getElementById('btn-' + tabId).className = 'tab-btn flex-1 md:flex-none px-4 py-2 rounded-xl text-xs font-bold transition bg-sqr-green text-white shadow-sm flex items-center justify-center gap-2';

        if (tabId === 'tab-diri') {
            setTimeout(function() {
                if (typeof leafletMap !== 'undefined' && leafletMap) {
                    leafletMap.invalidateSize();
                }
                if (typeof requestUserGpsLocation === 'function') {
                    requestUserGpsLocation();
                }
            }, 300);
        }
    }

    function toggleSelfUpdateForm() {
        var form = document.getElementById('updateSelfForm');
        if (form) {
            form.classList.toggle('hidden');
            if (!form.classList.contains('hidden')) {
                setTimeout(function() {
                    initSqrLeafletMap();
                    if (typeof leafletMap !== 'undefined' && leafletMap) {
                        leafletMap.invalidateSize();
                    }
                    if (typeof requestUserGpsLocation === 'function') {
                        requestUserGpsLocation();
                    }
                }, 200);
            }
        }
    }

    function fetchSantriAttendance() {
        var classId = document.getElementById('classSelector').value;
        var date = document.getElementById('datePicker').value;

        if (!classId) {
            document.getElementById('santriAttendanceForm').classList.add('hidden');
            document.getElementById('emptyClassPlaceholder').classList.remove('hidden');
            document.getElementById('loadingIndicator').classList.add('hidden');
            document.getElementById('attendanceStatusBanner').classList.add('hidden');
            return;
        }

        // Show loading, hide form and placeholders
        document.getElementById('emptyClassPlaceholder').classList.add('hidden');
        document.getElementById('santriAttendanceForm').classList.add('hidden');
        document.getElementById('loadingIndicator').classList.remove('hidden');
        document.getElementById('formClassId').value = classId;
        document.getElementById('formDate').value = date;

        var form = document.getElementById('santriAttendanceForm');
        var rows = document.getElementById('santriRows');
        var banner = document.getElementById('attendanceStatusBanner');

        fetch('/ustadz/absensi/kelas/' + classId + '/date/' + date)
            .then(res => res.json())
            .then(data => {
                document.getElementById('loadingIndicator').classList.add('hidden');

                // Hide main ustadz of this class from substitute selector dropdown
                var subSelect = document.getElementById('substituteSelector');
                if (subSelect) {
                    Array.from(subSelect.options).forEach(opt => {
                        if (opt.value && data.main_ustadz_id && parseInt(opt.value) === parseInt(data.main_ustadz_id)) {
                            opt.hidden = true;
                            opt.disabled = true;
                            if (subSelect.value === opt.value) {
                                subSelect.value = "";
                            }
                        } else {
                            opt.hidden = false;
                            opt.disabled = false;
                        }
                    });
                }

                var ustadzStatusInfo = '<div class="space-y-1">';
                ustadzStatusInfo += '<p class="font-bold"><i class="fa-solid fa-calendar-day mr-2"></i> Presensi Kelas: ' + data.class_name + ' (' + data.date_human + ')</p>';

                if (data.main_ustadz_name === 'Belum Ditentukan') {
                    ustadzStatusInfo += '<p class="text-[11px] font-medium text-amber-700"><i class="fa-solid fa-triangle-exclamation mr-1"></i> Kelas ini belum memiliki Ustadz Utama yang ditugaskan oleh Admin. Absensi santri dikunci.</p>';
                } else {
                    ustadzStatusInfo += '<p class="text-[11px] font-medium">Ustadz Utama Kelas: <strong>' + data.main_ustadz_name + '</strong> (Status: <span class="uppercase font-black px-2 py-0.5 rounded text-[10px] bg-sqr-dark text-white">' + data.main_ustadz_status + '</span>)</p>';
                }

                if (data.substitute_ustadz) {
                    if (data.is_auto_substitute) {
                        ustadzStatusInfo += '<p class="text-[11px] text-amber-900 font-bold bg-amber-100/80 p-2 rounded-xl border border-amber-300 mt-1"><i class="fa-solid fa-robot text-sqr-orange mr-1"></i> Sistem Otomatis Menugaskan Ustadz Pengganti (Hadir Hari Ini): Ust. ' + data.substitute_ustadz + '</p>';
                    } else {
                        ustadzStatusInfo += '<p class="text-[11px] text-amber-800 font-bold">🔄 Digantikan oleh Ustadz Pengganti (1 Hari): Ust. ' + data.substitute_ustadz + '</p>';
                    }
                }

                if (!data.can_record && data.cannot_record_reason) {
                    ustadzStatusInfo += '<p class="text-[11px] text-red-700 font-bold mt-1">' + data.cannot_record_reason + '</p>';
                }
                ustadzStatusInfo += '</div>';

                var canRec = data.can_record;

                if (!canRec) {
                    var lockReason = data.cannot_record_reason || '🔒 Presensi Santri Terkunci';
                    banner.className = 'p-4 rounded-2xl text-xs font-bold bg-red-50 border-2 border-red-200 text-red-900 flex flex-col sm:flex-row sm:items-center justify-between gap-3 shadow-xs';
                    banner.innerHTML = '<div class="flex items-center gap-2 font-bold"><i class="fa-solid fa-lock text-red-600 text-base"></i>' + lockReason + '</div>' +
                                       '<button type="button" onclick="switchTab(\'tab-diri\')" class="shrink-0 bg-red-600 hover:bg-red-700 text-white px-3.5 py-1.5 rounded-xl text-xs font-bold transition shadow-sm">Check-In Presensi Diri Ustadz →</button>';
                } else if (data.has_data) {
                    banner.className = 'p-4 rounded-2xl text-xs font-bold bg-emerald-50 border border-emerald-200 text-emerald-900 flex flex-col sm:flex-row sm:items-center justify-between gap-3';
                    banner.innerHTML = ustadzStatusInfo + '<span class="shrink-0 bg-emerald-600 text-white px-3 py-1 rounded-full text-[10px]">✅ Presensi Sudah Dicatat</span>';
                } else {
                    banner.className = 'p-4 rounded-2xl text-xs font-bold bg-amber-50 border border-amber-200 text-amber-900 flex flex-col sm:flex-row sm:items-center justify-between gap-3';
                    banner.innerHTML = ustadzStatusInfo + '<span class="shrink-0 bg-amber-500 text-white px-3 py-1 rounded-full text-[10px]">⚠️ Belum Ada Presensi Tercatat</span>';
                }
                banner.classList.remove('hidden');

                // Disable/Enable batch buttons
                document.querySelectorAll('#section-tab-santri button[onclick^="setAllStatus"]').forEach(btn => {
                    btn.disabled = !canRec;
                    if (!canRec) {
                        btn.classList.add('opacity-40', 'cursor-not-allowed');
                    } else {
                        btn.classList.remove('opacity-40', 'cursor-not-allowed');
                    }
                });

                if (!data.santri || data.santri.length === 0) {
                    rows.innerHTML = '<tr><td colspan="3" class="p-8 text-center text-gray-400"><i class="fa-solid fa-users text-2xl block mb-2 opacity-30"></i>Tidak ada santri aktif di kelas ini.</td></tr>';
                } else {
                    var html = '';
                    var disabledAttr = canRec ? '' : ' disabled ';
                    var disabledStyle = canRec ? '' : ' bg-gray-100 text-gray-400 cursor-not-allowed ';

                    data.santri.forEach((s, idx) => {
                        html += '<tr class="hover:bg-gray-50 transition">' +
                                '<td class="p-3.5 pl-4 font-bold text-gray-800">' + (idx + 1) + '. ' + s.full_name + '</td>' +
                                '<td class="p-3.5 text-center">' +
                                '<select name="status[' + s.id + ']" ' + disabledAttr + ' class="status-select border border-gray-200 rounded-xl p-2 text-xs font-bold outline-none focus:border-sqr-orange transition' + disabledStyle + '">' +
                                '<option value="Hadir"' + (s.status === 'Hadir' ? ' selected' : '') + '>🟢 Hadir</option>' +
                                '<option value="Izin"' + (s.status === 'Izin' ? ' selected' : '') + '>🔵 Izin</option>' +
                                '<option value="Sakit"' + (s.status === 'Sakit' ? ' selected' : '') + '>🟡 Sakit</option>' +
                                '<option value="Alpa"' + (s.status === 'Alpa' ? ' selected' : '') + '>🔴 Alpa</option>' +
                                '</select></td>' +
                                '<td class="p-3.5 pr-4">' +
                                '<input type="text" name="notes[' + s.id + ']" ' + disabledAttr + ' value="' + (s.notes || '') + '" placeholder="Catatan opsional..." class="w-full border border-gray-200 rounded-xl p-2 text-xs outline-none focus:border-sqr-orange transition' + disabledStyle + '">' +
                                '</td>' +
                                '</tr>';
                    });
                    rows.innerHTML = html;
                }

                var submitBtn = form.querySelector('button[type="submit"]');
                if (submitBtn) {
                    if (!canRec) {
                        submitBtn.disabled = true;
                        submitBtn.className = 'w-full bg-gray-300 text-gray-500 font-title font-bold text-sm py-4 rounded-2xl cursor-not-allowed flex items-center justify-center gap-2 border-2 border-red-200 shadow-none';
                        submitBtn.innerHTML = '<i class="fa-solid fa-lock text-red-500 text-base"></i> Absensi Santri Terkunci (Check-In HADIR Presensi Diri Dulu)';
                    } else {
                        submitBtn.disabled = false;
                        submitBtn.className = 'w-full bg-sqr-green hover:bg-sqr-dark text-white font-title font-bold text-sm py-4 rounded-2xl transition shadow-xl flex items-center justify-center gap-2 transform hover:-translate-y-0.5';
                        submitBtn.innerHTML = '<i class="fa-solid fa-floppy-disk text-sqr-orange text-base"></i> Simpan / Update Presensi Santri';
                    }
                }

                form.classList.remove('hidden');
            })
            .catch(err => {
                document.getElementById('loadingIndicator').classList.add('hidden');
                rows.innerHTML = '<tr><td colspan="3" class="p-6 text-center text-red-500"><i class="fa-solid fa-triangle-exclamation mr-2"></i>Gagal memuat data presensi santri. Coba refresh halaman.</td></tr>';
                form.classList.remove('hidden');
            });
    }

    function setAllStatus(statusValue) {
        document.querySelectorAll('.status-select').forEach(select => {
            select.value = statusValue;
        });
    }

    function selectClassQuick(classId) {
        var selector = document.getElementById('classSelector');
        if (selector) {
            selector.value = classId;
            fetchSantriAttendance();
        }
    }

    function loadHistoricalDate(classId, dateStr) {
        document.getElementById('classSelector').value = classId;
        document.getElementById('datePicker').value = dateStr;
        switchTab('tab-santri');
        fetchSantriAttendance();
        window.scrollTo({ top: 100, behavior: 'smooth' });
    }

    function toggleOnlineClassFields() {
        var selectedStatus = document.querySelector('input[name="status"]:checked')?.value;
        var onlineContainer = document.getElementById('onlineClassFields');
        var substituteWrapper = document.getElementById('substituteWrapper');
        var isCurrentAlpa = {{ $todaySelf?->status === 'Alpa' ? 'true' : 'false' }};

        if (onlineContainer) {
            if (selectedStatus === 'Hadir Online') {
                onlineContainer.classList.remove('hidden');
            } else {
                onlineContainer.classList.add('hidden');
            }
        }

        if (substituteWrapper) {
            if (!isCurrentAlpa && (selectedStatus === 'Izin' || selectedStatus === 'Sakit')) {
                substituteWrapper.classList.remove('hidden');
            } else {
                substituteWrapper.classList.add('hidden');
            }
        }
    }

    function toggleFilterInputs() {
        var type = document.getElementById('filterTypeSelect')?.value;
        var singleWrapper = document.getElementById('singleDateWrapper');
        var startWrapper  = document.getElementById('startDateWrapper');
        var endWrapper    = document.getElementById('endDateWrapper');
        var monthWrapper  = document.getElementById('monthWrapper');
        var yearWrapper   = document.getElementById('yearWrapper');

        if (singleWrapper) singleWrapper.classList.add('hidden');
        if (startWrapper)  startWrapper.classList.add('hidden');
        if (endWrapper)    endWrapper.classList.add('hidden');
        if (monthWrapper)  monthWrapper.classList.add('hidden');
        if (yearWrapper)   yearWrapper.classList.add('hidden');

        if (type === 'single') {
            if (singleWrapper) singleWrapper.classList.remove('hidden');
        } else if (type === 'range') {
            if (startWrapper) startWrapper.classList.remove('hidden');
            if (endWrapper)   endWrapper.classList.remove('hidden');
        } else {
            if (monthWrapper) monthWrapper.classList.remove('hidden');
            if (yearWrapper)  yearWrapper.classList.remove('hidden');
        }
    }

    function exportFilteredExcel() {
        var form = document.getElementById('historyFilterForm');
        var params = new URLSearchParams(new FormData(form)).toString();
        window.location.href = '{{ route("ustadz.attendance.export") }}?' + params;
    }

    // Auto load on initial render
    document.addEventListener('DOMContentLoaded', function() {
        toggleOnlineClassFields();

        // Switch to correct tab (santri by default or from query param)
        var defaultTab = '{{ request("tab", "tab-santri") }}';
        if (!defaultTab.startsWith('tab-')) defaultTab = 'tab-' + defaultTab;
        switchTab(defaultTab);

        // Auto-select class and load santri
        var classSelector = document.getElementById('classSelector');
        if (classSelector) {
            if (!classSelector.value && classSelector.options.length > 1) {
                classSelector.selectedIndex = 1;
            }
            if (classSelector.value) {
                fetchSantriAttendance();
            }
        }
    });
</script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    var sqrTargetLat    = {{ $userLocation->latitude ?? \App\Models\SchoolSchedule::sqrLatitude() }};
    var sqrTargetLng    = {{ $userLocation->longitude ?? \App\Models\SchoolSchedule::sqrLongitude() }};
    var sqrTargetRadius = {{ $userLocation->radius_meters ?? \App\Models\SchoolSchedule::sqrRadiusMeters() }};
    var sqrLocationName = "{{ addslashes($userLocation->name ?? 'TPQ SQR Utama') }}";

    var leafletMap = null;
    var sqrCircleMarker = null;
    var userGpsMarker = null;

    function initSqrLeafletMap() {
        if (!document.getElementById('sqrMapCanvas')) return;
        if (leafletMap) {
            setTimeout(function() { leafletMap.invalidateSize(); }, 200);
            return;
        }

        leafletMap = L.map('sqrMapCanvas').setView([sqrTargetLat, sqrTargetLng], 17);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap | TPQ Saung Quran Rabbani'
        }).addTo(leafletMap);

        var sqrIcon = L.divIcon({
            className: 'custom-sqr-marker',
            html: '<div style="background-color:#1b4332;color:white;padding:4px 8px;border-radius:12px;font-weight:bold;font-size:10px;border:2px solid #e67e22;box-shadow:0 4px 6px rgba(0,0,0,0.3);white-space:nowrap;">📍 ' + sqrLocationName + '</div>',
            iconSize: [110, 25],
            iconAnchor: [55, 12]
        });

        L.marker([sqrTargetLat, sqrTargetLng], { icon: sqrIcon }).addTo(leafletMap)
            .bindPopup('<b>' + sqrLocationName + '</b><br>Lokasi Mengajar Ustadz SQR').openPopup();

        sqrCircleMarker = L.circle([sqrTargetLat, sqrTargetLng], {
            color: '#e67e22',
            fillColor: '#f39c12',
            fillOpacity: 0.18,
            radius: sqrTargetRadius
        }).addTo(leafletMap);

        setTimeout(function() {
            if (leafletMap) leafletMap.invalidateSize();
        }, 300);
    }

    function calculateHaversineMeters(lat1, lon1, lat2, lon2) {
        var R = 6371000;
        var dLat = (lat2 - lat1) * Math.PI / 180;
        var dLon = (lon2 - lon1) * Math.PI / 180;
        var a = Math.sin(dLat/2) * Math.sin(dLat/2) +
                Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
                Math.sin(dLon/2) * Math.sin(dLon/2);
        var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
        return Math.round(R * c * 10) / 10;
    }

    function requestUserGpsLocation() {
        var badge = document.getElementById('gpsStatusBadge');
        var latInput = document.getElementById('userLatInput');
        var lngInput = document.getElementById('userLngInput');
        var hadirRadio = document.querySelector('input[name="status"][value="Hadir"]');

        if (!navigator.geolocation) {
            if (badge) badge.innerHTML = '<span class="text-red-700">⚠️ Browser Anda tidak mendukung akses Geolocation GPS.</span>';
            return;
        }

        if (badge) badge.innerHTML = '<span class="flex items-center gap-2"><i class="fa-solid fa-circle-notch fa-spin text-sqr-orange"></i> Mendeteksi posisi GPS Anda terhadap ' + sqrLocationName + '...</span>';

        navigator.geolocation.getCurrentPosition(
            function(pos) {
                var lat = pos.coords.latitude;
                var lng = pos.coords.longitude;

                if (latInput) latInput.value = lat;
                if (lngInput) lngInput.value = lng;

                initSqrLeafletMap();

                if (userGpsMarker) leafletMap.removeLayer(userGpsMarker);

                var userIcon = L.divIcon({
                    className: 'custom-user-marker',
                    html: '<div style="background-color:#2563eb;color:white;padding:4px 8px;border-radius:10px;font-weight:bold;font-size:10px;border:2px solid white;box-shadow:0 2px 6px rgba(0,0,0,0.3);white-space:nowrap;">👤 Anda Saat Ini</div>',
                    iconSize: [90, 24],
                    iconAnchor: [45, 12]
                });

                userGpsMarker = L.marker([lat, lng], { icon: userIcon }).addTo(leafletMap);

                // Auto fit bounds to show both SQR Location and User
                if (sqrCircleMarker && userGpsMarker) {
                    var group = L.featureGroup([sqrCircleMarker, userGpsMarker]);
                    leafletMap.fitBounds(group.getBounds().pad(0.2));
                }

                setTimeout(function() {
                    if (leafletMap) leafletMap.invalidateSize();
                }, 200);

                var dist = calculateHaversineMeters(lat, lng, sqrTargetLat, sqrTargetLng);
                var isWithin = (dist <= sqrTargetRadius);

                if (isWithin) {
                    if (badge) {
                        badge.className = 'p-3 rounded-xl text-xs font-bold bg-emerald-50 border border-emerald-200 text-emerald-900 flex items-center justify-between';
                        badge.innerHTML = '<span>🟢 <strong>Terdeteksi di Lokasi Mengajar: ' + sqrLocationName + '</strong> (Jarak: ' + dist + ' m)</span>' +
                                          '<span class="bg-emerald-600 text-white text-[10px] px-2.5 py-0.5 rounded-full font-bold">BISA HADIR FISIK</span>';
                    }
                    if (hadirRadio) {
                        hadirRadio.disabled = false;
                        hadirRadio.parentElement.classList.remove('opacity-40', 'cursor-not-allowed');
                    }
                } else {
                    if (badge) {
                        badge.className = 'p-3 rounded-xl text-xs font-bold bg-red-50 border border-red-200 text-red-900 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-2';
                        badge.innerHTML = '<div>🔴 <strong>Di Luar Radius Mengajar (' + sqrLocationName + ')</strong> (Jarak: ' + dist + ' m | Maks: ' + sqrTargetRadius + ' m)</div>' +
                                          '<div class="text-[10px] text-red-700 font-normal">Check-In HADIR Fisik Terkunci. Silakan pilih <strong>Hadir Online</strong> atau <strong>Izin</strong>.</div>';
                    }
                    if (hadirRadio) {
                        if (hadirRadio.checked) {
                            var onlineRadio = document.querySelector('input[name="status"][value="Hadir Online"]');
                            if (onlineRadio) onlineRadio.checked = true;
                            toggleOnlineClassFields();
                        }
                        hadirRadio.disabled = true;
                        hadirRadio.parentElement.classList.add('opacity-40', 'cursor-not-allowed');
                    }
                }
            },
            function(err) {
                if (badge) {
                    badge.className = 'p-3 rounded-xl text-xs font-bold bg-amber-50 border border-amber-200 text-amber-900 flex items-center justify-between';
                    badge.innerHTML = '<span>⚠️ Akses GPS Izin Browser Ditolak / Menggunakan Lokasi Estimasi Cabang.</span>';
                }
                initSqrLeafletMap();
            },
            { enableHighAccuracy: true, timeout: 10000, maximumAge: 0 }
        );
    }

    // Trigger GPS Map load when tab diri is clicked
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
            initSqrLeafletMap();
            requestUserGpsLocation();
        }, 500);
    });
</script>
@endpush
@endsection
