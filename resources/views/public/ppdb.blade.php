@extends('layouts.app')

@section('title', 'Pendaftaran PPDB Online - Saung Quran Rabbani')
@section('meta_description', 'Formulir Pendaftaran Peserta Didik Baru Saung Quran Rabbani Bogor. Daftar online dengan mudah dan cepat.')

@section('content')

@include('partials.navbar')
@include('partials.mobile-sidebar')

<!-- Header Banner -->
<section class="pt-28 pb-12 bg-gradient-to-b from-sqr-dark to-sqr-green text-white text-center relative overflow-hidden">
    <div class="max-w-4xl mx-auto px-4 relative z-10">
        <span class="bg-sqr-orange/20 text-sqr-orange border border-sqr-orange/40 text-xs font-bold px-4 py-1.5 rounded-full uppercase tracking-wider inline-block mb-3">
            🎓 Penerimaan Santri Baru (PPDB)
        </span>
        <h1 class="font-title text-3xl sm:text-5xl font-black text-white tracking-tight">Formulir Pendaftaran Online</h1>
        <p class="mt-3 text-sm sm:text-base text-gray-200 max-w-xl mx-auto leading-relaxed">
            Isi formulir pendaftaran secara bertahap di bawah ini. Proses cepat, praktis, dan dapat diakses dari mana saja.
        </p>
    </div>
</section>

<!-- Main Form & Quota Section -->
<section class="py-12 bg-[#f0f8d3] min-h-screen">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Live Quota Cards & PPDB Status Banner -->
        <div class="mb-10 space-y-6">
            <!-- Announcement Banner -->
            <div class="bg-gradient-to-r from-sqr-green to-sqr-dark text-white p-6 rounded-3xl shadow-xl border border-sqr-light-green/30 flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="flex items-center gap-4 text-left">
                    <div class="w-12 h-12 rounded-2xl bg-sqr-orange/20 border border-sqr-orange flex items-center justify-center text-sqr-orange font-bold text-2xl shrink-0">
                        <i class="fa-solid fa-bullhorn"></i>
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-emerald-400 animate-ping"></span>
                            <span class="text-xs font-bold text-emerald-400 uppercase tracking-widest">Status PPDB: TERBUKA 🟢</span>
                        </div>
                        <h3 class="font-title font-bold text-base sm:text-lg text-white mt-0.5">Pendaftaran Santri Baru Tahun Ajaran {{ date('Y') }}/{{ date('Y')+1 }}</h3>
                        <p class="text-xs text-gray-300">Cek rincian ketersediaan kuota bangku belajar di setiap kelas di bawah ini sebelum mendaftar.</p>
                    </div>
                </div>
                <a href="#ppdbForm" class="bg-sqr-orange hover:bg-orange-600 text-white font-title font-bold text-xs px-5 py-3 rounded-2xl shadow-md transition shrink-0">
                    Pilih Kelas & Daftar ↓
                </a>
            </div>

            <!-- Class Quota Grid -->
            <div>
                <h3 class="font-title font-bold text-base text-sqr-green mb-3 flex items-center gap-2">
                    <i class="fa-solid fa-chair text-sqr-orange"></i> Informasi Kuota & Bangku Terisi Real-Time
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @foreach($classes as $cls)
                    <div class="bg-white p-5 rounded-3xl shadow-lg border border-sqr-green/10 flex flex-col justify-between space-y-3 relative overflow-hidden group hover:shadow-xl transition-all duration-300 {{ !$cls->is_active ? 'opacity-75 bg-gray-50/50' : '' }}">
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <span class="bg-sqr-bg text-sqr-green text-[10px] font-bold px-3 py-1 rounded-full uppercase">{{ $cls->category ?? 'Regular' }}</span>
                                @if(!$cls->is_active)
                                    <span class="bg-gray-200 text-gray-700 text-[10px] font-bold px-2.5 py-0.5 rounded-full">🔒 DITUTUP</span>
                                @elseif($cls->isQuotaFull())
                                    <span class="bg-red-100 text-red-700 text-[10px] font-bold px-2.5 py-0.5 rounded-full">🔴 KUOTA PENUH</span>
                                @else
                                    <span class="bg-emerald-100 text-emerald-700 text-[10px] font-bold px-2.5 py-0.5 rounded-full">🟢 TERSEDIA</span>
                                @endif
                            </div>
                            <h4 class="font-title font-bold text-sm text-sqr-green group-hover:text-sqr-orange transition">{{ $cls->class_name }}</h4>
                            <p class="text-[11px] text-gray-500 mt-1"><i class="fa-solid fa-clock text-sqr-orange mr-1"></i> {{ $cls->schedule }}</p>

                            <!-- Progress Bar Capacity -->
                            <div class="mt-3 space-y-1">
                                <div class="flex justify-between text-[10px] font-bold">
                                    <span class="text-gray-500">Santri Terisi: {{ $cls->activeSantri()->count() }} / {{ $cls->quota }}</span>
                                    <span class="text-sqr-green font-bold">
                                        @if(!$cls->is_active)
                                            Ditutup
                                        @else
                                            Sisa {{ $cls->remaining_quota }} Kursi
                                        @endif
                                    </span>
                                </div>
                                <div class="w-full bg-gray-100 h-2.5 rounded-full overflow-hidden">
                                    <div class="{{ !$cls->is_active ? 'bg-gray-400' : ($cls->isQuotaFull() ? 'bg-red-500' : 'bg-sqr-orange') }} h-full rounded-full transition-all duration-1000" style="width: {{ $cls->quota_percentage }}%;"></div>
                                </div>
                            </div>
                        </div>

                        @if(!$cls->is_active)
                            <button type="button" disabled class="w-full bg-gray-100 text-gray-400 font-title font-bold text-xs py-2.5 rounded-xl cursor-not-allowed flex items-center justify-center gap-1.5">
                                <i class="fa-solid fa-lock"></i> Pendaftaran Ditutup
                            </button>
                        @elseif($cls->isQuotaFull())
                            <button type="button" disabled class="w-full bg-red-50 text-red-400 font-title font-bold text-xs py-2.5 rounded-xl cursor-not-allowed flex items-center justify-center gap-1.5">
                                <i class="fa-solid fa-lock"></i> Kuota Sudah Penuh
                            </button>
                        @else
                            <button type="button" onclick="selectClassAndScroll({{ $cls->id }})" class="w-full bg-sqr-green/10 text-sqr-green hover:bg-sqr-green hover:text-white font-title font-bold text-xs py-2.5 rounded-xl transition flex items-center justify-center gap-1.5">
                                <i class="fa-solid fa-user-plus"></i> Pilih Kelas Ini & Daftar
                            </button>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Step Wizard Header -->
        <div class="bg-white p-4 sm:p-6 rounded-3xl shadow-lg border border-sqr-green/10 mb-8">
            <div class="flex items-center justify-between relative">
                <!-- Step 1 -->
                <button type="button" onclick="goToStep(1)" id="stepBtn1" class="flex-1 flex flex-col items-center gap-1.5 z-10 focus:outline-none">
                    <div id="stepCircle1" class="w-10 h-10 sm:w-12 sm:h-12 rounded-2xl bg-sqr-green text-white font-title font-bold text-sm sm:text-base flex items-center justify-center shadow-md transition-all duration-300">
                        1
                    </div>
                    <span id="stepLabel1" class="text-[11px] sm:text-xs font-bold text-sqr-green">Data Santri</span>
                </button>

                <div class="w-12 sm:w-20 h-1 bg-gray-200 rounded-full"></div>

                <!-- Step 2 -->
                <button type="button" onclick="goToStep(2)" id="stepBtn2" class="flex-1 flex flex-col items-center gap-1.5 z-10 focus:outline-none">
                    <div id="stepCircle2" class="w-10 h-10 sm:w-12 sm:h-12 rounded-2xl bg-gray-200 text-gray-500 font-title font-bold text-sm sm:text-base flex items-center justify-center transition-all duration-300">
                        2
                    </div>
                    <span id="stepLabel2" class="text-[11px] sm:text-xs font-bold text-gray-400">Orang Tua / Wali</span>
                </button>

                <div class="w-12 sm:w-20 h-1 bg-gray-200 rounded-full"></div>

                <!-- Step 3 -->
                <button type="button" onclick="goToStep(3)" id="stepBtn3" class="flex-1 flex flex-col items-center gap-1.5 z-10 focus:outline-none">
                    <div id="stepCircle3" class="w-10 h-10 sm:w-12 sm:h-12 rounded-2xl bg-gray-200 text-gray-500 font-title font-bold text-sm sm:text-base flex items-center justify-center transition-all duration-300">
                        3
                    </div>
                    <span id="stepLabel3" class="text-[11px] sm:text-xs font-bold text-gray-400">Alamat & Kontak</span>
                </button>
            </div>
        </div>

        <!-- Form Card Container -->
        <div class="bg-white p-6 sm:p-10 rounded-3xl shadow-xl border border-sqr-green/10">
            <form method="POST" action="{{ route('ppdb.store') }}" id="ppdbForm" class="space-y-6">
                @csrf

                <!-- ==================== STEP 1: DATA SANTRI ==================== -->
                <div id="stepSection1" class="space-y-6 animate__animated animate__fadeIn">
                    <div class="flex items-center gap-3 border-b border-gray-100 pb-4">
                        <div class="w-10 h-10 rounded-2xl bg-sqr-orange/10 flex items-center justify-center text-sqr-orange">
                            <i class="fa-solid fa-child-reaching text-lg"></i>
                        </div>
                        <div>
                            <h2 class="font-title font-bold text-lg text-sqr-green">Langkah 1: Data Calon Santri</h2>
                            <p class="text-xs text-gray-500">Lengkapi identitas diri calon peserta didik baru</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="sm:col-span-2">
                            <label class="block text-xs font-bold text-gray-700 mb-1.5">Nama Lengkap Santri *</label>
                            <div class="relative">
                                <i class="fa-solid fa-user absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                                <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required
                                       class="w-full bg-gray-50/80 border border-gray-200 rounded-xl px-3.5 py-3 pl-10 text-xs font-semibold text-gray-800 focus:bg-white focus:ring-2 focus:ring-sqr-green/30 focus:border-sqr-green outline-none transition"
                                       placeholder="Contoh: Muhammad Rizki Pratama">
                            </div>
                            @error('nama_lengkap') <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1.5">Jenis Kelamin *</label>
                            <select name="gender" required
                                    class="w-full bg-gray-50/80 border border-gray-200 rounded-xl px-3.5 py-3 text-xs font-semibold text-gray-800 focus:bg-white focus:ring-2 focus:ring-sqr-green/30 focus:border-sqr-green outline-none transition">
                                <option value="">-- Pilih Jenis Kelamin --</option>
                                <option value="Laki-laki" {{ old('gender') === 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="Perempuan" {{ old('gender') === 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            @error('gender') <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1.5">Kelas yang Diminati *</label>
                            <select name="kelas_diminati" required
                                    class="w-full bg-gray-50/80 border border-gray-200 rounded-xl px-3.5 py-3 text-xs font-semibold text-gray-800 focus:bg-white focus:ring-2 focus:ring-sqr-green/30 focus:border-sqr-green outline-none transition">
                                <option value="">-- Pilih Kelas SQR --</option>
                                @foreach($classes as $class)
                                <option value="{{ $class->id }}" {{ old('kelas_diminati') == $class->id ? 'selected' : '' }} {{ (!$class->is_active || $class->isQuotaFull()) ? 'disabled' : '' }}>
                                    {{ $class->class_name }} 
                                    @if(!$class->is_active)
                                        (PPDB DITUTUP)
                                    @elseif($class->isQuotaFull())
                                        (KUOTA PENUH)
                                    @else
                                        (Sisa Kuota: {{ $class->remaining_quota }})
                                    @endif
                                </option>
                                @endforeach
                            </select>
                            @error('kelas_diminati') <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1.5">Tempat Lahir</label>
                            <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir') }}"
                                   class="w-full bg-gray-50/80 border border-gray-200 rounded-xl px-3.5 py-3 text-xs font-semibold text-gray-800 focus:bg-white focus:ring-2 focus:ring-sqr-green/30 focus:border-sqr-green outline-none transition"
                                   placeholder="Contoh: Bogor">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1.5">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}"
                                   class="w-full bg-gray-50/80 border border-gray-200 rounded-xl px-3.5 py-3 text-xs font-semibold text-gray-800 focus:bg-white focus:ring-2 focus:ring-sqr-green/30 focus:border-sqr-green outline-none transition">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1.5">Anak Ke-</label>
                            <input type="number" name="anak_ke" value="{{ old('anak_ke') }}" min="1"
                                   class="w-full bg-gray-50/80 border border-gray-200 rounded-xl px-3.5 py-3 text-xs font-semibold text-gray-800 focus:bg-white focus:ring-2 focus:ring-sqr-green/30 focus:border-sqr-green outline-none transition"
                                   placeholder="1">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1.5">Jumlah Saudara</label>
                            <input type="number" name="jumlah_saudara" value="{{ old('jumlah_saudara') }}" min="0"
                                   class="w-full bg-gray-50/80 border border-gray-200 rounded-xl px-3.5 py-3 text-xs font-semibold text-gray-800 focus:bg-white focus:ring-2 focus:ring-sqr-green/30 focus:border-sqr-green outline-none transition"
                                   placeholder="2">
                        </div>

                        <div class="sm:col-span-2">
                            <label class="block text-xs font-bold text-gray-700 mb-1.5">Sekolah Asal Santri</label>
                            <input type="text" name="sekolah_asal" value="{{ old('sekolah_asal') }}"
                                   class="w-full bg-gray-50/80 border border-gray-200 rounded-xl px-3.5 py-3 text-xs font-semibold text-gray-800 focus:bg-white focus:ring-2 focus:ring-sqr-green/30 focus:border-sqr-green outline-none transition"
                                   placeholder="Contoh: SDN Padasuka 01 Bogor">
                        </div>
                    </div>

                    <div class="pt-4 border-t border-gray-100 flex justify-end">
                        <button type="button" onclick="goToStep(2)" class="bg-sqr-green hover:bg-sqr-dark text-white font-title font-bold text-xs px-6 py-3.5 rounded-2xl shadow-lg transition flex items-center gap-2">
                            Lanjut ke Data Orang Tua <i class="fa-solid fa-arrow-right"></i>
                        </button>
                    </div>
                </div>

                <!-- ==================== STEP 2: DATA ORANG TUA ==================== -->
                <div id="stepSection2" class="space-y-6 hidden animate__animated animate__fadeIn">
                    <div class="flex items-center gap-3 border-b border-gray-100 pb-4">
                        <div class="w-10 h-10 rounded-2xl bg-sqr-orange/10 flex items-center justify-center text-sqr-orange">
                            <i class="fa-solid fa-user-tie text-lg"></i>
                        </div>
                        <div>
                            <h2 class="font-title font-bold text-lg text-sqr-green">Langkah 2: Data Orang Tua / Wali</h2>
                            <p class="text-xs text-gray-500">Lengkapi data orang tua atau wali penanggung jawab santri</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1.5">Nama Ayah Kandung</label>
                            <input type="text" name="nama_ayah" value="{{ old('nama_ayah') }}"
                                   class="w-full bg-gray-50/80 border border-gray-200 rounded-xl px-3.5 py-3 text-xs font-semibold text-gray-800 focus:bg-white focus:ring-2 focus:ring-sqr-green/30 focus:border-sqr-green outline-none transition"
                                   placeholder="Nama Ayah">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1.5">Nama Ibu Kandung</label>
                            <input type="text" name="nama_ibu" value="{{ old('nama_ibu') }}"
                                   class="w-full bg-gray-50/80 border border-gray-200 rounded-xl px-3.5 py-3 text-xs font-semibold text-gray-800 focus:bg-white focus:ring-2 focus:ring-sqr-green/30 focus:border-sqr-green outline-none transition"
                                   placeholder="Nama Ibu">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1.5">Pekerjaan Ayah</label>
                            <select name="pekerjaan_ayah"
                                    class="w-full bg-gray-50/80 border border-gray-200 rounded-xl px-3.5 py-3 text-xs font-semibold text-gray-800 focus:bg-white focus:ring-2 focus:ring-sqr-green/30 focus:border-sqr-green outline-none transition">
                                <option value="">-- Pilih Pekerjaan --</option>
                                @foreach($pekerjaanOptions as $p)
                                <option value="{{ $p }}" {{ old('pekerjaan_ayah') === $p ? 'selected' : '' }}>{{ $p }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1.5">Pekerjaan Ibu</label>
                            <select name="pekerjaan_ibu"
                                    class="w-full bg-gray-50/80 border border-gray-200 rounded-xl px-3.5 py-3 text-xs font-semibold text-gray-800 focus:bg-white focus:ring-2 focus:ring-sqr-green/30 focus:border-sqr-green outline-none transition">
                                <option value="">-- Pilih Pekerjaan --</option>
                                @foreach($pekerjaanOptions as $p)
                                <option value="{{ $p }}" {{ old('pekerjaan_ibu') === $p ? 'selected' : '' }}>{{ $p }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1.5">No. WhatsApp / HP Ayah</label>
                            <input type="tel" name="no_hp_ayah" value="{{ old('no_hp_ayah') }}"
                                   class="w-full bg-gray-50/80 border border-gray-200 rounded-xl px-3.5 py-3 text-xs font-semibold text-gray-800 focus:bg-white focus:ring-2 focus:ring-sqr-green/30 focus:border-sqr-green outline-none transition"
                                   placeholder="08129372xxxx">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1.5">No. WhatsApp / HP Ibu</label>
                            <input type="tel" name="no_hp_ibu" value="{{ old('no_hp_ibu') }}"
                                   class="w-full bg-gray-50/80 border border-gray-200 rounded-xl px-3.5 py-3 text-xs font-semibold text-gray-800 focus:bg-white focus:ring-2 focus:ring-sqr-green/30 focus:border-sqr-green outline-none transition"
                                   placeholder="08129372xxxx">
                        </div>

                        <div class="sm:col-span-2">
                            <label class="block text-xs font-bold text-gray-700 mb-1.5">Estimasi Penghasilan Bulanan Keluarga</label>
                            <select name="penghasilan_bulanan"
                                    class="w-full bg-gray-50/80 border border-gray-200 rounded-xl px-3.5 py-3 text-xs font-semibold text-gray-800 focus:bg-white focus:ring-2 focus:ring-sqr-green/30 focus:border-sqr-green outline-none transition">
                                <option value="">-- Pilih Range Penghasilan --</option>
                                @foreach($penghasilanOptions as $ph)
                                <option value="{{ $ph }}" {{ old('penghasilan_bulanan') === $ph ? 'selected' : '' }}>{{ $ph }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-gray-100 flex justify-between">
                        <button type="button" onclick="goToStep(1)" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-title font-bold text-xs px-5 py-3 rounded-2xl transition flex items-center gap-2">
                            <i class="fa-solid fa-arrow-left"></i> Kembali
                        </button>
                        <button type="button" onclick="goToStep(3)" class="bg-sqr-green hover:bg-sqr-dark text-white font-title font-bold text-xs px-6 py-3.5 rounded-2xl shadow-lg transition flex items-center gap-2">
                            Lanjut ke Alamat <i class="fa-solid fa-arrow-right"></i>
                        </button>
                    </div>
                </div>

                <!-- ==================== STEP 3: ALAMAT & KONTAK ==================== -->
                <div id="stepSection3" class="space-y-6 hidden animate__animated animate__fadeIn">
                    <div class="flex items-center gap-3 border-b border-gray-100 pb-4">
                        <div class="w-10 h-10 rounded-2xl bg-sqr-orange/10 flex items-center justify-center text-sqr-orange">
                            <i class="fa-solid fa-location-dot text-lg"></i>
                        </div>
                        <div>
                            <h2 class="font-title font-bold text-lg text-sqr-green">Langkah 3: Alamat Domisili & Kontak</h2>
                            <p class="text-xs text-gray-500">Lengkapi alamat domisili tinggal santri dan kontak utama</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1.5">Alamat Email Aktif</label>
                            <input type="email" name="email" value="{{ old('email') }}"
                                   class="w-full bg-gray-50/80 border border-gray-200 rounded-xl px-3.5 py-3 text-xs font-semibold text-gray-800 focus:bg-white focus:ring-2 focus:ring-sqr-green/30 focus:border-sqr-green outline-none transition"
                                   placeholder="contoh@email.com">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1.5">No. Telepon Rumah / Darurat</label>
                            <input type="tel" name="no_telephone" value="{{ old('no_telephone') }}"
                                   class="w-full bg-gray-50/80 border border-gray-200 rounded-xl px-3.5 py-3 text-xs font-semibold text-gray-800 focus:bg-white focus:ring-2 focus:ring-sqr-green/30 focus:border-sqr-green outline-none transition"
                                   placeholder="0812xxxxxxxx">
                        </div>

                        <div class="sm:col-span-2">
                            <label class="block text-xs font-bold text-gray-700 mb-1.5">Alamat Lengkap Rumah</label>
                            <textarea name="alamat" rows="3"
                                      class="w-full bg-gray-50/80 border border-gray-200 rounded-xl px-3.5 py-3 text-xs font-semibold text-gray-800 focus:bg-white focus:ring-2 focus:ring-sqr-green/30 focus:border-sqr-green outline-none transition resize-none"
                                      placeholder="Nama jalan, nomor rumah, nama komplek/patokan...">{{ old('alamat') }}</textarea>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1.5">RT / RW</label>
                            <div class="grid grid-cols-2 gap-2">
                                <input type="text" name="rt" value="{{ old('rt') }}" maxlength="5"
                                       class="bg-gray-50/80 border border-gray-200 rounded-xl px-3.5 py-3 text-xs font-semibold text-gray-800 focus:bg-white focus:ring-2 focus:ring-sqr-green/30 focus:border-sqr-green outline-none transition"
                                       placeholder="RT 001">
                                <input type="text" name="rw" value="{{ old('rw') }}" maxlength="5"
                                       class="bg-gray-50/80 border border-gray-200 rounded-xl px-3.5 py-3 text-xs font-semibold text-gray-800 focus:bg-white focus:ring-2 focus:ring-sqr-green/30 focus:border-sqr-green outline-none transition"
                                       placeholder="RW 003">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1.5">Desa / Kelurahan</label>
                            <input type="text" name="desa_kelurahan" value="{{ old('desa_kelurahan') }}"
                                   class="w-full bg-gray-50/80 border border-gray-200 rounded-xl px-3.5 py-3 text-xs font-semibold text-gray-800 focus:bg-white focus:ring-2 focus:ring-sqr-green/30 focus:border-sqr-green outline-none transition"
                                   placeholder="Kelurahan Cibogor">
                        </div>

                        <div class="sm:col-span-2">
                            <label class="block text-xs font-bold text-gray-700 mb-1.5">Kota / Kabupaten</label>
                            <input type="text" name="kota" value="{{ old('kota') }}"
                                   class="w-full bg-gray-50/80 border border-gray-200 rounded-xl px-3.5 py-3 text-xs font-semibold text-gray-800 focus:bg-white focus:ring-2 focus:ring-sqr-green/30 focus:border-sqr-green outline-none transition"
                                   placeholder="Kota Bogor">
                        </div>
                    </div>

                    <div class="pt-6 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-3">
                        <button type="button" onclick="goToStep(2)" class="w-full sm:w-auto bg-gray-100 hover:bg-gray-200 text-gray-700 font-title font-bold text-xs px-5 py-3.5 rounded-2xl transition flex items-center justify-center gap-2">
                            <i class="fa-solid fa-arrow-left"></i> Kembali
                        </button>

                        <button type="submit" class="w-full sm:w-auto bg-gradient-to-r from-sqr-orange to-amber-600 hover:from-amber-600 hover:to-sqr-orange text-white font-title font-bold text-sm px-8 py-4 rounded-2xl shadow-xl transition flex items-center justify-center gap-2 transform hover:-translate-y-0.5">
                            <i class="fa-solid fa-paper-plane"></i> Kirim Formulir Pendaftaran Sekarang
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

<script>
    function goToStep(step) {
        // Hide all step sections
        document.getElementById('stepSection1').classList.add('hidden');
        document.getElementById('stepSection2').classList.add('hidden');
        document.getElementById('stepSection3').classList.add('hidden');

        // Reset step circles and labels styling
        for (let i = 1; i <= 3; i++) {
            let circle = document.getElementById('stepCircle' + i);
            let label = document.getElementById('stepLabel' + i);
            if (i === step) {
                circle.className = 'w-10 h-10 sm:w-12 sm:h-12 rounded-2xl bg-sqr-green text-white font-title font-bold text-sm sm:text-base flex items-center justify-center shadow-md transition-all duration-300';
                label.className = 'text-[11px] sm:text-xs font-bold text-sqr-green';
            } else if (i < step) {
                circle.className = 'w-10 h-10 sm:w-12 sm:h-12 rounded-2xl bg-sqr-orange text-white font-title font-bold text-sm sm:text-base flex items-center justify-center shadow-md transition-all duration-300';
                label.className = 'text-[11px] sm:text-xs font-bold text-sqr-orange';
            } else {
                circle.className = 'w-10 h-10 sm:w-12 sm:h-12 rounded-2xl bg-gray-200 text-gray-500 font-title font-bold text-sm sm:text-base flex items-center justify-center transition-all duration-300';
                label.className = 'text-[11px] sm:text-xs font-bold text-gray-400';
            }
        }

        // Show target step section
        document.getElementById('stepSection' + step).classList.remove('hidden');
        window.scrollTo({ top: 200, behavior: 'smooth' });
    }

    function selectClassAndScroll(classId) {
        var select = document.querySelector('select[name="kelas_diminati"]');
        if (select) {
            select.value = classId;
        }
        goToStep(1);
        var form = document.getElementById('ppdbForm');
        if (form) {
            form.scrollIntoView({ behavior: 'smooth' });
        }
    }
</script>

@endsection
