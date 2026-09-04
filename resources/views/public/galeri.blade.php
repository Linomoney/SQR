@extends('layouts.app')

@section('title', 'Galeri Kegiatan - Saung Quran Rabbani')
@section('meta_description', 'Dokumentasi foto dan video kegiatan belajar mengajar Al-Quran, Sanlat, Kajian, dan Program Sosial Saung Quran Rabbani')

@section('content')

@include('partials.navbar')
@include('partials.mobile-sidebar')

<!-- Header Banner Galeri -->
<section class="pt-28 pb-12 bg-gradient-to-b from-sqr-dark to-sqr-green text-white relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
        <span class="bg-sqr-orange/20 text-sqr-orange border border-sqr-orange/40 text-xs font-bold px-4 py-1.5 rounded-full uppercase tracking-wider inline-block mb-3">
            📸 Dokumentasi Lembaga
        </span>
        <h1 class="font-title text-3xl sm:text-5xl font-black text-white tracking-tight">Galeri Kegiatan SQR</h1>
        <p class="mt-3 text-sm sm:text-base text-gray-200 max-w-2xl mx-auto leading-relaxed">
            Abadikan momen berharga pembelajaran Al-Quran, wisuda santri, pesantren kilat Ramadhan, dan aksi donasi ta'awun masyarakat.
        </p>
    </div>
</section>

<!-- Filter Categories & Gallery Grid -->
<section class="py-12 bg-[#f0f8d3] min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Category Filter Buttons -->
        <div class="flex items-center justify-center gap-2 flex-wrap mb-10" id="galleryFilters">
            <button onclick="filterGallery('all', this)" class="gallery-filter-btn bg-sqr-green text-white px-5 py-2 rounded-2xl text-xs font-bold shadow-md transition transform active:scale-95">
                Semua Foto
            </button>
            <button onclick="filterGallery('KBM Santri', this)" class="gallery-filter-btn bg-white text-sqr-green hover:bg-sqr-green hover:text-white px-5 py-2 rounded-2xl text-xs font-bold shadow-sm transition transform active:scale-95">
                KBM Santri
            </button>
            <button onclick="filterGallery('Sanlat', this)" class="gallery-filter-btn bg-white text-sqr-green hover:bg-sqr-green hover:text-white px-5 py-2 rounded-2xl text-xs font-bold shadow-sm transition transform active:scale-95">
                Sanlat Ramadhan
            </button>
            <button onclick="filterGallery('Kajian', this)" class="gallery-filter-btn bg-white text-sqr-green hover:bg-sqr-green hover:text-white px-5 py-2 rounded-2xl text-xs font-bold shadow-sm transition transform active:scale-95">
                Kajian Tematik
            </button>
            <button onclick="filterGallery('Donasi', this)" class="gallery-filter-btn bg-white text-sqr-green hover:bg-sqr-green hover:text-white px-5 py-2 rounded-2xl text-xs font-bold shadow-sm transition transform active:scale-95">
                Aksi Donasi
            </button>
            <button onclick="filterGallery('Wisuda', this)" class="gallery-filter-btn bg-white text-sqr-green hover:bg-sqr-green hover:text-white px-5 py-2 rounded-2xl text-xs font-bold shadow-sm transition transform active:scale-95">
                Wisuda Tahfidz
            </button>
        </div>

        <!-- Grid Images -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6" id="galleryGrid">
            @forelse($galleries as $gal)
                <div class="gallery-item group bg-white rounded-3xl overflow-hidden shadow-lg border border-sqr-green/10 transition-all duration-300 hover:-translate-y-1.5 hover:shadow-2xl" data-category="{{ $gal->category }}">
                    <div class="relative h-60 overflow-hidden cursor-pointer" onclick="openLightbox('{{ $gal->image_url }}', '{{ addslashes($gal->title) }}', '{{ addslashes($gal->description) }}')">
                        <img src="{{ $gal->image_url }}" alt="{{ $gal->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-5">
                            <span class="bg-sqr-orange text-white text-[10px] font-bold px-3 py-1 rounded-full flex items-center gap-1 shadow-md">
                                <i class="fa-solid fa-expand"></i> Perbesar Foto
                            </span>
                        </div>
                        <span class="absolute top-3 left-3 bg-sqr-dark/90 backdrop-blur-sm text-sqr-bg text-[10px] font-bold px-3 py-1 rounded-full border border-white/20">
                            {{ $gal->category }}
                        </span>
                    </div>
                    <div class="p-5">
                        <div class="text-[10px] font-semibold text-sqr-orange mb-1">
                            <i class="fa-solid fa-calendar-day mr-1"></i> {{ $gal->event_date?->format('d M Y') ?? 'Dokumentasi SQR' }}
                        </div>
                        <h3 class="font-title font-bold text-base text-sqr-green line-clamp-1 group-hover:text-sqr-orange transition">{{ $gal->title }}</h3>
                        <p class="text-xs text-gray-600 line-clamp-2 mt-1.5 leading-relaxed">{{ $gal->description }}</p>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-16 bg-white rounded-3xl shadow-sm border border-sqr-green/10">
                    <i class="fa-solid fa-images text-5xl text-sqr-green/30 mb-3 block"></i>
                    <p class="text-gray-500 text-sm font-semibold">Belum ada foto galeri dipublikasikan.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- Lightbox Modal -->
<div id="lightboxModal" class="fixed inset-0 bg-black/90 backdrop-blur-md z-[9999] hidden items-center justify-center p-4">
    <button onclick="closeLightbox()" class="absolute top-5 right-5 text-white/80 hover:text-white w-10 h-10 rounded-full bg-white/10 flex items-center justify-center transition">
        <i class="fa-solid fa-xmark text-xl"></i>
    </button>
    <div class="max-w-4xl w-full text-center animate__animated animate__zoomIn">
        <img id="lightboxImg" src="" alt="Detail Foto" class="max-h-[75vh] mx-auto rounded-2xl shadow-2xl object-contain border border-white/20">
        <h3 id="lightboxTitle" class="font-title font-bold text-xl text-white mt-4"></h3>
        <p id="lightboxDesc" class="text-xs text-gray-300 mt-1 max-w-xl mx-auto"></p>
    </div>
</div>

<script>
    function filterGallery(cat, btn) {
        document.querySelectorAll('.gallery-filter-btn').forEach(b => {
            b.classList.remove('bg-sqr-green', 'text-white');
            b.classList.add('bg-white', 'text-sqr-green');
        });
        btn.classList.remove('bg-white', 'text-sqr-green');
        btn.classList.add('bg-sqr-green', 'text-white');

        var items = document.querySelectorAll('.gallery-item');
        items.forEach(item => {
            if (cat === 'all' || item.getAttribute('data-category') === cat) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        });
    }

    function openLightbox(url, title, desc) {
        document.getElementById('lightboxImg').src = url;
        document.getElementById('lightboxTitle').innerText = title;
        document.getElementById('lightboxDesc').innerText = desc;
        var modal = document.getElementById('lightboxModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }

    function closeLightbox() {
        var modal = document.getElementById('lightboxModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.style.overflow = '';
    }
</script>

@endsection
