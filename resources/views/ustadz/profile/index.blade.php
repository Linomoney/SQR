@extends('layouts.dashboard')

@section('title', 'Profil & Biodata KTP/KK Pengajar')

@section('content')
<div class="space-y-6 max-w-4xl mx-auto">

    <!-- LOCKOUT MANDATORY BANNER (IF 3 DAYS DEADLINE PASSED AND INCOMPLETE) -->
    @if($isLocked)
    <div class="bg-red-600 text-white rounded-3xl p-6 shadow-xl space-y-3 animate__animated animate__shakeX">
        <div class="flex items-center gap-3">
            <div class="w-12 h-12 rounded-2xl bg-white/20 text-white flex items-center justify-center font-bold text-2xl shrink-0">
                <i class="fa-solid fa-lock"></i>
            </div>
            <div>
                <h3 class="font-title font-bold text-base text-white">⛔ HAK AKSES SISTEM DIKUNCI (BATAS AKHIR 3 HARI EXPIRATION)</h3>
                <p class="text-xs text-red-100 leading-relaxed mt-0.5">
                    Akun Anda telah dibuat lebih dari 3 hari lalu pada <strong>{{ $user->created_at?->format('d M Y H:i') }}</strong>. Sesuai aturan Saung Quran Rabbani, Anda **wajib melengkapi biodata resmi KTP & KK** di bawah ini untuk mengaktifkan kembali seluruh portal pengajar.
                </p>
            </div>
        </div>
    </div>
    @elseif(!$user->is_profile_completed)
    <!-- GENTLE REMINDER BANNER FOR DAYS 1 - 2 -->
    <div class="bg-amber-500 text-white rounded-3xl p-5 shadow-lg flex flex-col sm:flex-row items-center justify-between gap-3">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-white/20 text-white flex items-center justify-center font-bold text-lg shrink-0">
                <i class="fa-solid fa-triangle-exclamation"></i>
            </div>
            <div>
                <h4 class="font-title font-bold text-sm text-white">Pengingat: Lengkapi Biodata Resmi KTP & KK</h4>
                <p class="text-xs text-amber-100">
                    Batas akhir pengisian: <strong>{{ $deadlineDate }}</strong> (3 hari sejak akun dibuat). Silakan lengkapi form di bawah ini.
                </p>
            </div>
        </div>
    </div>
    @else
    <!-- PROFILE VERIFIED BADGE -->
    <div class="bg-emerald-50 border border-emerald-200 rounded-3xl p-5 shadow-sm flex items-center gap-3 text-emerald-900">
        <div class="w-10 h-10 rounded-xl bg-emerald-600 text-white flex items-center justify-center font-bold text-lg shrink-0">
            <i class="fa-solid fa-circle-check"></i>
        </div>
        <div>
            <h4 class="font-title font-bold text-sm text-emerald-900">Biodata Resmi KTP & KK Telah Lengkap</h4>
            <p class="text-xs text-emerald-700">Data Anda atas nama <strong>{{ $user->formatted_name }}</strong> sudah diverifikasi di sistem SQR.</p>
        </div>
    </div>
    @endif

    <!-- FORM BIODATA KTP & KK -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-gray-100 space-y-6">
        <div class="border-b pb-4 flex items-center justify-between">
            <div>
                <h3 class="font-title font-bold text-base text-sqr-green flex items-center gap-2">
                    <i class="fa-solid fa-id-card text-sqr-orange"></i> Form Kelengkapan Biodata Pengajar (KTP & KK)
                </h3>
                <p class="text-xs text-gray-500 mt-0.5">Isi seluruh data diri sesuai dokumen resmi KTP & Kartu Keluarga</p>
            </div>
            <span class="bg-sqr-green/10 text-sqr-green font-bold text-[10px] px-3 py-1 rounded-full uppercase">
                Role: {{ $user->title_prefix }}
            </span>
        </div>

        <form method="POST" action="{{ route('ustadz.profile.update') }}" class="space-y-5">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Nama Lengkap (Sesuai KTP) <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                           class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-xs font-bold text-gray-800 outline-none focus:border-sqr-orange">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Jenis Kelamin <span class="text-red-500">* (Panggilan Ustadz / Ustadzah)</span></label>
                    <select name="gender" required class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-xs font-bold text-gray-800 outline-none focus:border-sqr-orange">
                        <option value="L" {{ old('gender', $user->gender ?? 'L') === 'L' ? 'selected' : '' }}>👨 Laki-laki (Ustadz)</option>
                        <option value="P" {{ old('gender', $user->gender) === 'P' ? 'selected' : '' }}>🧕 Perempuan (Ustadzah)</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">NIK (Nomor Induk Kependudukan - 16 Digit) <span class="text-red-500">*</span></label>
                    <input type="text" name="nik" value="{{ old('nik', $user->nik) }}" required placeholder="3201..." maxlength="20"
                           class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-xs font-mono font-bold text-gray-800 outline-none focus:border-sqr-orange">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Nomor Kartu Keluarga (KK - 16 Digit) <span class="text-red-500">*</span></label>
                    <input type="text" name="no_kk" value="{{ old('no_kk', $user->no_kk) }}" required placeholder="3201..." maxlength="20"
                           class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-xs font-mono font-bold text-gray-800 outline-none focus:border-sqr-orange">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Nomor HP / WhatsApp Aktif <span class="text-red-500">*</span></label>
                    <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" required placeholder="08123456789"
                           class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-xs font-bold text-gray-800 outline-none focus:border-sqr-orange">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Tempat Lahir <span class="text-red-500">*</span></label>
                    <input type="text" name="birth_place" value="{{ old('birth_place', $user->birth_place) }}" required placeholder="Kota tempat lahir"
                           class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-xs font-medium text-gray-800 outline-none focus:border-sqr-orange">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Tanggal Lahir <span class="text-red-500">*</span></label>
                    <input type="date" name="birth_date" value="{{ old('birth_date', $user->birth_date?->format('Y-m-d')) }}" required
                           class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-xs font-bold text-gray-800 outline-none focus:border-sqr-orange">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Pendidikan Terakhir</label>
                    <input type="text" name="education" value="{{ old('education', $user->education) }}" placeholder="Contoh: S1 Ilmu Al-Quran & Tafsir / SMA"
                           class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-xs font-medium text-gray-800 outline-none focus:border-sqr-orange">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">URL Foto Profil / Cloudinary (Opsional)</label>
                    <input type="url" name="photo_url" value="{{ old('photo_url', $user->photo_url) }}" placeholder="https://res.cloudinary.com/..."
                           class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-xs font-medium text-gray-800 outline-none focus:border-sqr-orange">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">
                    URL Gambar Tanda Tangan Digital <span class="text-sqr-orange font-normal">(Cloudinary / URL Publik, PNG Transparan Tanpa Background)</span>
                </label>
                <input type="url" name="signature_url" value="{{ old('signature_url', $user->signature_url) }}" placeholder="https://res.cloudinary.com/.../ttd-ustadz.png"
                       class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-xs font-medium text-gray-800 outline-none focus:border-sqr-orange">
                <p class="text-[10px] text-gray-400 mt-1">Tanda tangan ini akan dicantumkan secara otomatis pada dokumen Sertifikat & Surat Rekomendasi santri yang Anda ampu.</p>
                @if(!empty($user->signature_url))
                <div class="mt-2 p-3 bg-sqr-bg/50 rounded-xl border border-dashed border-sqr-green/30 text-center">
                    <img src="{{ $user->signature_url }}" alt="TTD Ustadz" class="max-h-16 mx-auto object-contain">
                    <p class="text-[10px] text-sqr-green font-bold mt-1">Preview Tanda Tangan Ustadz/Ustadzah</p>
                </div>
                @endif
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">Alamat Lengkap Sesuai KTP <span class="text-red-500">*</span></label>
                <textarea name="address" rows="3" required placeholder="Jalan, RT/RW, Kelurahan, Kecamatan, Kota/Kabupaten..."
                          class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-xs font-medium text-gray-800 outline-none focus:border-sqr-orange">{{ old('address', $user->address) }}</textarea>
            </div>

            <div class="pt-3">
                <button type="submit" class="w-full bg-sqr-green hover:bg-sqr-dark text-white font-title font-bold text-sm py-4 rounded-2xl transition shadow-xl flex items-center justify-center gap-2 transform hover:-translate-y-0.5">
                    <i class="fa-solid fa-floppy-disk text-sqr-orange text-base"></i> Simpan & Konfirmasi Biodata Pengajar
                </button>
            </div>
        </form>
    </div>

    <!-- FORM GANTI PASSWORD -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-gray-100 space-y-6">
        <div class="border-b pb-4">
            <h3 class="font-title font-bold text-base text-sqr-green flex items-center gap-2">
                <i class="fa-solid fa-key text-sqr-orange"></i> Ganti Password Akun
            </h3>
            <p class="text-xs text-gray-500 mt-0.5">Ubah kata sandi akun untuk menjaga keamanan akun Ustadz/Ustadzah</p>
        </div>

        <form method="POST" action="{{ route('ustadz.profile.password') }}" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">Password Saat Ini *</label>
                <input type="password" name="current_password" required placeholder="••••••••"
                       class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-xs outline-none focus:border-sqr-orange">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Password Baru * (Min 8 karakter)</label>
                    <input type="password" name="password" required placeholder="••••••••"
                           class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-xs outline-none focus:border-sqr-orange">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Konfirmasi Password Baru *</label>
                    <input type="password" name="password_confirmation" required placeholder="••••••••"
                           class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-xs outline-none focus:border-sqr-orange">
                </div>
            </div>

            <div class="pt-2">
                <button type="submit" class="bg-sqr-orange hover:bg-orange-600 text-white font-title font-bold text-xs px-6 py-3 rounded-xl transition shadow-md flex items-center gap-2">
                    <i class="fa-solid fa-shield-halved"></i> Perbarui Password
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
