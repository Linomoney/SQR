@extends('layouts.dashboard')

@section('title', 'Input Progress Hafalan Santri')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">

    @if(session('success'))
    <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-bold flex items-center justify-between shadow-xs">
        <div class="flex items-center gap-2">
            <i class="fa-solid fa-circle-check text-emerald-500 text-base"></i>
            <span>{{ session('success') }}</span>
        </div>
    </div>
    @endif

    @if(session('error'))
    <div class="p-4 rounded-2xl bg-red-50 border border-red-200 text-red-800 text-xs font-bold flex items-center justify-between shadow-xs">
        <div class="flex items-center gap-2">
            <i class="fa-solid fa-triangle-exclamation text-red-500 text-base"></i>
            <span>{{ session('error') }}</span>
        </div>
    </div>
    @endif

    <!-- Header Banner -->
    <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-sqr-green rounded-2xl flex items-center justify-center text-white text-xl shadow-md shrink-0">
                <i class="fa-solid fa-book-open-reader"></i>
            </div>
            <div>
                <h3 class="font-title font-bold text-lg text-sqr-green">Input Progress Hafalan Santri</h3>
                <p class="text-xs text-gray-500 mt-0.5">Progress hafalan hanya dapat diinput untuk santri yang <strong>sudah di-absen hadir/izin/sakit</strong> hari ini.</p>
            </div>
        </div>
        <a href="{{ route('ustadz.attendance.index') }}"
           class="px-4 py-2.5 rounded-2xl border border-sqr-orange text-sqr-orange hover:bg-sqr-orange hover:text-white font-bold text-xs transition shrink-0 flex items-center gap-2">
            <i class="fa-solid fa-clipboard-user"></i> Presensi Kehadiran Hari Ini →
        </a>
    </div>

    @if($isSubstituteToday)
    <div class="p-4 rounded-2xl bg-blue-50 border border-blue-200 text-blue-900 text-xs font-semibold flex items-center gap-3">
        <div class="w-8 h-8 rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center font-bold shrink-0">
            <i class="fa-solid fa-user-shield text-sm"></i>
        </div>
        <div>
            <div class="font-bold text-blue-900">Modus Ustadz Pengganti Aktif Hari Ini</div>
            <div class="text-[11px] text-blue-700">Anda diberikan wewenang penuh untuk mengabsen dan menginput hafalan santri kelas ini menggantikan ustadz utama yang berhalangan.</div>
        </div>
    </div>
    @endif

    <!-- CLASS SELECTION CARDS -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
        @foreach($classes as $c)
        <button type="button" onclick="loadSantriForClass({{ $c->id }}, '{{ addslashes($c->name) }}')"
                id="class-card-{{ $c->id }}"
                class="class-card p-4 rounded-3xl border-2 border-gray-200 hover:border-sqr-orange hover:bg-sqr-bg/30 text-left transition shadow-sm group bg-white">
            <div class="flex items-center justify-between mb-2">
                <span class="text-[9px] font-black uppercase tracking-wider px-2 py-0.5 rounded-full bg-sqr-orange/10 text-sqr-orange">
                    {{ $c->category }}
                </span>
                <i class="fa-solid fa-chevron-right text-xs text-gray-400 group-hover:text-sqr-orange group-hover:translate-x-1 transition"></i>
            </div>
            <h4 class="font-title font-bold text-sm text-sqr-green group-hover:text-sqr-orange transition">{{ $c->name }}</h4>
            <p class="text-[11px] text-gray-400 mt-1 font-medium"><i class="fa-solid fa-users text-sqr-green mr-1"></i>{{ $c->activeSantri->count() }} Santri</p>
        </button>
        @endforeach
    </div>

    <!-- SANTRI ROSTER CONTAINER -->
    <div id="santriListContainer" class="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-gray-100 space-y-5 hidden">
        <div class="flex items-center justify-between border-b pb-4">
            <div>
                <h4 class="font-title font-bold text-base text-sqr-green flex items-center gap-2" id="selectedClassName">
                    <i class="fa-solid fa-users text-sqr-orange"></i> Daftar Santri Kelas
                </h4>
                <p class="text-xs text-gray-500 mt-0.5">Status presensi hari ini: <span class="text-emerald-600 font-bold">🟢 Hadir</span> / <span class="text-amber-600 font-bold">🟡 Belum Diabsen</span></p>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4" id="santriGrid">
            <!-- Loaded via JS -->
        </div>
    </div>

</div>

@push('scripts')
<script>
    var currentClassId = null;

    function loadSantriForClass(classId, className) {
        currentClassId = classId;
        document.querySelectorAll('.class-card').forEach(card => {
            card.classList.remove('border-sqr-green', 'bg-sqr-bg/40', 'shadow-md');
            card.classList.add('border-gray-200', 'bg-white');
        });

        var activeCard = document.getElementById('class-card-' + classId);
        if (activeCard) {
            activeCard.classList.remove('border-gray-200', 'bg-white');
            activeCard.classList.add('border-sqr-green', 'bg-sqr-bg/40', 'shadow-md');
        }

        document.getElementById('selectedClassName').innerHTML = '<i class="fa-solid fa-users text-sqr-orange mr-2"></i> Daftar Santri: ' + className;
        var container = document.getElementById('santriListContainer');
        var grid = document.getElementById('santriGrid');

        grid.innerHTML = '<div class="col-span-full py-8 text-center text-gray-400"><i class="fa-solid fa-spinner fa-spin text-2xl mb-2 block"></i>Memuat data santri...</div>';
        container.classList.remove('hidden');

        fetch('/ustadz/santri/' + classId)
            .then(res => res.json())
            .then(data => {
                if (!data || data.length === 0) {
                    grid.innerHTML = '<div class="col-span-full py-8 text-center text-gray-400 text-xs font-semibold">Tidak ada santri aktif di kelas ini.</div>';
                    return;
                }
                var html = '';
                data.forEach(s => {
                    var name = s.full_name || s.fullName || 'Santri';
                    var initial = name.charAt(0).toUpperCase();
                    var status = s.today_status || 'Belum Diabsen';
                    var canInput = s.can_input_progress;

                    var statusBadge = '';
                    if (status === 'Hadir') {
                        statusBadge = '<span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800 border border-emerald-200"><i class="fa-solid fa-circle-check mr-1"></i>Hadir</span>';
                    } else if (status === 'Izin' || status === 'Sakit') {
                        statusBadge = '<span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-amber-100 text-amber-800 border border-amber-200"><i class="fa-solid fa-clock mr-1"></i>' + status + '</span>';
                    } else if (status === 'Alpha') {
                        statusBadge = '<span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-red-100 text-red-800 border border-red-200"><i class="fa-solid fa-circle-xmark mr-1"></i>Tidak Hadir</span>';
                    } else {
                        statusBadge = '<span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-amber-50 text-amber-700 border border-amber-200 animate-pulse"><i class="fa-solid fa-triangle-exclamation mr-1"></i>Belum Diabsen</span>';
                    }

                    var actionBtn = '';
                    if (canInput) {
                        actionBtn = '<a href="/ustadz/progress/create/' + s.id + '" class="bg-sqr-green hover:bg-sqr-dark text-white font-bold text-xs px-3.5 py-1.5 rounded-xl transition shadow-sm flex items-center gap-1.5">' +
                                    '<i class="fa-solid fa-pen-to-square"></i> Input Progress' +
                                    '</a>';
                    } else {
                        actionBtn = '<button type="button" onclick="alertLockedProgress(\'' + name.replace(/'/g, "\\'") + '\')" class="bg-gray-100 text-gray-400 hover:bg-amber-100 hover:text-amber-800 font-bold text-xs px-3 py-1.5 rounded-xl transition flex items-center gap-1.5 cursor-not-allowed">' +
                                    '<i class="fa-solid fa-lock text-xs"></i> Belum Diabsen' +
                                    '</button>';
                    }

                    html += '<div class="bg-gray-50/80 hover:bg-white border border-gray-200 hover:border-sqr-green/40 rounded-2xl p-4 shadow-sm hover:shadow-md transition flex flex-col justify-between space-y-3 group">' +
                            '<div class="flex items-center justify-between gap-2">' +
                            '<div class="flex items-center gap-3 min-w-0">' +
                            '<div class="w-10 h-10 rounded-xl bg-sqr-green/10 text-sqr-green font-black text-sm flex items-center justify-center shrink-0 group-hover:bg-sqr-green group-hover:text-white transition">' + initial + '</div>' +
                            '<div class="min-w-0">' +
                            '<h5 class="font-title font-bold text-xs text-gray-800 truncate group-hover:text-sqr-green transition">' + name + '</h5>' +
                            '<p class="text-[10px] text-gray-400">NIS: SQR-' + s.id + '</p>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '<div class="pt-2.5 border-t border-gray-100 flex items-center justify-between">' +
                            statusBadge +
                            actionBtn +
                            '</div>' +
                            '</div>';
                });
                grid.innerHTML = html;
            })
            .catch(err => {
                grid.innerHTML = '<div class="col-span-full py-8 text-center text-red-500 text-xs">Gagal memuat santri. Silakan coba lagi.</div>';
            });
    }

    function alertLockedProgress(santriName) {
        if (confirm('⚠️ Progress hafalan ' + santriName + ' belum bisa diinput karena santri belum di-absen hadir hari ini.\n\nApakah Anda ingin mengisi Presensi Kehadiran sekarang?')) {
            window.location.href = '/ustadz/absensi?class_id=' + (currentClassId || '');
        }
    }

    // Auto-select first class on load
    document.addEventListener('DOMContentLoaded', function() {
        var firstCard = document.querySelector('.class-card');
        if (firstCard) {
            firstCard.click();
        }
    });
</script>
@endpush
@endsection
