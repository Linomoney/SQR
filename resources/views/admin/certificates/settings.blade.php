@extends('layouts.dashboard')

@section('title', 'Pengaturan Sertifikat & Lembaga')

@section('content')
<div class="space-y-6">

    <!-- Header -->
    <div class="bg-gradient-to-r from-sqr-green to-sqr-dark text-white rounded-3xl p-6 shadow-xl">
        <div class="flex items-center gap-3">
            <div class="w-12 h-12 rounded-2xl bg-white/10 flex items-center justify-center text-2xl">
                <i class="fa-solid fa-cog text-sqr-orange"></i>
            </div>
            <div>
                <h2 class="font-title font-bold text-xl">Pengaturan Sertifikat & Lembaga</h2>
                <p class="text-white/70 text-xs mt-0.5">Atur tanda tangan pimpinan, cap stempel, identitas lembaga, dan target threshold per kelas</p>
            </div>
        </div>
        <div class="mt-3">
            <a href="{{ route('admin.certificates.index') }}" class="inline-flex items-center gap-1.5 text-sqr-light-green text-xs font-bold hover:text-white transition">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Sertifikat
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-semibold rounded-2xl px-5 py-3.5 flex items-center gap-2">
        <i class="fa-solid fa-circle-check text-emerald-500"></i> {{ session('success') }}
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        <!-- ── Identitas & TTD Pimpinan ── -->
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 space-y-5">
            <h3 class="font-title font-bold text-base text-sqr-green flex items-center gap-2">
                <i class="fa-solid fa-signature text-sqr-orange"></i> Identitas & Tanda Tangan Pimpinan
            </h3>

            <form method="POST" action="{{ route('admin.certificates.settings.save') }}" class="space-y-4">
                @csrf @method('PUT')

                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1.5">Nama Lembaga <span class="text-red-500">*</span></label>
                    <input type="text" name="organization_name" value="{{ $orgSettings['organization_name'] ?? '' }}" class="w-full border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm outline-none focus:border-sqr-green bg-sqr-bg" required>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1.5">Subtitle Lembaga</label>
                    <input type="text" name="organization_subtitle" value="{{ $orgSettings['organization_subtitle'] ?? '' }}" class="w-full border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm outline-none focus:border-sqr-green bg-sqr-bg">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1.5">Kota / Tempat <span class="text-red-500">*</span></label>
                        <input type="text" name="organization_city" value="{{ $orgSettings['organization_city'] ?? '' }}" class="w-full border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm outline-none focus:border-sqr-green bg-sqr-bg" required>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1.5">No. Telepon</label>
                        <input type="text" name="organization_phone" value="{{ $orgSettings['organization_phone'] ?? '' }}" class="w-full border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm outline-none focus:border-sqr-green bg-sqr-bg">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1.5">Alamat Lengkap <span class="text-red-500">*</span></label>
                    <textarea name="organization_address" rows="2" class="w-full border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm outline-none focus:border-sqr-green bg-sqr-bg resize-none" required>{{ $orgSettings['organization_address'] ?? '' }}</textarea>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1.5">Email Lembaga</label>
                    <input type="email" name="organization_email" value="{{ $orgSettings['organization_email'] ?? '' }}" class="w-full border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm outline-none focus:border-sqr-green bg-sqr-bg">
                </div>

                <div class="border-t border-gray-100 pt-4">
                    <h4 class="text-xs font-bold text-gray-600 mb-3 uppercase tracking-wider">Pimpinan / Penandatangan</h4>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1.5">Nama Pimpinan <span class="text-red-500">*</span></label>
                        <input type="text" name="pimpinan_name" value="{{ $orgSettings['pimpinan_name'] ?? '' }}" class="w-full border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm outline-none focus:border-sqr-green bg-sqr-bg" required>
                    </div>
                    <div class="mt-3">
                        <label class="block text-xs font-bold text-gray-700 mb-1.5">Jabatan Pimpinan <span class="text-red-500">*</span></label>
                        <input type="text" name="pimpinan_title" value="{{ $orgSettings['pimpinan_title'] ?? '' }}" class="w-full border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm outline-none focus:border-sqr-green bg-sqr-bg" required>
                    </div>
                </div>

                <div class="border-t border-gray-100 pt-4 space-y-3">
                    <h4 class="text-xs font-bold text-gray-600 mb-2 uppercase tracking-wider">Gambar Tanda Tangan, Cap Stempel & Logo</h4>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1.5">
                            URL Gambar Tanda Tangan Pimpinan / Pembina
                            <span class="text-gray-400 font-normal">(Cloudinary / URL publik, format PNG transparan)</span>
                        </label>
                        <input type="url" name="pimpinan_signature_url" value="{{ $orgSettings['pimpinan_signature_url'] ?? '' }}" placeholder="https://res.cloudinary.com/..." class="w-full border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm outline-none focus:border-sqr-green bg-sqr-bg">
                        @if(!empty($orgSettings['pimpinan_signature_url']))
                        <div class="mt-2 p-3 bg-gray-50 rounded-xl border border-dashed border-gray-200 text-center">
                            <img src="{{ $orgSettings['pimpinan_signature_url'] }}" alt="TTD Pimpinan" class="max-h-16 mx-auto object-contain">
                            <p class="text-[10px] text-gray-400 mt-1">Preview Tanda Tangan Pimpinan</p>
                        </div>
                        @endif
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1.5">
                            URL Gambar Tanda Tangan Ustadz / Pengampu (Default)
                            <span class="text-gray-400 font-normal">(PNG transparan)</span>
                        </label>
                        <input type="url" name="ustadz_signature_url" value="{{ $orgSettings['ustadz_signature_url'] ?? '' }}" placeholder="https://res.cloudinary.com/..." class="w-full border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm outline-none focus:border-sqr-green bg-sqr-bg">
                        @if(!empty($orgSettings['ustadz_signature_url']))
                        <div class="mt-2 p-3 bg-gray-50 rounded-xl border border-dashed border-gray-200 text-center">
                            <img src="{{ $orgSettings['ustadz_signature_url'] }}" alt="TTD Ustadz" class="max-h-16 mx-auto object-contain">
                            <p class="text-[10px] text-gray-400 mt-1">Preview Tanda Tangan Ustadz</p>
                        </div>
                        @endif
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1.5">
                            URL Gambar Cap Stempel Lembaga
                            <span class="text-gray-400 font-normal">(format PNG transparan, bulat/oval)</span>
                        </label>
                        <input type="url" name="organization_stamp_url" value="{{ $orgSettings['organization_stamp_url'] ?? '' }}" placeholder="https://res.cloudinary.com/..." class="w-full border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm outline-none focus:border-sqr-green bg-sqr-bg">
                        @if(!empty($orgSettings['organization_stamp_url']))
                        <div class="mt-2 p-3 bg-gray-50 rounded-xl border border-dashed border-gray-200 text-center">
                            <img src="{{ $orgSettings['organization_stamp_url'] }}" alt="Cap Stempel" class="max-h-20 mx-auto object-contain opacity-70">
                            <p class="text-[10px] text-gray-400 mt-1">Preview Cap Stempel</p>
                        </div>
                        @endif
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1.5">
                            URL Logo Yayasan (Pojok Kanan Atas Kop Surat)
                            <span class="text-gray-400 font-normal">(format PNG transparan)</span>
                        </label>
                        <input type="url" name="yayasan_logo_url" value="{{ $orgSettings['yayasan_logo_url'] ?? 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787212253/WhatsApp_Image_2024-03-05_at_16.45.18__1_-removebg-preview_1_n7ggrp.png' }}" placeholder="https://res.cloudinary.com/..." class="w-full border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm outline-none focus:border-sqr-green bg-sqr-bg">
                        @if(!empty($orgSettings['yayasan_logo_url']))
                        <div class="mt-2 p-3 bg-gray-50 rounded-xl border border-dashed border-gray-200 text-center">
                            <img src="{{ $orgSettings['yayasan_logo_url'] }}" alt="Logo Yayasan" class="max-h-16 mx-auto object-contain">
                            <p class="text-[10px] text-gray-400 mt-1">Preview Logo Yayasan (Kanan Atas Kop)</p>
                        </div>
                        @endif
                    </div>
                </div>

                <div class="border-t border-gray-100 pt-4">
                    <label class="block text-xs font-bold text-gray-700 mb-1.5">Teks Footer Sertifikat</label>
                    <input type="text" name="certificate_footer_text" value="{{ $orgSettings['certificate_footer_text'] ?? '' }}" class="w-full border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm outline-none focus:border-sqr-green bg-sqr-bg">
                </div>

                <button type="submit" class="w-full bg-sqr-green hover:bg-sqr-dark text-white font-title font-bold py-3 rounded-2xl transition shadow-sm flex items-center justify-center gap-2">
                    <i class="fa-solid fa-save"></i> Simpan Pengaturan Lembaga
                </button>
            </form>
        </div>

        <!-- ── Target Threshold per Kelas ── -->
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 space-y-5">
            <h3 class="font-title font-bold text-base text-sqr-green flex items-center gap-2">
                <i class="fa-solid fa-bullseye text-sqr-orange"></i> Target Threshold Sertifikat per Kelas
            </h3>
            <p class="text-xs text-gray-500">Atur berapa persen (%) pencapaian hafalan minimum agar santri berhak mendapatkan Sertifikat dan/atau Surat Rekomendasi pada setiap kelas.</p>

            <form method="POST" action="{{ route('admin.certificates.threshold.save') }}" class="space-y-4">
                @csrf @method('PUT')

                @foreach($classes as $idx => $cls)
                <div class="bg-sqr-bg rounded-2xl p-4 border border-gray-100">
                    <input type="hidden" name="thresholds[{{ $idx }}][class_id]" value="{{ $cls->id }}">
                    <h4 class="font-bold text-sm text-sqr-green mb-3 flex items-center gap-2">
                        <i class="fa-solid fa-chalkboard-user text-sqr-orange text-xs"></i>
                        {{ $cls->name }}
                        <span class="text-xs text-gray-400 font-normal">({{ $cls->activeSantri->count() }} santri aktif)</span>
                    </h4>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-[11px] font-bold text-emerald-700 mb-1">
                                🎓 Target Sertifikat (%)
                            </label>
                            <div class="relative">
                                <input type="number" name="thresholds[{{ $idx }}][cert_target]"
                                    value="{{ $cls->certificate_target ?? 100 }}"
                                    min="1" max="100"
                                    class="w-full border border-emerald-200 rounded-xl px-3 py-2 text-sm font-bold text-emerald-800 outline-none focus:border-emerald-500 bg-white pr-8">
                                <span class="absolute right-3 top-1/2 -translate-y-1/2 text-xs text-gray-400 font-bold">%</span>
                            </div>
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-amber-700 mb-1">
                                📜 Target Rekomendasi (%)
                            </label>
                            <div class="relative">
                                <input type="number" name="thresholds[{{ $idx }}][rec_target]"
                                    value="{{ $cls->recommendation_target ?? 50 }}"
                                    min="1" max="100"
                                    class="w-full border border-amber-200 rounded-xl px-3 py-2 text-sm font-bold text-amber-800 outline-none focus:border-amber-500 bg-white pr-8">
                                <span class="absolute right-3 top-1/2 -translate-y-1/2 text-xs text-gray-400 font-bold">%</span>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach

                <button type="submit" class="w-full bg-sqr-orange hover:bg-orange-600 text-white font-title font-bold py-3 rounded-2xl transition shadow-sm flex items-center justify-center gap-2">
                    <i class="fa-solid fa-bullseye"></i> Simpan Target Threshold per Kelas
                </button>
            </form>

            <!-- Template Guide -->
            <div class="border-t border-gray-100 pt-5">
                <h3 class="font-title font-bold text-base text-sqr-green mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-palette text-sqr-orange"></i> Panduan Template Sertifikat
                </h3>
                <div class="space-y-3">
                    <div class="flex items-center gap-3 bg-emerald-50 rounded-2xl p-3 border border-emerald-200">
                        <div class="w-10 h-10 rounded-xl bg-emerald-700 flex items-center justify-center text-white font-black text-xs shrink-0">C</div>
                        <div>
                            <p class="font-bold text-xs text-emerald-800">🟢 Classic SQR</p>
                            <p class="text-[10px] text-emerald-600">Hijau formal, border ornament Islamic, elegan dan resmi</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 bg-amber-50 rounded-2xl p-3 border border-amber-200">
                        <div class="w-10 h-10 rounded-xl bg-amber-700 flex items-center justify-center text-white font-black text-xs shrink-0">E</div>
                        <div>
                            <p class="font-bold text-xs text-amber-800">🟡 Elegant Gold</p>
                            <p class="text-[10px] text-amber-600">Background gelap premium, detail emas mewah, pilar gold</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 bg-purple-50 rounded-2xl p-3 border border-purple-200">
                        <div class="w-10 h-10 rounded-xl bg-purple-700 flex items-center justify-center text-white font-black text-xs shrink-0">P</div>
                        <div>
                            <p class="font-bold text-xs text-purple-800">🟣 Premium Royal</p>
                            <p class="text-[10px] text-purple-600">Gradient indigo-hijau, geometric Islamic corners, sangat premium</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>
@endsection
