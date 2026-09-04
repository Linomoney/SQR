@extends('layouts.dashboard')

@section('title', 'Data Pendaftaran PPDB Santri Baru')

@section('content')
<div class="space-y-6">

    <!-- Header & Action -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white p-6 rounded-3xl shadow-sm border border-gray-100">
        <div>
            <span class="bg-sqr-green/10 text-sqr-green font-bold text-[10px] px-3 py-1 rounded-full uppercase tracking-wider inline-block mb-1">
                🎓 Penerimaan Santri Baru (PPDB)
            </span>
            <h1 class="font-title text-xl font-bold text-sqr-green">Manajemen Data Pendaftaran PPDB</h1>
            <p class="text-xs text-gray-500 mt-1">Verifikasi pendaftar baru, lihat detail orang tua, hubungi WhatsApp, dan update status</p>
        </div>
    </div>

    <!-- Stats Bar Cards -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
        <a href="{{ route('admin.ppdb.index') }}" class="bg-white p-5 rounded-3xl border border-gray-100 shadow-sm text-center transition hover:shadow-md">
            <span class="text-xs text-gray-500 font-bold block uppercase tracking-wider">Total Pendaftar</span>
            <span class="font-title text-2xl font-black text-sqr-green mt-1 block">{{ $stats['total'] }}</span>
        </a>
        <a href="{{ route('admin.ppdb.index', ['status' => 'Pending']) }}" class="bg-amber-50/70 p-5 rounded-3xl border border-amber-200 text-center transition hover:shadow-md">
            <span class="text-xs text-amber-700 font-bold block uppercase tracking-wider">Verifikasi (Pending)</span>
            <span class="font-title text-2xl font-black text-amber-800 mt-1 block">{{ $stats['pending'] }}</span>
        </a>
        <a href="{{ route('admin.ppdb.index', ['status' => 'Diterima']) }}" class="bg-emerald-50/70 p-5 rounded-3xl border border-emerald-200 text-center transition hover:shadow-md">
            <span class="text-xs text-emerald-700 font-bold block uppercase tracking-wider">Diterima</span>
            <span class="font-title text-2xl font-black text-emerald-800 mt-1 block">{{ $stats['diterima'] }}</span>
        </a>
        <a href="{{ route('admin.ppdb.index', ['status' => 'Ditolak']) }}" class="bg-red-50/70 p-5 rounded-3xl border border-red-200 text-center transition hover:shadow-md">
            <span class="text-xs text-red-700 font-bold block uppercase tracking-wider">Ditolak</span>
            <span class="font-title text-2xl font-black text-red-800 mt-1 block">{{ $stats['ditolak'] }}</span>
        </a>
    </div>

    <!-- Filter, Search & Sorting Bar -->
    <div class="bg-white p-5 rounded-3xl shadow-sm border border-gray-100">
        <form method="GET" action="{{ route('admin.ppdb.index') }}" class="grid grid-cols-1 sm:grid-cols-12 gap-3 items-center">
            
            <div class="sm:col-span-4">
                <div class="relative">
                    <i class="fa-solid fa-search absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama santri, ortu, no HP..."
                           class="w-full bg-gray-50 border border-gray-200 rounded-xl px-3.5 py-2.5 pl-10 text-xs font-semibold outline-none focus:border-sqr-green transition">
                </div>
            </div>

            <div class="sm:col-span-2">
                <select name="status" onchange="this.form.submit()" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-3 py-2.5 text-xs font-semibold outline-none focus:border-sqr-green transition">
                    <option value="all">-- Semua Status --</option>
                    <option value="Pending" {{ request('status') === 'Pending' ? 'selected' : '' }}>Pending</option>
                    <option value="Diterima" {{ request('status') === 'Diterima' ? 'selected' : '' }}>Diterima</option>
                    <option value="Ditolak" {{ request('status') === 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                </select>
            </div>

            <div class="sm:col-span-3">
                <select name="class_id" onchange="this.form.submit()" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-3 py-2.5 text-xs font-semibold outline-none focus:border-sqr-green transition">
                    <option value="all">-- Semua Kelas --</option>
                    @foreach($classes as $c)
                    <option value="{{ $c->id }}" {{ request('class_id') == $c->id ? 'selected' : '' }}>{{ $c->class_name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="sm:col-span-3 flex gap-2">
                <select name="sort" onchange="this.form.submit()" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-3 py-2.5 text-xs font-semibold outline-none focus:border-sqr-green transition">
                    <option value="latest" {{ request('sort', 'latest') === 'latest' ? 'selected' : '' }}>Urutkan: Terbaru</option>
                    <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>Urutkan: Terlama</option>
                    <option value="name_asc" {{ request('sort') === 'name_asc' ? 'selected' : '' }}>Nama (A - Z)</option>
                    <option value="name_desc" {{ request('sort') === 'name_desc' ? 'selected' : '' }}>Nama (Z - A)</option>
                </select>
                
                <button type="submit" class="bg-sqr-green hover:bg-sqr-dark text-white px-4 py-2.5 rounded-xl font-bold text-xs transition shrink-0">
                    Filter
                </button>
            </div>
        </form>
    </div>

    <!-- Tabel PPDB -->
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-5 border-b border-gray-100 flex items-center justify-between">
            <h3 class="font-title font-bold text-sm text-sqr-green">Daftar Formulir Pendaftaran PPDB</h3>
            <span class="text-xs text-gray-400 font-semibold">Menampilkan {{ $ppdbList->count() }} Pendaftar</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead class="bg-sqr-bg/60 text-sqr-green font-title uppercase tracking-wider text-[10px]">
                    <tr>
                        <th class="p-4">Tanggal & Ref</th>
                        <th class="p-4">Calon Santri</th>
                        <th class="p-4">Orang Tua / Wali</th>
                        <th class="p-4">Kelas Diminati</th>
                        <th class="p-4">No. WhatsApp</th>
                        <th class="p-4">Status</th>
                        <th class="p-4 text-center">Aksi / Verifikasi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($ppdbList as $p)
                    @php
                        $phone = $p->no_hp_ayah ?? $p->no_hp_ibu ?? $p->no_telephone;
                        $waLink = $phone ? 'https://wa.me/' . preg_replace('/[^0-9]/', '', (str_starts_with($phone, '0') ? '62' . substr($phone, 1) : $phone)) : null;
                    @endphp
                    <tr class="hover:bg-sqr-bg/30 transition">
                        <td class="p-4">
                            <span class="font-mono font-bold text-sqr-orange block">#PPDB-{{ $p->id }}</span>
                            <span class="text-[10px] text-gray-400 block mt-0.5">{{ $p->created_at->format('d M Y H:i') }}</span>
                        </td>
                        <td class="p-4">
                            <div class="font-bold text-gray-800 text-sm">{{ $p->nama_lengkap }}</div>
                            <div class="text-[10px] text-gray-500 font-semibold">{{ $p->gender }} @if($p->tempat_lahir)· {{ $p->tempat_lahir }} @endif</div>
                        </td>
                        <td class="p-4">
                            <div class="font-semibold text-gray-700">{{ $p->nama_ayah ?? $p->nama_ibu ?? 'Wali Santri' }}</div>
                            <div class="text-[10px] text-gray-400">{{ $p->pekerjaan_ayah ?? $p->pekerjaan_ibu ?? '-' }}</div>
                        </td>
                        <td class="p-4">
                            <span class="bg-sqr-bg text-sqr-green font-bold text-[10px] px-2.5 py-1 rounded-full border border-sqr-green/20">
                                {{ $p->kelasDiminati?->class_name ?? 'Kelas SQR' }}
                            </span>
                        </td>
                        <td class="p-4">
                            @if($waLink)
                            <a href="{{ $waLink }}" target="_blank" class="inline-flex items-center gap-1 bg-emerald-50 text-emerald-700 hover:bg-emerald-600 hover:text-white px-2.5 py-1 rounded-xl text-[11px] font-bold transition">
                                <i class="fa-brands fa-whatsapp text-sm"></i> {{ $phone }}
                            </a>
                            @else
                            <span class="text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="p-4">
                            <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider {{ $p->status === 'Pending' ? 'bg-amber-100 text-amber-800' : ($p->status === 'Diterima' ? 'bg-emerald-100 text-emerald-800' : 'bg-red-100 text-red-800') }}">
                                {{ $p->status }}
                            </span>
                        </td>
                        <td class="p-4 text-center">
                            <div class="flex items-center justify-center gap-1.5">
                                <button onclick="openDetailPpdbModal({{ json_encode($p) }})" class="px-2.5 py-1.5 bg-sqr-green/10 text-sqr-green hover:bg-sqr-green hover:text-white font-bold rounded-xl text-[11px] transition flex items-center gap-1" title="Lihat Detail Lengkap">
                                    <i class="fa-solid fa-eye"></i> Detail
                                </button>

                                <form method="POST" action="{{ route('admin.ppdb.status', $p->id) }}" class="inline">
                                    @csrf @method('PATCH')
                                    <input type="hidden" name="status" value="Diterima">
                                    <button type="submit" class="px-2.5 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-[11px] transition shadow-sm" title="Terima" onclick="return confirm('Terima pendaftaran santri ini?')">
                                        <i class="fa-solid fa-check"></i>
                                    </button>
                                </form>

                                <form method="POST" action="{{ route('admin.ppdb.status', $p->id) }}" class="inline">
                                    @csrf @method('PATCH')
                                    <input type="hidden" name="status" value="Ditolak">
                                    <button type="submit" class="px-2.5 py-1.5 bg-red-500 hover:bg-red-700 text-white font-bold rounded-xl text-[11px] transition shadow-sm" title="Tolak" onclick="return confirm('Tolak pendaftaran ini?')">
                                        <i class="fa-solid fa-times"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="p-12 text-center text-gray-400 font-semibold">
                            <i class="fa-solid fa-inbox text-4xl mb-2 block opacity-40"></i>
                            Tidak ada data pendaftaran PPDB yang cocok.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($ppdbList->hasPages())
        <div class="p-4 border-t border-gray-100">
            {{ $ppdbList->links() }}
        </div>
        @endif
    </div>

</div>

<!-- ==================== MODAL DETAIL PENDAFTAR PPDB ==================== -->
<div id="detailPpdbModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-[999] hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-2xl w-full p-6 sm:p-8 space-y-5 relative shadow-2xl animate__animated animate__fadeInUp max-h-[90vh] overflow-y-auto">
        <div class="flex justify-between items-center border-b border-gray-100 pb-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-sqr-orange/10 flex items-center justify-center text-sqr-orange">
                    <i class="fa-solid fa-id-card text-lg"></i>
                </div>
                <div>
                    <h3 class="font-title font-bold text-base text-sqr-green" id="modalPpdbTitle">Detail Pendaftar Santri</h3>
                    <p class="text-[11px] text-gray-500" id="modalPpdbDate"></p>
                </div>
            </div>
            <button onclick="document.getElementById('detailPpdbModal').classList.add('hidden')" class="w-8 h-8 rounded-full bg-gray-100 hover:bg-gray-200 text-gray-500 flex items-center justify-center transition">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <!-- Detail Content -->
        <div class="space-y-4 text-xs">
            <!-- Data Santri Box -->
            <div class="bg-sqr-bg/60 p-4 rounded-2xl border border-sqr-green/10 space-y-2">
                <h4 class="font-title font-bold text-sqr-green text-sm flex items-center gap-2">
                    <i class="fa-solid fa-child-reaching text-sqr-orange"></i> Data Santri
                </h4>
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-2 pt-1 text-gray-700">
                    <div><span class="text-gray-400 block text-[10px]">Nama Lengkap</span><strong id="modalNamaSantri" class="text-sqr-green"></strong></div>
                    <div><span class="text-gray-400 block text-[10px]">Jenis Kelamin</span><strong id="modalGender"></strong></div>
                    <div><span class="text-gray-400 block text-[10px]">Kelas Diminati</span><strong id="modalKelas" class="text-sqr-orange"></strong></div>
                    <div><span class="text-gray-400 block text-[10px]">Tempat / Tgl Lahir</span><span id="modalTglLahir"></span></div>
                    <div><span class="text-gray-400 block text-[10px]">Anak Ke- / Saudara</span><span id="modalAnakKe"></span></div>
                    <div><span class="text-gray-400 block text-[10px]">Sekolah Asal</span><span id="modalSekolahAsal"></span></div>
                </div>
            </div>

            <!-- Data Ortu Box -->
            <div class="bg-white p-4 rounded-2xl border border-gray-200 space-y-2">
                <h4 class="font-title font-bold text-sqr-green text-sm flex items-center gap-2">
                    <i class="fa-solid fa-user-tie text-sqr-orange"></i> Data Orang Tua / Wali
                </h4>
                <div class="grid grid-cols-2 gap-3 pt-1 text-gray-700">
                    <div>
                        <span class="text-gray-400 block text-[10px]">Ayah Kandung</span>
                        <strong id="modalNamaAyah"></strong>
                        <p class="text-[10px] text-gray-500" id="modalPekerjaanAyah"></p>
                        <p class="text-[10px] text-sqr-green font-bold" id="modalHPAyah"></p>
                    </div>
                    <div>
                        <span class="text-gray-400 block text-[10px]">Ibu Kandung</span>
                        <strong id="modalNamaIbu"></strong>
                        <p class="text-[10px] text-gray-500" id="modalPekerjaanIbu"></p>
                        <p class="text-[10px] text-sqr-green font-bold" id="modalHPIbu"></p>
                    </div>
                    <div class="col-span-2 pt-1 border-t border-gray-100">
                        <span class="text-gray-400 block text-[10px]">Estimasi Penghasilan Bulanan</span>
                        <strong id="modalPenghasilan" class="text-sqr-orange"></strong>
                    </div>
                </div>
            </div>

            <!-- Data Alamat & Kontak -->
            <div class="bg-white p-4 rounded-2xl border border-gray-200 space-y-2">
                <h4 class="font-title font-bold text-sqr-green text-sm flex items-center gap-2">
                    <i class="fa-solid fa-location-dot text-sqr-orange"></i> Alamat & Kontak
                </h4>
                <div class="space-y-1 text-gray-700">
                    <p><span class="text-gray-400">Email:</span> <strong id="modalEmail"></strong></p>
                    <p><span class="text-gray-400">Alamat Lengkap:</span> <span id="modalAlamat"></span></p>
                    <p><span class="text-gray-400">RT/RW:</span> <span id="modalRtRw"></span> · <span id="modalDesaKota"></span></p>
                </div>
            </div>
        </div>

        <div class="pt-3 border-t border-gray-100 flex items-center justify-between gap-3">
            <a id="modalWaBtn" href="#" target="_blank" class="bg-emerald-600 hover:bg-emerald-700 text-white font-title font-bold text-xs px-5 py-3 rounded-2xl transition flex items-center gap-2">
                <i class="fa-brands fa-whatsapp text-base"></i> Hubungi Wali via WhatsApp
            </a>
            <button onclick="document.getElementById('detailPpdbModal').classList.add('hidden')" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-title font-bold text-xs px-5 py-3 rounded-2xl transition">
                Tutup
            </button>
        </div>
    </div>
</div>

<script>
    function openDetailPpdbModal(p) {
        document.getElementById('modalPpdbTitle').innerText = 'Detail Pendaftar: ' + (p.nama_lengkap || '');
        document.getElementById('modalPpdbDate').innerText = 'Terdaftar pada: ' + (p.created_at || '');
        
        document.getElementById('modalNamaSantri').innerText = p.nama_lengkap || '-';
        document.getElementById('modalGender').innerText = p.gender || '-';
        document.getElementById('modalKelas').innerText = (p.kelas_diminati ? (p.kelas_diminati.class_name || 'Kelas SQR') : 'Kelas SQR');
        document.getElementById('modalTglLahir').innerText = (p.tempat_lahir || '') + ' ' + (p.tanggal_lahir || '');
        document.getElementById('modalAnakKe').innerText = 'Anak ke-' + (p.anak_ke || 1) + ' dari ' + (p.jumlah_saudara || 0) + ' saudara';
        document.getElementById('modalSekolahAsal').innerText = p.sekolah_asal || '-';

        document.getElementById('modalNamaAyah').innerText = p.nama_ayah || '-';
        document.getElementById('modalPekerjaanAyah').innerText = p.pekerjaan_ayah ? ('Pekerjaan: ' + p.pekerjaan_ayah) : '-';
        document.getElementById('modalHPAyah').innerText = p.no_hp_ayah ? ('HP: ' + p.no_hp_ayah) : '-';

        document.getElementById('modalNamaIbu').innerText = p.nama_ibu || '-';
        document.getElementById('modalPekerjaanIbu').innerText = p.pekerjaan_ibu ? ('Pekerjaan: ' + p.pekerjaan_ibu) : '-';
        document.getElementById('modalHPIbu').innerText = p.no_hp_ibu ? ('HP: ' + p.no_hp_ibu) : '-';

        document.getElementById('modalPenghasilan').innerText = p.penghasilan_bulanan || '-';
        document.getElementById('modalEmail').innerText = p.email || '-';
        document.getElementById('modalAlamat').innerText = p.alamat || '-';
        document.getElementById('modalRtRw').innerText = 'RT ' + (p.rt || '00') + ' / RW ' + (p.rw || '00');
        document.getElementById('modalDesaKota').innerText = (p.desa_kelurahan || '') + ', ' + (p.kota || '');

        var phone = p.no_hp_ayah || p.no_hp_ibu || p.no_telephone;
        if (phone) {
            var num = phone.replace(/[^0-9]/g, '');
            if (num.startsWith('0')) num = '62' + num.substring(1);
            document.getElementById('modalWaBtn').href = 'https://wa.me/' + num + '?text=Halo%20Bpk%2FIbu%20Wali%20Santri%20*'+encodeURIComponent(p.nama_lengkap)+'*%2C%20kami%20dari%20Admin%20Saung%20Quran%20Rabbani...';
            document.getElementById('modalWaBtn').style.display = 'inline-flex';
        } else {
            document.getElementById('modalWaBtn').style.display = 'none';
        }

        document.getElementById('detailPpdbModal').classList.remove('hidden');
    }
</script>
@endsection
