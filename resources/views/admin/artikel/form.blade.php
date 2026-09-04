@extends('layouts.dashboard')

@section('title', isset($article) ? 'Edit Artikel' : 'Tulis Artikel Baru')

@push('styles')
{{-- Quill Snow Theme --}}
<link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet">
<style>
    /* Editor container */
    #quill-editor {
        min-height: 360px;
        max-height: 600px;
        overflow-y: auto;
        font-size: 13px;
        line-height: 1.8;
        font-family: 'Inter', sans-serif;
        border-radius: 0 0 12px 12px;
        border: 1px solid #e5e7eb;
        border-top: none;
    }
    .ql-toolbar.ql-snow {
        border: 1px solid #e5e7eb;
        border-radius: 12px 12px 0 0;
        background: #f9fafb;
        padding: 8px 10px;
        flex-wrap: wrap;
        gap: 2px;
    }
    .ql-toolbar.ql-snow .ql-formats {
        margin-right: 8px;
    }
    .ql-container.ql-snow {
        font-size: 13px;
    }
    /* Image in editor */
    .ql-editor img {
        max-width: 100%;
        border-radius: 10px;
        margin: 8px 0;
        display: block;
    }
    .ql-editor p { margin-bottom: 6px; }
    /* Insert image button custom icon */
    .ql-insertImage::before { content: '🖼'; font-size: 14px; }
    /* Character count */
    #charCount { font-size: 10px; color: #9ca3af; text-align: right; padding: 4px 12px; }
</style>
@endpush

@section('content')
<div class="max-w-3xl mx-auto space-y-4">

    {{-- Page Header --}}
    <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 flex items-center gap-4">
        <div class="w-12 h-12 bg-sqr-green rounded-2xl flex items-center justify-center shadow-md shrink-0">
            <i class="fa-solid fa-newspaper text-white text-lg"></i>
        </div>
        <div>
            <h3 class="font-title font-bold text-lg text-sqr-green">
                {{ isset($article) ? 'Edit Artikel' : 'Tulis Artikel Baru' }}
            </h3>
            <p class="text-xs text-gray-500">Publikasikan konten berita, edukasi, atau laporan kegiatan SQR</p>
        </div>
    </div>

    <form method="POST" action="{{ isset($article) ? route('admin.artikel.update', $article) : route('admin.artikel.store') }}"
          id="artikelForm" class="space-y-4">
        @csrf
        @if(isset($article)) @method('PUT') @endif

        {{-- Hidden field: konten dari Quill akan di-inject ke sini --}}
        <input type="hidden" name="content" id="hiddenContent" value="{{ old('content', $article->content ?? '') }}">

        {{-- ===== META ARTIKEL ===== --}}
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 space-y-4">
            <h4 class="font-title font-bold text-sm text-sqr-green border-b pb-2 flex items-center gap-2">
                <i class="fa-solid fa-circle-info text-sqr-orange"></i> Informasi Artikel
            </h4>

            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">Judul Artikel <span class="text-red-500">*</span></label>
                <input type="text" name="title" value="{{ old('title', $article->title ?? '') }}" required
                       placeholder="Masukkan judul artikel yang menarik..."
                       class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 text-sm font-semibold text-gray-800 outline-none focus:ring-2 focus:ring-sqr-green/30 focus:border-sqr-green transition">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Kategori <span class="text-red-500">*</span></label>
                    <select name="category" required
                            class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 text-xs outline-none focus:ring-2 focus:ring-sqr-green/30 focus:border-sqr-green transition">
                        @foreach(['Kegiatan' => 'Kegiatan SQR', 'Acara' => 'Acara / Lomba', 'Pengumuman' => 'Pengumuman Resmi', 'Edukasi' => 'Edukasi Al-Quran'] as $val => $lbl)
                        <option value="{{ $val }}" {{ old('category', $article->category ?? '') == $val ? 'selected' : '' }}>{{ $lbl }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">URL Thumbnail Gambar</label>
                    <input type="url" name="media_url" value="{{ old('media_url', $article->media_url ?? '') }}"
                           id="mediaUrlInput"
                           placeholder="https://res.cloudinary.com/..."
                           class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 text-xs outline-none focus:ring-2 focus:ring-sqr-green/30 focus:border-sqr-green transition">
                    <p class="text-[10px] text-gray-400 mt-1">Gambar ini jadi thumbnail di daftar artikel.</p>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">Kutipan Ringkas (Excerpt)</label>
                <textarea name="excerpt" rows="2"
                          placeholder="Ringkasan singkat yang muncul di preview artikel (opsional)..."
                          class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-xs outline-none focus:ring-2 focus:ring-sqr-green/30 focus:border-sqr-green transition resize-none">{{ old('excerpt', $article->excerpt ?? '') }}</textarea>
            </div>
        </div>

        {{-- ===== RICH TEXT EDITOR ===== --}}
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 space-y-3">
            <div class="flex items-center justify-between border-b pb-3">
                <h4 class="font-title font-bold text-sm text-sqr-green flex items-center gap-2">
                    <i class="fa-solid fa-pen-nib text-sqr-orange"></i> Isi Konten Artikel
                    <span class="text-red-500">*</span>
                </h4>
                <div class="flex gap-2">
                    {{-- Insert image from URL --}}
                    <button type="button" onclick="insertImageUrl()" title="Sisipkan Gambar dari URL"
                            class="bg-sqr-bg hover:bg-sqr-green/20 text-sqr-green font-bold text-[10px] px-3 py-1.5 rounded-lg border border-sqr-green/20 transition flex items-center gap-1.5">
                        <i class="fa-solid fa-image text-sqr-orange"></i> Sisipkan Gambar
                    </button>
                </div>
            </div>

            {{-- Quill Editor --}}
            <div>
                <div id="quill-editor">{!! old('content', $article->content ?? '') !!}</div>
                <div id="charCount">0 karakter</div>
            </div>

            <div class="bg-sqr-bg/50 rounded-xl p-3 text-[10px] text-gray-500 space-y-1">
                <p class="font-bold text-sqr-green text-xs">💡 Panduan Editor:</p>
                <ul class="space-y-0.5 list-disc list-inside">
                    <li><strong>B</strong> = Tebal (Bold) · <em>I</em> = Miring (Italic) · <u>U</u> = Garis Bawah</li>
                    <li>Atur alignment: ⬅ Kiri | ☰ Tengah | ➡ Kanan | ⬜ Justify</li>
                    <li>H1 / H2 = Judul Besar/Kecil · Kutipan (") = Blockquote</li>
                    <li>Gambar: klik tombol "Sisipkan Gambar" di atas, masukkan URL gambar</li>
                </ul>
            </div>
        </div>

        {{-- ===== PENGATURAN PUBLIKASI ===== --}}
        <div class="bg-white rounded-3xl p-5 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between">
                <label class="flex items-center gap-3 cursor-pointer">
                    <div class="relative">
                        <input type="checkbox" name="is_published" id="is_published" value="1"
                               {{ old('is_published', $article->is_published ?? true) ? 'checked' : '' }}
                               class="sr-only peer">
                        <div class="w-10 h-5 bg-gray-200 rounded-full peer peer-checked:bg-sqr-green transition-colors"></div>
                        <div class="absolute top-0.5 left-0.5 w-4 h-4 bg-white rounded-full shadow transition-transform peer-checked:translate-x-5"></div>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-700">Publikasikan langsung di website</p>
                        <p class="text-[10px] text-gray-400">Jika dinonaktifkan, artikel tersimpan sebagai draft</p>
                    </div>
                </label>

                <div class="flex gap-3">
                    <a href="{{ route('admin.artikel.index') }}"
                       class="bg-gray-100 text-gray-600 font-bold text-xs px-5 py-2.5 rounded-xl hover:bg-gray-200 transition">
                        Batal
                    </a>
                    <button type="submit" id="submitBtn"
                            class="bg-sqr-green hover:bg-sqr-dark text-white font-bold text-xs px-6 py-2.5 rounded-xl transition shadow-md flex items-center gap-2">
                        <i class="fa-solid fa-floppy-disk"></i>
                        {{ isset($article) ? 'Update Artikel' : 'Simpan & Publikasikan' }}
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

@push('scripts')
{{-- Quill JS --}}
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
<script>
    // Custom toolbar config
    var toolbarOptions = [
        [{ 'header': [1, 2, 3, false] }],
        ['bold', 'italic', 'underline', 'strike'],
        [{ 'color': [] }, { 'background': [] }],
        [{ 'align': [] }],
        [{ 'list': 'ordered' }, { 'list': 'bullet' }],
        ['blockquote', 'code-block'],
        ['link'],
        ['clean']
    ];

    var quill = new Quill('#quill-editor', {
        theme: 'snow',
        placeholder: 'Mulai menulis konten artikel di sini...',
        modules: {
            toolbar: toolbarOptions
        }
    });

    // Load existing HTML content (for edit mode)
    var hiddenContent = document.getElementById('hiddenContent').value;
    if (hiddenContent && hiddenContent.trim() !== '') {
        quill.clipboard.dangerouslyPasteHTML(hiddenContent);
    }

    // Character counter
    quill.on('text-change', function() {
        var text = quill.getText();
        var count = text.replace(/\n/g, '').length;
        document.getElementById('charCount').textContent = count.toLocaleString('id-ID') + ' karakter';
    });

    // Before submit: copy Quill HTML to hidden input
    document.getElementById('artikelForm').addEventListener('submit', function(e) {
        var html = quill.root.innerHTML;
        // Don't submit if only empty paragraph
        if (html === '<p><br></p>' || html.trim() === '') {
            e.preventDefault();
            alert('Isi konten artikel tidak boleh kosong!');
            return false;
        }
        document.getElementById('hiddenContent').value = html;

        // Show loading state
        var btn = document.getElementById('submitBtn');
        btn.disabled = true;
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Menyimpan...';
    });

    // Insert image from URL prompt
    function insertImageUrl() {
        var url = prompt('Masukkan URL gambar (Cloudinary, Google Drive, dsb):');
        if (url && url.trim() !== '') {
            url = url.trim();
            var range = quill.getSelection(true);
            quill.insertEmbed(range ? range.index : quill.getLength(), 'image', url, Quill.sources.USER);
            quill.insertText(range ? range.index + 1 : quill.getLength(), '\n', Quill.sources.USER);
        }
    }

    // Toggle switch CSS trick for peer-checked
    var toggleInput = document.getElementById('is_published');
    var toggleDot   = toggleInput.parentElement.querySelector('.absolute');
    toggleInput.addEventListener('change', function() {
        // Tailwind peer handles this automatically via CSS
    });
</script>
@endpush
@endsection
