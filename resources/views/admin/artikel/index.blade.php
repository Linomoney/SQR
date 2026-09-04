@extends('layouts.dashboard')

@section('title', 'Kelola Artikel & Berita')

@section('content')
<div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 mb-6">
    <div class="flex flex-col md:flex-row items-center justify-between gap-4 border-b pb-5 mb-5">
        <div>
            <h3 class="font-title font-bold text-lg text-sqr-green">Daftar Artikel & News SQR</h3>
            <p class="text-xs text-gray-500">Kelola artikel kegiatan, pengumuman, dan berita edukasi Al-Quran</p>
        </div>
        <a href="{{ route('admin.artikel.create') }}" class="bg-sqr-green hover:bg-sqr-dark text-white text-xs font-bold px-4 py-2.5 rounded-xl transition flex items-center gap-2 shadow-md">
            <i class="fa-solid fa-plus"></i> Buat Artikel Baru
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left text-xs">
            <thead class="bg-sqr-bg/50 text-sqr-green font-title uppercase tracking-wider text-[10px]">
                <tr>
                    <th class="p-3.5 rounded-l-xl">Judul Artikel</th>
                    <th class="p-3.5">Kategori</th>
                    <th class="p-3.5">Penulis</th>
                    <th class="p-3.5">Status Publikasi</th>
                    <th class="p-3.5 text-center rounded-r-xl">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($articles as $a)
                <tr class="hover:bg-gray-50/80 transition">
                    <td class="p-3.5">
                        <p class="font-bold text-gray-800 line-clamp-1">{{ $a->title }}</p>
                        <p class="text-[10px] text-gray-400">Slug: {{ $a->slug }}</p>
                    </td>
                    <td class="p-3.5 font-bold text-sqr-orange">{{ $a->category }}</td>
                    <td class="p-3.5 text-gray-600">{{ $a->author?->name ?? 'Admin' }}</td>
                    <td class="p-3.5">
                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase {{ $a->is_published ? 'bg-emerald-100 text-emerald-800' : 'bg-gray-100 text-gray-600' }}">
                            {{ $a->is_published ? 'Published' : 'Draft' }}
                        </span>
                    </td>
                    <td class="p-3.5 text-center">
                        <div class="flex items-center justify-center gap-1.5">
                            <a href="{{ route('artikel.detail', $a->slug) }}" target="_blank" class="p-2 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100" title="Preview"><i class="fa-solid fa-eye"></i></a>
                            <a href="{{ route('admin.artikel.edit', $a) }}" class="p-2 bg-amber-50 text-amber-600 rounded-lg hover:bg-amber-100" title="Edit"><i class="fa-solid fa-pen"></i></a>
                            <form method="POST" action="{{ route('admin.artikel.destroy', $a) }}" onsubmit="return confirm('Hapus artikel ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="p-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100" title="Hapus"><i class="fa-solid fa-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="p-8 text-center text-gray-400">Belum ada artikel dipublikasikan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $articles->links() }}
    </div>
</div>
@endsection
