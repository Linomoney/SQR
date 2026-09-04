@extends('layouts.dashboard')

@section('title', 'Biodata Resmi KK/KTP & Akun Wali')

@section('content')
<div class="space-y-6 max-w-4xl mx-auto">

    <!-- Header Banner -->
    <div class="bg-gradient-to-r from-sqr-green via-sqr-dark to-sqr-green text-white rounded-3xl p-6 shadow-xl flex items-center justify-between gap-4">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 rounded-2xl bg-sqr-orange/20 border-2 border-sqr-orange flex items-center justify-center text-sqr-orange font-bold text-2xl shrink-0">
                <i class="fa-solid fa-address-card"></i>
            </div>
            <div>
                <h2 class="font-title font-bold text-xl">Biodata Resmi KK / KTP Wali & Santri</h2>
                <p class="text-white/70 text-xs mt-0.5">Kelola informasi identitas Kartu Keluarga (KK) dan Alamat Resmi untuk keperluan administrasi & Surat Rekomendasi</p>
            </div>
        </div>
    </div>

    @if(session('success'))
    <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-semibold rounded-2xl px-5 py-3.5 flex items-center gap-2">
        <i class="fa-solid fa-circle-check text-emerald-500"></i> {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="bg-red-50 border border-red-200 text-red-700 text-sm font-semibold rounded-2xl px-5 py-3.5 flex items-center gap-2">
        <i class="fa-solid fa-triangle-exclamation text-red-500 text-lg"></i> {{ session('error') }}
    </div>
    @endif

    <!-- Lock Warning (If > 3 Days Unfilled) -->
    @if($isLocked)
    <div class="bg-gradient-to-r from-red-600 to-rose-700 text-white rounded-3xl p-6 shadow-2xl border-2 border-red-400 animate-pulse">
        <div class="flex items-start gap-4">
            <div class="w-12 h-12 rounded-2xl bg-white/20 flex items-center justify-center text-2xl shrink-0">
                🔒
            </div>
            <div>
                <h3 class="font-title font-black text-lg text-yellow-300">AKSES PORTAL TERKUNCI SEMENTARA</h3>
                <p class="text-xs text-white/90 leading-relaxed mt-1">
                    Batas waktu 3 hari sejak pendaftaran akun (<strong>{{ $deadlineDate }}</strong>) telah berakhir. Anda wajib melengkapi data Kartu Keluarga (KK) & alamat santri di bawah ini untuk dapat mengakses kembali menu portal Wali.
                </p>
            </div>
        </div>
    </div>
    @elseif(!$user->is_profile_completed)
    <div class="bg-amber-50 border border-amber-300 rounded-3xl p-5 text-amber-900 flex items-start gap-3">
        <i class="fa-solid fa-clock text-amber-600 text-xl shrink-0 mt-0.5"></i>
        <div class="text-xs">
            <p class="font-bold text-sm text-amber-900">Perhatian: Pengisian Biodata Kartu Keluarga (KK)</p>
            <p class="mt-0.5">Anda diberikan tenggat waktu hingga <strong>{{ $deadlineDate }}</strong> (3 hari) untuk melengkapi data di bawah. Jika belum diisi setelah deadline, portal akan terkunci otomatis.</p>
        </div>
    </div>
    @endif

    <!-- ── FORM BIODATA WALI & SANTRI ── -->
    <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 space-y-6">
        <div class="border-b border-gray-100 pb-4 flex items-center justify-between">
            <h3 class="font-title font-bold text-base text-sqr-green flex items-center gap-2">
                <i class="fa-solid fa-id-card text-sqr-orange"></i> Formulir Biodata KK & KTP Resmi
            </h3>
            <span class="text-xs font-bold px-3 py-1 rounded-full {{ $user->is_profile_completed ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                {{ $user->is_profile_completed ? '✅ Terverifikasi Lengkap' : '⏳ Belum Lengkap' }}
            </span>
        </div>

        <form method="POST" action="{{ route('wali.profile.update') }}" class="space-y-6">
            @csrf @method('PUT')

            <!-- Data Wali -->
            <div class="space-y-4">
                <h4 class="font-title font-bold text-sm text-gray-800 uppercase tracking-wider flex items-center gap-2">
                    <i class="fa-solid fa-user-tie text-sqr-orange"></i> Data Wali Santri (Orang Tua)
                </h4>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Nama Lengkap Wali <span class="text-red-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm outline-none focus:border-sqr-green bg-sqr-bg" required>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Jenis Kelamin <span class="text-red-500">*</span></label>
                        <select name="gender" class="w-full border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm outline-none focus:border-sqr-green bg-sqr-bg" required>
                            <option value="L" {{ old('gender', $user->gender) == 'L' ? 'selected' : '' }}>Laki-laki (Bapak/Ayah)</option>
                            <option value="P" {{ old('gender', $user->gender) == 'P' ? 'selected' : '' }}>Perempuan (Ibu)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">NIK (Nomor Induk Kependudukan) Wali <span class="text-red-500">*</span></label>
                        <input type="text" name="nik" value="{{ old('nik', $user->nik) }}" placeholder="16 digit sesuai KTP" class="w-full border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm outline-none focus:border-sqr-green bg-sqr-bg" minlength="16" maxlength="20" required>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">No. KK (Kartu Keluarga) <span class="text-red-500">*</span></label>
                        <input type="text" name="no_kk" value="{{ old('no_kk', $user->no_kk) }}" placeholder="16 digit sesuai KK" class="w-full border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm outline-none focus:border-sqr-green bg-sqr-bg" minlength="16" maxlength="20" required>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Tempat Lahir Wali <span class="text-red-500">*</span></label>
                        <input type="text" name="birth_place" value="{{ old('birth_place', $user->birth_place) }}" placeholder="Contoh: Depok" class="w-full border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm outline-none focus:border-sqr-green bg-sqr-bg" required>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Tanggal Lahir Wali <span class="text-red-500">*</span></label>
                        <input type="date" name="birth_date" value="{{ old('birth_date', $user->birth_date?->format('Y-m-d')) }}" class="w-full border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm outline-none focus:border-sqr-green bg-sqr-bg" required>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-gray-700 mb-1">No. WhatsApp / Telepon <span class="text-red-500">*</span></label>
                        <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="08xxxxxxxxxx" class="w-full border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm outline-none focus:border-sqr-green bg-sqr-bg" required>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-gray-700 mb-1">Alamat Rumah Lengkap (KTP/KK) <span class="text-red-500">*</span></label>
                        <textarea name="address" rows="2" placeholder="Nama jalan, RT/RW, kelurahan, kecamatan, kota, kode pos" class="w-full border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm outline-none focus:border-sqr-green bg-sqr-bg resize-none" required>{{ old('address', $user->address) }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Data Santri (Ananda) -->
            @if($santriList->isNotEmpty())
            <div class="border-t border-gray-100 pt-5 space-y-4">
                <h4 class="font-title font-bold text-sm text-sqr-green uppercase tracking-wider flex items-center gap-2">
                    <i class="fa-solid fa-child-reaching text-sqr-orange"></i> Data Santri Ananda (Akan Dicantumkan di Surat Rekomendasi)
                </h4>

                @foreach($santriList as $idx => $s)
                <div class="bg-sqr-bg/40 border border-sqr-green/20 rounded-2xl p-4 space-y-3">
                    <input type="hidden" name="santri[{{ $idx }}][id]" value="{{ $s->id }}">
                    <div class="flex items-center justify-between">
                        <span class="font-bold text-xs text-sqr-green">Ananda: <strong>{{ $s->full_name }}</strong> (NIS: {{ $s->nis }})</span>
                        <span class="text-[10px] text-gray-400 font-bold">Kelas {{ $s->sqrClass?->name ?? 'SQR' }}</span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Tempat Lahir Santri <span class="text-red-500">*</span></label>
                            <input type="text" name="santri[{{ $idx }}][birth_place]" value="{{ old('santri.'.$idx.'.birth_place', $s->birth_place) }}" placeholder="Contoh: Depok" class="w-full border border-gray-200 rounded-xl px-3 py-2 text-xs outline-none focus:border-sqr-green bg-white" required>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Tanggal Lahir Santri <span class="text-red-500">*</span></label>
                            <input type="date" name="santri[{{ $idx }}][date_of_birth]" value="{{ old('santri.'.$idx.'.date_of_birth', $s->date_of_birth?->format('Y-m-d')) }}" class="w-full border border-gray-200 rounded-xl px-3 py-2 text-xs outline-none focus:border-sqr-green bg-white" required>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold text-gray-700 mb-1">Alamat Tinggal Santri <span class="text-red-500">*</span></label>
                            <textarea name="santri[{{ $idx }}][address]" rows="2" placeholder="Alamat tempat tinggal santri" class="w-full border border-gray-200 rounded-xl px-3 py-2 text-xs outline-none focus:border-sqr-green bg-white resize-none" required>{{ old('santri.'.$idx.'.address', $s->address) }}</textarea>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif

            <button type="submit" class="w-full bg-sqr-orange hover:bg-orange-600 text-white font-title font-bold py-3.5 rounded-2xl transition shadow-md flex items-center justify-center gap-2">
                <i class="fa-solid fa-floppy-disk"></i> Simpan Biodata Resmi KK & KTP Wali
            </button>
        </form>
    </div>

    <!-- Form Ubah Password -->
    <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 space-y-4">
        <h3 class="font-title font-bold text-base text-sqr-green flex items-center gap-2">
            <i class="fa-solid fa-lock text-sqr-orange"></i> Ganti Password Akun Wali
        </h3>

        <form method="POST" action="{{ route('wali.profile.password') }}" class="space-y-4">
            @csrf @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Password Saat Ini</label>
                    <input type="password" name="current_password" class="w-full border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm outline-none focus:border-sqr-green bg-sqr-bg" required>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Password Baru</label>
                    <input type="password" name="password" class="w-full border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm outline-none focus:border-sqr-green bg-sqr-bg" required>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation" class="w-full border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm outline-none focus:border-sqr-green bg-sqr-bg" required>
                </div>
            </div>
            <button type="submit" class="bg-sqr-green hover:bg-sqr-dark text-white font-title font-bold text-xs px-5 py-2.5 rounded-xl transition">
                <i class="fa-solid fa-key mr-1"></i> Perbarui Password
            </button>
        </form>
    </div>

</div>
@endsection
