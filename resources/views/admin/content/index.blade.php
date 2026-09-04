@extends('layouts.dashboard')

@section('title', 'Content Manager Website')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">

    {{-- Page Header --}}
    <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-sqr-green rounded-2xl flex items-center justify-center shadow-md">
                <i class="fa-solid fa-sliders text-white text-lg"></i>
            </div>
            <div>
                <h3 class="font-title font-bold text-lg text-sqr-green">Pengaturan Konten Website SQR</h3>
                <p class="text-xs text-gray-500 mt-0.5">Kelola konten per-section. Setiap bagian bisa disimpan secara mandiri.</p>
            </div>
        </div>
        {{-- Section Navigation Tabs --}}
        <div class="flex flex-wrap gap-2 mt-5">
            @foreach([
                ['id' => 'sec-hero',    'label' => 'Hero & Statistik',   'icon' => 'fa-bullhorn'],
                ['id' => 'sec-sanlat',  'label' => 'Sanlat Ramadhan',    'icon' => 'fa-star-and-crescent'],
                ['id' => 'sec-kajian',  'label' => 'Kajian Tematik',     'icon' => 'fa-video'],
                ['id' => 'sec-jumat',   'label' => 'Jumat Berbagi',      'icon' => 'fa-hand-holding-heart'],
                ['id' => 'sec-sosmed',  'label' => 'Media Sosial',       'icon' => 'fa-share-nodes'],
                ['id' => 'sec-kontak',  'label' => 'Kontak & Alamat',    'icon' => 'fa-location-dot'],
                ['id' => 'sec-faq',     'label' => 'FAQ',                'icon' => 'fa-circle-question'],
                ['id' => 'sec-laporan', 'label' => 'Laporan Donasi',     'icon' => 'fa-receipt'],
            ] as $tab)
            <a href="#{{ $tab['id'] }}"
               class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-[11px] font-bold bg-sqr-bg text-sqr-green border border-sqr-green/20 hover:bg-sqr-green hover:text-white transition">
                <i class="fa-solid {{ $tab['icon'] }} text-sqr-orange text-[10px]"></i>
                {{ $tab['label'] }}
            </a>
            @endforeach
        </div>
    </div>

    {{-- ===== 1. HERO & STATISTIK ===== --}}
    <div id="sec-hero" class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="bg-gradient-to-r from-sqr-green to-sqr-dark p-4 flex items-center gap-3">
            <i class="fa-solid fa-bullhorn text-sqr-orange text-base"></i>
            <h4 class="font-title font-bold text-sm text-white">1. Text Hero & Statistik</h4>
        </div>
        <form method="POST" action="{{ route('admin.content.section.store') }}" class="p-5 space-y-4">
            @csrf
            <input type="hidden" name="section" value="hero">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-gray-700 mb-1">🏷️ Tagline Hero Utama</label>
                    <input type="text" name="home_tagline" value="{{ $contents->get('home_tagline', 'Pondasi Quran Generasi Rabbani') }}"
                           class="w-full bg-gray-50 border border-gray-200 rounded-xl p-2.5 text-xs focus:ring-2 focus:ring-sqr-green/30 focus:border-sqr-green outline-none transition">
                    <p class="text-[10px] text-gray-400 mt-1">Tampil di bawah judul PPDB di hero section website.</p>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">👥 Statistik Santri Aktif</label>
                    <input type="text" name="stat_total_santri" value="{{ $contents->get('stat_total_santri', '150+') }}"
                           class="w-full bg-gray-50 border border-gray-200 rounded-xl p-2.5 text-xs focus:ring-2 focus:ring-sqr-green/30 focus:border-sqr-green outline-none transition">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">🎓 Statistik Pengajar</label>
                    <input type="text" name="stat_pengajar" value="{{ $contents->get('stat_pengajar', '8+') }}"
                           class="w-full bg-gray-50 border border-gray-200 rounded-xl p-2.5 text-xs focus:ring-2 focus:ring-sqr-green/30 focus:border-sqr-green outline-none transition">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">📅 Statistik Tahun Berdiri</label>
                    <input type="text" name="stat_tahun" value="{{ $contents->get('stat_tahun', '7th') }}"
                           class="w-full bg-gray-50 border border-gray-200 rounded-xl p-2.5 text-xs focus:ring-2 focus:ring-sqr-green/30 focus:border-sqr-green outline-none transition">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">📞 Link WhatsApp Resmi</label>
                    <input type="url" name="whatsapp_link" value="{{ $contents->get('whatsapp_link', 'https://wa.me/6289677082002') }}"
                           class="w-full bg-gray-50 border border-gray-200 rounded-xl p-2.5 text-xs focus:ring-2 focus:ring-sqr-green/30 focus:border-sqr-green outline-none transition">
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-gray-700 mb-1">📝 Deskripsi "Mengapa SQR?"</label>
                    <textarea name="mengapa_sqr" rows="3"
                              class="w-full bg-gray-50 border border-gray-200 rounded-xl p-2.5 text-xs focus:ring-2 focus:ring-sqr-green/30 focus:border-sqr-green outline-none transition resize-none">{{ $contents->get('mengapa_sqr', 'Saung Quran Rabbani (SQR) dikelola di bawah Yayasan Bina Cahaya Ilmu Rabbani.') }}</textarea>
                    <p class="text-[10px] text-gray-400 mt-1">Tampil di section "Mengapa Memilih Belajar Al-Quran di SQR?"</p>
                </div>
            </div>
            <div class="pt-2 border-t border-gray-100">
                <button type="submit" class="bg-sqr-green hover:bg-sqr-dark text-white font-bold text-xs px-5 py-2.5 rounded-xl transition shadow-md flex items-center gap-2">
                    <i class="fa-solid fa-floppy-disk"></i> Simpan Hero & Statistik
                </button>
            </div>
        </form>
    </div>

    {{-- ===== 2. SANLAT RAMADHAN ===== --}}
    <div id="sec-sanlat" class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="bg-gradient-to-r from-emerald-600 to-emerald-800 p-4 flex items-center gap-3">
            <i class="fa-solid fa-star-and-crescent text-yellow-300 text-base"></i>
            <h4 class="font-title font-bold text-sm text-white">2. Informasi Sanlat Ramadhan</h4>
        </div>
        <form method="POST" action="{{ route('admin.content.section.store') }}" class="p-5 space-y-4">
            @csrf
            <input type="hidden" name="section" value="sanlat">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Judul Utama Sanlat</label>
                    <input type="text" name="sanlat_title" value="{{ $contents->get('sanlat_title', 'YOOK GASS IKUT!!') }}"
                           class="w-full bg-gray-50 border border-gray-200 rounded-xl p-2.5 text-xs focus:ring-2 focus:ring-sqr-green/30 outline-none transition">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Sub-Judul Sanlat</label>
                    <input type="text" name="sanlat_subtitle" value="{{ $contents->get('sanlat_subtitle', '\"Ramadhan Ceria Ala Para Ulama\"') }}"
                           class="w-full bg-gray-50 border border-gray-200 rounded-xl p-2.5 text-xs focus:ring-2 focus:ring-sqr-green/30 outline-none transition">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Nama Pemateri</label>
                    <input type="text" name="sanlat_pemateri" value="{{ $contents->get('sanlat_pemateri', 'Ust. Raisya Rahman Aspian') }}"
                           class="w-full bg-gray-50 border border-gray-200 rounded-xl p-2.5 text-xs focus:ring-2 focus:ring-sqr-green/30 outline-none transition">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Deskripsi/Biografi Pemateri</label>
                    <input type="text" name="sanlat_pemateri_desc" value="{{ $contents->get('sanlat_pemateri_desc', 'Mahasiswa Jurusan Sastra Arab LIPIA Jakarta') }}"
                           class="w-full bg-gray-50 border border-gray-200 rounded-xl p-2.5 text-xs focus:ring-2 focus:ring-sqr-green/30 outline-none transition">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Tanggal & Waktu Sanlat</label>
                    <input type="text" name="sanlat_tanggal" value="{{ $contents->get('sanlat_tanggal', 'Sabtu, 7 Maret 2026 · 10.00–17.30 WIB') }}"
                           class="w-full bg-gray-50 border border-gray-200 rounded-xl p-2.5 text-xs focus:ring-2 focus:ring-sqr-green/30 outline-none transition">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Infaq Umum (Rp)</label>
                    <input type="text" name="sanlat_infaq_umum" value="{{ $contents->get('sanlat_infaq_umum', '35.000') }}"
                           class="w-full bg-gray-50 border border-gray-200 rounded-xl p-2.5 text-xs focus:ring-2 focus:ring-sqr-green/30 outline-none transition">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Infaq Santri (Rp)</label>
                    <input type="text" name="sanlat_infaq_santri" value="{{ $contents->get('sanlat_infaq_santri', '15.000') }}"
                           class="w-full bg-gray-50 border border-gray-200 rounded-xl p-2.5 text-xs focus:ring-2 focus:ring-sqr-green/30 outline-none transition">
                </div>
            </div>
            <div class="pt-2 border-t border-gray-100">
                <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs px-5 py-2.5 rounded-xl transition shadow-md flex items-center gap-2">
                    <i class="fa-solid fa-floppy-disk"></i> Simpan Informasi Sanlat
                </button>
            </div>
        </form>
    </div>

    {{-- ===== 3. KAJIAN TEMATIK ===== --}}
    <div id="sec-kajian" class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="bg-gradient-to-r from-slate-700 to-slate-900 p-4 flex items-center gap-3">
            <i class="fa-solid fa-video text-sqr-orange text-base"></i>
            <h4 class="font-title font-bold text-sm text-white">3. Kajian Tematik Online</h4>
        </div>
        <form method="POST" action="{{ route('admin.content.section.store') }}" class="p-5 space-y-4">
            @csrf
            <input type="hidden" name="section" value="kajian">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-gray-700 mb-1">Judul Kajian</label>
                    <input type="text" name="kajian_judul" value="{{ $contents->get('kajian_judul', '\"Hidayah Bukan Di Tangan Kita\"') }}"
                           class="w-full bg-gray-50 border border-gray-200 rounded-xl p-2.5 text-xs focus:ring-2 focus:ring-sqr-green/30 outline-none transition">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Pemateri Kajian</label>
                    <input type="text" name="kajian_pemateri" value="{{ $contents->get('kajian_pemateri', 'Ustaz Hendri') }}"
                           class="w-full bg-gray-50 border border-gray-200 rounded-xl p-2.5 text-xs focus:ring-2 focus:ring-sqr-green/30 outline-none transition">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Waktu Kajian</label>
                    <input type="text" name="kajian_waktu" value="{{ $contents->get('kajian_waktu', 'Jumat, 16 Mei 2025 · 19.30 WIB') }}"
                           class="w-full bg-gray-50 border border-gray-200 rounded-xl p-2.5 text-xs focus:ring-2 focus:ring-sqr-green/30 outline-none transition">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Media/Platform Kajian</label>
                    <input type="text" name="kajian_media" value="{{ $contents->get('kajian_media', 'Google Meet') }}"
                           class="w-full bg-gray-50 border border-gray-200 rounded-xl p-2.5 text-xs focus:ring-2 focus:ring-sqr-green/30 outline-none transition">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Link Daftar/Bergabung</label>
                    <input type="url" name="kajian_link" value="{{ $contents->get('kajian_link', '') }}"
                           placeholder="https://meet.google.com/..."
                           class="w-full bg-gray-50 border border-gray-200 rounded-xl p-2.5 text-xs focus:ring-2 focus:ring-sqr-green/30 outline-none transition">
                </div>
            </div>
            <div class="pt-2 border-t border-gray-100">
                <button type="submit" class="bg-slate-700 hover:bg-slate-900 text-white font-bold text-xs px-5 py-2.5 rounded-xl transition shadow-md flex items-center gap-2">
                    <i class="fa-solid fa-floppy-disk"></i> Simpan Kajian Tematik
                </button>
            </div>
        </form>
    </div>

    {{-- ===== 4. JUMAT BERBAGI & DONASI ===== --}}
    <div id="sec-jumat" class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="bg-gradient-to-r from-orange-500 to-amber-600 p-4 flex items-center gap-3">
            <i class="fa-solid fa-hand-holding-heart text-white text-base"></i>
            <h4 class="font-title font-bold text-sm text-white">4. Jumat Berbagi & Rekening Donasi</h4>
        </div>
        <form method="POST" action="{{ route('admin.content.section.store') }}" class="p-5 space-y-4">
            @csrf
            <input type="hidden" name="section" value="jumat">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-gray-700 mb-1">Deskripsi Program Jumat Berbagi</label>
                    <textarea name="jumat_berbagi_desc" rows="2"
                              class="w-full bg-gray-50 border border-gray-200 rounded-xl p-2.5 text-xs focus:ring-2 focus:ring-sqr-orange/30 outline-none transition resize-none">{{ $contents->get('jumat_berbagi_desc', 'Program Infaq & Sedekah Makanan Sehat Santri') }}</textarea>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Nama Bank Donasi</label>
                    <input type="text" name="jumat_berbagi_bank" value="{{ $contents->get('jumat_berbagi_bank', 'Bank Syariah Indonesia (BSI)') }}"
                           class="w-full bg-gray-50 border border-gray-200 rounded-xl p-2.5 text-xs focus:ring-2 focus:ring-sqr-orange/30 outline-none transition">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Nomor Rekening & Atas Nama</label>
                    <input type="text" name="jumat_berbagi_rekening" value="{{ $contents->get('jumat_berbagi_rekening', '7199588979 a.n. Yayasan Bina Cahaya Ilmu Rabbani') }}"
                           class="w-full bg-gray-50 border border-gray-200 rounded-xl p-2.5 text-xs focus:ring-2 focus:ring-sqr-orange/30 outline-none transition">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">No HP Admin Donasi (WhatsApp)</label>
                    <input type="text" name="jumat_berbagi_wa" value="{{ $contents->get('jumat_berbagi_wa', '6281293721163') }}"
                           placeholder="628xxxxxxxxxx"
                           class="w-full bg-gray-50 border border-gray-200 rounded-xl p-2.5 text-xs focus:ring-2 focus:ring-sqr-orange/30 outline-none transition">
                    <p class="text-[10px] text-gray-400 mt-1">Tanpa tanda + dan tanpa spasi. Contoh: 6281234567890</p>
                </div>
            </div>
            <div class="pt-2 border-t border-gray-100">
                <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white font-bold text-xs px-5 py-2.5 rounded-xl transition shadow-md flex items-center gap-2">
                    <i class="fa-solid fa-floppy-disk"></i> Simpan Jumat Berbagi
                </button>
            </div>
        </form>
    </div>

    {{-- ===== 5. MEDIA SOSIAL ===== --}}
    <div id="sec-sosmed" class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="bg-gradient-to-r from-rose-500 to-purple-600 p-4 flex items-center gap-3">
            <i class="fa-solid fa-share-nodes text-white text-base"></i>
            <h4 class="font-title font-bold text-sm text-white">5. Media Sosial SQR</h4>
        </div>
        <form method="POST" action="{{ route('admin.content.section.store') }}" class="p-5 space-y-4">
            @csrf
            <input type="hidden" name="section" value="sosmed">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1"><i class="fa-brands fa-instagram text-rose-500 mr-1"></i>Username Instagram</label>
                    <div class="flex">
                        <span class="bg-gray-100 border border-r-0 border-gray-200 rounded-l-xl px-3 flex items-center text-xs text-gray-500">@</span>
                        <input type="text" name="sosmed_instagram" value="{{ $contents->get('sosmed_instagram', 'saungquranrabbani') }}"
                               class="flex-1 bg-gray-50 border border-gray-200 rounded-r-xl p-2.5 text-xs focus:ring-2 focus:ring-rose-500/20 outline-none transition">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1"><i class="fa-brands fa-youtube text-red-500 mr-1"></i>Username YouTube Channel</label>
                    <div class="flex">
                        <span class="bg-gray-100 border border-r-0 border-gray-200 rounded-l-xl px-3 flex items-center text-xs text-gray-500">@</span>
                        <input type="text" name="sosmed_youtube" value="{{ $contents->get('sosmed_youtube', 'saungquranrabbani') }}"
                               class="flex-1 bg-gray-50 border border-gray-200 rounded-r-xl p-2.5 text-xs focus:ring-2 focus:ring-red-500/20 outline-none transition">
                    </div>
                </div>
            </div>
            <div class="pt-2 border-t border-gray-100">
                <button type="submit" class="bg-rose-500 hover:bg-rose-600 text-white font-bold text-xs px-5 py-2.5 rounded-xl transition shadow-md flex items-center gap-2">
                    <i class="fa-solid fa-floppy-disk"></i> Simpan Media Sosial
                </button>
            </div>
        </form>
    </div>

    {{-- ===== 6. KONTAK & ALAMAT ===== --}}
    <div id="sec-kontak" class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="bg-gradient-to-r from-blue-600 to-blue-800 p-4 flex items-center gap-3">
            <i class="fa-solid fa-location-dot text-white text-base"></i>
            <h4 class="font-title font-bold text-sm text-white">6. Kontak & Alamat</h4>
        </div>
        <form method="POST" action="{{ route('admin.content.section.store') }}" class="p-5 space-y-4">
            @csrf
            <input type="hidden" name="section" value="kontak">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-gray-700 mb-1">Alamat Lengkap SQR</label>
                    <textarea name="alamat" rows="2"
                              class="w-full bg-gray-50 border border-gray-200 rounded-xl p-2.5 text-xs focus:ring-2 focus:ring-blue-500/20 outline-none transition resize-none">{{ $contents->get('alamat', 'Jl. Contoh No. 123, Kota, Provinsi') }}</textarea>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Email SQR</label>
                    <input type="email" name="email_kontak" value="{{ $contents->get('email_kontak', '') }}"
                           placeholder="admin@sqr.id"
                           class="w-full bg-gray-50 border border-gray-200 rounded-xl p-2.5 text-xs focus:ring-2 focus:ring-blue-500/20 outline-none transition">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Nomor Telepon/WhatsApp Publik</label>
                    <input type="text" name="telepon_kontak" value="{{ $contents->get('telepon_kontak', '') }}"
                           placeholder="0812-xxxx-xxxx"
                           class="w-full bg-gray-50 border border-gray-200 rounded-xl p-2.5 text-xs focus:ring-2 focus:ring-blue-500/20 outline-none transition">
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-gray-700 mb-1">Link Google Maps Embed</label>
                    <input type="url" name="gmaps_link" value="{{ $contents->get('gmaps_link', '') }}"
                           placeholder="https://maps.google.com/..."
                           class="w-full bg-gray-50 border border-gray-200 rounded-xl p-2.5 text-xs focus:ring-2 focus:ring-blue-500/20 outline-none transition">
                </div>
            </div>
            <div class="pt-2 border-t border-gray-100">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs px-5 py-2.5 rounded-xl transition shadow-md flex items-center gap-2">
                    <i class="fa-solid fa-floppy-disk"></i> Simpan Kontak & Alamat
                </button>
            </div>
        </form>
    </div>

    {{-- ===== 7. MANAJEMEN FAQ ===== --}}
    <div id="sec-faq" class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="bg-gradient-to-r from-sqr-orange to-amber-500 p-4 flex items-center gap-3">
            <i class="fa-solid fa-circle-question text-white text-base"></i>
            <h4 class="font-title font-bold text-sm text-white">7. Manajemen FAQ (Pertanyaan Umum)</h4>
        </div>
        <div class="p-5 space-y-5">

            {{-- Daftar FAQ yang ada --}}
            <div class="space-y-3">
                <p class="text-xs font-bold text-gray-600">FAQ yang ditampilkan di website ({{ count($faqList) }} pertanyaan):</p>
                @forelse($faqList as $fIdx => $faq)
                <div class="bg-sqr-bg/50 border border-sqr-green/10 rounded-2xl p-4">
                    <div class="flex items-start justify-between gap-3">
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-bold text-sqr-green mb-1 line-clamp-1">{{ $fIdx + 1 }}. {{ $faq['question'] }}</p>
                            <p class="text-[11px] text-gray-500 line-clamp-2">{{ $faq['answer'] }}</p>
                        </div>
                        <div class="flex gap-2 shrink-0">
                            {{-- Edit button --}}
                            <button type="button"
                                    onclick="fillFaqForm({{ $fIdx }}, {{ json_encode($faq['question']) }}, {{ json_encode($faq['answer']) }})"
                                    class="w-7 h-7 bg-sqr-green/10 hover:bg-sqr-green text-sqr-green hover:text-white rounded-lg text-[10px] transition flex items-center justify-center" title="Edit">
                                <i class="fa-solid fa-pen"></i>
                            </button>
                            {{-- Delete button --}}
                            <form method="POST" action="{{ route('admin.content.faq.destroy', $fIdx) }}"
                                  onsubmit="return confirm('Hapus FAQ ini?')" class="inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="w-7 h-7 bg-red-50 hover:bg-red-500 text-red-400 hover:text-white rounded-lg text-[10px] transition flex items-center justify-center" title="Hapus">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center py-6 text-gray-400 text-xs font-semibold bg-gray-50 rounded-2xl border border-dashed border-gray-200">
                    <i class="fa-solid fa-circle-question text-2xl mb-2 block opacity-30"></i>
                    Belum ada FAQ. Tambahkan pertanyaan pertama di bawah.
                </div>
                @endforelse
            </div>

            {{-- Form tambah/edit FAQ --}}
            <form method="POST" action="{{ route('admin.content.faq.store') }}" id="faqForm" class="bg-sqr-green/5 border border-sqr-green/20 rounded-2xl p-4 space-y-3">
                @csrf
                <input type="hidden" name="faq_index" id="faqIndexInput" value="">
                <p class="text-xs font-bold text-sqr-green" id="faqFormTitle">➕ Tambah FAQ Baru</p>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Pertanyaan</label>
                    <input type="text" name="faq_question" id="faqQuestion"
                           placeholder="Contoh: Berapa usia minimal untuk mendaftar santri SQR?"
                           class="w-full bg-white border border-gray-200 rounded-xl p-2.5 text-xs focus:ring-2 focus:ring-sqr-green/30 outline-none transition">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Jawaban</label>
                    <textarea name="faq_answer" id="faqAnswer" rows="3"
                              placeholder="Tulis jawaban lengkap di sini..."
                              class="w-full bg-white border border-gray-200 rounded-xl p-2.5 text-xs focus:ring-2 focus:ring-sqr-green/30 outline-none transition resize-none"></textarea>
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="bg-sqr-orange hover:bg-orange-600 text-white font-bold text-xs px-5 py-2.5 rounded-xl transition shadow-md flex items-center gap-2">
                        <i class="fa-solid fa-floppy-disk"></i> <span id="faqSubmitLabel">Simpan FAQ</span>
                    </button>
                    <button type="button" onclick="resetFaqForm()" class="bg-gray-100 hover:bg-gray-200 text-gray-600 font-bold text-xs px-4 py-2.5 rounded-xl transition">
                        Batal/Reset
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- ===== 8. LAPORAN DONASI JUMAT BERBAGI ===== --}}
    <div id="sec-laporan" class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="bg-gradient-to-r from-teal-600 to-teal-800 p-4 flex items-center gap-3">
            <i class="fa-solid fa-receipt text-white text-base"></i>
            <h4 class="font-title font-bold text-sm text-white">8. Laporan Donasi Jumat Berbagi</h4>
        </div>
        <div class="p-5 space-y-5">
            <p class="text-[11px] text-gray-500">Data laporan ini akan ditampilkan di section "Laporan Donasi Jumat Berbagi" di halaman website publik.</p>

            {{-- Daftar laporan yang ada --}}
            <div class="space-y-3">
                <p class="text-xs font-bold text-gray-600">Laporan tersimpan ({{ count($laporanDonasi) }} bulan):</p>
                @forelse($laporanDonasi as $lIdx => $lap)
                <div class="bg-teal-50 border border-teal-100 rounded-2xl p-4">
                    <div class="flex items-center justify-between gap-3">
                        <div>
                            <p class="text-xs font-bold text-teal-700">{{ $lap['bulan'] }}</p>
                            <div class="flex gap-4 mt-1 text-[10px] text-gray-500">
                                <span class="text-green-600 font-semibold">📥 Masuk: Rp {{ $lap['total_masuk'] }}</span>
                                <span class="text-red-500 font-semibold">📤 Keluar: Rp {{ $lap['total_keluar'] }}</span>
                                <span class="text-teal-700 font-bold">💰 Saldo: Rp {{ $lap['saldo'] }}</span>
                            </div>
                        </div>
                        <div class="flex gap-2 shrink-0">
                            <button type="button"
                                    onclick="fillLaporanForm({{ $lIdx }}, {{ json_encode($lap) }})"
                                    class="w-7 h-7 bg-teal-100 hover:bg-teal-600 text-teal-600 hover:text-white rounded-lg text-[10px] transition flex items-center justify-center" title="Edit">
                                <i class="fa-solid fa-pen"></i>
                            </button>
                            <form method="POST" action="{{ route('admin.content.donasi.destroy', $lIdx) }}"
                                  onsubmit="return confirm('Hapus laporan bulan {{ $lap['bulan'] }}?')" class="inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="w-7 h-7 bg-red-50 hover:bg-red-500 text-red-400 hover:text-white rounded-lg text-[10px] transition flex items-center justify-center" title="Hapus">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center py-6 text-gray-400 text-xs font-semibold bg-gray-50 rounded-2xl border border-dashed border-gray-200">
                    <i class="fa-solid fa-receipt text-2xl mb-2 block opacity-30"></i>
                    Belum ada laporan donasi. Tambahkan laporan pertama di bawah.
                </div>
                @endforelse
            </div>

            {{-- Form tambah/edit laporan --}}
            <form method="POST" action="{{ route('admin.content.donasi.store') }}" id="laporanForm"
                  class="bg-teal-50 border border-teal-100 rounded-2xl p-4 space-y-3">
                @csrf
                <input type="hidden" name="laporan_index" id="laporanIndexInput" value="">
                <p class="text-xs font-bold text-teal-700" id="laporanFormTitle">➕ Tambah Laporan Bulan Baru</p>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-bold text-gray-700 mb-1">Periode Bulan</label>
                        <input type="text" name="laporan_bulan" id="laporanBulan"
                               placeholder="Contoh: Februari 2026"
                               class="w-full bg-white border border-gray-200 rounded-xl p-2.5 text-xs focus:ring-2 focus:ring-teal-500/30 outline-none transition">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Total Pemasukan (Rp)</label>
                        <input type="text" name="laporan_total_masuk" id="laporanTotalMasuk"
                               placeholder="Contoh: 423.500"
                               class="w-full bg-white border border-gray-200 rounded-xl p-2.5 text-xs focus:ring-2 focus:ring-teal-500/30 outline-none transition">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Total Pengeluaran (Rp)</label>
                        <input type="text" name="laporan_total_keluar" id="laporanTotalKeluar"
                               placeholder="Contoh: 375.000"
                               class="w-full bg-white border border-gray-200 rounded-xl p-2.5 text-xs focus:ring-2 focus:ring-teal-500/30 outline-none transition">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Saldo Akhir (Rp)</label>
                        <input type="text" name="laporan_saldo" id="laporanSaldo"
                               placeholder="Contoh: 48.500"
                               class="w-full bg-white border border-gray-200 rounded-xl p-2.5 text-xs focus:ring-2 focus:ring-teal-500/30 outline-none transition">
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-bold text-gray-700 mb-1">Rincian Transaksi</label>
                        <textarea name="laporan_detail" id="laporanDetail" rows="5"
                                  placeholder="Format: Label|Nominal (pisah baris)&#10;Contoh:&#10;Dana bulan lalu|48.500&#10;Uang ta'awun Februari|375.000&#10;Somay|250.000&#10;Hadiah|86.000"
                                  class="w-full bg-white border border-gray-200 rounded-xl p-2.5 text-xs focus:ring-2 focus:ring-teal-500/30 outline-none transition resize-none font-mono"></textarea>
                        <p class="text-[10px] text-gray-400 mt-1">Format setiap baris: <code class="bg-gray-100 px-1 rounded">Nama Item|Jumlah Rupiah</code> (tanpa Rp). Pisahkan dengan Enter.</p>
                    </div>
                </div>

                <div class="flex gap-2">
                    <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white font-bold text-xs px-5 py-2.5 rounded-xl transition shadow-md flex items-center gap-2">
                        <i class="fa-solid fa-floppy-disk"></i> <span id="laporanSubmitLabel">Simpan Laporan</span>
                    </button>
                    <button type="button" onclick="resetLaporanForm()" class="bg-gray-100 hover:bg-gray-200 text-gray-600 font-bold text-xs px-4 py-2.5 rounded-xl transition">
                        Batal/Reset
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>

@push('scripts')
<script>
    // ===== FAQ Form Helper =====
    function fillFaqForm(index, question, answer) {
        document.getElementById('faqIndexInput').value = index;
        document.getElementById('faqQuestion').value = question;
        document.getElementById('faqAnswer').value = answer;
        document.getElementById('faqFormTitle').textContent = '✏️ Edit FAQ #' + (index + 1);
        document.getElementById('faqSubmitLabel').textContent = 'Update FAQ';
        document.getElementById('faqForm').scrollIntoView({ behavior: 'smooth', block: 'center' });
    }

    function resetFaqForm() {
        document.getElementById('faqIndexInput').value = '';
        document.getElementById('faqQuestion').value = '';
        document.getElementById('faqAnswer').value = '';
        document.getElementById('faqFormTitle').textContent = '➕ Tambah FAQ Baru';
        document.getElementById('faqSubmitLabel').textContent = 'Simpan FAQ';
    }

    // ===== Laporan Donasi Form Helper =====
    function fillLaporanForm(index, laporan) {
        document.getElementById('laporanIndexInput').value = index;
        document.getElementById('laporanBulan').value = laporan.bulan || '';
        document.getElementById('laporanTotalMasuk').value = laporan.total_masuk || '';
        document.getElementById('laporanTotalKeluar').value = laporan.total_keluar || '';
        document.getElementById('laporanSaldo').value = laporan.saldo || '';

        // Rebuild detail textarea
        var detailText = '';
        if (laporan.detail && laporan.detail.length) {
            detailText = laporan.detail.map(function(d) {
                return (d.label || '') + '|' + (d.nominal || '');
            }).join('\n');
        }
        document.getElementById('laporanDetail').value = detailText;

        document.getElementById('laporanFormTitle').textContent = '✏️ Edit Laporan: ' + laporan.bulan;
        document.getElementById('laporanSubmitLabel').textContent = 'Update Laporan';
        document.getElementById('laporanForm').scrollIntoView({ behavior: 'smooth', block: 'center' });
    }

    function resetLaporanForm() {
        document.getElementById('laporanIndexInput').value = '';
        document.getElementById('laporanBulan').value = '';
        document.getElementById('laporanTotalMasuk').value = '';
        document.getElementById('laporanTotalKeluar').value = '';
        document.getElementById('laporanSaldo').value = '';
        document.getElementById('laporanDetail').value = '';
        document.getElementById('laporanFormTitle').textContent = '➕ Tambah Laporan Bulan Baru';
        document.getElementById('laporanSubmitLabel').textContent = 'Simpan Laporan';
    }
</script>
@endpush
@endsection
