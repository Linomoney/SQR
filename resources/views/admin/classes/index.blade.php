@extends('layouts.dashboard')

@section('title', 'Manajemen Kelas & Kuota SQR')

@section('content')
<div class="space-y-6">

    <!-- Header & Action -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white p-6 rounded-3xl shadow-sm border border-gray-100">
        <div>
            <span class="bg-sqr-green/10 text-sqr-green font-bold text-[10px] px-3 py-1 rounded-full uppercase tracking-wider inline-block mb-1">
                🏫 Manajemen Akademik, Ustadz & Kuota
            </span>
            <h1 class="font-title text-xl font-bold text-sqr-green">Manajemen Kelas SQR & Penugasan Ustadz</h1>
            <p class="text-xs text-gray-500 mt-1">Atur kelas, penugasan Ustadz Pengampu, kapasitas kuota bangku PPDB, dan kenaikan kelas</p>
        </div>
        <button onclick="document.getElementById('addClassModal').classList.remove('hidden')" 
                class="bg-gradient-to-r from-sqr-green to-sqr-dark hover:from-sqr-dark hover:to-sqr-green text-white font-title font-bold text-xs px-5 py-3 rounded-2xl transition shadow-lg flex items-center gap-2 transform active:scale-95">
            <i class="fa-solid fa-plus-circle text-sqr-orange text-sm"></i> Tambah Kelas SQR Baru
        </button>
    </div>

    <!-- Alert Success/Error -->
    @if(session('success'))
    <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 p-4 rounded-2xl text-xs font-bold flex items-center justify-between">
        <span><i class="fa-solid fa-check-circle text-emerald-600 mr-2"></i>{{ session('success') }}</span>
    </div>
    @endif
    @if($errors->any())
    <div class="bg-red-50 border border-red-200 text-red-800 p-4 rounded-2xl text-xs font-bold">
        <span><i class="fa-solid fa-triangle-exclamation text-red-600 mr-2"></i>{{ $errors->first() }}</span>
    </div>
    @endif

    <!-- Class Grid Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($classes as $cls)
        @php $assignedUstadz = $cls->ustadz; @endphp
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 flex flex-col justify-between space-y-4 hover:shadow-xl transition-all duration-300">
            <div>
                <div class="flex items-center justify-between mb-3">
                    <span class="bg-sqr-bg text-sqr-green text-[10px] font-bold px-3 py-1 rounded-full uppercase">
                        {{ $cls->category ?? 'Regular' }}
                    </span>
                    @if($cls->is_active)
                        @if($cls->isQuotaFull())
                            <span class="bg-red-100 text-red-700 text-[10px] font-bold px-3 py-1 rounded-full flex items-center gap-1">
                                🔴 KUOTA PENUH
                            </span>
                        @else
                            <span class="bg-emerald-100 text-emerald-700 text-[10px] font-bold px-3 py-1 rounded-full flex items-center gap-1">
                                🟢 BUKA PPDB
                            </span>
                        @endif
                    @else
                        <span class="bg-gray-100 text-gray-600 text-[10px] font-bold px-3 py-1 rounded-full flex items-center gap-1">
                            🔒 PPDB DITUTUP
                        </span>
                    @endif
                </div>

                <h3 class="font-title font-bold text-lg text-sqr-green leading-snug">{{ $cls->class_name }}</h3>
                <p class="text-xs text-gray-500 mt-1 line-clamp-2">{{ $cls->description ?? 'Bimbingan Al-Quran Saung Quran Rabbani' }}</p>

                <!-- Ustadz Pengampu Badge -->
                <div class="mt-3 p-3 rounded-2xl border {{ $assignedUstadz ? 'bg-emerald-50/60 border-emerald-200/60' : 'bg-amber-50/60 border-amber-200/60' }} flex items-center justify-between gap-2">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-xl {{ $assignedUstadz ? 'bg-emerald-600 text-white' : 'bg-amber-500 text-white' }} flex items-center justify-center font-bold text-xs shrink-0">
                            <i class="fa-solid fa-chalkboard-user"></i>
                        </div>
                        <div>
                            <span class="text-[9px] font-bold uppercase tracking-wider block {{ $assignedUstadz ? 'text-emerald-700' : 'text-amber-800' }}">Ustadz Pengampu:</span>
                            <span class="font-bold text-xs {{ $assignedUstadz ? 'text-emerald-900' : 'text-amber-900' }}">
                                {{ $assignedUstadz ? $assignedUstadz->name : '⚠️ Belum Ditugaskan' }}
                            </span>
                        </div>
                    </div>
                    <button onclick="openEditClassModal({{ json_encode($cls) }}, {{ $assignedUstadz ? $assignedUstadz->id : 'null' }})" class="text-[10px] font-bold px-2.5 py-1 rounded-lg border {{ $assignedUstadz ? 'bg-white text-emerald-800 border-emerald-300' : 'bg-amber-500 text-white border-amber-500' }} hover:shadow transition">
                        Edit / Assign
                    </button>
                </div>

                <div class="mt-2.5 px-3 py-1.5 rounded-xl bg-gray-50 border border-gray-200 text-[11px] font-bold text-gray-700 flex items-center justify-between">
                    <span><i class="fa-solid fa-clock text-sqr-orange mr-1"></i> Jam Mengajar:</span>
                    <span class="text-sqr-green font-mono">{{ $cls->start_time ?? '15:30' }} - {{ $cls->end_time ?? '17:00' }} WIB</span>
                </div>

                <!-- Quota Capacity Stats -->
                <div class="mt-3 p-4 rounded-2xl bg-sqr-bg/50 border border-sqr-green/10 space-y-2">
                    <div class="flex justify-between items-center text-xs font-bold">
                        <div>
                            <span class="text-[10px] text-gray-400 block font-normal">Santri Terisi</span>
                            <span class="text-sqr-green font-title text-base">{{ $cls->active_santri_count }} Santri</span>
                        </div>
                        <div class="text-right">
                            <span class="text-[10px] text-gray-400 block font-normal">Kapasitas Quota</span>
                            <span class="text-gray-700 font-title text-sm">{{ $cls->quota }} Bangku</span>
                        </div>
                    </div>
                    <div class="w-full bg-gray-200 h-3 rounded-full overflow-hidden shadow-inner">
                        <div class="{{ $cls->isQuotaFull() ? 'bg-red-500' : 'bg-sqr-orange' }} h-full rounded-full transition-all duration-1000" style="width: {{ $cls->quota_percentage }}%;"></div>
                    </div>
                    <div class="flex justify-between items-center text-[10px] font-bold">
                        <span class="text-sqr-orange"><i class="fa-solid fa-chart-pie mr-1"></i> {{ round($cls->quota_percentage) }}% Kapasitas</span>
                        <span class="text-sqr-green font-bold">Sisa {{ $cls->remaining_quota }} Kursi</span>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="pt-4 border-t border-gray-100 space-y-2">
                <a href="{{ route('admin.classes.show', $cls->id) }}" class="w-full bg-sqr-green hover:bg-sqr-dark text-white font-title font-bold text-xs py-2.5 rounded-xl transition flex items-center justify-center gap-1.5 shadow-sm">
                    <i class="fa-solid fa-users-gear text-sqr-orange"></i> Kelola Santri & Ustadz ({{ $cls->active_santri_count }})
                </a>

                <div class="flex items-center justify-between gap-2 pt-1">
                    <button onclick="openEditClassModal({{ json_encode($cls) }}, {{ $assignedUstadz ? $assignedUstadz->id : 'null' }})" class="text-xs text-sqr-green font-bold hover:underline flex items-center gap-1">
                        <i class="fa-solid fa-pen-to-square"></i> Edit Kelas & Ustadz
                    </button>

                    <form action="{{ route('admin.classes.destroy', $cls->id) }}" method="POST" onsubmit="return confirm('Hapus kelas ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-xs text-red-500 hover:text-red-700 font-bold flex items-center gap-1">
                            <i class="fa-solid fa-trash"></i> Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full bg-white p-12 text-center rounded-3xl border border-gray-100 shadow-sm">
            <i class="fa-solid fa-chalkboard-user text-5xl text-sqr-green/30 mb-3 block"></i>
            <p class="text-sm font-semibold text-gray-500">Belum ada kelas SQR terdaftar.</p>
        </div>
        @endforelse
    </div>
</div>

<!-- ==================== MODAL TAMBAH KELAS ==================== -->
<div id="addClassModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-[999] hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-8 space-y-5 relative shadow-2xl animate__animated animate__fadeInUp">
        <div class="flex justify-between items-center border-b border-gray-100 pb-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-sqr-green/10 flex items-center justify-center text-sqr-green">
                    <i class="fa-solid fa-school text-lg"></i>
                </div>
                <div>
                    <h3 class="font-title font-bold text-base text-sqr-green">Tambah Kelas SQR Baru</h3>
                    <p class="text-[11px] text-gray-500">Buat kelas baru, tugaskan Ustadz Pengampu, & atur kuota PPDB</p>
                </div>
            </div>
            <button onclick="document.getElementById('addClassModal').classList.add('hidden')" class="w-8 h-8 rounded-full bg-gray-100 hover:bg-gray-200 text-gray-500 flex items-center justify-center transition">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <form action="{{ route('admin.classes.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1.5">Nama Kelas *</label>
                <input type="text" name="class_name" required class="w-full bg-gray-50/80 border border-gray-200 rounded-xl px-3.5 py-2.5 text-xs font-medium focus:ring-2 focus:ring-sqr-green/30 focus:border-sqr-green outline-none transition" placeholder="Contoh: Kelas Anak (Ummi 1 - 6)">
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1.5">Tugaskan Ustadz Pengampu Kelas</label>
                <select name="ustadz_id" class="w-full bg-gray-50/80 border border-gray-200 rounded-xl px-3.5 py-2.5 text-xs font-bold text-sqr-green focus:ring-2 focus:ring-sqr-green/30 focus:border-sqr-green outline-none transition">
                    <option value="">-- Belum Ditugaskan (Opsional) --</option>
                    @foreach($allUstadz as $u)
                    <option value="{{ $u->id }}">Ust. {{ $u->name }} {{ $u->sqrClass ? '('.$u->sqrClass->name.')' : '(Belum Ada Kelas)' }}</option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1.5">Kapasitas Kuota (Santri) *</label>
                    <input type="number" name="quota" value="30" min="1" required class="w-full bg-gray-50/80 border border-gray-200 rounded-xl px-3.5 py-2.5 text-xs font-medium focus:ring-2 focus:ring-sqr-green/30 focus:border-sqr-green outline-none transition" placeholder="30">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1.5">Status Pembukaan PPDB</label>
                    <div class="flex items-center gap-2 mt-2">
                        <input type="checkbox" id="addIsActive" name="is_active" value="1" checked class="w-4 h-4 text-sqr-green rounded border-gray-300 focus:ring-sqr-green">
                        <label for="addIsActive" class="text-xs font-bold text-sqr-green">Buka untuk PPDB</label>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-sqr-green mb-1.5">⏰ Jam Mulai Mengajar *</label>
                    <input type="time" name="start_time" value="15:30" required class="w-full bg-gray-50/80 border border-gray-200 rounded-xl px-3.5 py-2.5 text-xs font-bold text-sqr-green outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold text-sqr-green mb-1.5">⏰ Jam Selesai (Batas Alpa) *</label>
                    <input type="time" name="end_time" value="17:00" required class="w-full bg-gray-50/80 border border-gray-200 rounded-xl px-3.5 py-2.5 text-xs font-bold text-sqr-green outline-none">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1.5">Deskripsi Singkat Kelas</label>
                <textarea name="description" rows="3" class="w-full bg-gray-50/80 border border-gray-200 rounded-xl px-3.5 py-2.5 text-xs font-medium focus:ring-2 focus:ring-sqr-green/30 focus:border-sqr-green outline-none transition" placeholder="Jelaskan kelompok usia, jadwal belajar, dan materi kurikulum..."></textarea>
            </div>

            <div class="pt-3">
                <button type="submit" class="w-full bg-gradient-to-r from-sqr-green to-sqr-dark hover:from-sqr-dark hover:to-sqr-green text-white font-title font-bold text-xs py-3.5 rounded-2xl shadow-lg transition flex items-center justify-center gap-2">
                    <i class="fa-solid fa-floppy-disk text-sqr-orange"></i> Simpan Kelas Baru
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ==================== MODAL EDIT KELAS & USTAADZ ==================== -->
<div id="editClassModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-[999] hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-8 space-y-5 relative shadow-2xl animate__animated animate__fadeInUp">
        <div class="flex justify-between items-center border-b border-gray-100 pb-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-sqr-orange/10 flex items-center justify-center text-sqr-orange">
                    <i class="fa-solid fa-pen-to-square text-lg"></i>
                </div>
                <div>
                    <h3 class="font-title font-bold text-base text-sqr-green">Edit Kelas, Jam Mengajar & Penugasan</h3>
                    <p class="text-[11px] text-gray-500">Ubah Ustadz Pengampu, jam mengajar (alpa otomatis), & kuota</p>
                </div>
            </div>
            <button onclick="document.getElementById('editClassModal').classList.add('hidden')" class="w-8 h-8 rounded-full bg-gray-100 hover:bg-gray-200 text-gray-500 flex items-center justify-center transition">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <form id="editClassForm" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1.5">Nama Kelas *</label>
                <input type="text" id="editClassName" name="class_name" required class="w-full bg-gray-50/80 border border-gray-200 rounded-xl px-3.5 py-2.5 text-xs font-medium outline-none">
            </div>

            <div>
                <label class="block text-xs font-bold text-sqr-green mb-1.5">Tugaskan / Ganti Ustadz Pengampu Kelas</label>
                <select id="editUstadzId" name="ustadz_id" class="w-full bg-gray-50/80 border border-gray-200 rounded-xl px-3.5 py-2.5 text-xs font-bold text-sqr-green outline-none">
                    <option value="">-- Kosongkan (Belum Ada Ustadz) --</option>
                    @foreach($allUstadz as $u)
                    <option value="{{ $u->id }}">Ust. {{ $u->name }} {{ $u->sqrClass ? '('.$u->sqrClass->name.')' : '(Belum Ada Kelas)' }}</option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-sqr-green mb-1.5">⏰ Jam Mulai Mengajar *</label>
                    <input type="time" id="editStartTime" name="start_time" required class="w-full bg-gray-50/80 border border-gray-200 rounded-xl px-3.5 py-2.5 text-xs font-bold text-sqr-green outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold text-sqr-green mb-1.5">⏰ Jam Selesai (Batas Alpa) *</label>
                    <input type="time" id="editEndTime" name="end_time" required class="w-full bg-gray-50/80 border border-gray-200 rounded-xl px-3.5 py-2.5 text-xs font-bold text-sqr-green outline-none">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1.5">Kapasitas Kuota (Santri) *</label>
                    <input type="number" id="editQuota" name="quota" min="1" required class="w-full bg-gray-50/80 border border-gray-200 rounded-xl px-3.5 py-2.5 text-xs font-medium outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1.5">Status Pembukaan PPDB</label>
                    <div class="flex items-center gap-2 mt-2">
                        <input type="checkbox" id="editIsActive" name="is_active" value="1" class="w-4 h-4 text-sqr-green rounded border-gray-300 focus:ring-sqr-green">
                        <label for="editIsActive" class="text-xs font-bold text-sqr-green">Buka untuk PPDB</label>
                    </div>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1.5">Deskripsi Kelas</label>
                <textarea id="editDescription" name="description" rows="3" class="w-full bg-gray-50/80 border border-gray-200 rounded-xl px-3.5 py-2.5 text-xs font-medium outline-none"></textarea>
            </div>

            <div class="pt-3">
                <button type="submit" class="w-full bg-sqr-orange hover:bg-orange-600 text-white font-title font-bold text-xs py-3.5 rounded-2xl shadow-lg transition flex items-center justify-center gap-2">
                    <i class="fa-solid fa-check-circle"></i> Simpan Perubahan Kelas & Penugasan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openEditClassModal(cls, ustadzId) {
        document.getElementById('editClassForm').action = '/admin/classes/' + cls.id;
        document.getElementById('editClassName').value = cls.class_name || '';
        document.getElementById('editQuota').value = cls.quota || 30;
        document.getElementById('editStartTime').value = cls.start_time || '15:30';
        document.getElementById('editEndTime').value = cls.end_time || '17:00';
        document.getElementById('editDescription').value = cls.description || '';
        document.getElementById('editIsActive').checked = cls.is_active ? true : false;
        
        var ustadzSelect = document.getElementById('editUstadzId');
        if (ustadzSelect) {
            ustadzSelect.value = ustadzId !== null ? ustadzId : '';
        }

        document.getElementById('editClassModal').classList.remove('hidden');
    }
</script>
@endsection
