@extends('layouts.dashboard')

@section('title', 'Detail Santri – ' . $santri->fullName)

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 flex items-center justify-between">
        <div class="flex items-center gap-4">
            <div class="w-16 h-16 bg-sqr-green rounded-2xl flex items-center justify-center text-white font-black text-2xl">
                {{ strtoupper(substr($santri->fullName, 0, 1)) }}
            </div>
            <div>
                <h3 class="font-title font-bold text-xl text-sqr-green">{{ $santri->fullName }}</h3>
                <p class="text-xs text-sqr-orange font-bold">NIS: {{ $santri->nis }} · {{ $santri->sqrClass?->name ?? 'Belum ada kelas' }}</p>
                <p class="text-[11px] text-gray-400 mt-0.5">Wali: {{ $santri->wali?->name ?? 'Belum terhubung' }}</p>
            </div>
        </div>
        <a href="{{ route('admin.santri.edit', $santri) }}" class="bg-amber-50 text-amber-700 font-bold text-xs px-4 py-2.5 rounded-xl border border-amber-200 hover:bg-amber-100 transition">
            <i class="fa-solid fa-pen"></i> Edit Profile
        </a>
    </div>

    <!-- Gamifikasi Progress Overview -->
    <div class="bg-sqr-dark text-white rounded-3xl p-6 shadow-lg border border-white/10">
        <h4 class="font-title font-bold text-sm text-sqr-bg mb-3">Statistik Progress Hafalan Santri</h4>
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 text-center">
            <div class="bg-white/10 p-4 rounded-2xl">
                <p class="text-[10px] text-gray-300 uppercase font-bold">Completed Juz</p>
                <p class="font-title font-black text-2xl text-sqr-orange mt-1">{{ $santri->progress_summary['completedJuzCount'] }} / 30</p>
            </div>
            <div class="bg-white/10 p-4 rounded-2xl">
                <p class="text-[10px] text-gray-300 uppercase font-bold">Persentase</p>
                <p class="font-title font-black text-2xl text-sqr-light-green mt-1">{{ $santri->progress_summary['progressPercentage'] }}%</p>
            </div>
            <div class="bg-white/10 p-4 rounded-2xl">
                <p class="text-[10px] text-gray-300 uppercase font-bold">Surat Rekomendasi</p>
                <p class="font-bold text-xs mt-2 {{ $santri->can_download_recommendation ? 'text-emerald-400' : 'text-gray-400' }}">
                    {{ $santri->can_download_recommendation ? 'UNLOCKED (Min 50%)' : 'LOCKED' }}
                </p>
            </div>
            <div class="bg-white/10 p-4 rounded-2xl">
                <p class="text-[10px] text-gray-300 uppercase font-bold">Sertifikat Kelulusan</p>
                <p class="font-bold text-xs mt-2 {{ $santri->can_download_certificate ? 'text-emerald-400' : 'text-gray-400' }}">
                    {{ $santri->can_download_certificate ? 'UNLOCKED (100%)' : 'LOCKED' }}
                </p>
            </div>
        </div>
    </div>

    <!-- Progress History -->
    <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100">
        <h4 class="font-title font-bold text-base text-sqr-green mb-4">Riwayat Setoran Hafalan</h4>
        <div class="space-y-3">
            @forelse($santri->studentProgress as $pr)
            <div class="flex items-center justify-between p-4 rounded-2xl border border-gray-100 text-xs">
                <div>
                    <span class="px-2 py-0.5 rounded-full text-[9px] font-bold bg-sqr-orange/10 text-sqr-orange uppercase">{{ $pr->type }}</span>
                    <p class="font-bold text-gray-800 mt-1">{{ $pr->materi_summary }}</p>
                    @if($pr->notes)<p class="text-[10px] text-gray-400 italic">Catatan: {{ $pr->notes }}</p>@endif
                </div>
                <div class="text-right">
                    <p class="font-semibold text-gray-500">{{ $pr->date?->format('d M Y') }}</p>
                    <p class="text-[10px] text-gray-400">Pengajar: {{ $pr->ustadz?->name ?? 'System' }}</p>
                </div>
            </div>
            @empty
            <p class="text-xs text-gray-400 text-center py-6">Belum ada riwayat hafalan yang dicatat.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
