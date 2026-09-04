@extends('layouts.dashboard')

@section('title', isset($user) ? 'Edit Akun Pengguna' : 'Tambah Akun Pengguna Baru')

@section('content')
<div class="max-w-xl mx-auto bg-white rounded-3xl p-6 shadow-sm border border-gray-100">
    <div class="border-b pb-4 mb-5">
        <h3 class="font-title font-bold text-lg text-sqr-green">
            {{ isset($user) ? 'Edit Akun Pengguna' : 'Tambah Akun Pengguna Baru' }}
        </h3>
        <p class="text-xs text-gray-500">Isi kredensial akun dan tentukan role hak aksesnya</p>
    </div>

    <form method="POST" action="{{ isset($user) ? route('admin.users.update', $user) : route('admin.users.store') }}" class="space-y-4">
        @csrf
        @if(isset($user)) @method('PUT') @endif

        <div>
            <label class="block text-xs font-bold text-gray-700 mb-1">Nama Lengkap *</label>
            <input type="text" name="name" value="{{ old('name', $user->name ?? '') }}" required
                   class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 text-xs outline-none focus:border-sqr-orange" placeholder="Nama pengguna">
        </div>

        <div>
            <label class="block text-xs font-bold text-gray-700 mb-1">Email *</label>
            <input type="email" name="email" value="{{ old('email', $user->email ?? '') }}" required
                   class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 text-xs outline-none focus:border-sqr-orange" placeholder="email@example.com">
        </div>

        <div>
            <label class="block text-xs font-bold text-gray-700 mb-1">Jenis Kelamin <span class="text-red-500">* (Menentukan Gelar Ustadz / Ustadzah)</span></label>
            <div class="grid grid-cols-2 gap-3">
                <label class="cursor-pointer">
                    <input type="radio" name="gender" value="L" {{ old('gender', $user->gender ?? 'L') === 'L' ? 'checked' : '' }} required class="sr-only peer">
                    <div class="p-3 rounded-xl border-2 border-gray-200 text-center peer-checked:border-sqr-green peer-checked:bg-sqr-green/10 peer-checked:text-sqr-green font-bold text-xs hover:bg-gray-50 transition">
                        👨 Laki-laki (Dipanggil Ustadz)
                    </div>
                </label>
                <label class="cursor-pointer">
                    <input type="radio" name="gender" value="P" {{ old('gender', $user->gender ?? '') === 'P' ? 'checked' : '' }} required class="sr-only peer">
                    <div class="p-3 rounded-xl border-2 border-gray-200 text-center peer-checked:border-purple-600 peer-checked:bg-purple-50 peer-checked:text-purple-800 font-bold text-xs hover:bg-gray-50 transition">
                        🧕 Perempuan (Dipanggil Ustadzah)
                    </div>
                </label>
            </div>
        </div>

        <div>
            <label class="block text-xs font-bold text-gray-700 mb-1">Password {{ isset($user) ? '(Biarkan kosong jika tidak diubah)' : '*' }}</label>
            <input type="password" name="password" {{ isset($user) ? '' : 'required' }}
                   class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 text-xs outline-none focus:border-sqr-orange" placeholder="••••••••">
        </div>

        <div>
            <label class="block text-xs font-bold text-gray-700 mb-1">Role Hak Akses *</label>
            <select name="role" required class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 text-xs outline-none focus:border-sqr-orange">
                @foreach($roles as $r)
                <option value="{{ $r->name }}" {{ old('role', isset($user) ? $user->getRoleNames()->first() : '') == $r->name ? 'selected' : '' }}>
                    {{ strtoupper($r->name) }}
                </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-xs font-bold text-gray-700 mb-1">Kelas Diampu (Khusus Role Ustadz)</label>
            <select name="classId" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 text-xs outline-none focus:border-sqr-orange">
                <option value="">-- Tanpa Kelas --</option>
                @foreach($classes as $c)
                <option value="{{ $c->id }}" {{ old('classId', $user->class_id ?? $user->classId ?? '') == $c->id ? 'selected' : '' }}>{{ $c->name }} ({{ $c->category }})</option>
                @endforeach
            </select>
        </div>

        <div class="pt-4 flex gap-3">
            <button type="submit" class="bg-sqr-green hover:bg-sqr-dark text-white font-bold text-xs px-6 py-3 rounded-xl transition shadow-md">
                Simpan Akun
            </button>
            <a href="{{ route('admin.users.index') }}" class="bg-gray-100 text-gray-600 font-bold text-xs px-6 py-3 rounded-xl hover:bg-gray-200 transition">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection
