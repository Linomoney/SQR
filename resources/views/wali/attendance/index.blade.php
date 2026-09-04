@extends('layouts.dashboard')

@section('title', 'Presensi & Kehadiran Santri')

@section('content')
<div class="space-y-6">

    <!-- Top Sub-Navigation Bar -->
    <div class="flex flex-col sm:flex-row items-center justify-between gap-4 bg-white rounded-2xl p-4 shadow-sm border border-gray-100">
        <a href="{{ route('wali.dashboard') }}" class="inline-flex items-center gap-2 text-sqr-green hover:text-sqr-orange text-xs font-bold transition">
            <i class="fa-solid fa-house text-sqr-orange"></i> Kembali ke Dashboard
        </a>
        <div class="flex gap-2 bg-sqr-bg p-1 rounded-xl">
            <a href="{{ route('wali.attendance.index') }}" class="px-4 py-2 rounded-lg text-xs font-bold bg-sqr-green text-white shadow-sm">
                📅 Absensi Santri
            </a>
            @if($selectedSantri)
            <a href="{{ route('wali.santri.progress', $selectedSantri) }}" class="px-4 py-2 rounded-lg text-xs font-bold text-gray-600 hover:text-sqr-green transition">
                📖 Progress Hafalan
            </a>
            @endif
        </div>
    </div>

    <!-- Header Banner -->
    <div class="relative bg-gradient-to-r from-sqr-green via-sqr-dark to-sqr-green text-white rounded-3xl p-8 shadow-xl overflow-hidden">
        <div class="absolute -top-8 -right-8 w-48 h-48 bg-white/5 rounded-full"></div>
        <div class="absolute -bottom-10 -left-10 w-52 h-52 bg-sqr-orange/10 rounded-full"></div>

        <div class="relative z-10 flex flex-col md:flex-row items-center md:items-start gap-6">
            <div class="w-20 h-20 rounded-2xl bg-sqr-orange/20 border-2 border-sqr-orange flex items-center justify-center text-4xl shrink-0 shadow-inner">
                📅
            </div>
            <div class="text-center md:text-left">
                <div class="inline-flex items-center gap-2 bg-sqr-orange/20 px-3 py-1 rounded-full text-xs font-black text-sqr-orange uppercase tracking-wider mb-2">
                    <i class="fa-solid fa-clipboard-user"></i> Portal Presensi Santri
                </div>
                <h1 class="font-title font-black text-2xl">{{ $selectedSantri?->full_name ?? 'Santri SQR' }}</h1>
                <p class="text-white/70 text-sm mt-1">{{ $selectedSantri?->sqrClass?->name ?? 'Kelas SQR' }} · NIS: {{ $selectedSantri?->nis ?? '-' }}</p>
                <p class="text-sqr-light-green text-xs mt-2">Rekapitulasi Kehadiran KBM Periode {{ \Carbon\Carbon::createFromDate($year, $month, 1)->translatedFormat('F Y') }}</p>
            </div>

            <div class="md:ml-auto text-center">
                <div class="text-5xl font-black text-sqr-orange">{{ $stats['percentage'] }}%</div>
                <p class="text-white/60 text-xs mt-1">Tingkat Kehadiran</p>
            </div>
        </div>
    </div>

    <!-- SANTRI SELECTION & PERIODE FILTER -->
    <div class="bg-white rounded-3xl p-5 shadow-sm border border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-4">
        <form method="GET" action="{{ route('wali.attendance.index') }}" class="flex items-center gap-3 flex-wrap w-full sm:w-auto">
            @if($santriList->count() > 1)
            <div>
                <label class="block text-[10px] font-bold text-gray-400 uppercase mb-0.5">Pilih Ananda</label>
                <select name="santri_id" class="bg-gray-50 border border-gray-200 rounded-xl p-2.5 text-xs font-bold text-gray-800 outline-none">
                    @foreach($santriList as $s)
                    <option value="{{ $s->id }}" {{ $selectedSantriId == $s->id ? 'selected' : '' }}>
                        {{ $s->full_name }} ({{ $s->sqrClass?->name ?? '-' }})
                    </option>
                    @endforeach
                </select>
            </div>
            @else
            <input type="hidden" name="santri_id" value="{{ $selectedSantriId }}">
            @endif

            <div>
                <label class="block text-[10px] font-bold text-gray-400 uppercase mb-0.5">Bulan & Tahun</label>
                <div class="flex gap-2">
                    <select name="month" class="bg-gray-50 border border-gray-200 rounded-xl p-2.5 text-xs font-bold text-gray-800 outline-none">
                        @for($m = 1; $m <= 12; $m++)
                        <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::createFromDate($year, $m, 1)->translatedFormat('F') }}
                        </option>
                        @endfor
                    </select>
                    <select name="year" class="bg-gray-50 border border-gray-200 rounded-xl p-2.5 text-xs font-bold text-gray-800 outline-none">
                        @for($y = 2025; $y <= 2030; $y++)
                        <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                </div>
            </div>

            <div class="self-end">
                <button type="submit" class="bg-sqr-green hover:bg-sqr-dark text-white font-bold text-xs px-4 py-2.5 rounded-xl transition shadow-xs">
                    Tampilkan Rekap
                </button>
            </div>
        </form>
    </div>

    <!-- STATS CARDS -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
        <div class="bg-white p-5 rounded-3xl border border-gray-100 shadow-sm text-center">
            <p class="text-[10px] font-bold uppercase text-gray-400">Total Sesi Belajar</p>
            <p class="font-title font-black text-2xl text-sqr-green mt-1">{{ $stats['total_days'] }} Sesi</p>
        </div>
        <div class="bg-white p-5 rounded-3xl border border-gray-100 shadow-sm text-center">
            <p class="text-[10px] font-bold uppercase text-gray-400">🟢 Hadir</p>
            <p class="font-title font-black text-2xl text-emerald-600 mt-1">{{ $stats['hadir'] }} Hari</p>
        </div>
        <div class="bg-white p-5 rounded-3xl border border-gray-100 shadow-sm text-center">
            <p class="text-[10px] font-bold uppercase text-gray-400">🔵 Izin / 🟡 Sakit</p>
            <p class="font-title font-black text-2xl text-blue-600 mt-1">{{ $stats['izin'] + $stats['sakit'] }} Hari</p>
        </div>
        <div class="bg-white p-5 rounded-3xl border border-gray-100 shadow-sm text-center">
            <p class="text-[10px] font-bold uppercase text-gray-400">🔴 Alpa (Tidak Hadir)</p>
            <p class="font-title font-black text-2xl text-red-600 mt-1">{{ $stats['alpa'] }} Hari</p>
        </div>
    </div>

    <!-- ATTENDANCE LOG TABLE -->
    <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 space-y-4">
        <h4 class="font-title font-bold text-sm text-sqr-green flex items-center gap-2 border-b pb-3">
            <i class="fa-solid fa-list-check text-sqr-orange"></i> Catatan Presensi Harian {{ $selectedSantri?->full_name }}
        </h4>

        <div class="overflow-x-auto rounded-2xl border border-gray-100">
            <table class="w-full text-left text-xs">
                <thead class="bg-sqr-bg/50 text-sqr-green font-title text-[10px] uppercase">
                    <tr>
                        <th class="p-3.5 pl-4">Tanggal KBM</th>
                        <th class="p-3.5">Kelas</th>
                        <th class="p-3.5 text-center">Status Kehadiran</th>
                        <th class="p-3.5">Ustadz Pencatats</th>
                        <th class="p-3.5 pr-4">Catatan Keterangan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-white">
                    @forelse($attendances as $att)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="p-3.5 pl-4 font-bold text-gray-800">{{ $att->date?->format('d M Y') }}</td>
                        <td class="p-3.5 font-semibold text-gray-600">{{ $att->sqrClass?->name ?? '-' }}</td>
                        <td class="p-3.5 text-center">
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase {{ $att->statusBadgeClass }}">
                                {{ $att->status }}
                            </span>
                        </td>
                        <td class="p-3.5 text-gray-600 font-medium">
                            {{ $att->recordedBy?->formatted_name ?? 'Ustadz Kelas' }}
                            @if($att->substituteUstadz)
                            <span class="block text-[9px] text-amber-600 italic">Digantikan: Ust. {{ $att->substituteUstadz->name }}</span>
                            @endif
                        </td>
                        <td class="p-3.5 pr-4 text-gray-600 italic">{{ $att->notes ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="p-8 text-center text-gray-400">
                            <i class="fa-solid fa-calendar-xmark text-3xl block mb-2 opacity-30"></i>
                            Belum ada catatan presensi pada periode bulan ini.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
