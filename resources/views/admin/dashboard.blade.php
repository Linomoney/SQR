@extends('layouts.dashboard')

@section('title', 'Overview Dashboard Admin')

@section('content')
<div class="space-y-8">

    <!-- Quick Actions Banner -->
    <div class="bg-gradient-to-r from-sqr-green via-sqr-dark to-sqr-green text-white rounded-3xl p-5 shadow-lg flex flex-col sm:flex-row items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <div class="w-11 h-11 rounded-2xl bg-white/20 flex items-center justify-center text-2xl font-bold shrink-0">
                📅
            </div>
            <div>
                <h3 class="font-title font-bold text-sm text-white">Kalender & Jadwal Kegiatan Akademik SQR</h3>
                <p class="text-xs text-sqr-light-green">Kelola hari libur yayasan, jam masuk/pulang, acara khusus, dan kelas online</p>
            </div>
        </div>
        <a href="{{ route('admin.jadwal.index') }}" class="bg-sqr-orange hover:bg-orange-600 text-white font-title font-bold text-xs px-5 py-3 rounded-2xl transition shadow-md shrink-0 flex items-center gap-2">
            <i class="fa-solid fa-calendar-days"></i> Buka Kalender Akademik →
        </a>
    </div>

    <!-- ⚙️ Maintenance Mode Control Widget -->
    @php
        $isMaintenance = (bool) \App\Models\OrganizationSetting::get('maintenance_mode', '0');
        $maintenanceMsg = \App\Models\OrganizationSetting::get('maintenance_message', '');
    @endphp

    <div id="maintenanceWidget" class="rounded-3xl p-5 shadow-lg border-2 transition-all duration-500
        {{ $isMaintenance
            ? 'bg-gradient-to-r from-red-900 via-red-800 to-red-900 border-red-600 text-white'
            : 'bg-white border-gray-200 text-gray-800' }}">

        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <!-- Left: Status Info -->
            <div class="flex items-center gap-4">
                <!-- Animated Status Indicator -->
                <div class="w-14 h-14 rounded-2xl flex items-center justify-center text-2xl shrink-0 relative
                    {{ $isMaintenance ? 'bg-white/15' : 'bg-amber-50' }}">
                    <span id="maintenanceEmoji">{{ $isMaintenance ? '🔧' : '✅' }}</span>
                    @if($isMaintenance)
                    <span class="absolute -top-1.5 -right-1.5 w-4 h-4 bg-red-400 border-2 border-red-800 rounded-full animate-pulse"></span>
                    @endif
                </div>
                <div>
                    <div class="flex items-center gap-2 flex-wrap">
                        <h3 class="font-title font-black text-sm {{ $isMaintenance ? 'text-white' : 'text-sqr-dark' }}">
                            Mode Pemeliharaan Sistem
                        </h3>
                        <span id="maintenanceBadge" class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider
                            {{ $isMaintenance ? 'bg-white/20 text-white border border-white/30' : 'bg-emerald-100 text-emerald-800 border border-emerald-200' }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ $isMaintenance ? 'bg-red-300 animate-pulse' : 'bg-emerald-500' }}"></span>
                            {{ $isMaintenance ? 'AKTIF – Web Tidak Dapat Diakses' : 'NONAKTIF – Web Berjalan Normal' }}
                        </span>
                    </div>
                    <p class="text-xs mt-0.5 {{ $isMaintenance ? 'text-red-200' : 'text-gray-500' }}">
                        {{ $isMaintenance
                            ? 'Pengunjung diarahkan ke halaman peringatan pemeliharaan. Anda (Admin) tetap dapat mengakses seluruh fitur.'
                            : 'Aktifkan untuk menampilkan halaman pemeliharaan kepada seluruh pengunjung website.' }}
                    </p>
                </div>
            </div>

            <!-- Right: Toggle Switch (inline form) -->
            <div class="flex items-center gap-3 shrink-0">
                <form action="{{ route('admin.maintenance.toggle') }}" method="POST" id="maintenanceToggleForm">
                    @csrf
                    <input type="hidden" name="maintenance_mode" id="maintenanceModeInput" value="{{ $isMaintenance ? '0' : '1' }}">
                    <input type="hidden" name="maintenance_message" id="maintenanceMsgHidden" value="{{ $maintenanceMsg }}">
                    <button type="button" id="maintenanceToggleBtn"
                        onclick="confirmMaintenanceToggle()"
                        class="relative inline-flex items-center gap-2 px-5 py-2.5 rounded-2xl font-title font-bold text-xs transition-all duration-300 shadow-md
                        {{ $isMaintenance
                            ? 'bg-white text-red-700 hover:bg-red-50 border border-red-200'
                            : 'bg-sqr-orange hover:bg-orange-600 text-white' }}">
                        <i class="fa-solid {{ $isMaintenance ? 'fa-power-off' : 'fa-wrench' }}"></i>
                        {{ $isMaintenance ? 'Matikan Maintenance' : 'Aktifkan Maintenance' }}
                    </button>
                </form>

                <!-- Settings Modal Trigger -->
                <button type="button" onclick="document.getElementById('maintenanceSettingsModal').showModal()"
                    class="w-10 h-10 rounded-2xl border-2 flex items-center justify-center transition
                    {{ $isMaintenance ? 'border-white/30 text-white/70 hover:bg-white/10' : 'border-gray-200 text-gray-500 hover:bg-gray-100' }}">
                    <i class="fa-solid fa-gear text-sm"></i>
                </button>
            </div>
        </div>

        @if($isMaintenance)
        <!-- Warning Banner when active -->
        <div class="mt-4 flex items-center gap-2.5 bg-white/10 border border-white/20 rounded-2xl px-4 py-3">
            <i class="fa-solid fa-triangle-exclamation text-amber-300 text-lg shrink-0"></i>
            <div>
                <p class="text-amber-200 font-bold text-xs">Peringatan: Semua aktivitas web publik terhenti!</p>
                <p class="text-white/60 text-[11px] mt-0.5">
                    Pesan ditampilkan: <em>"{{ $maintenanceMsg ?: 'Kami mohon maaf atas ketidaknyamanan ini...' }}"</em>
                </p>
            </div>
        </div>
        @endif
    </div>

    <!-- Maintenance Settings Modal (native <dialog>) -->
    <dialog id="maintenanceSettingsModal" class="w-full max-w-lg rounded-3xl shadow-2xl p-0 bg-white border border-gray-100 backdrop:bg-black/50">
        <div class="p-6">
            <div class="flex items-center justify-between mb-5">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-amber-100 rounded-2xl flex items-center justify-center">
                        <i class="fa-solid fa-screwdriver-wrench text-amber-600"></i>
                    </div>
                    <div>
                        <h3 class="font-title font-black text-sqr-dark text-base">Pengaturan Mode Pemeliharaan</h3>
                        <p class="text-xs text-gray-500">Atur pesan yang ditampilkan ke pengunjung</p>
                    </div>
                </div>
                <button type="button" onclick="document.getElementById('maintenanceSettingsModal').close()"
                    class="w-8 h-8 rounded-xl bg-gray-100 hover:bg-gray-200 flex items-center justify-center transition">
                    <i class="fa-solid fa-xmark text-gray-600"></i>
                </button>
            </div>

            <form action="{{ route('admin.maintenance.toggle') }}" method="POST" id="maintenanceSettingsForm">
                @csrf
                <input type="hidden" name="maintenance_mode" value="{{ $isMaintenance ? '1' : '0' }}">

                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1.5">
                            <i class="fa-solid fa-comment text-sqr-orange mr-1"></i> Pesan Pemeliharaan untuk Pengunjung
                        </label>
                        <textarea name="maintenance_message" rows="4"
                            class="w-full border border-gray-200 rounded-2xl px-4 py-3 text-sm text-gray-700 focus:ring-2 focus:ring-sqr-orange/30 focus:border-sqr-orange outline-none resize-none transition"
                            placeholder="Contoh: Kami sedang melakukan pembaruan sistem. Mohon coba kembali dalam 30 menit.">{{ $maintenanceMsg }}</textarea>
                        <p class="text-[11px] text-gray-400 mt-1">Kosongkan untuk menggunakan pesan default.</p>
                    </div>

                    <div class="bg-amber-50 border border-amber-100 rounded-2xl px-4 py-3 text-xs text-amber-800 flex items-start gap-2">
                        <i class="fa-solid fa-info-circle mt-0.5 shrink-0"></i>
                        <span>Mengubah pesan <strong>tidak</strong> mengubah status aktif/nonaktif mode pemeliharaan. Gunakan tombol di atas untuk mengaktifkan/menonaktifkan.</span>
                    </div>

                    <div class="flex items-center gap-3 pt-2">
                        <button type="submit"
                            class="flex-1 bg-sqr-green hover:bg-sqr-dark text-white font-title font-bold text-sm py-3 rounded-2xl transition shadow-md">
                            <i class="fa-solid fa-floppy-disk mr-1.5"></i> Simpan Pesan
                        </button>
                        <button type="button" onclick="document.getElementById('maintenanceSettingsModal').close()"
                            class="px-5 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold text-sm rounded-2xl transition">
                            Batal
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </dialog>

    <!-- Confirmation Modal (native <dialog>) -->
    <dialog id="maintenanceConfirmModal" class="w-full max-w-sm rounded-3xl shadow-2xl p-0 bg-white border border-gray-100 backdrop:bg-black/50">
        <div class="p-6 text-center">
            <div class="w-16 h-16 rounded-3xl flex items-center justify-center text-3xl mx-auto mb-4" id="confirmIconWrapper">
                🔧
            </div>
            <h3 class="font-title font-black text-sqr-dark text-lg mb-2" id="confirmTitle">Aktifkan Mode Pemeliharaan?</h3>
            <p class="text-gray-500 text-sm leading-relaxed mb-6" id="confirmMessage">
                Website akan tidak dapat diakses oleh pengunjung. Anda (Admin) tetap dapat mengakses semua fitur.
            </p>
            <div class="flex items-center gap-3">
                <button type="button" onclick="document.getElementById('maintenanceConfirmModal').close()"
                    class="flex-1 px-4 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold text-sm rounded-2xl transition">
                    Batal
                </button>
                <button type="button" id="confirmMaintenanceBtn"
                    class="flex-1 px-4 py-3 font-title font-bold text-sm rounded-2xl transition shadow-md" id="confirmOkBtn">
                    Ya, Lanjutkan
                </button>
            </div>
        </div>
    </dialog>

    @if(session('success'))
    <div id="successToast"
         class="fixed bottom-5 right-5 z-50 flex items-center gap-3 bg-sqr-green text-white px-5 py-4 rounded-2xl shadow-2xl border border-white/20 max-w-xs"
         x-data="{ show: true }" style="animation: slideInToast 0.4s ease-out;">
        <i class="fa-solid fa-circle-check text-sqr-light-green text-lg shrink-0"></i>
        <div>
            <p class="font-bold text-xs">Berhasil!</p>
            <p class="text-xs text-white/80">{{ session('success') }}</p>
        </div>
        <button onclick="this.parentElement.remove()" class="ml-auto text-white/50 hover:text-white">
            <i class="fa-solid fa-xmark text-sm"></i>
        </button>
    </div>
    <style>
        @keyframes slideInToast {
            from { opacity: 0; transform: translateX(100%); }
            to   { opacity: 1; transform: translateX(0); }
        }
    </style>
    <script>
        setTimeout(function() {
            var toast = document.getElementById('successToast');
            if (toast) toast.remove();
        }, 5000);
    </script>
    @endif

    <script>
    function confirmMaintenanceToggle() {
        var isCurrentlyActive = {{ $isMaintenance ? 'true' : 'false' }};
        var modal = document.getElementById('maintenanceConfirmModal');
        var title = document.getElementById('confirmTitle');
        var msg = document.getElementById('confirmMessage');
        var btn = document.getElementById('confirmMaintenanceBtn');
        var icon = document.getElementById('confirmIconWrapper');

        if (isCurrentlyActive) {
            title.textContent = 'Nonaktifkan Mode Pemeliharaan?';
            msg.textContent = 'Website akan kembali dapat diakses oleh seluruh pengunjung secara normal.';
            icon.textContent = '✅';
            btn.className = 'flex-1 px-4 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-title font-bold text-sm rounded-2xl transition shadow-md';
        } else {
            title.textContent = 'Aktifkan Mode Pemeliharaan?';
            msg.textContent = 'Website akan tidak dapat diakses oleh pengunjung. Anda (Admin) tetap dapat mengakses semua fitur.';
            icon.textContent = '🔧';
            btn.className = 'flex-1 px-4 py-3 bg-red-600 hover:bg-red-700 text-white font-title font-bold text-sm rounded-2xl transition shadow-md';
        }

        btn.onclick = function() {
            document.getElementById('maintenanceToggleForm').submit();
        };

        modal.showModal();
    }
    </script>


    <!-- Metric Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <div class="bg-white rounded-3xl p-5 shadow-sm border border-gray-100 flex items-center justify-between hover:shadow-md transition">
            <div>
                <p class="text-xs text-gray-500 font-medium uppercase tracking-wider">Santri Aktif</p>
                <h3 class="font-title font-black text-2xl text-sqr-green mt-1">{{ $stats['total_santri'] }}</h3>
                <span class="text-[10px] text-sqr-orange font-bold">Terdaftar di sistem SQR</span>
            </div>
            <div class="w-12 h-12 bg-sqr-green/10 rounded-2xl flex items-center justify-center text-sqr-green text-xl font-bold">
                <i class="fa-solid fa-user-graduate"></i>
            </div>
        </div>

        <div class="bg-white rounded-3xl p-5 shadow-sm border border-gray-100 flex items-center justify-between hover:shadow-md transition">
            <div>
                <p class="text-xs text-gray-500 font-medium uppercase tracking-wider">Pengajar (Ustadz)</p>
                <h3 class="font-title font-black text-2xl text-sqr-green mt-1">{{ $stats['total_ustadz'] }}</h3>
                <span class="text-[10px] text-sqr-orange font-bold">Pengampu Kelas</span>
            </div>
            <div class="w-12 h-12 bg-sqr-orange/10 rounded-2xl flex items-center justify-center text-sqr-orange text-xl font-bold">
                <i class="fa-solid fa-chalkboard-user"></i>
            </div>
        </div>

        <div class="bg-white rounded-3xl p-5 shadow-sm border border-gray-100 flex items-center justify-between hover:shadow-md transition">
            <div>
                <p class="text-xs text-gray-500 font-medium uppercase tracking-wider">Pendaftaran PPDB</p>
                <h3 class="font-title font-black text-2xl text-sqr-orange mt-1">{{ $stats['ppdb_pending'] }}</h3>
                <span class="text-[10px] text-gray-400 font-bold">Menunggu Verifikasi (Total: {{ $stats['ppdb_total'] }})</span>
            </div>
            <div class="w-12 h-12 bg-amber-50 rounded-2xl flex items-center justify-center text-amber-600 text-xl font-bold">
                <i class="fa-solid fa-file-signature"></i>
            </div>
        </div>

        <div class="bg-white rounded-3xl p-5 shadow-sm border border-gray-100 flex items-center justify-between hover:shadow-md transition">
            <div>
                <p class="text-xs text-gray-500 font-medium uppercase tracking-wider">Verifikasi SPP</p>
                <h3 class="font-title font-black text-2xl text-sqr-green mt-1">{{ $stats['spp_pending'] }}</h3>
                <span class="text-[10px] text-sqr-orange font-bold">Bukti Transfer Masuk</span>
            </div>
            <div class="w-12 h-12 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-600 text-xl font-bold">
                <i class="fa-solid fa-receipt"></i>
            </div>
        </div>
    </div>

    <!-- ── 📅 JADWAL & KALENDER AKADEMIK WIDGET FOR ADMIN ── -->
    <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 space-y-5">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-gray-100 pb-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-sqr-green/10 text-sqr-green flex items-center justify-center font-bold text-xl shrink-0">
                    📅
                </div>
                <div>
                    <h3 class="font-title font-black text-base text-sqr-green">Jadwal & Kalender Akademik TPQ SQR</h3>
                    <p class="text-xs text-gray-500">Status harian KBM ({{ $jamMasuk }} - {{ $jamPulang }} WIB) dan agenda 7 hari ke depan</p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.jadwal.index') }}"
                   class="bg-sqr-green hover:bg-sqr-dark text-white font-title font-bold text-xs px-4 py-2 rounded-2xl transition shadow-md flex items-center gap-1.5">
                    <i class="fa-solid fa-pen-to-square"></i> Kelola Kalender & Jam →
                </a>
            </div>
        </div>

        <!-- Today Info Banner -->
        <div class="p-4 rounded-2xl flex flex-col md:flex-row items-center justify-between gap-4 border
            {{ $isSchoolDay ? 'bg-gradient-to-r from-emerald-50 to-teal-50 border-emerald-100 text-emerald-900' : 'bg-gradient-to-r from-red-50 to-orange-50 border-red-100 text-red-900' }}">
            <div class="flex items-center gap-3">
                <div class="text-2xl">{{ $isSchoolDay ? '📚' : '🏖️' }}</div>
                <div>
                    <div class="font-bold text-sm">
                        Status Hari Ini ({{ today()->translatedFormat('l, d F Y') }}): {{ $isSchoolDay ? 'KBM Belajar Aktif' : 'Tidak Ada Kegiatan KBM (Libur)' }}
                    </div>
                    @if($isSchoolDay)
                    <div class="text-xs opacity-80 mt-0.5">
                        Jam Operasional: <strong>{{ $jamMasuk }} WIB</strong> s/d <strong>{{ $jamPulang }} WIB</strong> · Libur Rutin: <strong>Sabtu & Minggu</strong>
                    </div>
                    @else
                    <div class="text-xs opacity-80 mt-0.5">Hari ini diliburkan dari kegiatan belajar mengajar rutin.</div>
                    @endif
                </div>
            </div>

            @if($todayEvents->isNotEmpty())
            <div class="flex flex-wrap gap-2">
                @foreach($todayEvents as $event)
                <span class="text-xs px-3 py-1 rounded-xl font-bold border shadow-xs
                    @if($event->type === 'libur') bg-red-100 text-red-800 border-red-200
                    @elseif($event->type === 'online') bg-blue-100 text-blue-800 border-blue-200
                    @elseif($event->type === 'acara') bg-amber-100 text-amber-800 border-amber-200
                    @else bg-purple-100 text-purple-800 border-purple-200 @endif">
                    {{ $event->type_icon }} {{ $event->title }}
                </span>
                @endforeach
            </div>
            @endif
        </div>

        <!-- 7 Days Strip -->
        <div class="space-y-2">
            <div class="text-xs font-bold text-gray-400 uppercase tracking-wider">Pratinjau Agenda 7 Hari Ke Depan</div>
            <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-7 gap-2">
                @foreach($next7Days as $dayItem)
                @php
                    $d = $dayItem['date'];
                @endphp
                <div class="rounded-2xl p-3 text-center border transition flex flex-col justify-between min-h-[95px]
                    {{ $dayItem['is_today'] ? 'ring-2 ring-sqr-green bg-sqr-green/5 border-sqr-green' : 'bg-gray-50/70 border-gray-100' }}
                    {{ $dayItem['is_off'] || $dayItem['has_holiday'] ? 'bg-red-50/50 border-red-100' : '' }}">
                    <div>
                        <div class="text-[10px] font-bold uppercase tracking-wider {{ $dayItem['is_off'] ? 'text-red-500' : 'text-gray-400' }}">
                            {{ $d->translatedFormat('D') }}
                        </div>
                        <div class="text-base font-black {{ $dayItem['is_today'] ? 'text-sqr-green' : 'text-gray-800' }}">
                            {{ $d->format('d M') }}
                        </div>
                    </div>

                    <div class="mt-2">
                        @if($dayItem['is_off'] && !$dayItem['has_holiday'])
                        <span class="inline-block text-[9px] font-bold px-1.5 py-0.5 rounded bg-red-100 text-red-700">
                            Libur Rutin
                        </span>
                        @elseif($dayItem['events']->isNotEmpty())
                            @foreach($dayItem['events']->take(1) as $ev)
                            <span class="inline-block text-[9px] font-bold px-1.5 py-0.5 rounded truncate max-w-full
                                @if($ev->type === 'libur') bg-red-100 text-red-700
                                @elseif($ev->type === 'online') bg-blue-100 text-blue-700
                                @elseif($ev->type === 'acara') bg-amber-100 text-amber-700
                                @else bg-purple-100 text-purple-700 @endif">
                                {{ $ev->title }}
                            </span>
                            @endforeach
                        @else
                        <span class="inline-block text-[9px] font-bold px-1.5 py-0.5 rounded bg-emerald-100 text-emerald-700">
                            KBM Aktif
                        </span>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- ── END JADWAL & KALENDER AKADEMIK WIDGET FOR ADMIN ── -->

    <!-- Section 1: Tables Grid (PPDB Terbaru & Status Kuota Kelas SQR) -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        
        <!-- Widget 1: Pendaftaran PPDB Terbaru (Fixed Data Properties) -->
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between border-b border-gray-100 pb-4 mb-4">
                <h3 class="font-title font-bold text-base text-sqr-green flex items-center gap-2">
                    <i class="fa-solid fa-file-signature text-sqr-orange"></i> Pendaftaran PPDB Online Terbaru
                </h3>
                <a href="{{ route('admin.ppdb.index') }}" class="text-xs text-sqr-orange font-bold hover:underline">Kelola Pendaftar →</a>
            </div>
            <div class="space-y-3">
                @forelse($recentPpdb as $p)
                @php
                    $wa = $p->no_hp_ayah ?? $p->no_hp_ibu ?? $p->no_telephone ?? '-';
                @endphp
                <div class="flex items-center justify-between p-3.5 rounded-2xl border border-gray-100 hover:bg-sqr-bg/30 transition text-xs">
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="font-bold text-gray-800 text-sm">{{ $p->nama_lengkap }}</span>
                            <span class="text-[10px] text-gray-400">({{ $p->gender }})</span>
                        </div>
                        <p class="text-[11px] text-sqr-green font-semibold mt-0.5">
                            Kelas: {{ $p->kelasDiminati?->class_name ?? 'Kelas SQR' }}
                        </p>
                        <p class="text-[10px] text-gray-400">Wali: {{ $p->nama_ayah ?? $p->nama_ibu ?? 'Wali' }} · WA: {{ $wa }}</p>
                    </div>
                    <div class="text-right">
                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase {{ $p->status === 'Pending' ? 'bg-amber-100 text-amber-800' : ($p->status === 'Diterima' ? 'bg-emerald-100 text-emerald-800' : 'bg-red-100 text-red-800') }}">
                            {{ $p->status }}
                        </span>
                        <span class="text-[9px] text-gray-400 block mt-1">{{ $p->created_at->diffForHumans() }}</span>
                    </div>
                </div>
                @empty
                <div class="py-8 text-center text-gray-400 font-semibold text-xs">
                    <i class="fa-solid fa-inbox text-3xl mb-2 block opacity-40"></i>
                    Belum ada pendaftaran PPDB online baru.
                </div>
                @endforelse
            </div>
        </div>

        <!-- Widget 2: Status Kuota Bangku Belajar Kelas SQR -->
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 space-y-4">
            <div class="flex items-center justify-between border-b border-gray-100 pb-4">
                <h3 class="font-title font-bold text-base text-sqr-green flex items-center gap-2">
                    <i class="fa-solid fa-chair text-sqr-orange"></i> Kapasitas Bangku Belajar Per Kelas
                </h3>
                <a href="{{ route('admin.classes.index') }}" class="text-xs text-sqr-orange font-bold hover:underline">Atur Kuota →</a>
            </div>

            <div class="space-y-4">
                @foreach($classes as $c)
                <div class="bg-sqr-bg/30 p-4 rounded-2xl border border-sqr-green/10 space-y-2">
                    <div class="flex justify-between items-center text-xs font-bold">
                        <div class="flex items-center gap-2">
                            <span class="font-title text-sqr-green">{{ $c->class_name }}</span>
                            @if(!$c->is_active)
                                <span class="bg-gray-200 text-gray-700 text-[9px] px-2 py-0.2 rounded-full">🔒 DITUTUP</span>
                            @elseif($c->isQuotaFull())
                                <span class="bg-red-100 text-red-700 text-[9px] px-2 py-0.2 rounded-full">🔴 FULL</span>
                            @else
                                <span class="bg-emerald-100 text-emerald-700 text-[9px] px-2 py-0.2 rounded-full">🟢 BUKA</span>
                            @endif
                        </div>
                        <span class="text-sqr-orange">{{ $c->active_santri_count }} / {{ $c->quota }} Santri (Sisa {{ $c->remaining_quota }})</span>
                    </div>

                    <div class="w-full bg-gray-200 h-2.5 rounded-full overflow-hidden">
                        <div class="{{ $c->isQuotaFull() ? 'bg-red-500' : 'bg-sqr-green' }} h-2.5 rounded-full transition-all duration-1000" style="width: {{ $c->quota_percentage }}%"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Section 2: Extra Useful Widgets (Program SQR Berbagi & System Alerts) -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        
        <!-- Widget 3: Program SQR Berbagi / Campaign Progress -->
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 space-y-4">
            <div class="flex items-center justify-between border-b border-gray-100 pb-4">
                <h3 class="font-title font-bold text-base text-sqr-green flex items-center gap-2">
                    <i class="fa-solid fa-hand-holding-heart text-sqr-orange"></i> Progres Infaq & Program SQR Berbagi
                </h3>
                <a href="{{ route('admin.campaigns.index') }}" class="text-xs text-sqr-orange font-bold hover:underline">Update Dana →</a>
            </div>

            <div class="space-y-3">
                @forelse($campaigns as $cmp)
                <div class="p-3.5 rounded-2xl border border-gray-100 space-y-2 text-xs">
                    <div class="flex items-center justify-between font-bold">
                        <span class="text-sqr-green line-clamp-1">{{ $cmp->title }}</span>
                        <span class="text-sqr-orange">{{ round($cmp->percentage_progress) }}%</span>
                    </div>
                    <div class="w-full bg-gray-100 h-2 rounded-full overflow-hidden">
                        <div class="bg-sqr-orange h-full rounded-full" style="width: {{ $cmp->percentage_progress }}%;"></div>
                    </div>
                    <div class="flex justify-between text-[10px] text-gray-500 font-semibold">
                        <span>Terkumpul: <strong>{{ $cmp->formatted_current }}</strong></span>
                        <span>Target: <strong>{{ $cmp->formatted_target }}</strong></span>
                    </div>
                </div>
                @empty
                <div class="py-6 text-center text-gray-400 font-semibold text-xs">
                    Belum ada program campaign aktif.
                </div>
                @endforelse
            </div>
        </div>

        <!-- Widget 4: Notifikasi Sistem Terbaru -->
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 space-y-4">
            <div class="flex items-center justify-between border-b border-gray-100 pb-4">
                <h3 class="font-title font-bold text-base text-sqr-green flex items-center gap-2">
                    <i class="fa-solid fa-bell text-sqr-orange"></i> Notifikasi Masuk Terbaru Admin
                </h3>
                <a href="{{ route('admin.notifications.index') }}" class="text-xs text-sqr-orange font-bold hover:underline">Semua Notifikasi →</a>
            </div>

            <div class="space-y-3">
                @forelse($notifications as $notif)
                <div class="p-3 rounded-2xl bg-sqr-bg/30 border border-sqr-green/10 text-xs space-y-1">
                    <div class="flex items-center justify-between">
                        <span class="font-bold text-sqr-green line-clamp-1">{{ $notif->title }}</span>
                        <span class="text-[9px] text-gray-400 font-semibold">{{ $notif->created_at->diffForHumans() }}</span>
                    </div>
                    <p class="text-[11px] text-gray-600 line-clamp-2">{{ $notif->message }}</p>
                </div>
                @empty
                <div class="py-6 text-center text-gray-400 font-semibold text-xs">
                    Tidak ada notifikasi baru.
                </div>
                @endforelse
            </div>
        </div>

    </div>

</div>
@endsection
