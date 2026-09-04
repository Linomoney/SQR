@extends('layouts.dashboard')

@section('title', 'Portal Pembayaran SPP Santri')

@section('content')
<div class="space-y-6">

    <!-- Header Banner -->
    <div class="bg-gradient-to-r from-sqr-green via-sqr-dark to-sqr-green text-white rounded-3xl p-6 shadow-xl flex flex-col md:flex-row items-center justify-between gap-4">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 rounded-2xl bg-sqr-orange/20 border-2 border-sqr-orange flex items-center justify-center text-sqr-orange text-2xl shrink-0">
                <i class="fa-solid fa-receipt"></i>
            </div>
            <div>
                <h2 class="font-title font-bold text-xl">Portal Pembayaran SPP Santri</h2>
                <p class="text-white/70 text-xs mt-0.5">Kelola iuran SPP bulanan ananda, unggah bukti transfer, dan pantau status kelunasan 12 bulan</p>
            </div>
        </div>
        <button onclick="document.getElementById('uploadFormCard').scrollIntoView({behavior: 'smooth'})" class="bg-sqr-orange hover:bg-orange-600 text-white font-title font-bold text-xs px-5 py-3 rounded-2xl transition shadow-lg shrink-0 flex items-center gap-2">
            <i class="fa-solid fa-cloud-arrow-up text-sm"></i> Upload Bukti SPP Baru
        </button>
    </div>

    @if(session('success'))
    <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-semibold rounded-2xl px-5 py-3.5 flex items-center gap-2">
        <i class="fa-solid fa-circle-check text-emerald-500"></i> {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="bg-red-600 text-white rounded-3xl p-6 shadow-2xl border-2 border-red-400 animate-pulse">
        <div class="flex items-start gap-4">
            <div class="w-12 h-12 rounded-2xl bg-white/20 flex items-center justify-center text-2xl shrink-0">
                🔒
            </div>
            <div>
                <h3 class="font-title font-black text-lg text-yellow-300">AKSES PORTAL TERKUNCI</h3>
                <p class="text-xs text-white/90 leading-relaxed mt-1">
                    {{ session('error') }}
                </p>
            </div>
        </div>
    </div>
    @elseif($isPortalLocked)
    <div class="bg-gradient-to-r from-red-600 to-rose-700 text-white rounded-3xl p-6 shadow-2xl border-2 border-red-400">
        <div class="flex items-start gap-4">
            <div class="w-12 h-12 rounded-2xl bg-white/20 flex items-center justify-center text-2xl shrink-0">
                ⛔
            </div>
            <div>
                <h3 class="font-title font-black text-lg text-yellow-300">PERHATIAN: TUNGGAKAN SPP LEBIH DARI 1 BULAN</h3>
                <p class="text-xs text-white/90 leading-relaxed mt-1">
                    Terdapat tunggakan pembayaran SPP bulan sebelumnya yang belum lunas/diverifikasi. Akses portal sementara waktu hanya terbuka untuk halaman pembayaran SPP. Silakan lakukan upload bukti pembayaran di bawah ini.
                </p>
            </div>
        </div>
    </div>
    @elseif(auth()->user()->has_current_month_unpaid_spp)
    <div class="bg-amber-50 border border-amber-300 rounded-3xl p-5 text-amber-900 flex items-start gap-3">
        <i class="fa-solid fa-bell text-amber-600 text-xl shrink-0 mt-0.5"></i>
        <div class="text-xs">
            <p class="font-bold text-sm text-amber-900">Pengingat Pembayaran SPP Bulan {{ now()->translatedFormat('F Y') }}</p>
            <p class="mt-0.5">SPP bulan ini belum diverifikasi. Silakan selesaikan pembayaran dan upload bukti transfer untuk menjaga kelancaran belajar ananda.</p>
        </div>
    </div>
    @endif

    <!-- Stat Cards Summary -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-white rounded-3xl p-5 shadow-sm border border-gray-100 flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-emerald-100 text-emerald-700 flex items-center justify-center text-xl shrink-0 font-black">
                <i class="fa-solid fa-circle-check"></i>
            </div>
            <div>
                <p class="text-xs text-gray-500 font-semibold">Total Terbayar ({{ $yearFilter }})</p>
                <p class="text-xl font-black text-emerald-700">Rp {{ number_format($verifiedSum, 0, ',', '.') }}</p>
            </div>
        </div>

        <div class="bg-white rounded-3xl p-5 shadow-sm border border-gray-100 flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-amber-100 text-amber-700 flex items-center justify-center text-xl shrink-0 font-black">
                <i class="fa-solid fa-hourglass-half"></i>
            </div>
            <div>
                <p class="text-xs text-gray-500 font-semibold">Menunggu Verifikasi</p>
                <p class="text-xl font-black text-amber-700">{{ $pendingCount }} Transaksi</p>
            </div>
        </div>

        <div class="bg-white rounded-3xl p-5 shadow-sm border border-gray-100 flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl {{ $isPortalLocked ? 'bg-red-100 text-red-700' : 'bg-sqr-bg text-sqr-green' }} flex items-center justify-center text-xl shrink-0 font-black">
                <i class="fa-solid {{ $isPortalLocked ? 'fa-lock' : 'fa-shield-halved' }}"></i>
            </div>
            <div>
                <p class="text-xs text-gray-500 font-semibold">Status Portal Akun</p>
                <p class="text-sm font-black {{ $isPortalLocked ? 'text-red-600' : 'text-sqr-green' }}">
                    {{ $isPortalLocked ? '🔒 Terkunci (Tunggakan)' : '✅ Aktif Normal' }}
                </p>
            </div>
        </div>
    </div>

    <!-- ── MATRIKS KELUNASAN 12 BULAN SANTRI ── -->
    <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 space-y-6">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 border-b border-gray-100 pb-4">
            <div>
                <h3 class="font-title font-bold text-base text-sqr-green flex items-center gap-2">
                    <i class="fa-solid fa-calendar-days text-sqr-orange"></i> Matriks Status SPP 12 Bulan (Tahun {{ $yearFilter }})
                </h3>
                <p class="text-xs text-gray-500 mt-0.5">Pantau status pembayaran setiap bulan dari Januari hingga Desember</p>
            </div>
            <!-- Year Selector -->
            <form method="GET" action="{{ route('wali.payments.index') }}" class="flex items-center gap-2">
                <span class="text-xs font-bold text-gray-500">Tahun:</span>
                <select name="year" onchange="this.form.submit()" class="bg-sqr-bg border border-gray-200 rounded-xl px-3 py-1.5 text-xs font-bold text-sqr-green outline-none focus:border-sqr-orange">
                    @for($y = date('Y'); $y >= date('Y') - 2; $y--)
                    <option value="{{ $y }}" {{ $yearFilter == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
            </form>
        </div>

        @foreach($monthlyMatrix as $matrix)
        <div class="bg-sqr-bg/40 border border-sqr-green/10 rounded-2xl p-5 space-y-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-sqr-green text-white font-bold text-sm flex items-center justify-center">
                        {{ strtoupper(substr($matrix['santri']->full_name, 0, 1)) }}
                    </div>
                    <div>
                        <h4 class="font-title font-bold text-sm text-sqr-green">{{ $matrix['santri']->full_name }}</h4>
                        <p class="text-[10px] text-gray-500">NIS: {{ $matrix['santri']->nis }} · {{ $matrix['santri']->sqrClass?->name ?? 'Kelas SQR' }}</p>
                    </div>
                </div>
            </div>

            <!-- 12 Months Grid -->
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-2.5">
                @foreach($matrix['months'] as $m)
                @php
                    $badgeStyle = match($m['status']) {
                        'Verified' => 'bg-emerald-600 text-white border-emerald-700',
                        'Pending'  => 'bg-amber-500 text-white border-amber-600 animate-pulse',
                        'Rejected' => 'bg-red-500 text-white border-red-600',
                        default    => 'bg-white text-gray-500 border-gray-200 hover:border-sqr-orange',
                    };
                    $statusIcon = match($m['status']) {
                        'Verified' => 'fa-circle-check',
                        'Pending'  => 'fa-clock',
                        'Rejected' => 'fa-circle-xmark',
                        default    => 'fa-circle-minus',
                    };
                @endphp
                <div class="rounded-xl border p-2.5 text-center transition flex flex-col justify-between h-20 {{ $badgeStyle }}">
                    <div class="flex items-center justify-between text-[10px]">
                        <span class="font-bold">{{ $m['month_name'] }}</span>
                        <i class="fa-solid {{ $statusIcon }}"></i>
                    </div>

                    <div class="my-auto">
                        <p class="text-[11px] font-black uppercase tracking-wider">
                            @if($m['status'] === 'Verified') LUNAS
                            @elseif($m['status'] === 'Pending') DIPROSES
                            @elseif($m['status'] === 'Rejected') DITOLAK
                            @else BELUM LUNAS @endif
                        </p>
                    </div>

                    @if($m['status'] === 'Unpaid' || $m['status'] === 'Rejected')
                    <button type="button" onclick="selectMonthForUpload('{{ $matrix['santri']->id }}', '{{ $m['month_year'] }}', '{{ $m['amount'] }}')" class="bg-sqr-orange text-white text-[9px] font-bold py-1 px-2 rounded-lg hover:bg-orange-600 transition">
                        Bayar →
                    </button>
                    @else
                    <span class="text-[9px] opacity-80">Rp {{ number_format($m['amount'], 0, ',', '.') }}</span>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
        @endforeach
    </div>

    <!-- ── FORM UPLOAD BUKTI SPP ── -->
    <div id="uploadFormCard" class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 space-y-5">
        <div class="border-b border-gray-100 pb-4">
            <h3 class="font-title font-bold text-base text-sqr-green flex items-center gap-2">
                <i class="fa-solid fa-cloud-arrow-up text-sqr-orange"></i> Form Upload Bukti Transfer SPP Baru
            </h3>
            <p class="text-xs text-gray-500 mt-0.5">Unggah bukti transfer pembayaran SPP untuk diverifikasi oleh bendahara yayasan</p>
        </div>

        <form method="POST" action="{{ route('wali.payments.upload') }}" class="space-y-4">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Pilih Santri Ananda <span class="text-red-500">*</span></label>
                    <select name="santri_id" id="uploadSantriId" class="w-full border border-gray-200 rounded-xl px-3.5 py-2.5 text-xs font-bold text-gray-800 outline-none focus:border-sqr-green bg-sqr-bg" required>
                        @foreach($mySantri as $s)
                        <option value="{{ $s->id }}">{{ $s->full_name }} ({{ $s->sqrClass?->name ?? 'SQR' }})</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Bulan & Tahun SPP <span class="text-red-500">*</span></label>
                    <input type="month" name="month_year" id="uploadMonthYear" value="{{ date('Y-m') }}" class="w-full border border-gray-200 rounded-xl px-3.5 py-2.5 text-xs font-bold text-gray-800 outline-none focus:border-sqr-green bg-sqr-bg" required>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Nominal Pembayaran (Rp) <span class="text-red-500">*</span></label>
                    <input type="number" name="amount" id="uploadAmount" value="150000" min="1000" class="w-full border border-gray-200 rounded-xl px-3.5 py-2.5 text-xs font-bold text-gray-800 outline-none focus:border-sqr-green bg-sqr-bg" required>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">
                    URL Gambar Bukti Transfer <span class="text-sqr-orange font-normal">(Cloudinary / URL Gambar Publik / WhatsApp)</span> <span class="text-red-500">*</span>
                </label>
                <input type="url" name="proof_url" id="uploadProofUrl" placeholder="https://res.cloudinary.com/.../bukti-spp.jpg" class="w-full border border-gray-200 rounded-xl px-3.5 py-2.5 text-xs outline-none focus:border-sqr-green bg-sqr-bg" required>
                <p class="text-[10px] text-gray-400 mt-1">Masukkan URL gambar bukti transfer dari bank / e-wallet yang sah.</p>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">Catatan Tambahan (Opsional)</label>
                <input type="text" name="notes" placeholder="Contoh: Transfer via M-Banking BCA a.n. Fulanah" class="w-full border border-gray-200 rounded-xl px-3.5 py-2.5 text-xs outline-none focus:border-sqr-green bg-sqr-bg">
            </div>

            <button type="submit" class="w-full bg-sqr-orange hover:bg-orange-600 text-white font-title font-bold py-3.5 rounded-2xl transition shadow-md flex items-center justify-center gap-2">
                <i class="fa-solid fa-paper-plane"></i> Kirim Bukti Pembayaran SPP
            </button>
        </form>
    </div>

    <!-- ── TABEL RIWAYAT PEMBAYARAN SPP DENGAN FILTER ── -->
    <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 space-y-5">
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4 border-b border-gray-100 pb-4">
            <div>
                <h3 class="font-title font-bold text-base text-sqr-green flex items-center gap-2">
                    <i class="fa-solid fa-clock-rotate-left text-sqr-orange"></i> Riwayat Pembayaran & Verifikasi SPP
                </h3>
                <p class="text-xs text-gray-500 mt-0.5">Daftar transaksi dan catatan verifikasi dari pengurus yayasan</p>
            </div>

            <!-- Filter Controls -->
            <form method="GET" action="{{ route('wali.payments.index') }}" class="flex flex-wrap items-center gap-2">
                <input type="hidden" name="year" value="{{ $yearFilter }}">
                <select name="status" onchange="this.form.submit()" class="bg-sqr-bg border border-gray-200 rounded-xl px-3 py-1.5 text-xs font-bold text-gray-700 outline-none focus:border-sqr-orange">
                    <option value="all" {{ $statusFilter === 'all' ? 'selected' : '' }}>Semua Status</option>
                    <option value="verified" {{ $statusFilter === 'verified' ? 'selected' : '' }}>🟢 Verified (Lunas)</option>
                    <option value="pending" {{ $statusFilter === 'pending' ? 'selected' : '' }}>🟡 Pending (Proses)</option>
                    <option value="rejected" {{ $statusFilter === 'rejected' ? 'selected' : '' }}>🔴 Rejected (Ditolak)</option>
                </select>

                @if($mySantri->count() > 1)
                <select name="santri_id" onchange="this.form.submit()" class="bg-sqr-bg border border-gray-200 rounded-xl px-3 py-1.5 text-xs font-bold text-gray-700 outline-none focus:border-sqr-orange">
                    <option value="">Semua Santri</option>
                    @foreach($mySantri as $s)
                    <option value="{{ $s->id }}" {{ $santriFilter == $s->id ? 'selected' : '' }}>{{ $s->full_name }}</option>
                    @endforeach
                </select>
                @endif
            </form>
        </div>

        <!-- History Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-sqr-bg text-sqr-green text-xs font-bold uppercase tracking-wider border-b border-gray-200">
                        <th class="py-3 px-4">Tanggal Upload</th>
                        <th class="py-3 px-4">Santri</th>
                        <th class="py-3 px-4">Bulan SPP</th>
                        <th class="py-3 px-4">Nominal</th>
                        <th class="py-3 px-4 text-center">Bukti Transfer</th>
                        <th class="py-3 px-4 text-center">Status</th>
                        <th class="py-3 px-4">Catatan Admin</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-xs">
                    @forelse($payments as $pay)
                    @php
                        $ver = $pay->latestVerification;
                        $proofImg = $ver?->proof_image_path ?? $pay->verifications->first()?->proof_image_path;
                    @endphp
                    <tr class="hover:bg-gray-50 transition">
                        <td class="py-3.5 px-4 font-semibold text-gray-600">
                            {{ $pay->created_at?->translatedFormat('d M Y (H:i)') ?? '-' }}
                        </td>
                        <td class="py-3.5 px-4 font-bold text-sqr-green">
                            {{ $pay->santri?->full_name ?? '-' }}
                        </td>
                        <td class="py-3.5 px-4 font-bold text-gray-800">
                            {{ $pay->month_year }}
                        </td>
                        <td class="py-3.5 px-4 font-black text-sqr-orange">
                            Rp {{ number_format($pay->amount, 0, ',', '.') }}
                        </td>
                        <td class="py-3.5 px-4 text-center">
                            @if(!empty($proofImg))
                            <a href="{{ $proofImg }}" target="_blank" class="inline-flex items-center gap-1 text-[11px] font-bold text-blue-600 hover:underline">
                                <i class="fa-solid fa-image"></i> Lihat Bukti
                            </a>
                            @else
                            <span class="text-gray-400 italic">Tidak ada</span>
                            @endif
                        </td>
                        <td class="py-3.5 px-4 text-center">
                            <span class="inline-block px-3 py-1 rounded-full text-[10px] font-black {{ $pay->status_badge_class }}">
                                {{ strtoupper($pay->status) }}
                            </span>
                        </td>
                        <td class="py-3.5 px-4 text-gray-500">
                            {{ $ver?->admin_notes ?? ($pay->notes ?? '-') }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="py-12 text-center text-gray-400">
                            <i class="fa-solid fa-receipt text-4xl block mb-2 opacity-30"></i>
                            <p class="font-bold text-gray-600">Belum ada riwayat transaksi SPP</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pt-2">
            {{ $payments->links() }}
        </div>
    </div>

</div>

<script>
function selectMonthForUpload(santriId, monthYear, amount) {
    document.getElementById('uploadSantriId').value = santriId;
    document.getElementById('uploadMonthYear').value = monthYear;
    document.getElementById('uploadAmount').value = amount;
    document.getElementById('uploadFormCard').scrollIntoView({ behavior: 'smooth' });
}
</script>
@endsection
