@extends('layouts.dashboard')

@section('title', 'Input Progress Hafalan - ' . $santri->full_name)

@push('styles')
<style>
    .ts-control {
        background-color: #f9fafb !important;
        border: 1px solid #e5e7eb !important;
        border-radius: 0.75rem !important;
        padding: 0.65rem 0.85rem !important;
        font-size: 0.75rem !important;
        box-shadow: none !important;
    }
    .ts-control.focus {
        border-color: #e67e22 !important;
        box-shadow: 0 0 0 2px rgba(230, 126, 34, 0.2) !important;
    }
    .ts-dropdown {
        position: absolute !important;
        background-color: #ffffff !important;
        border: 1px solid #e5e7eb !important;
        border-radius: 0.85rem !important;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.2), 0 8px 10px -6px rgba(0, 0, 0, 0.1) !important;
        z-index: 9999 !important;
        padding: 0.35rem !important;
        margin-top: 4px !important;
    }
    .ts-dropdown .option {
        padding: 0.6rem 0.85rem !important;
        font-size: 0.75rem !important;
        border-radius: 0.5rem !important;
        color: #1f2937 !important;
        background-color: #ffffff !important;
    }
    .ts-dropdown .option.active, .ts-dropdown .option:hover {
        background-color: #f0f8d3 !important;
        color: #2d4a22 !important;
        font-weight: 700 !important;
    }
</style>
@endpush

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    @if(session('success'))
    <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-bold flex items-center justify-between shadow-xs">
        <div class="flex items-center gap-2">
            <i class="fa-solid fa-circle-check text-emerald-500 text-base"></i>
            <span>{{ session('success') }}</span>
        </div>
    </div>
    @endif

    @if(session('error'))
    <div class="p-4 rounded-2xl bg-red-50 border border-red-200 text-red-800 text-xs font-bold flex items-center justify-between shadow-xs">
        <div class="flex items-center gap-2">
            <i class="fa-solid fa-triangle-exclamation text-red-500 text-base"></i>
            <span>{{ session('error') }}</span>
        </div>
    </div>
    @endif

    @if(!$canInputProgress)
    <div class="p-5 rounded-3xl bg-amber-50 border border-amber-200 text-amber-900 shadow-sm flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-2xl bg-amber-100 text-amber-700 flex items-center justify-center font-bold text-xl shrink-0">
                <i class="fa-solid fa-lock"></i>
            </div>
            <div>
                <h4 class="font-bold text-sm text-amber-900">Perhatian: Santri Belum Di-absen Hadir Hari Ini</h4>
                <p class="text-xs text-amber-800 mt-0.5">Status hari ini: <strong class="uppercase">{{ $todayStatus }}</strong>. Harap lakukan presensi kehadiran santri terlebih dahulu.</p>
            </div>
        </div>
        <a href="{{ route('ustadz.attendance.index', ['class_id' => $santri->class_id]) }}"
           class="px-4 py-2.5 rounded-2xl bg-amber-600 hover:bg-amber-700 text-white font-bold text-xs transition shadow-sm shrink-0 flex items-center gap-1.5">
            <i class="fa-solid fa-clipboard-user"></i> Isi Absensi Sekarang →
        </a>
    </div>
    @endif

    <!-- Top Navigation & Breadcrumb -->
    <div class="flex items-center justify-between">
        <a href="{{ route('ustadz.progress.index') }}" class="inline-flex items-center gap-2 text-xs font-bold text-sqr-green bg-white hover:bg-sqr-bg px-4 py-2.5 rounded-2xl shadow-sm border border-gray-200 transition">
            <i class="fa-solid fa-arrow-left text-sqr-orange"></i> Kembali ke Daftar Santri
        </a>
        <span class="text-xs text-gray-500 font-semibold">NIS: <strong class="text-gray-800">{{ $santri->nis }}</strong></span>
    </div>

    <!-- SANTRI HERO SUMMARY CARD -->
    <div class="bg-gradient-to-r from-sqr-dark via-sqr-green to-[#2d4a22] text-white rounded-3xl p-6 shadow-xl border border-white/10 relative overflow-hidden">
        <div class="absolute -right-10 -bottom-10 opacity-10 text-9xl pointer-events-none">
            <i class="fa-solid fa-book-quran"></i>
        </div>
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6 relative z-10">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 rounded-2xl bg-sqr-orange/20 border-2 border-sqr-orange flex items-center justify-center text-sqr-orange font-black text-2xl shadow-lg shrink-0">
                    {{ strtoupper(substr($santri->full_name, 0, 1)) }}
                </div>
                <div>
                    <div class="flex items-center gap-2 flex-wrap">
                        <span class="bg-sqr-orange text-white text-[9px] font-black px-2.5 py-0.5 rounded-full uppercase tracking-wider">
                            {{ $santri->sqrClass?->name ?? 'Tanpa Kelas' }}
                        </span>
                        @if($santri->isEligibleForCertificate())
                        <span class="bg-amber-400 text-sqr-dark text-[9px] font-black px-2.5 py-0.5 rounded-full uppercase tracking-wider flex items-center gap-1">
                            <i class="fa-solid fa-award"></i> Lulus 30 Juz
                        </span>
                        @endif
                    </div>
                    <h2 class="font-title font-black text-xl sm:text-2xl text-sqr-bg mt-1">{{ $santri->full_name }}</h2>
                    <p class="text-xs text-sqr-light-green mt-0.5">
                        Wali: <strong>{{ $santri->parent_name ?? '-' }}</strong> · HP: <strong>{{ $santri->phone ?? '-' }}</strong>
                    </p>
                </div>
            </div>

            <!-- Progress Meter Widget -->
            <div class="w-full md:w-64 bg-black/30 backdrop-blur-md p-4 rounded-2xl border border-white/10 shrink-0">
                <div class="flex justify-between items-center text-xs mb-1.5 font-bold">
                    <span class="text-sqr-light-green"><i class="fa-solid fa-chart-line text-sqr-orange mr-1"></i> Target Hafalan</span>
                    <span class="text-sqr-orange font-black text-sm">{{ $totalJuz }} / 30 Juz</span>
                </div>
                <div class="w-full bg-white/20 h-3 rounded-full overflow-hidden p-0.5">
                    <div class="bg-gradient-to-r from-sqr-orange to-amber-400 h-full rounded-full transition-all duration-500" style="width: {{ max(4, $progressPct) }}%;"></div>
                </div>
                <div class="flex justify-between items-center text-[10px] text-gray-300 mt-1.5 font-semibold">
                    <span>Capaian: {{ $progressPct }}%</span>
                    <span>Sisa: {{ max(0, 30 - $totalJuz) }} Juz</span>
                </div>
            </div>
        </div>
    </div>

    <!-- FORM INPUT PROGRESS -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-gray-100 space-y-6">
        <div class="flex items-center justify-between border-b pb-4">
            <div>
                <h3 class="font-title font-bold text-lg text-sqr-green flex items-center gap-2">
                    <i class="fa-solid fa-pen-to-square text-sqr-orange"></i> Formulir Catat Progress Hafalan
                </h3>
                <p class="text-xs text-gray-500 mt-0.5">Isikan detail setoran hafalan, tahsin, atau murojaah santri</p>
            </div>
            @if($lastProgress)
            <div class="hidden sm:block text-right bg-sqr-bg/50 px-3.5 py-1.5 rounded-xl border border-sqr-green/10 text-xs">
                <p class="text-[10px] text-gray-400 font-semibold">Setoran Terakhir ({{ $lastProgress->date?->format('d M') }}):</p>
                <p class="font-bold text-sqr-green">{{ $lastProgress->type }} — {{ $lastProgress->materi_summary }}</p>
            </div>
            @endif
        </div>

        <form method="POST" action="{{ route('ustadz.progress.store') }}" id="progressForm" class="space-y-6">
            @csrf
            <input type="hidden" name="santri_id" value="{{ $santri->id }}">

            <!-- 1. PILIH JENIS SETORAN -->
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                    1. Pilih Jenis Setoran <span class="text-red-500">*</span>
                </label>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <label class="cursor-pointer group">
                        <input type="radio" name="type" value="Tahfiz" {{ old('type', 'Tahfiz') === 'Tahfiz' ? 'checked' : '' }} class="sr-only peer">
                        <div class="p-4 rounded-2xl border-2 border-gray-200 peer-checked:border-emerald-600 peer-checked:bg-emerald-50/50 hover:border-emerald-300 transition flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold text-lg group-hover:scale-105 transition">
                                <i class="fa-solid fa-book-bookmark"></i>
                            </div>
                            <div>
                                <p class="font-title font-bold text-xs text-gray-800">Tahfiz</p>
                                <p class="text-[10px] text-gray-500">Hafalan Ayat Baru</p>
                            </div>
                        </div>
                    </label>

                    <label class="cursor-pointer group">
                        <input type="radio" name="type" value="Tahsin" {{ old('type') === 'Tahsin' ? 'checked' : '' }} class="sr-only peer">
                        <div class="p-4 rounded-2xl border-2 border-gray-200 peer-checked:border-blue-600 peer-checked:bg-blue-50/50 hover:border-blue-300 transition flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center font-bold text-lg group-hover:scale-105 transition">
                                <i class="fa-solid fa-spell-check"></i>
                            </div>
                            <div>
                                <p class="font-title font-bold text-xs text-gray-800">Tahsin</p>
                                <p class="text-[10px] text-gray-500">Perbaikan Bacaan</p>
                            </div>
                        </div>
                    </label>

                    <label class="cursor-pointer group">
                        <input type="radio" name="type" value="Murojaah" {{ old('type') === 'Murojaah' ? 'checked' : '' }} class="sr-only peer">
                        <div class="p-4 rounded-2xl border-2 border-gray-200 peer-checked:border-amber-600 peer-checked:bg-amber-50/50 hover:border-amber-300 transition flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center font-bold text-lg group-hover:scale-105 transition">
                                <i class="fa-solid fa-rotate-right"></i>
                            </div>
                            <div>
                                <p class="font-title font-bold text-xs text-gray-800">Murojaah</p>
                                <p class="text-[10px] text-gray-500">Pengulangan Hafalan</p>
                            </div>
                        </div>
                    </label>
                </div>
            </div>

            <!-- 2. TANGGAL & CAKUPAN JUZ -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-2">
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Tanggal Sesi <span class="text-red-500">*</span></label>
                    <input type="date" name="date" value="{{ old('date', today()->format('Y-m-d')) }}" required
                           class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-xs outline-none focus:border-sqr-orange focus:bg-white transition font-semibold">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Juz Al-Qur'an (1–30)</label>
                    <select name="juz_start" id="juz_start" onchange="onJuzChange()" class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-xs outline-none focus:border-sqr-orange focus:bg-white transition font-bold text-sqr-green">
                        <option value="">-- Pilih Juz --</option>
                        @for($j = 1; $j <= 30; $j++)
                        <option value="{{ $j }}" {{ old('juz_start', $lastProgress?->juz_start) == $j ? 'selected' : '' }}>Juz {{ $j }}</option>
                        @endfor
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Juz Sampai (Multi-Juz)</label>
                    <select name="juz_end" id="juz_end" class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-xs outline-none focus:border-sqr-orange focus:bg-white transition">
                        <option value="">-- Sama dengan Juz Awal --</option>
                        @for($j = 1; $j <= 30; $j++)
                        <option value="{{ $j }}" {{ old('juz_end', $lastProgress?->juz_end) == $j ? 'selected' : '' }}>Juz {{ $j }}</option>
                        @endfor
                    </select>
                </div>
            </div>

            <!-- 3. PILIH SURAH & RENTANG AYAT DINAMIS -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="sm:col-span-2">
                    <div class="flex items-center justify-between mb-1">
                        <label class="block text-xs font-bold text-gray-700">Surah yang Disetorkan</label>
                        <span class="text-[10px] text-sqr-orange font-bold" id="surahCountHint">Pilih Juz untuk memfilter Surah</span>
                    </div>
                    <select id="surah_select" name="surah_memorized" onchange="onSurahChange()" class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-xs outline-none focus:border-sqr-orange font-bold text-gray-800">
                        <option value="">-- Pilih Surah --</option>
                        @foreach($surahList as $idx => $surah)
                        <option value="{{ $surah }}" {{ old('surah_memorized') === $surah ? 'selected' : '' }}>
                            {{ $idx + 1 }}. {{ $surah }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Ayat Mulai</label>
                        <input type="number" id="verse_start" name="verse_start" min="1" placeholder="Ayat 1" value="{{ old('verse_start') }}"
                               class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-xs outline-none focus:border-sqr-orange font-bold">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Ayat Selesai</label>
                        <input type="number" id="verse_end" name="verse_end" min="1" placeholder="Sampai" value="{{ old('verse_end') }}"
                               class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-xs outline-none focus:border-sqr-orange font-bold">
                    </div>
                </div>
            </div>

            <!-- 4. PREDIKAT / RATING PENILAIAN -->
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                    4. Predikat Kelancaran / Penilaian
                </label>
                <div class="grid grid-cols-3 gap-3">
                    <label class="cursor-pointer">
                        <input type="radio" name="rating" value="Mumtaz (Sangat Lancar)" checked class="sr-only peer">
                        <div class="p-3 rounded-xl border border-gray-200 text-center peer-checked:border-emerald-600 peer-checked:bg-emerald-50 peer-checked:text-emerald-800 hover:bg-gray-50 transition">
                            <p class="font-bold text-xs">⭐⭐⭐ Mumtaz</p>
                            <p class="text-[9px] text-gray-400">Sangat Lancar</p>
                        </div>
                    </label>

                    <label class="cursor-pointer">
                        <input type="radio" name="rating" value="Jayyid Jiddan (Lancar)" class="sr-only peer">
                        <div class="p-3 rounded-xl border border-gray-200 text-center peer-checked:border-blue-600 peer-checked:bg-blue-50 peer-checked:text-blue-800 hover:bg-gray-50 transition">
                            <p class="font-bold text-xs">⭐⭐ Jayyid Jiddan</p>
                            <p class="text-[9px] text-gray-400">Lancar</p>
                        </div>
                    </label>

                    <label class="cursor-pointer">
                        <input type="radio" name="rating" value="Jayyid (Perlu Murojaah)" class="sr-only peer">
                        <div class="p-3 rounded-xl border border-gray-200 text-center peer-checked:border-amber-600 peer-checked:bg-amber-50 peer-checked:text-amber-800 hover:bg-gray-50 transition">
                            <p class="font-bold text-xs">⭐ Jayyid</p>
                            <p class="text-[9px] text-gray-400">Perlu Murojaah</p>
                        </div>
                    </label>
                </div>
            </div>

            <!-- 5. CATATAN EVALUASI -->
            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">Catatan Evaluasi Pengajar (Opsional)</label>
                <textarea name="notes" rows="2"
                          class="w-full bg-gray-50 border border-gray-200 rounded-2xl p-3.5 text-xs outline-none focus:border-sqr-orange focus:bg-white transition resize-none"
                          placeholder="Contoh: Makhraj huruf 'Ain di ayat 12 sudah bagus, pertahankan tajwidnya...">{{ old('notes') }}</textarea>
            </div>

            <!-- SUBMIT BUTTON -->
            <div class="pt-3">
                <button type="submit" class="w-full bg-sqr-green hover:bg-sqr-dark text-white font-title font-bold text-sm py-4 rounded-2xl transition shadow-xl flex items-center justify-center gap-2 transform hover:-translate-y-0.5">
                    <i class="fa-solid fa-floppy-disk text-sqr-orange text-base"></i> Simpan Progress Hafalan Santri
                </button>
            </div>
        </form>
    </div>

    <!-- RIWAYAT 15 PROGRESS TERAKHIR SANTRI -->
    <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 space-y-4">
        <div class="flex items-center justify-between border-b pb-3">
            <h4 class="font-title font-bold text-sm text-sqr-green flex items-center gap-2">
                <i class="fa-solid fa-clock-rotate-left text-sqr-orange"></i> Riwayat Progress {{ $santri->full_name }}
            </h4>
            <span class="text-xs text-gray-400 font-semibold">Total {{ $recentProgress->count() }} Setoran Recorded</span>
        </div>

        <div class="space-y-3">
            @forelse($recentProgress as $pr)
            <div class="p-4 rounded-2xl border border-gray-100 bg-gray-50/50 hover:bg-white hover:shadow-md transition flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 text-xs">
                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center font-bold text-base shrink-0 shadow-sm
                        {{ $pr->type === 'Tahfiz' ? 'bg-emerald-100 text-emerald-700' : ($pr->type === 'Tahsin' ? 'bg-blue-100 text-blue-700' : 'bg-amber-100 text-amber-700') }}">
                        <i class="fa-solid {{ $pr->type === 'Tahfiz' ? 'fa-book-bookmark' : ($pr->type === 'Tahsin' ? 'fa-spell-check' : 'fa-rotate-right') }}"></i>
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="px-2.5 py-0.5 rounded-full text-[9px] font-bold uppercase
                                {{ $pr->type === 'Tahfiz' ? 'bg-emerald-100 text-emerald-800' : ($pr->type === 'Tahsin' ? 'bg-blue-100 text-blue-800' : 'bg-amber-100 text-amber-800') }}">
                                {{ $pr->type }}
                            </span>
                            <span class="text-gray-400 font-semibold text-[10px]">{{ $pr->date?->format('d M Y') }}</span>
                        </div>
                        <p class="font-bold text-gray-800 text-sm mt-1">{{ $pr->materi_summary }}</p>
                        @if($pr->notes)
                        <p class="text-xs text-gray-500 mt-0.5 leading-relaxed">{{ $pr->notes }}</p>
                        @endif
                    </div>
                </div>

                <div class="self-end sm:self-center shrink-0">
                    <form method="POST" action="{{ route('ustadz.progress.destroy', $pr) }}" onsubmit="return confirm('Hapus entri progress ini?')" class="inline">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-red-500 hover:text-red-700 font-bold text-xs bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-xl border border-red-200 transition">
                            <i class="fa-solid fa-trash-can mr-1"></i> Hapus
                        </button>
                    </form>
                </div>
            </div>
            @empty
            <div class="text-center py-8 text-gray-400 text-xs font-semibold">
                <i class="fa-solid fa-book-open text-3xl mb-2 block opacity-30"></i>
                Belum ada entri progress hafalan tercatat untuk santri ini.
            </div>
            @endforelse
        </div>
    </div>

</div>

@push('scripts')
<script>
    var juzMapData = @json($juzMap);
    var allSurahList = @json($surahList);

    function onJuzChange() {
        var juzVal = parseInt(document.getElementById('juz_start').value);
        var surahSelect = document.getElementById('surah_select');
        var hint = document.getElementById('surahCountHint');

        if (!juzVal || !juzMapData[juzVal]) {
            // Restore all surahs
            surahSelect.innerHTML = '<option value="">-- Pilih Surah --</option>';
            allSurahList.forEach(function(s, idx) {
                surahSelect.innerHTML += '<option value="' + s + '">' + (idx + 1) + '. ' + s + '</option>';
            });
            if (hint) hint.innerText = 'Menampilkan seluruh surah';
            return;
        }

        var surahsInJuz = juzMapData[juzVal];
        surahSelect.innerHTML = '<option value="">-- Pilih Surah di Juz ' + juzVal + ' --</option>';
        surahsInJuz.forEach(function(item) {
            surahSelect.innerHTML += '<option value="' + item.name + '" data-start="' + item.start_verse + '" data-end="' + item.end_verse + '">' +
                                     item.surah_no + '. Surah ' + item.name + ' (Ayat ' + item.start_verse + '-' + item.end_verse + ')</option>';
        });

        if (hint) hint.innerText = 'Di-filter: ' + surahsInJuz.length + ' Surah di Juz ' + juzVal;
        onSurahChange();
    }

    function onSurahChange() {
        var surahSelect = document.getElementById('surah_select');
        var selectedOpt = surahSelect.options[surahSelect.selectedIndex];

        if (selectedOpt && selectedOpt.dataset.start) {
            document.getElementById('verse_start').value = selectedOpt.dataset.start;
            document.getElementById('verse_end').value = selectedOpt.dataset.end;
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        if (document.getElementById('juz_start').value) {
            onJuzChange();
        }
    });
</script>
@endpush
@endsection
