@extends('layouts.dashboard')

@section('title', 'Laporan Progress Hafalan - ' . $santri->full_name)

@section('content')
<div class="space-y-6">

    {{-- Top Bar & Back Navigation --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-3xl border border-gray-100 shadow-sm">
        <div class="flex items-center gap-4">
            <a href="{{ route('wali.dashboard') }}"
               class="w-10 h-10 rounded-2xl bg-gray-100 hover:bg-gray-200 text-gray-600 flex items-center justify-center transition shrink-0">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <div>
                <span class="bg-sqr-green/10 text-sqr-green font-bold text-[10px] px-3 py-1 rounded-full uppercase tracking-wider inline-block mb-1">
                    📖 Detail Capaian & Setoran Ananda
                </span>
                <h2 class="text-xl font-title font-black text-sqr-green">{{ $santri->full_name }}</h2>
                <p class="text-xs text-gray-500 mt-0.5">NIS: {{ $santri->nis }} · Kelas: {{ $santri->sqrClass?->name ?? 'Belum Ditentukan' }}</p>
            </div>
        </div>
        <div class="flex items-center gap-2">
            @if($santri->can_download_certificate)
            <a href="{{ route('wali.certificate.download', $santri->id) }}"
               class="px-4 py-2.5 rounded-2xl bg-sqr-green text-white text-xs font-bold hover:bg-sqr-dark transition shadow-md flex items-center gap-2">
                <i class="fa-solid fa-award"></i> Unduh Sertifikat
            </a>
            @endif
            @if($santri->can_download_recommendation)
            <a href="{{ route('wali.recommendation.download', $santri->id) }}"
               class="px-4 py-2.5 rounded-2xl bg-sqr-orange text-white text-xs font-bold hover:bg-orange-600 transition shadow-md flex items-center gap-2">
                <i class="fa-solid fa-file-pdf"></i> Surat Rekomendasi
            </a>
            @endif
        </div>
    </div>

    {{-- Stats Cards & Progress Meter --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        {{-- Progress Bar Box --}}
        <div class="md:col-span-2 bg-gradient-to-br from-sqr-green via-sqr-dark to-sqr-green text-white p-6 rounded-3xl shadow-lg relative overflow-hidden flex flex-col justify-between">
            <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-white/5 rounded-full"></div>
            <div>
                <div class="flex items-center justify-between text-xs text-sqr-light-green font-bold uppercase tracking-wider mb-2">
                    <span>Target Capaian Hafalan Al-Qur'an</span>
                    <span>Target Total: 30 Juz</span>
                </div>
                <div class="flex items-baseline gap-2 mb-3">
                    <span class="text-4xl font-title font-black text-white">{{ $summary['completedJuzCount'] }}</span>
                    <span class="text-lg font-bold text-sqr-light-green">/ 30 Juz Tercapai</span>
                    <span class="ml-auto text-2xl font-black text-sqr-orange">{{ $summary['progressPercentage'] }}%</span>
                </div>
                <div class="w-full bg-white/20 rounded-full h-3.5 p-0.5 overflow-hidden">
                    <div class="bg-sqr-orange h-2.5 rounded-full transition-all duration-500 shadow-sm"
                         style="width: {{ min(100, $summary['progressPercentage']) }}%"></div>
                </div>
            </div>

            <div class="grid grid-cols-3 gap-3 mt-6 pt-4 border-t border-white/10 text-center">
                <div class="bg-white/10 p-2.5 rounded-2xl backdrop-blur-sm">
                    <div class="text-[10px] text-sqr-light-green font-bold uppercase">Tahfiz (Baru)</div>
                    <div class="text-base font-black text-white mt-0.5">{{ $summary['tahfiz_sessions'] }} Sesi</div>
                </div>
                <div class="bg-white/10 p-2.5 rounded-2xl backdrop-blur-sm">
                    <div class="text-[10px] text-sqr-light-green font-bold uppercase">Murojaah (Ulang)</div>
                    <div class="text-base font-black text-white mt-0.5">{{ $summary['murojaah_sessions'] }} Sesi</div>
                </div>
                <div class="bg-white/10 p-2.5 rounded-2xl backdrop-blur-sm">
                    <div class="text-[10px] text-sqr-light-green font-bold uppercase">Tahsin (Bacaan)</div>
                    <div class="text-base font-black text-white mt-0.5">{{ $summary['tahsin_sessions'] }} Sesi</div>
                </div>
            </div>
        </div>

        {{-- Status Gamifikasi & Penghargaan --}}
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 flex flex-col justify-between space-y-4">
            <div>
                <h3 class="font-title font-bold text-sm text-sqr-green flex items-center gap-2">
                    <i class="fa-solid fa-trophy text-sqr-orange"></i> Status Penghargaan & Gamifikasi
                </h3>
                <p class="text-xs text-gray-400 mt-0.5">Syarat kelulusan & sertifikasi santri</p>
            </div>

            <div class="space-y-2.5 text-xs">
                <div class="p-3 rounded-2xl border flex items-center justify-between
                    {{ $summary['is_certified'] ? 'bg-emerald-50 border-emerald-200 text-emerald-800' : 'bg-gray-50 border-gray-100 text-gray-500' }}">
                    <div class="flex items-center gap-2 font-bold">
                        <i class="fa-solid {{ $summary['is_certified'] ? 'fa-circle-check text-emerald-500' : 'fa-circle-notch' }}"></i>
                        <span>Sertifikat Hafiz SQR</span>
                    </div>
                    <span class="text-[10px] font-black uppercase px-2 py-0.5 rounded-full {{ $summary['is_certified'] ? 'bg-emerald-200 text-emerald-900' : 'bg-gray-200 text-gray-600' }}">
                        {{ $summary['is_certified'] ? 'Lulus' : 'Dalam Proses' }}
                    </span>
                </div>

                <div class="p-3 rounded-2xl border flex items-center justify-between
                    {{ $summary['is_recommended'] ? 'bg-blue-50 border-blue-200 text-blue-800' : 'bg-gray-50 border-gray-100 text-gray-500' }}">
                    <div class="flex items-center gap-2 font-bold">
                        <i class="fa-solid {{ $summary['is_recommended'] ? 'fa-circle-check text-blue-500' : 'fa-circle-notch' }}"></i>
                        <span>Surat Rekomendasi</span>
                    </div>
                    <span class="text-[10px] font-black uppercase px-2 py-0.5 rounded-full {{ $summary['is_recommended'] ? 'bg-blue-200 text-blue-900' : 'bg-gray-200 text-gray-600' }}">
                        {{ $summary['is_recommended'] ? 'Layak' : 'Belum Memenuhi' }}
                    </span>
                </div>
            </div>

            <div class="text-[11px] text-gray-400 text-center font-medium pt-2 border-t border-gray-100">
                Terakhir Diampu: <strong class="text-gray-700">{{ $santri->last_ustadz_user?->name ?? 'Pengajar SQR' }}</strong>
            </div>
        </div>

    </div>

    {{-- History Table --}}
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
            <div>
                <h3 class="text-sm font-title font-black text-sqr-green">📋 Riwayat Setoran Hafalan & Catatan Pengajar</h3>
                <p class="text-xs text-gray-400">Total {{ $summary['total_sessions'] }} kali setoran tercatat di sistem</p>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-xs">
                <thead>
                    <tr class="border-b border-gray-100 bg-gray-50/80 font-title uppercase tracking-wider text-gray-500 text-[10px]">
                        <th class="text-left px-5 py-3">Tanggal</th>
                        <th class="text-left px-5 py-3">Jenis Setoran</th>
                        <th class="text-left px-5 py-3">Juz / Surah & Ayat</th>
                        <th class="text-left px-5 py-3 hidden md:table-cell">Pengajar (Ustadz)</th>
                        <th class="text-left px-5 py-3">Nilai & Catatan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($progressList as $item)
                    <tr class="hover:bg-gray-50/60 transition">
                        <td class="px-5 py-3 text-xs text-gray-700 font-bold whitespace-nowrap">
                            {{ $item->date ? $item->date->translatedFormat('d M Y') : '-' }}
                        </td>
                        <td class="px-5 py-3">
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold border
                                @if($item->type === 'Tahfiz') bg-emerald-50 text-emerald-700 border-emerald-200
                                @elseif($item->type === 'Murojaah') bg-blue-50 text-blue-700 border-blue-200
                                @else bg-amber-50 text-amber-700 border-amber-200 @endif">
                                {{ $item->type }}
                            </span>
                        </td>
                        <td class="px-5 py-3">
                            <div class="font-bold text-gray-800 text-xs">Juz {{ $item->juz_start ?? 1 }} {{ $item->juz_end && $item->juz_end != $item->juz_start ? '– ' . $item->juz_end : '' }}</div>
                            @if($item->surah_name)
                            <div class="text-[11px] text-sqr-green font-semibold">Surah {{ $item->surah_name }} {{ $item->verse_start ? "Ayat {$item->verse_start}" : '' }} {{ $item->verse_end ? "– {$item->verse_end}" : '' }}</div>
                            @endif
                        </td>
                        <td class="px-5 py-3 text-gray-600 hidden md:table-cell whitespace-nowrap">
                            {{ $item->ustadz?->name ?? 'Pengajar SQR' }}
                        </td>
                        <td class="px-5 py-3">
                            @if($item->grade)
                            <span class="inline-block px-2 py-0.5 rounded font-black text-[10px] bg-sqr-green/10 text-sqr-green mr-1">
                                {{ $item->grade }}
                            </span>
                            @endif
                            @if($item->notes)
                            <span class="text-gray-600 text-xs font-medium">{{ $item->notes }}</span>
                            @else
                            <span class="text-gray-400 italic text-[11px]">Tidak ada catatan khusus</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-5 py-12 text-center text-gray-400 text-xs font-semibold">
                            <i class="fa-solid fa-book-open text-3xl mb-2 block opacity-40"></i>
                            Belum ada catatan riwayat setoran untuk ananda {{ $santri->full_name }}
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($progressList->hasPages())
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $progressList->links() }}
        </div>
        @endif
    </div>

</div>
@endsection
