@extends('layouts.dashboard')

@section('title', 'Manajemen Program Donasi (SQR Berbagi)')

@section('content')
<div class="space-y-6">

    @if(session('success'))
    <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-bold flex items-center gap-2 shadow-xs">
        <i class="fa-solid fa-circle-check text-emerald-500 text-base"></i>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    <!-- Header & Action -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white p-6 rounded-3xl shadow-sm border border-gray-100">
        <div>
            <span class="bg-sqr-green/10 text-sqr-green font-bold text-[10px] px-3 py-1 rounded-full uppercase tracking-wider inline-block mb-1">
                ❤️ Campaign Donasi & Ta'awun
            </span>
            <h1 class="font-title text-xl font-bold text-sqr-green">Manajemen Program Campaign & Log Donasi SQR Berbagi</h1>
            <p class="text-xs text-gray-500 mt-1">Kelola program donasi, pantau log transaksi masuk, dan ekspor rekap ke Excel</p>
        </div>
        <div class="flex flex-wrap items-center gap-3">
            <a href="{{ route('admin.campaigns.export-donasi') }}" class="bg-sqr-orange hover:bg-orange-600 text-white font-title font-bold text-xs px-4 py-3 rounded-2xl transition shadow-md flex items-center gap-2">
                <i class="fa-solid fa-file-excel text-sm"></i> Export Log Donasi (Excel)
            </a>
            <button onclick="document.getElementById('addCampaignModal').classList.remove('hidden')" 
                    class="bg-gradient-to-r from-sqr-green to-sqr-dark hover:from-sqr-dark hover:to-sqr-green text-white font-title font-bold text-xs px-5 py-3 rounded-2xl transition shadow-lg flex items-center gap-2 transform active:scale-95">
                <i class="fa-solid fa-plus-circle text-sqr-orange text-sm"></i> Tambah Program Campaign
            </button>
        </div>
    </div>

    <!-- Stats Widget Cards (Atas) -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
        <div class="bg-white rounded-3xl p-5 shadow-sm border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-400 font-bold uppercase tracking-wider">Total Donasi Terkumpul</p>
                <h3 class="font-title font-black text-2xl text-emerald-600 mt-1">Rp {{ number_format($totalCollected, 0, ',', '.') }}</h3>
                <span class="text-[10px] text-emerald-700 font-bold">Terakumulasi Real-Time</span>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-emerald-100 text-emerald-600 flex items-center justify-center font-bold text-xl">
                💚
            </div>
        </div>

        <div class="bg-white rounded-3xl p-5 shadow-sm border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-400 font-bold uppercase tracking-wider">Total Donatur Terdaftar</p>
                <h3 class="font-title font-black text-2xl text-sqr-green mt-1">{{ number_format($totalDonors, 0, ',', '.') }} Transaksi</h3>
                <span class="text-[10px] text-sqr-green font-bold">Donasi Berhasil Masuk</span>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-sqr-bg text-sqr-green flex items-center justify-center font-bold text-xl">
                🤝
            </div>
        </div>

        <div class="bg-white rounded-3xl p-5 shadow-sm border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-400 font-bold uppercase tracking-wider">Program Campaign Aktif</p>
                <h3 class="font-title font-black text-2xl text-sqr-orange mt-1">{{ $totalCampaigns }} Program</h3>
                <span class="text-[10px] text-sqr-orange font-bold">Penggalangan Dana SQR</span>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-orange-100 text-sqr-orange flex items-center justify-center font-bold text-xl">
                🏆
            </div>
        </div>
    </div>

    <!-- Campaign Grid Cards -->
    <div class="space-y-4">
        <h3 class="font-title font-bold text-base text-sqr-green flex items-center gap-2">
            <i class="fa-solid fa-hand-holding-heart text-sqr-orange"></i> Program Campaign Donasi Aktif
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($campaigns as $cmp)
            <div class="bg-white rounded-3xl overflow-hidden shadow-sm border border-gray-100 flex flex-col justify-between p-5 space-y-4 hover:shadow-xl transition-all duration-300">
                <div>
                    <div class="relative h-44 rounded-2xl overflow-hidden mb-4">
                        <img src="{{ $cmp->image_url }}" alt="{{ $cmp->title }}" class="w-full h-full object-cover">
                        <span class="absolute top-3 left-3 bg-sqr-dark/90 backdrop-blur-sm text-sqr-bg text-[9px] font-bold px-3 py-1 rounded-full border border-white/20 uppercase">
                            {{ $cmp->category }}
                        </span>
                        <span class="absolute top-3 right-3 text-[9px] font-bold px-3 py-1 rounded-full {{ $cmp->is_active ? 'bg-emerald-500 text-white' : 'bg-red-500 text-white' }}">
                            {{ $cmp->is_active ? 'Aktif' : 'Non-Aktif' }}
                        </span>
                    </div>

                    <h3 class="font-title font-bold text-base text-sqr-green line-clamp-1 leading-snug">{{ $cmp->title }}</h3>
                    <p class="text-xs text-gray-500 line-clamp-2 mt-1">{{ $cmp->excerpt }}</p>

                    <!-- Progress Bar Card -->
                    <div class="mt-4 p-4 rounded-2xl bg-sqr-bg/50 border border-sqr-green/10 space-y-2">
                        <div class="flex justify-between items-center text-xs font-bold">
                            <div>
                                <span class="text-[10px] text-gray-400 block font-normal">Terkumpul</span>
                                <span class="text-sqr-green font-title text-sm">{{ $cmp->formatted_current }}</span>
                            </div>
                            <div class="text-right">
                                <span class="text-[10px] text-gray-400 block font-normal">Target Dana</span>
                                <span class="text-gray-700 font-title text-xs">{{ $cmp->formatted_target }}</span>
                            </div>
                        </div>
                        <div class="w-full bg-gray-200 h-3 rounded-full overflow-hidden shadow-inner">
                            <div class="bg-gradient-to-r from-sqr-orange to-amber-500 h-full rounded-full transition-all duration-1000" style="width: {{ $cmp->percentage_progress }}%;"></div>
                        </div>
                        <div class="flex justify-between items-center text-[10px] font-bold text-sqr-orange">
                            <span><i class="fa-solid fa-chart-line mr-1"></i> {{ $cmp->percentage_progress }}% Terpenuhi</span>
                            <span class="text-gray-400 font-normal">{{ $cmp->donations_count }} Donatur</span>
                        </div>
                    </div>
                </div>

                <!-- Actions Bar -->
                <div class="pt-4 border-t border-gray-100 flex items-center justify-between gap-2">
                    <button onclick="openUpdateProgressModal({{ json_encode($cmp) }})" 
                            class="bg-sqr-green/10 text-sqr-green hover:bg-sqr-green hover:text-white text-xs font-bold px-3 py-2 rounded-xl transition flex items-center gap-1.5">
                        <i class="fa-solid fa-pen-to-square text-sqr-orange"></i> Edit & Update Dana
                    </button>
                    <div class="flex items-center gap-1">
                        <a href="{{ route('berbagi.detail', $cmp->slug) }}" target="_blank" class="p-2 text-gray-400 hover:text-sqr-green transition" title="Lihat Public">
                            <i class="fa-solid fa-external-link"></i>
                        </a>
                        <form action="{{ route('admin.campaigns.destroy', $cmp->id) }}" method="POST" onsubmit="return confirm('Hapus program donasi ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="p-2 text-red-400 hover:text-red-600 transition" title="Hapus">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full bg-white p-12 text-center rounded-3xl border border-gray-100 shadow-sm">
                <i class="fa-solid fa-hand-holding-heart text-5xl text-sqr-green/30 mb-3 block"></i>
                <p class="text-sm font-semibold text-gray-500">Belum ada program donasi dibuat.</p>
            </div>
            @endforelse
        </div>
    </div>

    <!-- LOG TRANSAKSI DONASI TABEL WITH PAGINATION -->
    <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 space-y-4">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2 border-b pb-3">
            <div>
                <h3 class="font-title font-bold text-base text-sqr-green flex items-center gap-2">
                    <i class="fa-solid fa-receipt text-sqr-orange"></i> Log Riwayat Transaksi Donasi Masuk
                </h3>
                <p class="text-xs text-gray-500">Daftar transaksi donatur real-time tersinkron dengan kas yayasan</p>
            </div>
            <a href="{{ route('admin.campaigns.export-donasi') }}" class="px-3.5 py-1.5 rounded-xl bg-sqr-bg text-sqr-green hover:bg-sqr-green hover:text-white font-bold text-xs transition border border-sqr-green/20">
                <i class="fa-solid fa-file-csv text-sqr-orange mr-1"></i> Download CSV
            </a>
        </div>

        <div class="overflow-x-auto rounded-2xl border border-gray-100">
            <table class="w-full text-left text-xs">
                <thead class="bg-sqr-bg/50 text-sqr-green font-title text-[10px] uppercase">
                    <tr>
                        <th class="p-3 pl-4">Tanggal</th>
                        <th class="p-3">Nama Donatur</th>
                        <th class="p-3">Program Campaign</th>
                        <th class="p-3 text-right">Jumlah Donasi</th>
                        <th class="p-3">Metode Bayar</th>
                        <th class="p-3 text-center">Status</th>
                        <th class="p-3 pr-4">Catatan / Doa</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($donationLogs as $don)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="p-3 pl-4 text-gray-500 font-semibold">{{ $don->created_at->format('d M Y H:i') }}</td>
                        <td class="p-3 font-bold text-gray-800">
                            {{ $don->donor_name }}
                            @if($don->donor_phone)<span class="block text-[10px] font-normal text-gray-400">{{ $don->donor_phone }}</span>@endif
                        </td>
                        <td class="p-3 text-sqr-green font-bold">{{ $don->campaign?->title ?? 'Program Umum' }}</td>
                        <td class="p-3 text-right font-bold text-emerald-600">Rp {{ number_format($don->amount, 0, ',', '.') }}</td>
                        <td class="p-3 font-semibold text-gray-600">{{ $don->payment_method }}</td>
                        <td class="p-3 text-center">
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase {{ $don->status === 'Paid' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                                {{ $don->status === 'Paid' ? '✅ Lunas' : '⏳ Pending' }}
                            </span>
                        </td>
                        <td class="p-3 pr-4 text-gray-500 italic">{{ $don->notes ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="p-6 text-center text-gray-400">Belum ada riwayat transaksi donasi tercatat.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($donationLogs->hasPages())
        <div class="pt-2">
            {{ $donationLogs->links() }}
        </div>
        @endif
    </div>

</div>

<!-- ==================== MODAL TAMBAH CAMPAIGN ==================== -->
<div id="addCampaignModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-[999] hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-xl w-full p-6 sm:p-8 space-y-5 relative shadow-2xl max-h-[90vh] overflow-y-auto">
        <div class="flex justify-between items-center border-b border-gray-100 pb-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-sqr-green/10 flex items-center justify-center text-sqr-green">
                    <i class="fa-solid fa-hand-holding-heart text-lg"></i>
                </div>
                <div>
                    <h3 class="font-title font-bold text-base text-sqr-green">Buat Campaign Donasi Baru</h3>
                    <p class="text-[11px] text-gray-500">Isi detail program penggalangan dana SQR</p>
                </div>
            </div>
            <button onclick="document.getElementById('addCampaignModal').classList.add('hidden')" class="w-8 h-8 rounded-full bg-gray-100 hover:bg-gray-200 text-gray-500 flex items-center justify-center transition">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <form action="{{ route('admin.campaigns.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1.5">Judul Program Campaign *</label>
                <div class="relative">
                    <i class="fa-solid fa-heading absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                    <input type="text" name="title" required class="w-full bg-gray-50/80 border border-gray-200 rounded-xl px-3.5 py-2.5 pl-10 text-xs font-medium focus:ring-2 focus:ring-sqr-green/30 focus:border-sqr-green outline-none transition" placeholder="Contoh: Wakaf 100 Mus-haf Al-Quran Hafalan">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1.5">Kategori *</label>
                    <select name="category" class="w-full bg-gray-50/80 border border-gray-200 rounded-xl px-3.5 py-2.5 text-xs font-medium focus:ring-2 focus:ring-sqr-green/30 focus:border-sqr-green outline-none transition">
                        <option value="Program Rutin">Program Rutin</option>
                        <option value="Wakaf Quran">Wakaf Quran</option>
                        <option value="Fasilitas">Fasilitas & Sarana</option>
                        <option value="Beasiswa Santri">Beasiswa Santri</option>
                        <option value="Sosial & Ta'awun">Sosial & Ta'awun</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1.5">Target Dana (Rp) *</label>
                    <div class="relative">
                        <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-xs font-bold text-sqr-green">Rp</span>
                        <input type="number" name="target_amount" required class="w-full bg-gray-50/80 border border-gray-200 rounded-xl px-3.5 py-2.5 pl-9 text-xs font-medium focus:ring-2 focus:ring-sqr-green/30 focus:border-sqr-green outline-none transition" placeholder="5000000">
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1.5">Dana Terkumpul Awal (Rp)</label>
                    <div class="relative">
                        <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-xs font-bold text-sqr-orange">Rp</span>
                        <input type="number" name="current_amount" value="0" class="w-full bg-gray-50/80 border border-gray-200 rounded-xl px-3.5 py-2.5 pl-9 text-xs font-medium focus:ring-2 focus:ring-sqr-green/30 focus:border-sqr-green outline-none transition" placeholder="0">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1.5">URL Foto Banner Program</label>
                    <div class="relative">
                        <i class="fa-solid fa-image absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                        <input type="url" name="image_url" class="w-full bg-gray-50/80 border border-gray-200 rounded-xl px-3.5 py-2.5 pl-10 text-xs font-medium focus:ring-2 focus:ring-sqr-green/30 focus:border-sqr-green outline-none transition" placeholder="https://images.unsplash.com/...">
                    </div>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1.5">Ringkasan Singkat (1 Kalimat)</label>
                <input type="text" name="excerpt" class="w-full bg-gray-50/80 border border-gray-200 rounded-xl px-3.5 py-2.5 text-xs font-medium focus:ring-2 focus:ring-sqr-green/30 focus:border-sqr-green outline-none transition" placeholder="Contoh: Pengadaan mus-haf hafalan standar Tajwid berwarna untuk santri baru SQR.">
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1.5">Deskripsi Cerita Campaign Lengkap</label>
                <textarea name="description" rows="3" class="w-full bg-gray-50/80 border border-gray-200 rounded-xl px-3.5 py-2.5 text-xs font-medium focus:ring-2 focus:ring-sqr-green/30 focus:border-sqr-green outline-none transition" placeholder="Jelaskan secara transparan latar belakang, tujuan, dan peruntukan donasi..."></textarea>
            </div>

            <div class="pt-3">
                <button type="submit" class="w-full bg-gradient-to-r from-sqr-green to-sqr-dark hover:from-sqr-dark hover:to-sqr-green text-white font-title font-bold text-xs py-3.5 rounded-2xl shadow-lg transition flex items-center justify-center gap-2">
                    <i class="fa-solid fa-floppy-disk text-sqr-orange"></i> Simpan & Publikasikan Campaign
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ==================== MODAL EDIT & UPDATE PROGRESS DANA ==================== -->
<div id="updateProgressModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-[999] hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-8 space-y-5 relative shadow-2xl max-h-[90vh] overflow-y-auto">
        <div class="flex justify-between items-center border-b border-gray-100 pb-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-sqr-orange/10 flex items-center justify-center text-sqr-orange">
                    <i class="fa-solid fa-chart-line text-lg"></i>
                </div>
                <div>
                    <h3 class="font-title font-bold text-base text-sqr-green">Update Nominal & Progress Donasi</h3>
                    <p class="text-[11px] text-gray-500">Perbarui jumlah dana terkumpul dan target campaign</p>
                </div>
            </div>
            <button onclick="document.getElementById('updateProgressModal').classList.add('hidden')" class="w-8 h-8 rounded-full bg-gray-100 hover:bg-gray-200 text-gray-500 flex items-center justify-center transition">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <form id="editCampaignForm" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1.5">Judul Program</label>
                <input type="text" id="editTitle" name="title" required class="w-full bg-gray-50/80 border border-gray-200 rounded-xl px-3.5 py-2.5 text-xs font-medium focus:ring-2 focus:ring-sqr-green/30 focus:border-sqr-green outline-none transition">
            </div>

            <div class="bg-sqr-bg/80 p-4 rounded-2xl border border-sqr-green/20 space-y-3">
                <p class="text-xs font-bold text-sqr-green flex items-center gap-1.5">
                    <i class="fa-solid fa-coins text-sqr-orange"></i> Update Dana Terkumpul (Real-Time)
                </p>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-[11px] font-bold text-gray-600 mb-1">Nominal Terkumpul (Rp) *</label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-xs font-bold text-sqr-orange">Rp</span>
                            <input type="number" id="editCurrentAmount" name="current_amount" required class="w-full bg-white border border-sqr-orange/40 rounded-xl px-3 py-2 pl-8 text-xs font-bold text-sqr-green focus:ring-2 focus:ring-sqr-orange/30 outline-none">
                        </div>
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-gray-600 mb-1">Target Total Dana (Rp) *</label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-xs font-bold text-sqr-green">Rp</span>
                            <input type="number" id="editTargetAmount" name="target_amount" required class="w-full bg-white border border-gray-300 rounded-xl px-3 py-2 pl-8 text-xs font-bold text-gray-700 focus:ring-2 focus:ring-sqr-green/30 outline-none">
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1.5">Kategori</label>
                    <input type="text" id="editCategory" name="category" class="w-full bg-gray-50/80 border border-gray-200 rounded-xl px-3.5 py-2.5 text-xs font-medium outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1.5">Status Program</label>
                    <div class="flex items-center gap-2 mt-2">
                        <input type="checkbox" id="editIsActive" name="is_active" value="1" class="w-4 h-4 text-sqr-green rounded border-gray-300 focus:ring-sqr-green">
                        <label for="editIsActive" class="text-xs font-bold text-gray-700">Aktif Dipublikasikan</label>
                    </div>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1.5">URL Foto Program</label>
                <input type="url" id="editImageUrl" name="image_url" class="w-full bg-gray-50/80 border border-gray-200 rounded-xl px-3.5 py-2.5 text-xs font-medium outline-none">
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1.5">Ringkasan Singkat</label>
                <input type="text" id="editExcerpt" name="excerpt" class="w-full bg-gray-50/80 border border-gray-200 rounded-xl px-3.5 py-2.5 text-xs font-medium outline-none">
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1.5">Deskripsi Lengkap</label>
                <textarea id="editDescription" name="description" rows="3" class="w-full bg-gray-50/80 border border-gray-200 rounded-xl px-3.5 py-2.5 text-xs font-medium outline-none"></textarea>
            </div>

            <div class="pt-3">
                <button type="submit" class="w-full bg-sqr-orange hover:bg-orange-600 text-white font-title font-bold text-xs py-3.5 rounded-2xl shadow-lg transition flex items-center justify-center gap-2">
                    <i class="fa-solid fa-check-circle"></i> Simpan Perubahan & Update Nominal
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openUpdateProgressModal(cmp) {
        document.getElementById('editCampaignForm').action = '/admin/campaigns/' + cmp.id;
        document.getElementById('editTitle').value = cmp.title || '';
        document.getElementById('editCurrentAmount').value = cmp.current_amount || 0;
        document.getElementById('editTargetAmount').value = cmp.target_amount || 0;
        document.getElementById('editCategory').value = cmp.category || '';
        document.getElementById('editImageUrl').value = cmp.image_url || '';
        document.getElementById('editExcerpt').value = cmp.excerpt || '';
        document.getElementById('editDescription').value = cmp.description || '';
        document.getElementById('editIsActive').checked = cmp.is_active ? true : false;
        
        document.getElementById('updateProgressModal').classList.remove('hidden');
    }
</script>
@endsection
