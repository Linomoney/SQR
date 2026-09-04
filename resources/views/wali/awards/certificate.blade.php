@extends('layouts.dashboard')

@section('title', 'Sertifikat Hafalan – ' . $santri->full_name)

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

    <!-- Top Sub-Navigation Bar -->
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

    @if($errors->any())
    <div class="bg-red-50 border border-red-200 text-red-700 text-sm font-semibold rounded-2xl px-5 py-3.5 flex items-center gap-2">
        <i class="fa-solid fa-circle-exclamation text-red-500"></i> {{ $errors->first() }}
    </div>
    @endif

    @if(session('error'))
    <div class="bg-red-50 border border-red-200 text-red-700 text-sm font-semibold rounded-2xl px-5 py-3.5 flex items-center gap-2">
        <i class="fa-solid fa-circle-exclamation text-red-500"></i> {{ session('error') }}
    </div>
    @endif

    <!-- Hero Header -->
    <div class="relative bg-gradient-to-r from-sqr-green via-sqr-dark to-sqr-green text-white rounded-3xl p-8 shadow-xl overflow-hidden">
        <div class="absolute -top-8 -right-8 w-48 h-48 bg-white/5 rounded-full"></div>
        <div class="absolute -bottom-10 -left-10 w-52 h-52 bg-sqr-orange/10 rounded-full"></div>

        <div class="relative z-10 flex flex-col md:flex-row items-center md:items-start gap-6">
            <div class="w-20 h-20 rounded-2xl bg-sqr-orange/20 border-2 border-sqr-orange flex items-center justify-center text-4xl shrink-0 shadow-inner">
                🎓
            </div>
            <div class="text-center md:text-left">
                <div class="inline-flex items-center gap-2 bg-sqr-orange/20 px-3 py-1 rounded-full text-xs font-black text-sqr-orange uppercase tracking-wider mb-2">
                    <i class="fa-solid fa-star"></i> Penghargaan Hafalan
                </div>
                <h1 class="font-title font-black text-2xl">{{ $santri->full_name }}</h1>
                <p class="text-white/70 text-sm mt-1">{{ $santri->sqrClass?->name ?? 'Kelas SQR' }} · NIS: {{ $santri->nis }}</p>
                <p class="text-sqr-light-green text-xs mt-2">{{ $summary['total_juz'] }} dari {{ $summary['target_juz'] }} Juz Al-Qur'an Al-Karim</p>
            </div>
            <div class="md:ml-auto text-center">
                <div class="text-5xl font-black text-sqr-orange">{{ round($summary['percentage']) }}%</div>
                <p class="text-white/60 text-xs mt-1">Capaian Hafalan</p>
            </div>
        </div>
    </div>

    <!-- BANNER SURAT KEJUTAN ADMIN JIKA CAPAI TARGET -->
    @if($santri->isEligibleForCertificate())
    <div class="bg-gradient-to-r from-amber-500 via-sqr-orange to-amber-600 text-white rounded-3xl p-6 shadow-xl border border-amber-300/40 relative overflow-hidden flex flex-col md:flex-row items-center justify-between gap-4">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 rounded-2xl bg-white/20 text-white flex items-center justify-center text-3xl font-bold shrink-0 envelope-shake">
                ✉️
            </div>
            <div>
                <span class="bg-white/20 text-white font-black text-[10px] px-3 py-1 rounded-full uppercase tracking-wider">
                    🎉 Surat Apresiasi Kejutan dari Admin & Pembina Yayasan
                </span>
                <h3 class="font-title font-black text-lg text-white mt-1">Selamat! Ananda Berhasil Mencapai Target Sertifikat</h3>
                <p class="text-xs text-white/90">Klik tombol di samping untuk membuka surat ucapan dan klaim kejutan apresiasi!</p>
            </div>
        </div>
        <button type="button" onclick="openSurpriseModal()"
                class="px-6 py-3 rounded-2xl bg-white text-sqr-dark hover:bg-amber-50 font-title font-black text-xs transition shadow-lg shrink-0 flex items-center gap-2">
            <i class="fa-solid fa-envelope-open-text text-sqr-orange text-sm"></i> Buka Surat Kejutan ✉️
        </button>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Left: Status & Eligibility -->
        <div class="lg:col-span-1 space-y-4">

            <!-- Progress Bars -->
            <div class="bg-white rounded-3xl p-5 shadow-sm border border-gray-100 space-y-4">
                <h3 class="font-title font-bold text-sm text-sqr-green">📊 Statistik Hafalan & Presensi</h3>
                <div>
                    <div class="flex justify-between text-xs mb-1.5">
                        <span class="font-bold text-gray-700">Pencapaian Total</span>
                        <span class="font-black text-sqr-orange">{{ $summary['total_juz'] }}/{{ $summary['target_juz'] }} Juz</span>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-3 overflow-hidden">
                        <div class="h-3 rounded-full bg-gradient-to-r from-sqr-green to-sqr-orange transition-all duration-1000" style="width: {{ min(100, $summary['percentage']) }}%"></div>
                    </div>
                </div>
                <div class="grid grid-cols-3 gap-3 text-center">
                    <div class="bg-sqr-bg rounded-xl p-2">
                        <p class="font-black text-sqr-green text-lg">{{ $summary['total_sessions'] }}</p>
                        <p class="text-[9px] text-gray-400 font-bold">Total Sesi</p>
                    </div>
                    <div class="bg-sqr-bg rounded-xl p-2">
                        <p class="font-black text-blue-600 text-lg">{{ $summary['tahfiz_sessions'] }}</p>
                        <p class="text-[9px] text-gray-400 font-bold">Tahfiz</p>
                    </div>
                    <div class="bg-sqr-bg rounded-xl p-2">
                        <p class="font-black text-purple-600 text-lg">{{ $summary['attendance_streak'] ?? 0 }} Hari</p>
                        <p class="text-[9px] text-gray-400 font-bold">Streak Rajin</p>
                    </div>
                </div>
            </div>

            <!-- Certificate Eligibility Card -->
            @php
                $certTarget = $santri->certificate_target;
                $recTarget  = $santri->recommendation_target;
                $canCert    = $santri->isEligibleForCertificate();
                $canRec     = $santri->isEligibleForRecommendation();
            @endphp
            <div class="bg-white rounded-3xl p-5 shadow-sm border border-gray-100 space-y-3">
                <h3 class="font-title font-bold text-sm text-sqr-green">🏆 Kelayakan Penghargaan</h3>

                <!-- Certificate -->
                <div class="rounded-2xl p-4 border-2 {{ $canCert ? 'bg-emerald-50 border-emerald-300' : 'bg-gray-50 border-gray-200' }}">
                    <div class="flex items-center justify-between mb-2">
                        <div class="flex items-center gap-2">
                            <i class="fa-solid fa-graduation-cap text-{{ $canCert ? 'emerald-600' : 'gray-400' }}"></i>
                            <span class="font-bold text-xs text-{{ $canCert ? 'emerald-800' : 'gray-500' }}">Sertifikat Tahfiz</span>
                        </div>
                        <span class="text-[10px] font-black px-2 py-0.5 rounded-full {{ $canCert ? 'bg-emerald-600 text-white' : 'bg-gray-200 text-gray-500' }}">
                            {{ $canCert ? 'LAYAK' : 'BELUM' }}
                        </span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-1.5 overflow-hidden mb-2">
                        <div class="h-1.5 rounded-full {{ $canCert ? 'bg-emerald-500' : 'bg-gray-300' }}" style="width: {{ min(100, ($summary['percentage'] / $certTarget) * 100) }}%"></div>
                    </div>
                    <p class="text-[10px] text-gray-500">Target: {{ $certTarget }}% · Capaian: {{ round($summary['percentage']) }}%</p>
                    @if($canCert)
                    <a href="{{ route('wali.certificate.download', $santri) }}" class="mt-2.5 block w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs py-2 rounded-xl text-center transition">
                        <i class="fa-solid fa-download mr-1"></i> Download Sertifikat PDF
                    </a>
                    @endif
                </div>

                <!-- Recommendation -->
                <div class="rounded-2xl p-4 border-2 {{ $canRec ? 'bg-amber-50 border-amber-300' : 'bg-gray-50 border-gray-200' }}">
                    <div class="flex items-center justify-between mb-2">
                        <div class="flex items-center gap-2">
                            <i class="fa-solid fa-file-signature text-{{ $canRec ? 'amber-600' : 'gray-400' }}"></i>
                            <span class="font-bold text-xs text-{{ $canRec ? 'amber-800' : 'gray-500' }}">Surat Rekomendasi</span>
                        </div>
                        <span class="text-[10px] font-black px-2 py-0.5 rounded-full {{ $canRec ? 'bg-amber-600 text-white' : 'bg-gray-200 text-gray-500' }}">
                            {{ $canRec ? 'LAYAK' : 'BELUM' }}
                        </span>
                    </div>
                    <p class="text-[10px] text-gray-500">Target: {{ $recTarget }}% · Capaian: {{ round($summary['percentage']) }}%</p>
                    <a href="{{ route('wali.recommendation.show', $santri) }}" class="mt-2.5 block w-full bg-amber-500 hover:bg-amber-600 text-white font-bold text-xs py-2 rounded-xl text-center transition">
                        <i class="fa-solid fa-scroll mr-1"></i> Lihat Surat Rekomendasi
                    </a>
                </div>
            </div>
        </div>

        <!-- Right: Certificate Preview Card -->
        <div class="lg:col-span-2 space-y-4">
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden relative">
                <div class="bg-sqr-green px-6 py-4 flex items-center justify-between">
                    <h3 class="font-title font-bold text-white text-sm flex items-center gap-2">
                        <i class="fa-solid fa-certificate text-sqr-orange"></i>
                        Preview Sertifikat Tahfiz
                    </h3>
                    @if($canCert)
                    <a href="{{ route('wali.certificate.download', $santri) }}" class="bg-sqr-orange hover:bg-orange-600 text-white font-bold text-xs px-4 py-2 rounded-xl transition flex items-center gap-1.5 shadow-sm">
                        <i class="fa-solid fa-file-pdf"></i> Download PDF
                    </a>
                    @endif
                </div>

                <div class="p-6 relative">
                    @if(!$canCert)
                    <div class="absolute inset-0 z-50 bg-gray-900/60 backdrop-blur-md flex flex-col items-center justify-center p-6 text-center text-white unselectable">
                        <div class="relative z-10 max-w-md bg-sqr-dark/90 border-2 border-red-500/80 rounded-3xl p-6 shadow-2xl space-y-4">
                            <div class="w-16 h-16 rounded-2xl bg-red-500/20 border-2 border-red-500 text-red-400 flex items-center justify-center text-3xl mx-auto shadow-inner">
                                <i class="fa-solid fa-lock"></i>
                            </div>
                            <div>
                                <span class="bg-red-500 text-white text-[10px] font-black px-3 py-1 rounded-full uppercase tracking-wider">
                                    🔒 PREVIEW SERTIFIKAT DIBLOKIR
                                </span>
                                <h4 class="font-title font-black text-lg text-white mt-2">SERTIFIKAT BELUM BISA DILIHAT</h4>
                                <p class="text-xs text-gray-300 mt-1 leading-relaxed">
                                    Ananda <strong>{{ $santri->full_name }}</strong> belum mencapai target hafalan minimum sertifikat (<strong>{{ $certTarget }}%</strong>). Sertifikat resmi akan terbuka otomatis begitu target tercapai.
                                </p>
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="rounded-2xl overflow-hidden shadow-lg border-4 border-sqr-green {{ !$canCert ? 'filter blur-[4px] pointer-events-none' : '' }}"
                         style="background: linear-gradient(160deg, #1a3a0f 0%, #2d4a22 50%, #1a3a0f 100%);">
                        <div class="text-center px-8 py-6">
                            <p class="text-[10px] tracking-widest text-green-300 uppercase font-bold mb-1">
                                {{ $orgSettings['organization_name'] ?? 'Saung Quran Rabbani' }}
                            </p>
                            <h2 class="text-3xl font-black text-white tracking-widest uppercase mb-1">SERTIFIKAT TAHFIZ</h2>
                            <p class="text-green-300/70 text-xs italic tracking-widest">Penghargaan Pencapaian Hafalan Al-Qur'an Al-Karim</p>
                        </div>

                        <div class="mx-8 h-px bg-gradient-to-r from-transparent via-yellow-400 to-transparent"></div>

                        <div class="px-8 py-5 text-center">
                            <p class="text-xs text-white/50 tracking-widest uppercase mb-3">Diberikan dengan penuh kebanggaan kepada</p>
                            <h3 class="text-2xl font-black text-white mb-2 inline-block border-b-2 border-yellow-400 pb-2 px-6">{{ $santri->full_name }}</h3>

                            <p class="text-white/60 text-xs mt-3 mb-4">
                                Telah berhasil menyelesaikan Program Tahfiz Al-Qur'an Karim di<br>
                                <strong class="text-white">{{ $orgSettings['organization_name'] ?? 'Saung Quran Rabbani' }}</strong>
                            </p>

                            <div class="inline-block bg-white/10 border-2 border-yellow-400 rounded-2xl px-10 py-4 mb-4">
                                <p class="text-4xl font-black text-yellow-400">{{ $summary['total_juz'] }} JUZ</p>
                                <p class="text-green-300 text-xs tracking-widest">Al-Qur'an Al-Karim</p>
                            </div>
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
        <div class="bg-gradient-to-r from-sqr-green to-sqr-dark text-white p-6 text-center relative">
            <button onclick="closeSurpriseModal()" class="absolute top-4 right-4 w-8 h-8 rounded-full bg-white/20 hover:bg-white/30 text-white flex items-center justify-center transition">
                <i class="fa-solid fa-xmark"></i>
            </button>
            <div class="w-16 h-16 rounded-2xl bg-sqr-orange/30 border-2 border-sqr-orange text-white flex items-center justify-center text-3xl mx-auto shadow-lg mb-2">
                ✉️
            </div>
            <span class="bg-sqr-orange text-white font-black text-[10px] px-3 py-1 rounded-full uppercase tracking-wider inline-block">
                Surat Apresiasi Resmi Yayasan SQR
            </span>
            <h3 class="font-title font-black text-xl text-white mt-2">Assalamu'alaikum Warahmatullahi Wabarakatuh</h3>
        </div>

        <div class="p-6 space-y-4 text-xs leading-relaxed text-gray-700">
            <p><strong>Bismillahirrahmānirrahīm,</strong></p>
            <p>
                Alhamdulillah wa syukrulillah! Dengan bangga dan kebahagiaan mendalam, Pengurus & Pembina Yayasan <strong>Saung Quran Rabbani</strong> mengucapkan selamat kepada Ananda:
            </p>
            <div class="p-4 rounded-2xl bg-amber-50 border border-amber-200 text-center">
                <div class="font-title font-black text-base text-sqr-green">{{ $santri->full_name }}</div>
                <div class="text-[11px] text-sqr-orange font-bold mt-0.5">Telah Berhasil Mencapai {{ $summary['total_juz'] }} Juz Hafalan Al-Qur'an</div>
            </div>
            <p>
                Semoga hafalan Al-Qur'an yang telah disetorkan menjadi berkah, penerang kehidupan, serta mahkota kebanggaan bagi orang tua di akhirat kelak.
            </p>
            <div class="p-3.5 rounded-2xl bg-emerald-50 border border-emerald-200 flex items-center gap-3">
                <div class="text-2xl">🎁</div>
                <div>
                    <div class="font-bold text-emerald-900">Hadiah & Apresiasi Tambahan:</div>
                    <div class="text-[11px] text-emerald-700">Mushaf Al-Qur'an Tajwid Eksklusif & Sertifikat Resmi SQR</div>
                </div>
            </div>
        </div>

        <div class="p-5 border-t border-gray-100 bg-gray-50 flex justify-end gap-3">
            <button type="button" onclick="closeSurpriseModal()" class="px-5 py-2.5 rounded-xl bg-sqr-green hover:bg-sqr-dark text-white font-bold text-xs transition shadow-md">
                Tutup & Simpan Surat ❤️
            </button>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.9.2/dist/confetti.browser.min.js"></script>
<script>
    function triggerConfettiLeftRight() {
        if (typeof confetti === 'function') {
            // Left side burst
            confetti({
                particleCount: 80,
                angle: 60,
                spread: 55,
                origin: { x: 0, y: 0.7 }
            });
            // Right side burst
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

    @if($santri->isEligibleForCertificate())
    document.addEventListener('DOMContentLoaded', function() {
        // Auto trigger confetti on initial load if earned!
        setTimeout(function() {
            triggerConfettiLeftRight();
        }, 500);
    });
    @endif
</script>
@endpush
@endsection
