@extends('layouts.dashboard')

@section('title', 'Manajemen Penggajian & Slip Gaji Ustadz')

@section('content')
<div class="space-y-6">

    @if(session('success'))
    <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-bold flex items-center gap-2 shadow-xs">
        <i class="fa-solid fa-circle-check text-emerald-500 text-base"></i>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    <!-- Header Banner -->
    <div class="bg-gradient-to-r from-sqr-dark via-sqr-green to-sqr-dark text-white rounded-3xl p-6 sm:p-8 shadow-xl relative overflow-hidden flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
        <div class="flex items-center gap-4 relative z-10">
            <div class="w-14 h-14 rounded-2xl bg-sqr-orange/30 border-2 border-sqr-orange flex items-center justify-center text-sqr-orange font-bold text-3xl shadow-lg shrink-0">
                💰
            </div>
            <div>
                <span class="bg-white/20 text-white font-black text-[10px] px-3 py-1 rounded-full uppercase tracking-wider">
                    Sistem Penggajian & Honorarium SQR
                </span>
                <h1 class="font-title font-black text-xl sm:text-2xl text-white mt-1">Manajemen Penggajian Ustadz & Ustadzah</h1>
                <p class="text-xs text-white/80 mt-0.5">Kelola tarif mengajar fisik vs online, bonus admin, rincian slip gaji, & export rekapitulasi Excel</p>
            </div>
        </div>

        <div class="flex items-center gap-3 shrink-0 relative z-10">
            <a href="{{ route('admin.payroll.export', ['month' => $month, 'year' => $year]) }}"
               class="px-5 py-3 rounded-2xl bg-sqr-orange hover:bg-orange-600 text-white font-title font-bold text-xs transition shadow-lg flex items-center gap-2">
                <i class="fa-solid fa-file-excel text-base"></i> Export Rekap Excel/CSV 📊
            </a>
        </div>
    </div>

    <!-- TARIF & GPS SETTINGS CARD -->
    <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 space-y-4">
        <div class="flex items-center justify-between border-b pb-3">
            <h3 class="font-title font-bold text-sm text-sqr-green flex items-center gap-2">
                <i class="fa-solid fa-gears text-sqr-orange"></i> Pengaturan Tarif Honorarium & Lokasi Cabang Presensi SQR
            </h3>
            <a href="{{ route('admin.locations.index') }}" class="text-[11px] font-bold text-sqr-orange hover:underline flex items-center gap-1">
                <i class="fa-solid fa-map-location-dot"></i> 🏢 Kelola Detail Peta & Titik Cabang SQR →
            </a>
        </div>

        <form method="POST" action="{{ route('admin.payroll.settings') }}" class="space-y-4">
            @csrf @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Tarif Hadir Fisik / Hari *</label>
                    <div class="relative">
                        <span class="absolute left-3 top-2.5 text-xs text-gray-400 font-bold">Rp</span>
                        <input type="number" name="rate_hadir_fisik" value="{{ old('rate_hadir_fisik', $rateFisik) }}" required
                               class="w-full bg-gray-50 border border-gray-200 rounded-xl pl-9 pr-3 py-2 text-xs font-bold outline-none focus:border-sqr-orange">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Tarif Hadir Online / Hari *</label>
                    <div class="relative">
                        <span class="absolute left-3 top-2.5 text-xs text-gray-400 font-bold">Rp</span>
                        <input type="number" name="rate_hadir_online" value="{{ old('rate_hadir_online', $rateOnline) }}" required
                               class="w-full bg-gray-50 border border-gray-200 rounded-xl pl-9 pr-3 py-2 text-xs font-bold outline-none focus:border-sqr-orange">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Insentif Pengganti / Sesi *</label>
                    <div class="relative">
                        <span class="absolute left-3 top-2.5 text-xs text-gray-400 font-bold">Rp</span>
                        <input type="number" name="rate_substitute_bonus" value="{{ old('rate_substitute_bonus', $rateSubstitute) }}" required
                               class="w-full bg-gray-50 border border-gray-200 rounded-xl pl-9 pr-3 py-2 text-xs font-bold outline-none focus:border-sqr-orange">
                    </div>
                </div>
            </div>

            <!-- Pilih Lokasi SQR Berdasarkan Nama Cabang -->
            <div class="p-4 rounded-2xl bg-sqr-bg/50 border border-sqr-green/10 space-y-3">
                <div class="flex items-center justify-between">
                    <label class="block text-xs font-bold text-sqr-green">📍 Pilih Lokasi Cabang SQR Default untuk Presensi GPS:</label>
                    <span class="text-[10px] text-gray-500">Pilih dari nama lokasi yang sudah terdaftar</span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-4 gap-3">
                    <div class="sm:col-span-2">
                        <select id="locationSelect" onchange="autoFillLocationGps(this)" class="w-full bg-white border border-gray-200 rounded-xl p-2.5 text-xs font-bold text-gray-800 outline-none focus:border-sqr-orange">
                            <option value="">-- Pilih Nama Cabang SQR --</option>
                            @foreach($locations as $loc)
                            <option value="{{ $loc->id }}" data-lat="{{ $loc->latitude }}" data-lng="{{ $loc->longitude }}" data-radius="{{ $loc->radius_meters }}">
                                {{ $loc->name }} (Radius: {{ $loc->radius_meters }}m)
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <input type="text" name="sqr_lat" id="settingLat" value="{{ old('sqr_lat', $sqrLat) }}" required placeholder="Latitude"
                               class="w-full bg-white border border-gray-200 rounded-xl p-2.5 text-xs font-bold outline-none focus:border-sqr-orange">
                    </div>
                    <div>
                        <input type="text" name="sqr_lng" id="settingLng" value="{{ old('sqr_lng', $sqrLng) }}" required placeholder="Longitude"
                               class="w-full bg-white border border-gray-200 rounded-xl p-2.5 text-xs font-bold outline-none focus:border-sqr-orange">
                    </div>
                </div>

                <div class="flex items-center justify-between gap-3 pt-1">
                    <div class="flex items-center gap-2">
                        <label class="text-xs font-bold text-gray-700">Radius GPS Default (Meter):</label>
                        <input type="number" name="sqr_radius_meters" id="settingRadius" value="{{ old('sqr_radius_meters', $sqrRadius) }}" required
                               class="w-28 bg-white border border-gray-200 rounded-xl p-2 text-xs font-bold outline-none focus:border-sqr-orange">
                    </div>
                    <button type="submit" class="bg-sqr-green hover:bg-sqr-dark text-white font-bold text-xs px-5 py-2.5 rounded-xl transition shadow-md shrink-0">
                        <i class="fa-solid fa-floppy-disk mr-1"></i> Simpan Pengaturan
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- FILTER PERIODE BULAN & TAHUN -->
    <div class="bg-white rounded-3xl p-5 shadow-sm border border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-4">
        <form method="GET" action="{{ route('admin.payroll.index') }}" class="flex items-center gap-3 flex-wrap">
            <span class="text-xs font-bold text-sqr-green"><i class="fa-solid fa-calendar text-sqr-orange mr-1"></i> Pilih Periode:</span>
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
            <button type="submit" class="bg-sqr-green hover:bg-sqr-dark text-white font-bold text-xs px-4 py-2.5 rounded-xl transition shadow-xs">
                Tampilkan Rekap
            </button>
        </form>

        <div class="text-right">
            <span class="text-[10px] text-gray-400 font-bold uppercase block">Total Anggaran Gaji Periode Ini:</span>
            <span class="text-xl font-black text-emerald-600">Rp {{ number_format($totalPayrollBudget, 0, ',', '.') }}</span>
        </div>
    </div>

    <!-- PAYROLL SUMMARY TABLE -->
    <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 space-y-4">
        <h4 class="font-title font-bold text-sm text-sqr-green flex items-center gap-2 border-b pb-3">
            <i class="fa-solid fa-calculator text-sqr-orange"></i> Rincian Penggajian Ustadz & Ustadzah ({{ \Carbon\Carbon::createFromDate($year, $month, 1)->translatedFormat('F Y') }})
        </h4>

        <div class="overflow-x-auto rounded-2xl border border-gray-100">
            <table class="w-full text-left text-xs">
                <thead class="bg-sqr-dark text-white font-title text-[10px] uppercase tracking-wider">
                    <tr>
                        <th class="p-3.5 pl-4">No & Ustadz</th>
                        <th class="p-3.5 text-center">Hadir Fisik</th>
                        <th class="p-3.5 text-center">Hadir Online</th>
                        <th class="p-3.5 text-center">Izin/Sakit/Alpa</th>
                        <th class="p-3.5 text-center">Pengganti</th>
                        <th class="p-3.5 text-right">Gaji Pokok</th>
                        <th class="p-3.5 text-right">Bonus Admin</th>
                        <th class="p-3.5 text-right font-black">TOTAL GAJI</th>
                        <th class="p-3.5 text-center pr-4">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-white">
                    @forelse($payrollData as $idx => $data)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="p-3.5 pl-4">
                            <div class="font-bold text-gray-800 text-xs">{{ $idx + 1 }}. {{ $data['ustadz']->formatted_name }}</div>
                            <div class="text-[10px] text-sqr-green font-bold flex items-center gap-1 mt-0.5">
                                <i class="fa-solid fa-building-columns text-sqr-orange"></i> {{ $data['location_name'] }}
                            </div>
                            <div class="text-[10px] text-gray-400">{{ $data['ustadz']->email }}</div>
                        </td>
                        <td class="p-3.5 text-center">
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">
                                {{ $data['hadir_fisik'] }} Hari
                            </span>
                        </td>
                        <td class="p-3.5 text-center">
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-purple-100 text-purple-800">
                                {{ $data['hadir_online'] }} Hari
                            </span>
                        </td>
                        <td class="p-3.5 text-center text-gray-500 font-semibold">
                            {{ $data['izin'] }} Iz / {{ $data['sakit'] }} Sk / <span class="text-red-500 font-bold">{{ $data['alpa'] }} Alp</span>
                        </td>
                        <td class="p-3.5 text-center">
                            @if($data['substitute_count'] > 0)
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800">
                                +{{ $data['substitute_count'] }} Sesi
                            </span>
                            @else
                            <span class="text-gray-300">-</span>
                            @endif
                        </td>
                        <td class="p-3.5 text-right font-bold text-gray-700">
                            Rp {{ number_format($data['total_fisik_pay'] + $data['total_online_pay'] + $data['total_sub_pay'], 0, ',', '.') }}
                        </td>
                        <td class="p-3.5 text-right">
                            @if($data['bonus_amount'] > 0)
                            <span class="font-bold text-amber-600">+Rp {{ number_format($data['bonus_amount'], 0, ',', '.') }}</span>
                            @if($data['bonus_note'])<span class="block text-[9px] text-gray-400 italic">{{ $data['bonus_note'] }}</span>@endif
                            @else
                            <span class="text-gray-300">Rp 0</span>
                            @endif
                        </td>
                        <td class="p-3.5 text-right font-black text-sqr-green text-sm">
                            Rp {{ number_format($data['grand_total'], 0, ',', '.') }}
                        </td>
                        <td class="p-3.5 text-center pr-4">
                            <button type="button" onclick="openBonusModal({{ $data['ustadz']->id }}, '{{ addslashes($data['ustadz']->formatted_name) }}', {{ $data['bonus_amount'] }}, '{{ addslashes($data['bonus_note']) }}')"
                                    class="bg-sqr-bg hover:bg-sqr-orange hover:text-white text-sqr-orange font-bold text-[10px] px-2.5 py-1.5 rounded-xl border border-sqr-orange/20 transition">
                                <i class="fa-solid fa-gift mr-1"></i> + Bonus
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="p-8 text-center text-gray-400">Belum ada data ustadz aktif.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- MODAL TAMBAH BONUS ADMIN -->
<div id="bonusModal" class="fixed inset-0 z-[9999] bg-black/70 backdrop-blur-sm hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl shadow-2xl max-w-md w-full p-6 space-y-4">
        <div class="flex items-center justify-between border-b pb-3">
            <h4 class="font-title font-bold text-sm text-sqr-green flex items-center gap-2">
                <i class="fa-solid fa-gift text-sqr-orange"></i> Tambah Bonus Admin Ustadz
            </h4>
            <button type="button" onclick="closeBonusModal()" class="text-gray-400 hover:text-gray-600 text-lg">×</button>
        </div>

        <form method="POST" action="{{ route('admin.payroll.bonus') }}" class="space-y-4">
            @csrf
            <input type="hidden" name="ustadz_id" id="modalUstadzId">
            <input type="hidden" name="month" value="{{ $month }}">
            <input type="hidden" name="year" value="{{ $year }}">

            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">Nama Ustadz/Ustadzah</label>
                <input type="text" id="modalUstadzName" readonly class="w-full bg-gray-100 border border-gray-200 rounded-xl p-3 text-xs font-bold text-gray-800">
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">Nominal Bonus / Tunjangan (Rp) *</label>
                <input type="number" name="bonus_amount" id="modalBonusAmount" required placeholder="Contoh: 100000"
                       class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-xs font-bold text-sqr-green outline-none focus:border-sqr-orange">
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">Keterangan Bonus (Opsional)</label>
                <input type="text" name="bonus_note" id="modalBonusNote" placeholder="Contoh: Bonus Kerajinan & Pengampu Terbaik"
                       class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-xs outline-none focus:border-sqr-orange">
            </div>

            <div class="pt-2 flex gap-3">
                <button type="button" onclick="closeBonusModal()" class="w-1/2 bg-gray-100 hover:bg-gray-200 text-gray-600 font-bold text-xs py-3 rounded-xl transition">
                    Batal
                </button>
                <button type="submit" class="w-1/2 bg-sqr-green hover:bg-sqr-dark text-white font-bold text-xs py-3 rounded-xl transition shadow-md">
                    Simpan Bonus
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function openBonusModal(id, name, amount, note) {
        document.getElementById('modalUstadzId').value = id;
        document.getElementById('modalUstadzName').value = name;
        document.getElementById('modalBonusAmount').value = amount || '';
        document.getElementById('modalBonusNote').value = note || '';
        document.getElementById('bonusModal').classList.remove('hidden');
    }

    function closeBonusModal() {
        document.getElementById('bonusModal').classList.add('hidden');
    }

    function autoFillLocationGps(select) {
        var selectedOption = select.options[select.selectedIndex];
        if (selectedOption && selectedOption.value) {
            var lat = selectedOption.getAttribute('data-lat');
            var lng = selectedOption.getAttribute('data-lng');
            var radius = selectedOption.getAttribute('data-radius');
            if (lat) document.getElementById('settingLat').value = lat;
            if (lng) document.getElementById('settingLng').value = lng;
            if (radius) document.getElementById('settingRadius').value = radius;
        }
    }
</script>
@endpush
@endsection
