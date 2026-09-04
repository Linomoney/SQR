@extends('layouts.app')

@section('title', 'Artikel & Berita SQR')

@section('content')
<div class="min-h-screen flex flex-col bg-sqr-bg pt-16 sm:pt-20">

    @include('partials.navbar')
    @include('partials.mobile-sidebar')

    <!-- Hero Banner -->
    <div class="bg-gradient-to-br from-sqr-dark via-sqr-green to-[#3d6030] text-white py-12 px-4 text-center">
        <h1 class="text-3xl sm:text-4xl font-title font-black text-white">Artikel, Berita & Edukasi SQR</h1>
        <p class="text-sm text-sqr-light-green mt-2">Kumpulan tulisan inspiratif, informasi kegiatan, dan panduan Al-Qur'an</p>
    </div>

    <!-- Articles Grid -->
    <div class="max-w-6xl mx-auto px-4 py-12 flex-1 w-full space-y-8">

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @forelse($articles as $a)
            @php
                $thumbnail = null;
                if ($a->image_url) {
                    $thumbnail = $a->image_url;
                } elseif ($a->media_url) {
                    if (str_contains($a->media_url, 'youtu')) {
                        preg_match('/(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))([\w-]{11})/', $a->media_url, $matches);
                        $ytId = $matches[1] ?? null;
                        if ($ytId) {
                            $thumbnail = "https://img.youtube.com/vi/{$ytId}/hqdefault.jpg";
                        }
                    } else {
                        $thumbnail = $a->media_url;
                    }
                }
            @endphp

            <article class="bg-white rounded-3xl overflow-hidden shadow-sm border border-gray-100 flex flex-col hover:shadow-md transition group">
                <div class="relative h-48 bg-sqr-dark overflow-hidden shrink-0">
                    @if($thumbnail)
                        <img src="{{ $thumbnail }}" alt="{{ $a->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    @else
                        <div class="w-full h-full bg-gradient-to-br from-sqr-green to-sqr-dark flex items-center justify-center p-4">
                            <img src="https://res.cloudinary.com/ddh5nkwv7/image/upload/v1782638700/logo_sqr_atzzpb.png" alt="Logo SQR" class="h-16 w-auto opacity-70">
                        </div>
                    @endif
                    <span class="absolute top-3 left-3 bg-sqr-orange text-white text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-wider shadow-md">
                        {{ $a->category }}
                    </span>
                </div>

                <div class="p-5 flex-1 flex flex-col justify-between space-y-3">
                    <div>
                        <h3 class="font-title font-bold text-base text-sqr-green group-hover:text-sqr-orange transition line-clamp-2">
                            {{ $a->title }}
                        </h3>
                        <p class="text-xs text-gray-500 mt-2 line-clamp-3 leading-relaxed">
                            {{ $a->excerpt ?? Str::limit(strip_tags($a->content), 120) }}
                        </p>
                    </div>

                    <div class="pt-3 border-t border-gray-100 flex items-center justify-between text-xs text-gray-400 font-semibold">
                        <span>{{ $a->created_at->format('d M Y') }}</span>
                        <a href="{{ route('artikel.detail', $a->slug) }}" class="text-sqr-green font-bold group-hover:text-sqr-orange transition">
                            Baca Selengkapnya →
                        </a>
                    </div>
                </div>
            </article>
            @empty
            <div class="col-span-3 text-center py-16 text-gray-400">
                <i class="fa-solid fa-newspaper text-5xl block mb-3 opacity-30"></i>
                <p class="text-sm font-bold text-gray-600">Belum ada artikel dipublikasikan.</p>
            </div>
            @endforelse
        </div>

        <div class="mt-4">
            {{ $articles->links() }}
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-sqr-dark text-white py-6 text-center text-xs text-white/50 border-t border-white/10 mt-auto">
        © {{ date('Y') }} Saung Quran Rabbani · Yayasan Bina Cahaya Ilmu Rabbani
    </footer>
</div>
@endsection
