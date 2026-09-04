@extends('layouts.dashboard')

@section('title', 'Kelola Pengguna Sistem')

@section('content')
<div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 mb-6">
    <div class="flex flex-col md:flex-row items-center justify-between gap-4 border-b pb-5 mb-5">
        <div>
            <h3 class="font-title font-bold text-lg text-sqr-green">Daftar Akun Pengguna</h3>
            <p class="text-xs text-gray-500">Kelola akun Admin, Ustadz, dan Wali Santri beserta hak aksesnya</p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="bg-sqr-green hover:bg-sqr-dark text-white text-xs font-bold px-4 py-2.5 rounded-xl transition flex items-center gap-2 shadow-md">
            <i class="fa-solid fa-user-plus"></i> Tambah Pengguna Baru
        </a>
    </div>

    <!-- Filters -->
    <form method="GET" action="{{ route('admin.users.index') }}" class="grid grid-cols-1 sm:grid-cols-3 gap-3 mb-5">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama / email..."
               class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2 text-xs focus:outline-none focus:border-sqr-orange">
        
        <select name="role" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2 text-xs focus:outline-none focus:border-sqr-orange">
            <option value="">-- Semua Role --</option>
            @foreach($roles as $r)
            <option value="{{ $r->name }}" {{ request('role') == $r->name ? 'selected' : '' }}>{{ strtoupper($r->name) }}</option>
            @endforeach
        </select>

        <button type="submit" class="bg-sqr-orange hover:bg-orange-600 text-white text-xs font-bold px-4 py-2 rounded-xl transition">
            Filter Users
        </button>
    </form>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="w-full text-left text-xs">
            <thead class="bg-sqr-bg/50 text-sqr-green font-title uppercase tracking-wider text-[10px]">
                <tr>
                    <th class="p-3.5 rounded-l-xl">Nama</th>
                    <th class="p-3.5">Email</th>
                    <th class="p-3.5">Role</th>
                    <th class="p-3.5">Kelas Diampu (Ustadz)</th>
                    <th class="p-3.5 text-center rounded-r-xl">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($users as $u)
                <tr class="hover:bg-gray-50/80 transition">
                    <td class="p-3.5 font-bold text-gray-800">
                        {{ $u->hasRole('ustadz') ? $u->formatted_name : $u->name }}
                        <span class="text-[10px] text-gray-400 font-normal">({{ $u->gender === 'P' ? '🧕 Perempuan' : '👨 Laki-laki' }})</span>
                    </td>
                    <td class="p-3.5 text-gray-600">{{ $u->email }}</td>
                    <td class="p-3.5">
                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase {{ $u->hasRole('admin') ? 'bg-red-100 text-red-700' : ($u->hasRole('ustadz') ? 'bg-blue-100 text-blue-700' : 'bg-emerald-100 text-emerald-700') }}">
                            {{ $u->getRoleNames()->first() ?? 'user' }}
                        </span>
                    </td>
                    <td class="p-3.5 text-gray-600">{{ $u->sqrClass?->name ?? '-' }}</td>
                    <td class="p-3.5 text-center">
                        <div class="flex items-center justify-center gap-1.5">
                            <a href="{{ route('admin.users.edit', $u) }}" class="p-2 bg-amber-50 text-amber-600 rounded-lg hover:bg-amber-100" title="Edit"><i class="fa-solid fa-pen"></i></a>
                            @if($u->id !== auth()->id())
                            <form method="POST" action="{{ route('admin.users.destroy', $u) }}" onsubmit="return confirm('Hapus akun pengguna ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="p-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100" title="Hapus"><i class="fa-solid fa-trash"></i></button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="p-8 text-center text-gray-400">Tidak ada pengguna ditemukan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $users->links() }}
    </div>
</div>
@endsection
