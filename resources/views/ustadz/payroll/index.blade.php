@extends('layouts.dashboard')

@section('title', 'Slip Gaji & Honorarium Ustadz')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <!-- Header Banner -->
    <div class="bg-gradient-to-r from-sqr-dark via-sqr-green to-[#2d4a22] text-white rounded-3xl p-6 sm:p-8 shadow-xl relative overflow-hidden flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
        <div class="flex items-center gap-4 relative z-10">
            <div class="w-14 h-14 rounded-2xl bg-sqr-orange/30 border-2 border-sqr-orange flex items-center justify-center text-sqr-orange font-bold text-3xl shadow-lg shrink-0">
                💰
            </div>
            <div>
                <span class="bg-white/20 text-white font-black text-[10px] px-3 py-1 rounded-full uppercase tracking-wider">
                    Portal Keuangan & Slip Gaji Resmi SQR
                </span>
                <h1 class="font-title font-black text-xl sm:text-2xl text-white mt-1">Slip Gaji & Honorarium Mengajar</h1>
                <p class="text-xs text-sqr-light-green mt-0.5">{{ $user->formatted_name }} · Periode {{ \Carbon\Carbon::createFromDate($year, $month, 1)->translatedFormat('F Y') }}</p>
            </div>
        </div>

        <a href="{{ route('ustadz.payroll.download', ['month' => $month, 'year' => $year]) }}"
           class="px-5 py-3 rounded-2xl bg-sqr-orange hover:bg-orange-600 text-white font-title font-bold text-xs transition shadow-lg shrink-0 flex items-center gap-2 relative z-10">
            <i class="fa-solid fa-file-pdf text-base"></i> Cetak / Download Slip PDF 📥
        </a>
    </div>

    <!-- FILTER PERIODE BULAN & TAHUN -->
    <div class="bg-white rounded-3xl p-5 shadow-sm border border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-4">
        <form method="GET" action="{{ route('ustadz.payroll.index') }}" class="flex items-center gap-3 flex-wrap">
            <span class="text-xs font-bold text-sqr-green"><i class="fa-solid fa-calendar text-sqr-orange mr-1"></i> Pilih Bulan & Tahun:</span>
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
                Tampilkan Rincian
            </button>
        </form>

        <div class="text-right">
            <span class="text-[10px] text-gray-400 font-bold uppercase block">Total Penerimaan Gaji:</span>
            <span class="text-2xl font-black text-emerald-600">Rp {{ number_format($grandTotal, 0, ',', '.') }}</span>
        </div>
    </div>

    <!-- SALARY SLIP BREAKDOWN CARD -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-gray-100 space-y-6">
        <div class="flex items-center justify-between border-b pb-4">
            <div>
                <p class="text-[10px] font-black uppercase text-sqr-orange tracking-widest">{{ $orgSettings['organization_name'] ?? 'Saung Quran Rabbani' }}</p>
                <h3 class="font-title font-black text-lg text-sqr-green mt-0.5">Rincian Slip Gaji Periode {{ \Carbon\Carbon::createFromDate($year, $month, 1)->translatedFormat('F Y') }}</h3>
            </div>
            <div class="text-right text-xs">
                <span class="text-gray-400">Status Pembayaran:</span>
                <span class="block font-black text-emerald-600 uppercase text-xs">🟢 Lunas / Ditransfer</span>
            </div>
        </div>

        <!-- STATS BREAKDOWN GRID -->
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
            <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-center">
                <p class="text-[10px] font-bold uppercase text-emerald-800">Hadir Fisik</p>
                <p class="font-title font-black text-xl text-emerald-700 mt-0.5">{{ $hadirFisikCount }} Hari</p>
                <p class="text-[10px] text-emerald-600">@ Rp {{ number_format($rateFisik, 0, ',', '.') }}</p>
            </div>

            <div class="p-4 rounded-2xl bg-purple-50 border border-purple-200 text-center">
                <p class="text-[10px] font-bold uppercase text-purple-800">Hadir Online</p>
                <p class="font-title font-black text-xl text-purple-700 mt-0.5">{{ $hadirOnlineCount }} Hari</p>
                <p class="text-[10px] text-purple-600">@ Rp {{ number_format($rateOnline, 0, ',', '.') }}</p>
            </div>

            <div class="p-4 rounded-2xl bg-amber-50 border border-amber-200 text-center">
                <p class="text-[10px] font-bold uppercase text-amber-800">Tugas Pengganti</p>
                <p class="font-title font-black text-xl text-amber-700 mt-0.5">{{ $substituteCount }} Sesi</p>
                <p class="text-[10px] text-amber-600">@ Rp {{ number_format($rateSubstitute, 0, ',', '.') }}</p>
            </div>

            <div class="p-4 rounded-2xl bg-gray-50 border border-gray-200 text-center">
                <p class="text-[10px] font-bold uppercase text-gray-500">Absen / Izin</p>
                <p class="font-title font-black text-xl text-gray-700 mt-0.5">{{ $izinCount + $sakitCount }} Hari</p>
                <p class="text-[10px] text-red-500">Alpa: {{ $alpaCount }} Hari</p>
            </div>
        </div>

        <!-- DETAILED TABLE OF PAYROLL COMPONENTS -->
        <div class="overflow-x-auto rounded-2xl border border-gray-200">
            <table class="w-full text-left text-xs">
                <thead class="bg-sqr-dark text-white font-title text-[10px] uppercase">
                    <tr>
                        <th class="p-3.5 pl-4">Komponen Gaji / Pendapatan</th>
                        <th class="p-3.5 text-center">Frekuensi</th>
                        <th class="p-3.5 text-right">Tarif Satuan</th>
                        <th class="p-3.5 text-right pr-4">Total Sub-Jumlah</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-white font-medium">
                    <tr>
                        <td class="p-3.5 pl-4 font-bold text-gray-800">1. Honorarium Hadir Fisik Tatap Muka</td>
                        <td class="p-3.5 text-center">{{ $hadirFisikCount }} Hari</td>
                        <td class="p-3.5 text-right">Rp {{ number_format($rateFisik, 0, ',', '.') }}</td>
                        <td class="p-3.5 text-right pr-4 font-bold text-emerald-700">Rp {{ number_format($totalFisikPay, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td class="p-3.5 pl-4 font-bold text-gray-800">2. Honorarium Hadir Daring (Online Zoom/GMeet)</td>
                        <td class="p-3.5 text-center">{{ $hadirOnlineCount }} Hari</td>
                        <td class="p-3.5 text-right">Rp {{ number_format($rateOnline, 0, ',', '.') }}</td>
                        <td class="p-3.5 text-right pr-4 font-bold text-purple-700">Rp {{ number_format($totalOnlinePay, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td class="p-3.5 pl-4 font-bold text-gray-800">3. Insentif Ustadz Pengganti (Substitute Teacher)</td>
                        <td class="p-3.5 text-center">{{ $substituteCount }} Sesi</td>
                        <td class="p-3.5 text-right">Rp {{ number_format($rateSubstitute, 0, ',', '.') }}</td>
                        <td class="p-3.5 text-right pr-4 font-bold text-amber-700">Rp {{ number_format($totalSubPay, 0, ',', '.') }}</td>
                    </tr>
                    @if($bonusAmount > 0)
                    <tr class="bg-amber-50/50">
                        <td class="p-3.5 pl-4 font-bold text-amber-900">
                            4. Bonus / Tunjangan Tambahan Admin
                            @if($bonusNote)<span class="block text-[10px] text-gray-500 font-normal italic">Keterangan: {{ $bonusNote }}</span>@endif
                        </td>
                        <td class="p-3.5 text-center text-amber-800 font-bold">1 Paket</td>
                        <td class="p-3.5 text-right text-amber-800 font-bold">Rp {{ number_format($bonusAmount, 0, ',', '.') }}</td>
                        <td class="p-3.5 text-right pr-4 font-bold text-amber-700">Rp {{ number_format($bonusAmount, 0, ',', '.') }}</td>
                    </tr>
                    @endif
                </tbody>
                <tfoot class="bg-sqr-bg/80 font-bold text-sqr-green border-t-2 border-sqr-green">
                    <tr>
                        <td colspan="3" class="p-4 pl-4 text-right font-title text-sm uppercase">TOTAL PENERIMAAN BERSIH (TAKE HOME PAY):</td>
                        <td class="p-4 pr-4 text-right font-title text-lg text-emerald-600 font-black">Rp {{ number_format($grandTotal, 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <!-- RIWAYAT DETAIL KEHADIRAN HARI PER HARI -->
        <div class="pt-3 border-t border-gray-100 space-y-3">
            <h4 class="font-title font-bold text-xs text-sqr-green flex items-center gap-1.5">
                <i class="fa-solid fa-list-check text-sqr-orange"></i> Detail Log Presensi Kehadiran Diri ({{ $attendances->count() }} Hari Catatan)
            </h4>

            <div class="overflow-x-auto rounded-2xl border border-gray-100">
                <table class="w-full text-left text-xs">
                    <thead class="bg-gray-50 text-gray-600 font-title text-[9px] uppercase">
                        <tr>
                            <th class="p-2.5 pl-3">Tanggal</th>
                            <th class="p-2.5">Jam Check-In</th>
                            <th class="p-2.5 text-center">Status</th>
                            <th class="p-2.5 text-center">Jarak GPS</th>
                            <th class="p-2.5 pr-3">Catatan / Keterangan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white text-[11px]">
                        @forelse($attendances as $att)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="p-2.5 pl-3 font-bold text-gray-800">{{ $att->date?->format('d M Y') }}</td>
                            <td class="p-2.5 text-gray-500 font-semibold">{{ $att->check_in_time ?? '-' }}</td>
                            <td class="p-2.5 text-center">
                                <span class="px-2 py-0.5 rounded-full text-[9px] font-bold uppercase {{ $att->statusBadgeClass }}">
                                    {{ $att->status }}
                                </span>
                            </td>
                            <td class="p-2.5 text-center text-gray-500">
                                @if($att->distance_meters !== null)
                                <span class="text-[10px] font-bold {{ $att->is_within_radius ? 'text-emerald-600' : 'text-red-600' }}">
                                    {{ $att->distance_meters }} m {{ $att->is_within_radius ? '🟢 (SQR)' : '🔴 (Luar)' }}
                                </span>
                                @else
                                <span class="text-gray-300">-</span>
                                @endif
                            </td>
                            <td class="p-2.5 pr-3 text-gray-600 italic">{{ $att->notes ?? '-' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="p-6 text-center text-gray-400 text-xs">Belum ada log presensi pada periode ini.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection
