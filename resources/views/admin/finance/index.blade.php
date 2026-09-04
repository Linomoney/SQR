@extends('layouts.dashboard')

@section('title', 'Laporan Keuangan & Kas Yayasan')

@section('content')
<div class="space-y-6">

    @if(session('success'))
    <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-bold flex items-center gap-2 shadow-xs">
        <i class="fa-solid fa-circle-check text-emerald-500 text-base"></i>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    <!-- Header Banner & Export Excel Button -->
    <div class="bg-gradient-to-r from-sqr-dark via-sqr-green to-sqr-dark text-white rounded-3xl p-6 sm:p-8 shadow-xl flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 rounded-2xl bg-sqr-orange/30 border-2 border-sqr-orange flex items-center justify-center text-sqr-orange font-bold text-3xl shadow-lg shrink-0">
                💰
            </div>
            <div>
                <span class="bg-white/20 text-white font-black text-[10px] px-3 py-1 rounded-full uppercase tracking-wider">
                    Sistem Akuntansi & Rekap Laporan Keuangan SQR
                </span>
                <h1 class="font-title font-black text-xl sm:text-2xl text-white mt-1">Laporan Keuangan & Kas Yayasan (Sinkronisasi Otomatis)</h1>
                <p class="text-xs text-white/80 mt-0.5">Semua data pemasukan (Donasi, SPP, Infaq) & pengeluaran (Honor Ustadz, Operasional) tersinkron otomatis</p>
            </div>
        </div>

        <a href="{{ route('admin.finance.export') }}" class="px-5 py-3 rounded-2xl bg-sqr-orange hover:bg-orange-600 text-white font-title font-bold text-xs transition shadow-lg shrink-0 flex items-center gap-2">
            <i class="fa-solid fa-file-excel text-base"></i> Export Rekap Excel (CSV)
        </a>
    </div>

    <!-- Financial Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
        <!-- Pemasukan Card -->
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 space-y-3">
            <div class="flex items-center justify-between">
                <p class="text-xs text-emerald-800 font-bold uppercase tracking-wider">Total Pemasukan (Sinkron)</p>
                <span class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center font-bold text-xs">📈</span>
            </div>
            <h3 class="font-title font-black text-2xl text-emerald-600">Rp {{ number_format($totalIncome, 0, ',', '.') }}</h3>
            
            <div class="pt-2 border-t border-gray-100 space-y-1.5 text-[11px]">
                <div class="flex justify-between text-gray-600">
                    <span>💚 Donasi Campaign:</span>
                    <strong class="text-emerald-700">Rp {{ number_format($donationIncome, 0, ',', '.') }}</strong>
                </div>
                <div class="flex justify-between text-gray-600">
                    <span>💳 SPP Syahriyah Santri:</span>
                    <strong class="text-emerald-700">Rp {{ number_format($sppIncome, 0, ',', '.') }}</strong>
                </div>
                <div class="flex justify-between text-gray-600">
                    <span>📝 Infaq / Donasi Manual:</span>
                    <strong class="text-emerald-700">Rp {{ number_format($manualIncome, 0, ',', '.') }}</strong>
                </div>
            </div>
        </div>

        <!-- Pengeluaran Card -->
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 space-y-3">
            <div class="flex items-center justify-between">
                <p class="text-xs text-red-800 font-bold uppercase tracking-wider">Total Pengeluaran (Sinkron)</p>
                <span class="w-8 h-8 rounded-full bg-red-100 text-red-600 flex items-center justify-center font-bold text-xs">📉</span>
            </div>
            <h3 class="font-title font-black text-2xl text-red-600">Rp {{ number_format($totalExpense, 0, ',', '.') }}</h3>
            
            <div class="pt-2 border-t border-gray-100 space-y-1.5 text-[11px]">
                <div class="flex justify-between text-gray-600">
                    <span>👨‍🏫 Honor Penggajian Ustadz:</span>
                    <strong class="text-red-700">Rp {{ number_format($payrollExpense, 0, ',', '.') }}</strong>
                </div>
                <div class="flex justify-between text-gray-600">
                    <span>📦 Operasional & Jumat Berbagi:</span>
                    <strong class="text-red-700">Rp {{ number_format($manualExpense, 0, ',', '.') }}</strong>
                </div>
            </div>
        </div>

        <!-- Saldo Kas Card -->
        <div class="bg-gradient-to-br from-sqr-green to-sqr-dark text-white rounded-3xl p-6 shadow-xl space-y-3 relative overflow-hidden flex flex-col justify-between">
            <div>
                <p class="text-xs text-sqr-light-green font-bold uppercase tracking-wider">Sisa Saldo Kas Bersih SQR</p>
                <h3 class="font-title font-black text-3xl text-sqr-orange mt-2">Rp {{ number_format($balance, 0, ',', '.') }}</h3>
            </div>
            
            <div class="bg-white/10 p-3 rounded-2xl border border-white/20 text-[11px] space-y-1">
                <p class="font-bold text-white"><i class="fa-solid fa-calculator text-sqr-orange mr-1"></i> Rumus Saldo Kas Bersih:</p>
                <p class="text-white/80 text-[10px]">(Total Donasi + SPP + Infaq) - (Honor Ustadz + Operasional)</p>
            </div>
        </div>
    </div>

    <!-- Forms & Detail Tables -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Form & List Pemasukan Manual -->
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 space-y-6">
            <div class="border-b pb-4 flex items-center justify-between">
                <h3 class="font-title font-bold text-base text-emerald-700 flex items-center gap-2">
                    <i class="fa-solid fa-circle-plus text-emerald-500"></i> Catat Pemasukan Manual Baru
                </h3>
            </div>
            <form method="POST" action="{{ route('admin.finance.income.store') }}" class="grid grid-cols-2 gap-3">
                @csrf
                <div class="col-span-2">
                    <label class="block text-[11px] font-bold text-gray-600 mb-1">Sumber Pemasukan *</label>
                    <input type="text" name="source" required placeholder="Contoh: Infaq Kotak Jumat / Ta'awun Donatur" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-3 py-2.5 text-xs font-bold outline-none focus:border-sqr-orange">
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-gray-600 mb-1">Jumlah (Rp) *</label>
                    <input type="number" name="amount" required min="0" placeholder="50000" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-3 py-2.5 text-xs font-bold outline-none focus:border-sqr-orange">
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-gray-600 mb-1">Tanggal *</label>
                    <input type="date" name="date" required value="{{ date('Y-m-d') }}" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-3 py-2.5 text-xs font-bold outline-none focus:border-sqr-orange">
                </div>
                <div class="col-span-2">
                    <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs py-3 rounded-xl transition shadow-md">
                        <i class="fa-solid fa-floppy-disk mr-1"></i> Simpan Pemasukan
                    </button>
                </div>
            </form>

            <div class="overflow-x-auto pt-2">
                <table class="w-full text-left text-xs">
                    <thead class="bg-emerald-50 text-emerald-800 font-title text-[10px] uppercase">
                        <tr><th class="p-2.5">Tanggal</th><th class="p-2.5">Sumber Pemasukan</th><th class="p-2.5 text-right">Jumlah</th><th class="p-2.5 text-center">Aksi</th></tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($incomes as $inc)
                        <tr class="hover:bg-gray-50">
                            <td class="p-2.5 text-gray-500 font-semibold">{{ $inc->date?->format('d M Y') }}</td>
                            <td class="p-2.5 font-bold text-gray-800">{{ $inc->title ?? $inc->source }}</td>
                            <td class="p-2.5 text-right font-bold text-emerald-600">Rp {{ number_format($inc->amount, 0, ',', '.') }}</td>
                            <td class="p-2.5 text-center">
                                <form method="POST" action="{{ route('admin.finance.income.destroy', $inc) }}" onsubmit="return confirm('Hapus Pemasukan?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 font-bold">&times;</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Form & List Pengeluaran Manual -->
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 space-y-6">
            <div class="border-b pb-4 flex items-center justify-between">
                <h3 class="font-title font-bold text-base text-red-600 flex items-center gap-2">
                    <i class="fa-solid fa-circle-minus text-red-500"></i> Catat Pengeluaran Manual Baru
                </h3>
            </div>
            <form method="POST" action="{{ route('admin.finance.expense.store') }}" class="grid grid-cols-2 gap-3">
                @csrf
                <div class="col-span-2">
                    <label class="block text-[11px] font-bold text-gray-600 mb-1">Kategori Pengeluaran *</label>
                    <input type="text" name="category" required placeholder="Contoh: Snack Pengajian / Paket Jumat Berbagi" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-3 py-2.5 text-xs font-bold outline-none focus:border-sqr-orange">
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-gray-600 mb-1">Jumlah (Rp) *</label>
                    <input type="number" name="amount" required min="0" placeholder="250000" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-3 py-2.5 text-xs font-bold outline-none focus:border-sqr-orange">
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-gray-600 mb-1">Tanggal *</label>
                    <input type="date" name="date" required value="{{ date('Y-m-d') }}" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-3 py-2.5 text-xs font-bold outline-none focus:border-sqr-orange">
                </div>
                <div class="col-span-2">
                    <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-bold text-xs py-3 rounded-xl transition shadow-md">
                        <i class="fa-solid fa-floppy-disk mr-1"></i> Simpan Pengeluaran
                    </button>
                </div>
            </form>

            <div class="overflow-x-auto pt-2">
                <table class="w-full text-left text-xs">
                    <thead class="bg-red-50 text-red-800 font-title text-[10px] uppercase">
                        <tr><th class="p-2.5">Tanggal</th><th class="p-2.5">Kategori Pengeluaran</th><th class="p-2.5 text-right">Jumlah</th><th class="p-2.5 text-center">Aksi</th></tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($expenses as $exp)
                        <tr class="hover:bg-gray-50">
                            <td class="p-2.5 text-gray-500 font-semibold">{{ $exp->date?->format('d M Y') }}</td>
                            <td class="p-2.5 font-bold text-gray-800">{{ $exp->title ?? $exp->category }}</td>
                            <td class="p-2.5 text-right font-bold text-red-600">Rp {{ number_format($exp->amount, 0, ',', '.') }}</td>
                            <td class="p-2.5 text-center">
                                <form method="POST" action="{{ route('admin.finance.expense.destroy', $exp) }}" onsubmit="return confirm('Hapus Pengeluaran?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 font-bold">&times;</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection
