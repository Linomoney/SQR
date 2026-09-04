@extends('layouts.app')

@section('title', $article->title . ' – Saung Quran Rabbani')
@section('meta_description', $article->excerpt ?? Str::limit(strip_tags($article->content), 160))

@push('styles')
<style>
    /* ===== Artikel Content Typography ===== */
    .artikel-body h1 {
        font-size: 1.6rem;
        font-weight: 900;
        color: #2d4a22;
        margin: 1.5rem 0 0.75rem;
        font-family: var(--font-title, 'Outfit', sans-serif);
        line-height: 1.3;
    }
    .artikel-body h2 {
        font-size: 1.25rem;
        font-weight: 800;
        color: #2d4a22;
        margin: 1.25rem 0 0.6rem;
        font-family: var(--font-title, 'Outfit', sans-serif);
        border-left: 4px solid #e67e22;
        padding-left: 12px;
    }
    .artikel-body h3 {
        font-size: 1rem;
        font-weight: 700;
        color: #365c2a;
        margin: 1rem 0 0.5rem;
    }
    .artikel-body p {
        margin-bottom: 0.85rem;
        line-height: 1.85;
        color: #374151;
    }
    .artikel-body strong, .artikel-body b { color: #1f2937; font-weight: 700; }
    .artikel-body em, .artikel-body i { color: #4b5563; font-style: italic; }
    .artikel-body u { text-decoration: underline; text-underline-offset: 3px; }
    .artikel-body s { color: #9ca3af; }
    .artikel-body ul {
        list-style: disc;
        padding-left: 1.5rem;
        margin-bottom: 0.85rem;
        color: #374151;
        space-y: 4px;
    }
    .artikel-body ol {
        list-style: decimal;
        padding-left: 1.5rem;
        margin-bottom: 0.85rem;
        color: #374151;
    }
    .artikel-body li { margin-bottom: 4px; line-height: 1.75; }
    .artikel-body blockquote {
        border-left: 4px solid #e67e22;
        background: #fff8f0;
        color: #7c4a1a;
        font-style: italic;
        padding: 12px 16px;
        margin: 1rem 0;
        border-radius: 0 12px 12px 0;
        font-size: 0.9em;
    }
    .artikel-body pre.ql-syntax {
        background: #1f2937;
        color: #d1fae5;
        padding: 12px 16px;
        border-radius: 10px;
        font-family: monospace;
        font-size: 12px;
        overflow-x: auto;
        margin: 1rem 0;
    }
    .artikel-body a {
        color: #2d7d32;
        text-decoration: underline;
        text-underline-offset: 2px;
        font-weight: 600;
    }
    .artikel-body a:hover { color: #e67e22; }
    .artikel-body img {
        max-width: 100%;
        border-radius: 14px;
        margin: 1rem auto;
        display: block;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    }
    /* Alignment classes from Quill */
    .artikel-body .ql-align-center { text-align: center; }
    .artikel-body .ql-align-right  { text-align: right; }
    .artikel-body .ql-align-justify { text-align: justify; }
    .artikel-body .ql-indent-1 { padding-left: 2em; }
    .artikel-body .ql-indent-2 { padding-left: 4em; }
</style>
@endpush

@section('content')
<div class="min-h-screen flex flex-col bg-sqr-bg pt-16 sm:pt-20">

    @include('partials.navbar')
    @include('partials.mobile-sidebar')

    <div class="max-w-4xl mx-auto px-4 py-8 flex-1 w-full space-y-8">

        {{-- Breadcrumb & Back --}}
        <div class="flex items-center justify-between gap-3 flex-wrap">
            <a href="{{ route('artikel') }}" class="inline-flex items-center gap-2 text-xs font-bold text-sqr-green hover:text-sqr-orange transition bg-white px-4 py-2 rounded-xl shadow-sm border border-gray-100">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Artikel
            </a>
            <div class="flex items-center gap-2">
                <span class="text-xs font-bold text-sqr-orange uppercase tracking-wider bg-sqr-orange/10 px-3 py-1 rounded-full">
                    {{ $article->category }}
                </span>
                @if(!$article->is_published)
                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider bg-gray-100 px-3 py-1 rounded-full">Draft</span>
                @endif
            </div>
        </div>

        {{-- Main Article --}}
        <article class="bg-white rounded-3xl p-6 sm:p-10 shadow-sm border border-gray-100 space-y-6">

            {{-- Header --}}
            <div class="space-y-3 border-b pb-6">
                <h1 class="font-title font-black text-2xl sm:text-3xl text-sqr-green leading-tight">
                    {{ $article->title }}
                </h1>
                <div class="flex flex-wrap items-center gap-4 text-xs text-gray-500 font-medium">
                    <span class="flex items-center gap-1.5">
                        <i class="fa-solid fa-user text-sqr-orange"></i>
                        {{ $article->author?->name ?? 'Admin SQR' }}
                    </span>
                    <span>•</span>
                    <span class="flex items-center gap-1.5">
                        <i class="fa-solid fa-calendar text-sqr-orange"></i>
                        {{ $article->created_at->format('d M Y · H:i') }} WIB
                    </span>
                    <span>•</span>
                    <span class="flex items-center gap-1.5">
                        <i class="fa-solid fa-clock text-sqr-orange"></i>
                        ~{{ max(1, (int)(str_word_count(strip_tags($article->content)) / 200)) }} menit baca
                    </span>
                </div>
            </div>

            {{-- Media: YouTube embed or Image thumbnail --}}
            @php
                $ytId = null;
                if ($article->media_url && str_contains($article->media_url, 'youtu')) {
                    preg_match('/(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))([\w-]{11})/', $article->media_url, $matches);
                    $ytId = $matches[1] ?? null;
                }
            @endphp

            @if($ytId)
            <div class="rounded-3xl overflow-hidden shadow-md bg-black my-2">
                <div class="aspect-video w-full">
                    <iframe class="w-full h-full" src="https://www.youtube.com/embed/{{ $ytId }}"
                            title="Video Artikel" frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen></iframe>
                </div>
            </div>
            @elseif($article->image_url || $article->media_url)
            <div class="rounded-3xl overflow-hidden shadow-md my-2 max-h-[460px]">
                <img src="{{ $article->image_url ?? $article->media_url }}" alt="{{ $article->title }}"
                     class="w-full h-full object-cover">
            </div>
            @endif

            {{-- Excerpt --}}
            @if($article->excerpt)
            <div class="p-4 rounded-2xl bg-sqr-bg/60 border-l-4 border-sqr-orange italic text-xs sm:text-sm text-sqr-dark font-medium">
                "{{ $article->excerpt }}"
            </div>
            @endif

            {{-- ===== Article Body (Quill HTML rendered) ===== --}}
            <div class="artikel-body text-sm leading-relaxed">
                {!! $article->content !!}
            </div>

            {{-- Footer: Share --}}
            <div class="pt-6 border-t flex flex-col sm:flex-row items-center justify-between gap-4">
                <p class="text-xs text-gray-400">Bagikan artikel ini ke media sosial:</p>
                <div class="flex items-center gap-2">
                    <a href="https://wa.me/?text={{ urlencode($article->title . ' – Baca selengkapnya: ' . request()->fullUrl()) }}"
                       target="_blank"
                       class="flex items-center gap-1.5 bg-emerald-500 hover:bg-emerald-600 text-white font-bold text-xs px-4 py-2 rounded-xl transition">
                        <i class="fa-brands fa-whatsapp text-sm"></i> WhatsApp
                    </a>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}"
                       target="_blank"
                       class="flex items-center gap-1.5 bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs px-4 py-2 rounded-xl transition">
                        <i class="fa-brands fa-facebook-f text-sm"></i> Facebook
                    </a>
                    <button onclick="copyUrl()" title="Salin Link"
                            class="w-9 h-9 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-600 flex items-center justify-center transition">
                        <i class="fa-solid fa-link text-sm" id="copyIcon"></i>
                    </button>
                </div>
            </div>
        </article>

        {{-- Related Articles --}}
        @if($related->isNotEmpty())
        <div class="space-y-4">
            <h3 class="font-title font-bold text-lg text-sqr-green">Artikel Terkait Lainnya</h3>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                @foreach($related as $r)
                <a href="{{ route('artikel.detail', $r->slug) }}"
                   class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md hover:border-sqr-green/20 transition space-y-2 block group">
                    @if($r->image_url || $r->media_url)
                    <div class="h-28 rounded-xl overflow-hidden mb-3">
                        <img src="{{ $r->image_url ?? $r->media_url }}" alt="{{ $r->title }}"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    </div>
                    @endif
                    <span class="text-[9px] font-bold uppercase tracking-wider text-sqr-orange">{{ $r->category }}</span>
                    <h4 class="font-title font-bold text-xs text-sqr-green group-hover:text-sqr-orange transition line-clamp-2">{{ $r->title }}</h4>
                    <p class="text-[10px] text-gray-400 flex items-center gap-1">
                        <i class="fa-solid fa-calendar"></i> {{ $r->created_at->format('d M Y') }}
                    </p>
                </a>
                @endforeach
            </div>
        </div>
        @endif

    </div>

    {{-- Footer --}}
    <footer class="bg-sqr-dark text-white py-6 text-center text-xs text-white/50 border-t border-white/10 mt-auto">
        © {{ date('Y') }} Saung Quran Rabbani · Yayasan Bina Cahaya Ilmu Rabbani
    </footer>
</div>

@push('scripts')
<script>
function copyUrl() {
    navigator.clipboard.writeText(window.location.href).then(function() {
        var icon = document.getElementById('copyIcon');
        icon.className = 'fa-solid fa-check text-sm text-sqr-green';
        setTimeout(function() {
            icon.className = 'fa-solid fa-link text-sm';
        }, 2000);
    });
}
</script>
@endpush
@endsection
