@extends('layouts.dashboard')

@section('title', 'Detail Kelas & Naik/Pindah Kelas Santri')

@section('content')
<div class="space-y-6">

    <!-- Header & Action -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white p-6 rounded-3xl shadow-sm border border-gray-100">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <a href="{{ route('admin.classes.index') }}" class="text-xs text-sqr-green font-bold hover:underline">
                    ← Kembali ke Daftar Kelas
                </a>
            </div>
            <h1 class="font-title text-xl font-bold text-sqr-green">Detail Kelas: {{ $class->class_name }}</h1>
            <p class="text-xs text-gray-500 mt-1">Daftar santri aktif terdaftar & fitur pemindahan/kenaikan kelas</p>
        </div>

        <button onclick="document.getElementById('moveSantriModal').classList.remove('hidden')" 
                class="bg-sqr-orange hover:bg-orange-600 text-white font-title font-bold text-xs px-5 py-3 rounded-2xl transition shadow-lg flex items-center gap-2">
            <i class="fa-solid fa-graduation-cap text-base"></i> Proses Naik / Pindah Kelas Santri
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

    <!-- Class Summary Card -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white p-5 rounded-3xl shadow-sm border border-gray-100">
            <span class="text-[10px] text-gray-400 font-bold uppercase">Total Santri Terisi</span>
            <p class="font-title font-black text-2xl text-sqr-green mt-1">{{ $class->activeSantri->count() }} Santri</p>
        </div>
        <div class="bg-white p-5 rounded-3xl shadow-sm border border-gray-100">
            <span class="text-[10px] text-gray-400 font-bold uppercase">Kapasitas Quota</span>
            <p class="font-title font-bold text-2xl text-gray-700 mt-1">{{ $class->quota }} Bangku</p>
        </div>
        <div class="bg-white p-5 rounded-3xl shadow-sm border border-gray-100">
            <span class="text-[10px] text-gray-400 font-bold uppercase">Sisa Bangku Kosong</span>
            <p class="font-title font-bold text-2xl text-sqr-orange mt-1">{{ $class->remaining_quota }} Kursi</p>
        </div>
        <!-- Ustadz Pengampu Card with Inline Quick Assign -->
        <div class="bg-white p-5 rounded-3xl shadow-sm border border-gray-100 space-y-2">
            <span class="text-[10px] text-gray-400 font-bold uppercase">Ustadz Pengampu Kelas</span>
            @php $currentUstadz = $class->ustadz; @endphp
            <form action="{{ route('admin.classes.update', $class->id) }}" method="POST" class="space-y-2">
                @csrf @method('PUT')
                <input type="hidden" name="class_name" value="{{ $class->class_name }}">
                <input type="hidden" name="quota" value="{{ $class->quota }}">
                <input type="hidden" name="description" value="{{ $class->description }}">
                @if($class->is_active)<input type="hidden" name="is_active" value="1">@endif

                <select name="ustadz_id" onchange="this.form.submit()" class="w-full bg-sqr-bg border border-sqr-green/30 rounded-xl px-2.5 py-1.5 text-xs font-bold text-sqr-green outline-none focus:border-sqr-orange transition">
                    <option value="">-- Belum Ditugaskan --</option>
                    @foreach($allUstadz as $u)
                    <option value="{{ $u->id }}" {{ $currentUstadz?->id == $u->id ? 'selected' : '' }}>
                        Ust. {{ $u->name }}
                    </option>
                    @endforeach
                </select>
                <p class="text-[10px] text-gray-400">Pilih Ustadz dari dropdown untuk langsung menyimpan penugasan.</p>
            </form>
        </div>
    </div>

    <!-- Enrolled Santri Table -->
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100 flex items-center justify-between">
            <h3 class="font-title font-bold text-base text-sqr-green">Daftar Santri Terdaftar di {{ $class->class_name }}</h3>
            <span class="text-xs text-gray-400 font-semibold">Total {{ $class->activeSantri->count() }} Orang</span>
        </div>

        <form action="{{ route('admin.classes.move-santri', $class->id) }}" method="POST" id="batchMoveForm">
            @csrf
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-gray-50 text-gray-500 font-bold uppercase tracking-wider border-b border-gray-100">
                        <tr>
                            <th class="p-4 w-10 text-center">
                                <input type="checkbox" id="selectAllSantri" onclick="toggleSelectAll(this)" class="w-4 h-4 text-sqr-green rounded border-gray-300">
                            </th>
                            <th class="p-4">NIS</th>
                            <th class="p-4">Nama Santri</th>
                            <th class="p-4">Jenis Kelamin</th>
                            <th class="p-4">Wali Santri</th>
                            <th class="p-4 text-right">Aksi Pindah</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($class->activeSantri as $st)
                        <tr class="hover:bg-sqr-bg/30 transition">
                            <td class="p-4 text-center">
                                <input type="checkbox" name="santri_ids[]" value="{{ $st->id }}" class="santri-checkbox w-4 h-4 text-sqr-green rounded border-gray-300">
                            </td>
                            <td class="p-4 font-mono font-bold text-sqr-orange">{{ $st->nis }}</td>
                            <td class="p-4 font-bold text-gray-800">{{ $st->full_name }}</td>
                            <td class="p-4"><span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-gray-100 text-gray-600">{{ $st->gender }}</span></td>
                            <td class="p-4 text-gray-600 font-semibold">{{ $st->parent_name ?? $st->wali?->name ?? '-' }}</td>
                            <td class="p-4 text-right">
                                <button type="button" onclick="moveSingleSantri({{ $st->id }}, '{{ addslashes($st->full_name) }}')" 
                                        class="bg-sqr-green/10 text-sqr-green hover:bg-sqr-green hover:text-white px-3 py-1.5 rounded-xl font-bold transition">
                                    Pindahkan Kelas →
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="p-12 text-center text-gray-400 font-semibold">
                                Belum ada santri terdaftar di kelas ini.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($class->activeSantri->count() > 0)
            <div class="p-4 bg-gray-50 border-t border-gray-100 flex items-center justify-between">
                <span class="text-xs text-gray-500 font-semibold">Pilih beberapa santri centang di atas untuk memindahkan secara kolektif.</span>
                <button type="button" onclick="openBatchMoveModal()" class="bg-sqr-orange text-white font-title font-bold text-xs px-4 py-2 rounded-xl shadow transition">
                    Pindahkan Santri Terpilih ke Kelas Lain
                </button>
            </div>
            @endif
        </form>
    </div>
</div>

<!-- ==================== MODAL PINDAH/NAIK KELAS ==================== -->
<div id="moveSantriModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-[999] hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-8 space-y-5 relative shadow-2xl animate__animated animate__fadeInUp">
        <div class="flex justify-between items-center border-b border-gray-100 pb-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-sqr-orange/10 flex items-center justify-center text-sqr-orange">
                    <i class="fa-solid fa-graduation-cap text-lg"></i>
                </div>
                <div>
                    <h3 class="font-title font-bold text-base text-sqr-green">Naik / Pindah Kelas Santri</h3>
                    <p class="text-[11px] text-gray-500">Pindahkan santri dari kelas saat ini ke kelas tujuan baru</p>
                </div>
            </div>
            <button onclick="document.getElementById('moveSantriModal').classList.add('hidden')" class="w-8 h-8 rounded-full bg-gray-100 hover:bg-gray-200 text-gray-500 flex items-center justify-center transition">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <form action="{{ route('admin.classes.move-santri', $class->id) }}" method="POST" id="moveFormModal" class="space-y-4">
            @csrf
            
            <div id="singleSantriSelectBox" class="space-y-1">
                <label class="block text-xs font-bold text-gray-700 mb-1.5">Pilih Santri yang Akan Dipindahkan *</label>
                <select name="santri_ids[]" id="modalSantriSelect" required class="w-full bg-gray-50/80 border border-gray-200 rounded-xl px-3.5 py-2.5 text-xs font-semibold text-gray-800 outline-none">
                    @foreach($class->activeSantri as $st)
                    <option value="{{ $st->id }}">{{ $st->full_name }} ({{ $st->nis }})</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1.5">Pilih Kelas Tujuan Baru (Naik Kelas) *</label>
                <select name="target_class_id" required class="w-full bg-gray-50/80 border border-gray-200 rounded-xl px-3.5 py-2.5 text-xs font-semibold text-gray-800 outline-none">
                    <option value="">-- Pilih Kelas Tujuan --</option>
                    @foreach($allClasses as $ac)
                    <option value="{{ $ac->id }}" {{ $ac->isQuotaFull() ? 'disabled' : '' }}>
                        {{ $ac->class_name }} (Sisa Kuota: {{ $ac->remaining_quota }} Bangku)
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="pt-3">
                <button type="submit" class="w-full bg-gradient-to-r from-sqr-orange to-amber-600 hover:from-amber-600 hover:to-sqr-orange text-white font-title font-bold text-xs py-3.5 rounded-2xl shadow-lg transition flex items-center justify-center gap-2">
                    <i class="fa-solid fa-check-circle"></i> Proses Pindah / Naik Kelas
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function toggleSelectAll(master) {
        var checkboxes = document.querySelectorAll('.santri-checkbox');
        checkboxes.forEach(cb => cb.checked = master.checked);
    }

    function moveSingleSantri(id, name) {
        var modalSelect = document.getElementById('modalSantriSelect');
        if (modalSelect) {
            modalSelect.value = id;
        }
        document.getElementById('moveSantriModal').classList.remove('hidden');
    }

    function openBatchMoveModal() {
        var checked = document.querySelectorAll('.santri-checkbox:checked');
        if (checked.length === 0) {
            alert('Silakan pilih minimal 1 santri dengan mencentang kotak di sebelah kiri nama!');
            return;
        }
        document.getElementById('moveSantriModal').classList.remove('hidden');
    }
</script>
@endsection
