@extends('layouts.dashboard')

@section('title', 'Manajemen Galeri Foto SQR')

@section('content')
<div class="space-y-6">

    <!-- Header & Action -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white p-6 rounded-3xl shadow-sm border border-gray-100">
        <div>
            <span class="bg-sqr-green/10 text-sqr-green font-bold text-[10px] px-3 py-1 rounded-full uppercase tracking-wider inline-block mb-1">
                📸 Dokumentasi Kegiatan
            </span>
            <h1 class="font-title text-xl font-bold text-sqr-green">Manajemen Galeri Foto Kegiatan</h1>
            <p class="text-xs text-gray-500 mt-1">Upload dan atur dokumentasi kegiatan santri, wisuda, sanlat, dan aksi sosial</p>
        </div>
        <button onclick="document.getElementById('addGalleryModal').classList.remove('hidden')" 
                class="bg-gradient-to-r from-sqr-green to-sqr-dark hover:from-sqr-dark hover:to-sqr-green text-white font-title font-bold text-xs px-5 py-3 rounded-2xl transition shadow-lg flex items-center gap-2 transform active:scale-95">
            <i class="fa-solid fa-plus-circle text-sqr-orange text-sm"></i> Tambah Foto Galeri
        </button>
    </div>

    <!-- Gallery Grid Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @forelse($galleries as $gal)
        <div class="bg-white rounded-3xl overflow-hidden shadow-sm border border-gray-100 flex flex-col justify-between p-4 space-y-3 hover:shadow-xl transition-all duration-300 group">
            <div>
                <div class="relative h-44 rounded-2xl overflow-hidden mb-3">
                    <img src="{{ $gal->image_url }}" alt="{{ $gal->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    <span class="absolute top-2.5 left-2.5 bg-sqr-dark/90 backdrop-blur-sm text-sqr-bg text-[9px] font-bold px-3 py-0.5 rounded-full uppercase border border-white/20">
                        {{ $gal->category }}
                    </span>
                </div>
                <h3 class="font-title font-bold text-sm text-sqr-green line-clamp-1 group-hover:text-sqr-orange transition">{{ $gal->title }}</h3>
                <p class="text-[11px] text-gray-500 line-clamp-2 mt-1 leading-relaxed">{{ $gal->description }}</p>
            </div>

            <!-- Actions -->
            <div class="pt-3 border-t border-gray-100 flex items-center justify-between">
                <span class="text-[10px] text-gray-400 font-semibold"><i class="fa-solid fa-calendar-day mr-1 text-sqr-orange"></i> {{ $gal->event_date?->format('d M Y') }}</span>
                <form action="{{ route('admin.galleries.destroy', $gal->id) }}" method="POST" onsubmit="return confirm('Hapus foto galeri ini?')">
                    @csrf
                    @method('DELETE')
                    <button class="bg-red-50 text-red-600 hover:bg-red-100 text-xs font-bold px-3 py-1.5 rounded-xl transition flex items-center gap-1">
                        <i class="fa-solid fa-trash text-[10px]"></i> Hapus
                    </button>
                </form>
            </div>
        </div>
        @empty
        <div class="col-span-full bg-white p-12 text-center rounded-3xl border border-gray-100 shadow-sm">
            <i class="fa-solid fa-images text-5xl text-sqr-green/30 mb-3 block"></i>
            <p class="text-sm font-semibold text-gray-500">Belum ada foto galeri diunggah.</p>
        </div>
        @endforelse
    </div>
</div>

<!-- ==================== MODAL TAMBAH GALERI ==================== -->
<div id="addGalleryModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-[999] hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-8 space-y-5 relative shadow-2xl animate__animated animate__fadeInUp max-h-[90vh] overflow-y-auto">
        <div class="flex justify-between items-center border-b border-gray-100 pb-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-sqr-green/10 flex items-center justify-center text-sqr-green">
                    <i class="fa-solid fa-camera-retro text-lg"></i>
                </div>
                <div>
                    <h3 class="font-title font-bold text-base text-sqr-green">Tambah Foto Galeri Kegiatan</h3>
                    <p class="text-[11px] text-gray-500">Unggah foto dokumentasi kegiatan santri SQR</p>
                </div>
            </div>
            <button onclick="document.getElementById('addGalleryModal').classList.add('hidden')" class="w-8 h-8 rounded-full bg-gray-100 hover:bg-gray-200 text-gray-500 flex items-center justify-center transition">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <form action="{{ route('admin.galleries.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1.5">Judul Foto / Kegiatan *</label>
                <div class="relative">
                    <i class="fa-solid fa-heading absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                    <input type="text" name="title" required class="w-full bg-gray-50/80 border border-gray-200 rounded-xl px-3.5 py-2.5 pl-10 text-xs font-medium focus:ring-2 focus:ring-sqr-green/30 focus:border-sqr-green outline-none transition" placeholder="Contoh: KBM Santri Ummi Jilid 2">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1.5">Kategori Kegiatan *</label>
                    <select name="category" required class="w-full bg-gray-50/80 border border-gray-200 rounded-xl px-3.5 py-2.5 text-xs font-medium focus:ring-2 focus:ring-sqr-green/30 focus:border-sqr-green outline-none transition">
                        <option value="KBM Santri">KBM Santri</option>
                        <option value="Sanlat">Sanlat Ramadhan</option>
                        <option value="Kajian">Kajian Tematik</option>
                        <option value="Donasi">Aksi Donasi</option>
                        <option value="Wisuda">Wisuda Tahfidz</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1.5">Tanggal Acara</label>
                    <input type="date" name="event_date" value="{{ date('Y-m-d') }}" class="w-full bg-gray-50/80 border border-gray-200 rounded-xl px-3.5 py-2.5 text-xs font-medium focus:ring-2 focus:ring-sqr-green/30 focus:border-sqr-green outline-none transition">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1.5">URL Foto Dokumentasi *</label>
                <div class="relative">
                    <i class="fa-solid fa-link absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                    <input type="url" name="image_url" required class="w-full bg-gray-50/80 border border-gray-200 rounded-xl px-3.5 py-2.5 pl-10 text-xs font-medium focus:ring-2 focus:ring-sqr-green/30 focus:border-sqr-green outline-none transition" placeholder="https://images.unsplash.com/...">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1.5">Deskripsi Foto Kegiatan</label>
                <textarea name="description" rows="3" class="w-full bg-gray-50/80 border border-gray-200 rounded-xl px-3.5 py-2.5 text-xs font-medium focus:ring-2 focus:ring-sqr-green/30 focus:border-sqr-green outline-none transition" placeholder="Tuliskan keterangan singkat mengenai momen kegiatan ini..."></textarea>
            </div>

            <div class="pt-3">
                <button type="submit" class="w-full bg-gradient-to-r from-sqr-green to-sqr-dark hover:from-sqr-dark hover:to-sqr-green text-white font-title font-bold text-xs py-3.5 rounded-2xl shadow-lg transition flex items-center justify-center gap-2">
                    <i class="fa-solid fa-floppy-disk text-sqr-orange"></i> Simpan Foto Galeri
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
