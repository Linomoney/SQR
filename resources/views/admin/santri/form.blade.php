@extends('layouts.dashboard')

@section('title', isset($santri) ? 'Edit Data Santri' : 'Tambah Santri Baru')

@section('content')
<div class="max-w-2xl mx-auto bg-white rounded-3xl p-6 shadow-sm border border-gray-100">
    <div class="border-b pb-4 mb-5">
        <h3 class="font-title font-bold text-lg text-sqr-green">
            {{ isset($santri) ? 'Edit Data Santri' : 'Tambah Santri Baru' }}
        </h3>
        <p class="text-xs text-gray-500">Lengkapi informasi santri dan tautkan ke Wali murid</p>
    </div>

    <form method="POST" action="{{ isset($santri) ? route('admin.santri.update', $santri) : route('admin.santri.store') }}" class="space-y-4">
        @csrf
        @if(isset($santri)) @method('PUT') @endif

        <div>
            <label class="block text-xs font-bold text-gray-700 mb-1">Nama Lengkap Santri *</label>
            <input type="text" name="fullName" value="{{ old('fullName', $santri->fullName ?? '') }}" required
                   class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 text-xs outline-none focus:border-sqr-orange" placeholder="Masukkan nama lengkap santri">
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">Jenis Kelamin *</label>
                <select name="gender" required class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 text-xs outline-none focus:border-sqr-orange">
                    <option value="L" {{ old('gender', $santri->gender ?? '') == 'L' ? 'selected' : '' }}>Laki-laki (L)</option>
                    <option value="P" {{ old('gender', $santri->gender ?? '') == 'P' ? 'selected' : '' }}>Perempuan (P)</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">Tanggal Lahir</label>
                <input type="date" name="birthDate" value="{{ old('birthDate', isset($santri->birthDate) ? $santri->birthDate->format('Y-m-d') : '') }}"
                       class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 text-xs outline-none focus:border-sqr-orange">
            </div>
        </div>

        <div>
            <label class="block text-xs font-bold text-gray-700 mb-1">Pilih Kelas *</label>
            <select name="classId" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 text-xs outline-none focus:border-sqr-orange">
                <option value="">-- Pilih Kelas --</option>
                @foreach($classes as $c)
                <option value="{{ $c->id }}" {{ old('classId', $santri->classId ?? '') == $c->id ? 'selected' : '' }}>{{ $c->name }} ({{ $c->category }})</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-xs font-bold text-gray-700 mb-1">Tautkan ke Wali Santri (Akun Wali)</label>
            <select name="waliUserId" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 text-xs outline-none focus:border-sqr-orange">
                <option value="">-- Tanpa Akun Wali --</option>
                @foreach($walis as $w)
                <option value="{{ $w->id }}" {{ old('waliUserId', $santri->waliUserId ?? '') == $w->id ? 'selected' : '' }}>{{ $w->name }} ({{ $w->email }})</option>
                @endforeach
            </select>
        </div>

        <div class="pt-4 flex gap-3">
            <button type="submit" class="bg-sqr-green hover:bg-sqr-dark text-white font-bold text-xs px-6 py-3 rounded-xl transition shadow-md">
                Simpan Data Santri
            </button>
            <a href="{{ route('admin.santri.index') }}" class="bg-gray-100 text-gray-600 font-bold text-xs px-6 py-3 rounded-xl hover:bg-gray-200 transition">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection
