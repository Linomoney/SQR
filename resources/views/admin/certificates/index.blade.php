@extends('layouts.dashboard')

@section('title', 'Manajemen Sertifikat & Penghargaan Santri')

@section('content')
<div class="space-y-6">

    <!-- Header -->
    <div class="bg-gradient-to-r from-sqr-green via-sqr-dark to-sqr-green text-white rounded-3xl p-6 shadow-xl flex flex-col sm:flex-row items-center justify-between gap-4">
        <div>
            <h2 class="font-title font-bold text-xl flex items-center gap-2">
                <i class="fa-solid fa-award text-sqr-orange text-2xl"></i> Manajemen Sertifikat & Rekomendasi Santri
            </h2>
            <p class="text-white/70 text-xs mt-1">Kelola template sertifikat, download PDF resmi ber-TTD & ber-cap, dan pantau kelayakan setiap santri</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.certificates.settings') }}" class="bg-white/20 hover:bg-white/30 text-white font-bold text-xs px-4 py-2.5 rounded-xl transition flex items-center gap-1.5 border border-white/30">
                <i class="fa-solid fa-cog"></i> Pengaturan TTD & Cap
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-semibold rounded-2xl px-5 py-3.5 flex items-center gap-2">
        <i class="fa-solid fa-circle-check text-emerald-500"></i> {{ session('success') }}
    </div>
    @endif

    <!-- Stats Cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        @php
            $totalSantri = $santriList->count();
            $eligibleCert = $santriList->filter(fn($s) => $s->isEligibleForCertificate())->count();
            $eligibleRec  = $santriList->filter(fn($s) => $s->isEligibleForRecommendation())->count();
            $noneYet      = $santriList->filter(fn($s) => !$s->isEligibleForRecommendation())->count();
        @endphp
        <div class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100 text-center">
            <p class="text-2xl font-black text-sqr-green">{{ $totalSantri }}</p>
            <p class="text-xs text-gray-500 font-semibold mt-1">Total Santri Aktif</p>
        </div>
        <div class="bg-emerald-50 rounded-2xl p-4 shadow-sm border border-emerald-200 text-center">
            <p class="text-2xl font-black text-emerald-700">{{ $eligibleCert }}</p>
            <p class="text-xs text-emerald-600 font-semibold mt-1">🎓 Layak Sertifikat</p>
        </div>
        <div class="bg-amber-50 rounded-2xl p-4 shadow-sm border border-amber-200 text-center">
            <p class="text-2xl font-black text-amber-700">{{ $eligibleRec }}</p>
            <p class="text-xs text-amber-600 font-semibold mt-1">📜 Layak Rekomendasi</p>
        </div>
        <div class="bg-gray-50 rounded-2xl p-4 shadow-sm border border-gray-200 text-center">
            <p class="text-2xl font-black text-gray-500">{{ $noneYet }}</p>
            <p class="text-xs text-gray-400 font-semibold mt-1">⏳ Belum Memenuhi</p>
        </div>
    </div>

    <!-- Filter Bar -->
    <form method="GET" action="{{ route('admin.certificates.index') }}" class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100 flex flex-wrap items-center gap-3">
        <select name="class_id" class="bg-sqr-bg border border-gray-200 rounded-xl px-3 py-2 text-xs font-bold text-gray-700 outline-none focus:border-sqr-green">
            <option value="">Semua Kelas</option>
            @foreach($classes as $cls)
            <option value="{{ $cls->id }}" {{ $classId == $cls->id ? 'selected' : '' }}>{{ $cls->name }}</option>
            @endforeach
        </select>
        <select name="filter" class="bg-sqr-bg border border-gray-200 rounded-xl px-3 py-2 text-xs font-bold text-gray-700 outline-none focus:border-sqr-green">
            <option value="all" {{ $filter === 'all' ? 'selected' : '' }}>Semua Santri</option>
            <option value="eligible_cert" {{ $filter === 'eligible_cert' ? 'selected' : '' }}>🎓 Layak Sertifikat</option>
            <option value="eligible_rec" {{ $filter === 'eligible_rec' ? 'selected' : '' }}>📜 Layak Rekomendasi</option>
            <option value="none" {{ $filter === 'none' ? 'selected' : '' }}>⏳ Belum Memenuhi Syarat</option>
        </select>
        <button type="submit" class="bg-sqr-green hover:bg-sqr-dark text-white font-bold text-xs px-4 py-2 rounded-xl transition flex items-center gap-1.5">
            <i class="fa-solid fa-filter"></i> Filter
        </button>
    </form>

    <!-- Santri Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
        @forelse($santriList as $santri)
        @php
            $progress = $santri->progress_summary;
            $canCert  = $santri->isEligibleForCertificate();
            $canRec   = $santri->isEligibleForRecommendation();
            $tplLabel = match($santri->certificate_template ?? 'classic') {
                'elegant' => ['label' => 'Elegant Gold', 'color' => 'amber'],
                'premium' => ['label' => 'Premium Royal', 'color' => 'purple'],
                default   => ['label' => 'Classic SQR', 'color' => 'emerald'],
            };
        @endphp
        <div class="bg-white rounded-3xl p-5 shadow-sm border border-gray-100 hover:shadow-md transition space-y-4">
            <!-- Header -->
            <div class="flex items-start justify-between gap-3">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-2xl bg-sqr-green text-white font-black text-lg flex items-center justify-center shrink-0">
                        {{ strtoupper(substr($santri->full_name, 0, 1)) }}
                    </div>
                    <div>
                        <h4 class="font-title font-bold text-sm text-sqr-green leading-tight">{{ $santri->full_name }}</h4>
                        <p class="text-[10px] text-gray-500">{{ $santri->nis }} · {{ $santri->sqrClass?->name ?? 'SQR' }}</p>
                    </div>
                </div>
                <span class="text-xs font-black px-2.5 py-1 rounded-full {{ $progress['percentage'] >= 100 ? 'bg-emerald-100 text-emerald-800' : ($progress['percentage'] >= 50 ? 'bg-amber-100 text-amber-800' : 'bg-gray-100 text-gray-500') }}">
                    {{ round($progress['percentage']) }}%
                </span>
            </div>

            <!-- Progress Bar -->
            <div>
                <div class="flex justify-between text-[10px] text-gray-500 mb-1">
                    <span>Pencapaian Hafalan</span>
                    <span class="font-bold text-sqr-green">{{ $progress['total_juz'] }} / {{ $progress['target_juz'] }} Juz</span>
                </div>
                <div class="w-full bg-gray-100 rounded-full h-2.5 overflow-hidden">
                    <div class="h-2.5 rounded-full transition-all" style="width: {{ min(100, $progress['percentage']) }}%;background:{{ $progress['percentage'] >= 100 ? '#16a34a' : ($progress['percentage'] >= 50 ? '#d97706' : '#9ca3af') }}"></div>
                </div>
            </div>

            <!-- Eligibility Badges -->
            <div class="flex gap-2 flex-wrap">
                <span class="text-[10px] font-bold px-2.5 py-1 rounded-full {{ $canRec ? 'bg-amber-100 text-amber-800 border border-amber-300' : 'bg-gray-100 text-gray-400' }}">
                    📜 Rekomendasi ({{ $santri->recommendation_target }}%)
                </span>
                <span class="text-[10px] font-bold px-2.5 py-1 rounded-full {{ $canCert ? 'bg-emerald-100 text-emerald-800 border border-emerald-300' : 'bg-gray-100 text-gray-400' }}">
                    🎓 Sertifikat ({{ $santri->certificate_target }}%)
                </span>
            </div>

            <!-- Template Selector -->
            @if($canCert)
            <form method="POST" action="{{ route('admin.certificates.template', $santri) }}" class="flex items-center gap-2">
                @csrf @method('PATCH')
                <select name="certificate_template" class="flex-1 bg-sqr-bg border border-gray-200 rounded-xl px-2.5 py-2 text-[11px] font-bold text-gray-700 outline-none focus:border-sqr-orange">
                    <option value="classic" {{ ($santri->certificate_template ?? 'classic') === 'classic' ? 'selected' : '' }}>🟢 Classic SQR</option>
                    <option value="elegant" {{ $santri->certificate_template === 'elegant' ? 'selected' : '' }}>🟡 Elegant Gold</option>
                    <option value="premium" {{ $santri->certificate_template === 'premium' ? 'selected' : '' }}>🟣 Premium Royal</option>
                </select>
                <button type="submit" class="bg-sqr-orange hover:bg-orange-600 text-white font-bold text-[10px] px-3 py-2 rounded-xl transition">
                    <i class="fa-solid fa-check"></i>
                </button>
            </form>
            @endif

            <!-- Action Buttons -->
            <div class="flex gap-2 pt-1 border-t border-gray-100 flex-wrap">
                @if($canCert)
                <a href="{{ route('admin.certificates.download', $santri) }}" class="flex-1 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-[10px] py-2 rounded-xl transition text-center flex items-center justify-center gap-1">
                    <i class="fa-solid fa-download"></i> Download Sertifikat
                </a>
                @else
                <span class="flex-1 bg-gray-100 text-gray-400 font-bold text-[10px] py-2 rounded-xl text-center cursor-not-allowed">
                    <i class="fa-solid fa-lock"></i> Sertifikat Terkunci
                </span>
                @endif

                @if($canRec)
                <a href="{{ route('admin.certificates.recommendation.download', $santri) }}" class="flex-1 bg-amber-500 hover:bg-amber-600 text-white font-bold text-[10px] py-2 rounded-xl transition text-center flex items-center justify-center gap-1">
                    <i class="fa-solid fa-file-pdf"></i> Download Rekomendasi
                </a>
                @else
                <span class="flex-1 bg-gray-100 text-gray-400 font-bold text-[10px] py-2 rounded-xl text-center cursor-not-allowed">
                    <i class="fa-solid fa-lock"></i> Rekomendasi Terkunci
                </span>
                @endif
            </div>
        </div>
        @empty
        <div class="col-span-3 py-16 text-center text-gray-400">
            <i class="fa-solid fa-award text-5xl block mb-3 opacity-20"></i>
            <p class="font-bold text-gray-600">Tidak ada santri ditemukan</p>
            <p class="text-xs mt-1">Coba ubah filter kelas atau status kelayakan</p>
        </div>
        @endforelse
    </div>

</div>
@endsection
