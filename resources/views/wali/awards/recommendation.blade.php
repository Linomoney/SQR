@extends('layouts.dashboard')

@section('title', 'Surat Rekomendasi – ' . $santri->full_name)

@push('styles')
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
.envelope-shake {
    animation: floatBounce 2s ease-in-out infinite;
}
@keyframes floatBounce {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-8px); }
}
</style>
@endpush

@section('content')
<div class="space-y-6 unselectable">

    <!-- Top Navigation Bar -->
    <div class="flex flex-col sm:flex-row items-center justify-between gap-4 bg-white rounded-2xl p-4 shadow-sm border border-gray-100">
        <a href="{{ route('wali.dashboard') }}" class="inline-flex items-center gap-2 text-sqr-green hover:text-sqr-orange text-xs font-bold transition">
            <i class="fa-solid fa-house text-sqr-orange"></i> Kembali ke Dashboard
        </a>
        <div class="flex gap-2 bg-sqr-bg p-1 rounded-xl">
            <a href="{{ route('wali.certificate.show', $santri) }}" class="px-4 py-2 rounded-lg text-xs font-bold transition {{ request()->routeIs('wali.certificate.show') ? 'bg-sqr-green text-white shadow-sm' : 'text-gray-600 hover:text-sqr-green' }}">
                🎓 Sertifikat Hafalan
            </a>
            <a href="{{ route('wali.recommendation.show', $santri) }}" class="px-4 py-2 rounded-lg text-xs font-bold transition {{ request()->routeIs('wali.recommendation.show') ? 'bg-sqr-green text-white shadow-sm' : 'text-gray-600 hover:text-sqr-green' }}">
                📜 Surat Rekomendasi
            </a>
        </div>
    </div>

    @if(session('error'))
    <div class="bg-red-50 border border-red-200 text-red-700 text-sm font-semibold rounded-2xl px-5 py-3.5 flex items-center gap-2">
        <i class="fa-solid fa-circle-exclamation text-red-500"></i> {{ session('error') }}
    </div>
    @endif

    <!-- Header Banner -->
    <div class="relative bg-gradient-to-r from-amber-600 via-amber-700 to-sqr-green text-white rounded-3xl p-8 shadow-xl overflow-hidden">
        <div class="absolute -top-8 -right-8 w-48 h-48 bg-white/5 rounded-full"></div>
        <div class="absolute -bottom-10 -left-10 w-52 h-52 bg-black/10 rounded-full"></div>
        <div class="relative z-10 flex flex-col md:flex-row items-center gap-6">
            <div class="w-20 h-20 rounded-2xl bg-white/20 border-2 border-white/40 flex items-center justify-center text-4xl shrink-0">
                📜
            </div>
            <div class="text-center md:text-left">
                <div class="inline-flex items-center gap-2 bg-white/20 px-3 py-1 rounded-full text-xs font-black uppercase tracking-wider mb-2">
                    <i class="fa-solid fa-file-signature"></i> Surat Rekomendasi Resmi
                </div>
                <h1 class="font-title font-black text-2xl">{{ $santri->full_name }}</h1>
                <p class="text-white/70 text-sm mt-1">{{ $santri->sqrClass?->name ?? 'Kelas SQR' }} · NIS: {{ $santri->nis }}</p>
                <p class="text-white/60 text-xs mt-2">Yayasan Bina Cahaya Ilmu Rabbani · Saung Quran Rabbani</p>
            </div>
            <div class="md:ml-auto text-center">
                <div class="text-5xl font-black">{{ round($summary['percentage']) }}%</div>
                <p class="text-white/60 text-xs mt-1">Capaian Hafalan</p>
            </div>
        </div>
    </div>

    @if($santri->isEligibleForRecommendation())
    <div class="bg-gradient-to-r from-amber-500 via-sqr-orange to-amber-600 text-white rounded-3xl p-6 shadow-xl border border-amber-300/40 relative overflow-hidden flex flex-col md:flex-row items-center justify-between gap-4">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 rounded-2xl bg-white/20 text-white flex items-center justify-center text-3xl font-bold shrink-0 envelope-shake">
                ✉️
            </div>
            <div>
                <span class="bg-white/20 text-white font-black text-[10px] px-3 py-1 rounded-full uppercase tracking-wider">
                    🎉 Surat Rekomendasi Resmi Siap Diunduh
                </span>
                <h3 class="font-title font-black text-lg text-white mt-1">Selamat! Ananda Berhak Mendapatkan Surat Rekomendasi SQR</h3>
                <p class="text-xs text-white/90">Klik tombol di samping untuk membaca pesan kejutan ucapan dari Admin!</p>
            </div>
        </div>
        <button type="button" onclick="openSurpriseModal()"
                class="px-6 py-3 rounded-2xl bg-white text-sqr-dark hover:bg-amber-50 font-title font-black text-xs transition shadow-lg shrink-0 flex items-center gap-2">
            <i class="fa-solid fa-envelope-open-text text-sqr-orange text-sm"></i> Buka Surat Kejutan ✉️
        </button>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Left: Info & Actions -->
        <div class="space-y-4">
            <div class="bg-white rounded-3xl p-5 shadow-sm border border-gray-100 space-y-4">
                <h3 class="font-title font-bold text-sm text-sqr-green">📊 Ringkasan Pencapaian</h3>
                <div class="grid grid-cols-2 gap-3 text-center">
                    <div class="bg-amber-50 border border-amber-200 rounded-2xl p-3">
                        <p class="text-2xl font-black text-amber-700">{{ round($summary['percentage']) }}%</p>
                        <p class="text-[9px] text-amber-600 font-bold">Capaian Hafalan</p>
                    </div>
                    <div class="bg-sqr-bg rounded-2xl p-3">
                        <p class="text-2xl font-black text-sqr-green">{{ $summary['total_juz'] }}</p>
                        <p class="text-[9px] text-gray-500 font-bold">Juz Dihafal</p>
                    </div>
                    <div class="bg-sqr-bg rounded-2xl p-3">
                        <p class="text-2xl font-black text-blue-600">{{ $summary['tahfiz_sessions'] }}</p>
                        <p class="text-[9px] text-gray-500 font-bold">Sesi Tahfiz</p>
                    </div>
                    <div class="bg-sqr-bg rounded-2xl p-3">
                        <p class="text-2xl font-black text-purple-600">{{ $summary['attendance_streak'] ?? 0 }} Hari</p>
                        <p class="text-[9px] text-gray-500 font-bold">Streak Rajin</p>
                    </div>
                </div>
            </div>

            <!-- Eligibility & Download -->
            @php
                $recTarget = $santri->recommendation_target;
                $canRec    = $santri->isEligibleForRecommendation();
                $ustadzSig = $lastUstadz?->signature_url ?? ($orgSettings['ustadz_signature_url'] ?? null);
            @endphp
            <div class="bg-white rounded-3xl p-5 shadow-sm border border-gray-100 space-y-3">
                <h3 class="font-title font-bold text-sm text-sqr-green">📜 Status Surat Rekomendasi</h3>

                <div class="w-full bg-gray-100 rounded-full h-3 overflow-hidden">
                    <div class="h-3 rounded-full {{ $canRec ? 'bg-amber-500' : 'bg-gray-300' }} transition-all" style="width: {{ min(100, ($summary['percentage'] / $recTarget) * 100) }}%"></div>
                </div>
                <p class="text-xs text-gray-500">Target: <strong>{{ $recTarget }}%</strong> · Capaian: <strong>{{ round($summary['percentage']) }}%</strong></p>

                @if($canRec)
                <div class="bg-amber-50 border border-amber-200 rounded-2xl p-3 text-center">
                    <i class="fa-solid fa-circle-check text-amber-500 text-xl mb-1 block"></i>
                    <p class="font-bold text-amber-800 text-xs">Ananda memenuhi syarat rekomendasi!</p>
                </div>
                <a href="{{ route('wali.recommendation.download', $santri) }}" class="block w-full bg-amber-500 hover:bg-amber-600 text-white font-title font-bold py-3 rounded-2xl transition text-center flex items-center justify-center gap-2 shadow-sm">
                    <i class="fa-solid fa-file-pdf text-lg"></i> Download Surat Rekomendasi PDF
                </a>
                @else
                <div class="bg-red-50 border border-red-200 rounded-2xl p-3 text-center">
                    <i class="fa-solid fa-lock text-red-500 text-xl mb-1 block"></i>
                    <p class="font-bold text-red-800 text-xs">Belum Memenuhi Syarat (Terkunci)</p>
                    <p class="text-[10px] text-red-600 mt-1">Perlu {{ max(0, $recTarget - round($summary['percentage'])) }}% lagi untuk membuka dokumen resmi ini</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Right: Preview Card -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden relative">
                <div class="bg-gradient-to-r from-amber-600 to-sqr-green px-6 py-4 flex items-center justify-between">
                    <h3 class="font-title font-bold text-white text-sm flex items-center gap-2">
                        <i class="fa-solid fa-scroll text-white/80"></i>
                        Preview Surat Rekomendasi
                    </h3>
                    @if($canRec)
                    <a href="{{ route('wali.recommendation.download', $santri) }}" class="bg-white text-amber-700 font-bold text-xs px-4 py-2 rounded-xl transition hover:bg-amber-50 flex items-center gap-1.5 shadow-sm">
                        <i class="fa-solid fa-download"></i> Download PDF
                    </a>
                    @endif
                </div>

                <div class="p-6 relative">
                    @if(!$canRec)
                    <div class="absolute inset-0 z-50 bg-gray-900/60 backdrop-blur-md flex flex-col items-center justify-center p-6 text-center text-white unselectable">
                        <div class="relative z-10 max-w-md bg-sqr-dark/90 border-2 border-red-500/80 rounded-3xl p-6 shadow-2xl space-y-4">
                            <div class="w-16 h-16 rounded-2xl bg-red-500/20 border-2 border-red-500 text-red-400 flex items-center justify-center text-3xl mx-auto shadow-inner">
                                <i class="fa-solid fa-lock"></i>
                            </div>
                            <div>
                                <span class="bg-red-500 text-white text-[10px] font-black px-3 py-1 rounded-full uppercase tracking-wider">
                                    🔒 PREVIEW DIBLOKIR / DILINDUNGI
                                </span>
                                <h4 class="font-title font-black text-lg text-white mt-2">DOKUMEN BELUM BISA DILIHAT</h4>
                                <p class="text-xs text-gray-300 mt-1 leading-relaxed">
                                    Ananda <strong>{{ $santri->full_name }}</strong> belum mencapai target hafalan minimum (<strong>{{ $recTarget }}%</strong>). Dokumen rekomendasi resmi ini akan terbuka otomatis begitu target tercapai.
                                </p>
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="border-2 border-gray-200 rounded-2xl p-8 bg-white text-black space-y-4 shadow-sm text-sm {{ !$canRec ? 'filter blur-[4px] pointer-events-none' : '' }}">
                        <div class="flex items-center justify-between pb-3 border-b-4 border-black">
                            <div class="w-1/6">
                                @if(!empty($orgSettings['organization_logo_url']))
                                <img src="{{ $orgSettings['organization_logo_url'] }}" class="max-h-16 object-contain" alt="SQR Logo">
                                @else
                                <div class="text-3xl">📖</div>
                                @endif
                            </div>
                            <div class="w-4/6 text-center leading-tight">
                                <p class="font-black text-base uppercase">YAYASAN BINA CAHAYA ILMU RABBANI</p>
                                <p class="font-black text-sm uppercase">SAUNG QURAN RABBANI</p>
                            </div>
                        </div>

                        <div class="text-center pt-2">
                            <h3 class="font-black text-lg underline uppercase">SURAT REKOMENDASI</h3>
                        </div>

                        <div class="text-xs leading-relaxed text-justify space-y-2 pt-1">
                            <p>
                                Bahwa yang bersangkutan adalah benar santri aktif di TPQ Saung Quran Rabbani. Selama menempuh pendidikan di tempat kami yang bersangkutan menunjukkan akhlak yang baik, disiplin, dan kesungguhan dalam menuntut ilmu.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- MODAL SURAT KEJUTAN ADMIN & PARTICLES CONFETTI -->
<div id="surpriseModal" class="fixed inset-0 z-[9999] bg-black/80 backdrop-blur-md hidden flex items-center justify-center p-4">
    <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-lg overflow-hidden border-4 border-amber-400 space-y-0">
        <div class="bg-gradient-to-r from-amber-600 to-sqr-green text-white p-6 text-center relative">
            <button onclick="closeSurpriseModal()" class="absolute top-4 right-4 w-8 h-8 rounded-full bg-white/20 hover:bg-white/30 text-white flex items-center justify-center transition">
                <i class="fa-solid fa-xmark"></i>
            </button>
            <div class="w-16 h-16 rounded-2xl bg-white/20 border-2 border-white/40 text-white flex items-center justify-center text-3xl mx-auto shadow-lg mb-2">
                📜
            </div>
            <span class="bg-white/20 text-white font-black text-[10px] px-3 py-1 rounded-full uppercase tracking-wider inline-block">
                Surat Rekomendasi Resmi SQR
            </span>
            <h3 class="font-title font-black text-xl text-white mt-2">Assalamu'alaikum Warahmatullahi Wabarakatuh</h3>
        </div>

        <div class="p-6 space-y-4 text-xs leading-relaxed text-gray-700">
            <p><strong>Bismillahirrahmānirrahīm,</strong></p>
            <p>
                Selamat untuk Ananda <strong>{{ $santri->full_name }}</strong> yang telah resmi memenuhi kualifikasi pencapaian hafalan untuk mendapatkan <strong>Surat Rekomendasi Khusus</strong> dari Saung Quran Rabbani!
            </p>
            <div class="p-4 rounded-2xl bg-amber-50 border border-amber-200 text-center">
                <div class="font-title font-black text-base text-amber-800">{{ $santri->full_name }}</div>
                <div class="text-[11px] text-amber-700 font-bold mt-0.5">Siap Melanjutkan Pendidikan ke Jenjang Lebih Tinggi</div>
            </div>
            <p>
                Surat ini merupakan bukti otentik rekomendasi dari Pembina & Ustadz Pengampu untuk mendukung kelulusan dan pendaftaran sekolah lanjutan.
            </p>
        </div>

        <div class="p-5 border-t border-gray-100 bg-gray-50 flex justify-end gap-3">
            <button type="button" onclick="closeSurpriseModal()" class="px-5 py-2.5 rounded-xl bg-amber-600 hover:bg-amber-700 text-white font-bold text-xs transition shadow-md">
                Tutup & Lihat Dokumen 📜
            </button>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.9.2/dist/confetti.browser.min.js"></script>
<script>
    function triggerConfettiLeftRight() {
        if (typeof confetti === 'function') {
            confetti({
                particleCount: 80,
                angle: 60,
                spread: 55,
                origin: { x: 0, y: 0.7 }
            });
            confetti({
                particleCount: 80,
                angle: 120,
                spread: 55,
                origin: { x: 1, y: 0.7 }
            });
        }
    }

    function openSurpriseModal() {
        document.getElementById('surpriseModal').classList.remove('hidden');
        triggerConfettiLeftRight();
    }

    function closeSurpriseModal() {
        document.getElementById('surpriseModal').classList.add('hidden');
    }

    @if($santri->isEligibleForRecommendation())
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
            triggerConfettiLeftRight();
        }, 500);
    });
    @endif
</script>
@endpush
@endsection
