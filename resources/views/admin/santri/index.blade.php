@extends('layouts.dashboard')

@section('title', 'Kelola Data Santri SQR')

@section('content')
<div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 mb-6">
    <div class="flex flex-col md:flex-row items-center justify-between gap-4 border-b pb-5 mb-5">
        <div>
            <h3 class="font-title font-bold text-lg text-sqr-green">Daftar Santri SQR</h3>
            <p class="text-xs text-gray-500">Kelola data santri, penempatan kelas, dan Wali murid</p>
        </div>
        <a href="{{ route('admin.santri.create') }}" class="bg-sqr-green hover:bg-sqr-dark text-white text-xs font-bold px-4 py-2.5 rounded-xl transition flex items-center gap-2 shadow-md">
            <i class="fa-solid fa-plus"></i> Tambah Santri Baru
        </a>
    </div>

    <!-- Filters -->
    <form method="GET" action="{{ route('admin.santri.index') }}" class="grid grid-cols-1 sm:grid-cols-3 gap-3 mb-5">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama / NIS santri..."
               class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2 text-xs focus:outline-none focus:border-sqr-orange">
        
        <select name="class_id" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2 text-xs focus:outline-none focus:border-sqr-orange">
            <option value="">-- Semua Kelas --</option>
            @foreach($classes as $c)
            <option value="{{ $c->id }}" {{ request('class_id') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
            @endforeach
        </select>

        <button type="submit" class="bg-sqr-orange hover:bg-orange-600 text-white text-xs font-bold px-4 py-2 rounded-xl transition">
            Filter Data
        </button>
    </form>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="w-full text-left text-xs">
            <thead class="bg-sqr-bg/50 text-sqr-green font-title uppercase tracking-wider text-[10px]">
                <tr>
                    <th class="p-3.5 rounded-l-xl">NIS</th>
                    <th class="p-3.5">Nama Santri</th>
                    <th class="p-3.5">Kelas</th>
                    <th class="p-3.5">Wali Santri</th>
                    <th class="p-3.5">Progress Hafalan</th>
                    <th class="p-3.5 text-center rounded-r-xl">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($santri as $s)
                <tr class="hover:bg-gray-50/80 transition">
                    <td class="p-3.5 font-bold text-sqr-orange">{{ $s->nis }}</td>
                    <td class="p-3.5 font-bold text-gray-800">{{ $s->fullName }} ({{ $s->gender }})</td>
                    <td class="p-3.5 font-semibold text-sqr-green">{{ $s->sqrClass?->name ?? 'Belum ada' }}</td>
                    <td class="p-3.5 text-gray-600">{{ $s->wali?->name ?? 'Belum terhubung' }}</td>
                    <td class="p-3.5 font-bold text-emerald-700">
                        {{ $s->progress_summary['completedJuzCount'] }} Juz ({{ $s->progress_summary['progressPercentage'] }}%)
                    </td>
                    <td class="p-3.5 text-center">
                        <div class="flex items-center justify-center gap-1.5">
                            <a href="{{ route('admin.santri.show', $s) }}" class="p-2 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100" title="Detail"><i class="fa-solid fa-eye"></i></a>
                            <a href="{{ route('admin.santri.edit', $s) }}" class="p-2 bg-amber-50 text-amber-600 rounded-lg hover:bg-amber-100" title="Edit"><i class="fa-solid fa-pen"></i></a>
                            <form method="POST" action="{{ route('admin.santri.destroy', $s) }}" onsubmit="return confirm('Hapus santri ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="p-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100" title="Hapus"><i class="fa-solid fa-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="p-8 text-center text-gray-400">Tidak ada data santri ditemukan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $santri->links() }}
    </div>
</div>
@endsection
