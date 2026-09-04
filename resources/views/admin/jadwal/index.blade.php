@extends('layouts.dashboard')

@section('title', 'Jadwal & Kalender Akademik SQR')

@section('content')
@php
    $monthNames = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                   'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
    $dayNames = ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'];

    $jamMasuk      = $settings['jam_masuk'] ?? '16:00';
    $jamPulang     = $settings['jam_pulang'] ?? '17:30';
    $weeklyOffDays = \App\Models\SchoolSchedule::weeklyOffDays();

    // Build calendar days array
    $firstDayOfMonth = $calStart->copy()->startOfMonth();
    $startGrid = $firstDayOfMonth->copy()->startOfWeek(\Carbon\Carbon::SUNDAY);
    $endGrid   = $calEnd->copy()->endOfWeek(\Carbon\Carbon::SATURDAY);

    $calDays = [];
    $cursor = $startGrid->copy();
    while ($cursor->lte($endGrid)) {
        $calDays[] = $cursor->copy();
        $cursor->addDay();
    }
@endphp

<style>
.event-pill       { font-size: 10px; padding: 1px 5px; border-radius: 999px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 100%; display: block; }
.event-libur      { background: #fee2e2; color: #b91c1c; }
.event-acara      { background: #fef9c3; color: #854d0e; }
.event-online     { background: #dbeafe; color: #1e40af; }
.event-pengumuman { background: #f3e8ff; color: #6b21a8; }
</style>

<div class="space-y-6">

    {{-- ── Flash message ─────────────────────────────────── --}}
    @if(session('success'))
    <div class="flex items-center justify-between gap-3 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl px-5 py-3.5 shadow-sm">
        <div class="flex items-center gap-2">
            <i class="fa-solid fa-circle-check text-emerald-500 text-base"></i>
            <span class="text-xs font-bold">{{ session('success') }}</span>
        </div>
    </div>
    @endif

    {{-- ── Header Row ─────────────────────────────────────── --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-3xl border border-gray-100 shadow-sm">
        <div>
            <span class="bg-sqr-green/10 text-sqr-green font-bold text-[10px] px-3 py-1 rounded-full uppercase tracking-wider inline-block mb-1">
                📅 Kelola Kalender & Jadwal TPQ SQR
            </span>
            <h2 class="text-xl font-title font-bold text-sqr-green">Jadwal & Kalender Akademik SQR</h2>
            <p class="text-xs text-gray-500 mt-0.5">Klik pada tanggal kalender untuk menambah event/libur. Sabtu & Minggu libur rutin.</p>
        </div>
        <div class="flex items-center gap-2">
            <button onclick="openSettingsModal()"
                    class="flex items-center gap-2 px-4 py-2.5 rounded-2xl border border-gray-200 text-xs font-bold text-gray-700 hover:bg-gray-50 transition shadow-xs">
                <i class="fa-solid fa-gear text-sqr-orange"></i> Pengaturan Jam Operasional
            </button>
            <button onclick="openAddModal()"
                    class="flex items-center gap-2 px-5 py-2.5 rounded-2xl bg-sqr-green text-white text-xs font-bold hover:bg-sqr-dark transition shadow-md">
                <i class="fa-solid fa-plus"></i> Tambah Event
            </button>
        </div>
    </div>

    {{-- ── Today Status Card ───────────────────────────────── --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        {{-- Status Hari Ini --}}
        <div class="col-span-1 sm:col-span-2 rounded-3xl overflow-hidden shadow-sm border
            {{ $isSchoolDay ? 'bg-gradient-to-br from-emerald-50 to-teal-50 border-emerald-200' : 'bg-gradient-to-br from-red-50 to-orange-50 border-red-200' }}">
            <div class="p-5 flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl flex items-center justify-center text-2xl shrink-0
                    {{ $isSchoolDay ? 'bg-emerald-100 text-emerald-600' : 'bg-red-100 text-red-500' }}">
                    {{ $isSchoolDay ? '📚' : '🏖️' }}
                </div>
                <div class="flex-1">
                    <div class="text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-0.5">Status Hari Ini — {{ today()->translatedFormat('l, d F Y') }}</div>
                    <div class="text-lg font-title font-black {{ $isSchoolDay ? 'text-emerald-700' : 'text-red-600' }}">
                        {{ $isSchoolDay ? "Hari Belajar Aktif (KBM: {$jamMasuk} - {$jamPulang} WIB)" : 'Hari Libur (Tidak Ada KBM)' }}
                    </div>
                    @if($isSchoolDay)
                    <div class="text-xs text-gray-600 mt-1">⏰ Jam masuk <strong>{{ $jamMasuk }} WIB</strong> · Jam Pulang <strong>{{ $jamPulang }} WIB</strong></div>
                    @else
                    <div class="text-xs text-gray-500 mt-1">Tidak ada kegiatan belajar mengajar hari ini</div>
                    @endif
                </div>
                @if($todayEvents->count())
                <div class="hidden sm:flex flex-col gap-1">
                    @foreach($todayEvents->take(2) as $ev)
                    <span class="text-xs px-2.5 py-1 rounded-full font-bold
                        @if($ev->type === 'libur') bg-red-100 text-red-700
                        @elseif($ev->type === 'online') bg-blue-100 text-blue-700
                        @elseif($ev->type === 'acara') bg-amber-100 text-amber-700
                        @else bg-purple-100 text-purple-700 @endif">
                        {{ $ev->type_icon }} {{ $ev->title }}
                    </span>
                    @endforeach
                </div>
                @endif
            </div>
        </div>

        {{-- Jam Masuk / Pulang --}}
        <div class="rounded-3xl bg-white border border-gray-100 shadow-sm p-5 flex flex-col justify-between">
            <div class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Jam Operasional Pengajaran TPQ</div>
            <div class="mt-2 space-y-1.5 text-xs">
                <div class="flex items-center justify-between">
                    <span class="text-gray-600">🟢 Jam Masuk</span>
                    <span class="font-black text-sqr-green">{{ $jamMasuk }} WIB</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-gray-600">🔴 Jam Pulang</span>
                    <span class="font-black text-sqr-green">{{ $jamPulang }} WIB</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-gray-600">📅 Libur Rutin</span>
                    <span class="font-bold text-red-600">Sabtu & Minggu</span>
                </div>
            </div>
            <button onclick="openSettingsModal()"
                    class="mt-3 text-xs text-sqr-orange font-bold hover:underline text-left">
                ✏️ Ubah Jam & Hari Libur
            </button>
        </div>
    </div>

    {{-- ── Calendar + Events Panel ─────────────────────────── --}}
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

        {{-- CALENDAR ─────────────────── --}}
        <div class="xl:col-span-2 bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
            {{-- Month Navigation --}}
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                <a href="{{ route('admin.jadwal.index', ['year' => $month == 1 ? $year - 1 : $year, 'month' => $month == 1 ? 12 : $month - 1]) }}"
                   class="w-9 h-9 rounded-xl border border-gray-200 flex items-center justify-center hover:bg-gray-50 transition text-gray-600">
                    <i class="fa-solid fa-chevron-left text-xs"></i>
                </a>
                <div class="text-center">
                    <h3 class="text-base font-title font-black text-sqr-green">
                        {{ $monthNames[$month] }} {{ $year }}
                    </h3>
                    <span class="text-[10px] text-gray-400 font-semibold">Klik tanggal untuk menambah event</span>
                </div>
                <a href="{{ route('admin.jadwal.index', ['year' => $month == 12 ? $year + 1 : $year, 'month' => $month == 12 ? 1 : $month + 1]) }}"
                   class="w-9 h-9 rounded-xl border border-gray-200 flex items-center justify-center hover:bg-gray-50 transition text-gray-600">
                    <i class="fa-solid fa-chevron-right text-xs"></i>
                </a>
            </div>

            {{-- Day headers --}}
            <div class="grid grid-cols-7 border-b border-gray-100 bg-gray-50/50">
                @foreach($dayNames as $idx => $day)
                @php
                    $isOffHeader = in_array($idx, $weeklyOffDays);
                @endphp
                <div class="text-center py-2.5 text-xs font-bold {{ $isOffHeader ? 'text-red-500' : 'text-gray-600' }}">
                    {{ $day }}
                </div>
                @endforeach
            </div>

            {{-- Calendar grid --}}
            <div class="grid grid-cols-7">
                @foreach($calDays as $day)
                @php
                    $dateStr        = $day->toDateString();
                    $isCurrentMonth = $day->month === $month;
                    $isToday        = $day->isToday();
                    $isWeeklyOff    = in_array($day->dayOfWeek, $weeklyOffDays);
                    $dayEvents      = $eventsByDate[$dateStr] ?? [];
                    $hasHoliday     = collect($dayEvents)->where('is_holiday', true)->count() > 0;
                @endphp
                <div onclick="openAddModalForDate('{{ $dateStr }}')"
                     title="Klik untuk tambah event di tanggal {{ $dateStr }}"
                     class="min-h-[95px] border-b border-r border-gray-100 p-1.5 relative transition cursor-pointer hover:bg-emerald-50/50 group
                    {{ !$isCurrentMonth ? 'opacity-30 bg-gray-50/30' : '' }}
                    {{ $isWeeklyOff && !count($dayEvents) ? 'bg-red-50/30' : '' }}
                    {{ $hasHoliday ? 'bg-red-100/70 border-red-200' : '' }}
                    {{ $isToday ? 'ring-2 ring-inset ring-sqr-green bg-sqr-green/5' : '' }}">
                    <div class="flex items-center justify-between mb-1">
                        <span class="text-xs font-bold {{ $isToday ? 'bg-sqr-green text-white w-5 h-5 rounded-full flex items-center justify-center' : ($isWeeklyOff ? 'text-red-500' : 'text-gray-700') }}">
                            {{ $day->day }}
                        </span>
                        <i class="fa-solid fa-plus text-[9px] text-sqr-green opacity-0 group-hover:opacity-100 transition"></i>
                    </div>
                    @foreach(collect($dayEvents)->take(2) as $ev)
                    <span class="event-pill event-{{ $ev->type }} mb-0.5 font-semibold" onclick="event.stopPropagation(); openEditModal(@json($ev));">
                        {{ $ev->type_icon }} {{ $ev->title }}
                    </span>
                    @endforeach
                    @if(count($dayEvents) > 2)
                    <span class="text-[9px] text-gray-400 font-bold block mt-0.5">+{{ count($dayEvents) - 2 }} lagi</span>
                    @endif
                </div>
                @endforeach
            </div>

            {{-- Legend --}}
            <div class="px-6 py-3 border-t border-gray-100 flex flex-wrap gap-3 bg-gray-50/30">
                <div class="flex items-center gap-1.5 text-xs text-gray-600 font-medium">
                    <span class="w-3 h-3 rounded bg-red-100 border border-red-300"></span> Libur Khusus
                </div>
                <div class="flex items-center gap-1.5 text-xs text-gray-600 font-medium">
                    <span class="w-3 h-3 rounded bg-amber-100 border border-amber-300"></span> Acara
                </div>
                <div class="flex items-center gap-1.5 text-xs text-gray-600 font-medium">
                    <span class="w-3 h-3 rounded bg-blue-100 border border-blue-300"></span> Online
                </div>
                <div class="flex items-center gap-1.5 text-xs text-gray-600 font-medium">
                    <span class="w-3 h-3 rounded bg-purple-100 border border-purple-300"></span> Pengumuman
                </div>
                <div class="flex items-center gap-1.5 text-xs text-gray-600 font-medium">
                    <span class="w-3 h-3 rounded bg-red-50 border border-red-200"></span> Libur Rutin (Sabtu/Minggu)
                </div>
            </div>
        </div>

        {{-- UPCOMING EVENTS LIST ─────── --}}
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden flex flex-col">
            <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-title font-black text-sqr-green">📋 Agenda 30 Hari Ke Depan</h3>
                    <p class="text-xs text-gray-400">Daftar event terdekat</p>
                </div>
                <a href="{{ route('kalender') }}" target="_blank" class="text-xs text-sqr-orange font-bold hover:underline">Lihat Mode Baca →</a>
            </div>
            <div class="flex-1 overflow-y-auto divide-y divide-gray-50 max-h-[440px]">
                @forelse($upcomingEvents as $ev)
                <div class="px-5 py-3.5 hover:bg-gray-50/70 transition group">
                    <div class="flex items-start gap-3">
                        <div class="text-center shrink-0 w-10">
                            <div class="text-base font-black text-sqr-green leading-none">{{ $ev->date->format('d') }}</div>
                            <div class="text-[9px] font-bold text-gray-400 uppercase mt-0.5">{{ $ev->date->translatedFormat('M') }}</div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="text-xs font-bold text-gray-800 truncate">{{ $ev->title }}</div>
                            <div class="flex items-center gap-1 mt-1">
                                <span class="inline-block px-2 py-0.5 rounded-full text-[9px] font-bold uppercase
                                    @if($ev->type === 'libur') bg-red-100 text-red-700
                                    @elseif($ev->type === 'online') bg-blue-100 text-blue-700
                                    @elseif($ev->type === 'acara') bg-amber-100 text-amber-700
                                    @else bg-purple-100 text-purple-700 @endif">
                                    {{ $ev->type }}
                                </span>
                                @if($ev->sqrClass)
                                <span class="text-[9px] text-gray-400 font-semibold">· {{ $ev->sqrClass->name }}</span>
                                @endif
                            </div>
                            @if($ev->online_link)
                            <a href="{{ $ev->online_link }}" target="_blank"
                               class="text-[10px] text-blue-600 hover:underline mt-1 block truncate font-medium">🔗 Link Meeting Zoom/Meet</a>
                            @endif
                        </div>
                        <div class="flex items-center gap-1 opacity-80 group-hover:opacity-100 transition shrink-0">
                            <button onclick='openEditModal(@json($ev))'
                                    class="p-1.5 text-blue-600 hover:bg-blue-50 rounded-lg transition" title="Edit">
                                <i class="fa-solid fa-pen-to-square text-xs"></i>
                            </button>
                            <form method="POST" action="{{ route('admin.jadwal.destroy', $ev->id) }}"
                                  onsubmit="return confirm('Hapus event {{ addslashes($ev->title) }}?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="p-1.5 text-red-500 hover:bg-red-50 rounded-lg transition" title="Hapus">
                                    <i class="fa-solid fa-trash-can text-xs"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @empty
                <div class="flex flex-col items-center justify-center py-12 text-gray-400">
                    <i class="fa-regular fa-calendar-xmark text-3xl mb-2 opacity-50"></i>
                    <p class="text-xs font-semibold">Belum ada event mendatang</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- ── All Events This Month (Table) ─────────────────── --}}
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
            <div>
                <h3 class="text-sm font-title font-black text-sqr-green">📝 Semua Event — {{ $monthNames[$month] }} {{ $year }}</h3>
                <p class="text-xs text-gray-400">Total {{ $events->count() }} event terdaftar</p>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-xs">
                <thead>
                    <tr class="border-b border-gray-100 bg-gray-50/80 font-title uppercase tracking-wider text-gray-500 text-[10px]">
                        <th class="text-left px-5 py-3">Tanggal</th>
                        <th class="text-left px-5 py-3">Judul Event</th>
                        <th class="text-left px-5 py-3">Tipe</th>
                        <th class="text-left px-5 py-3 hidden md:table-cell">Target Kelas</th>
                        <th class="text-left px-5 py-3 hidden lg:table-cell">Link Online</th>
                        <th class="text-center px-5 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($events as $ev)
                    <tr class="hover:bg-gray-50/60 transition">
                        <td class="px-5 py-3 text-xs text-gray-700 font-bold">
                            {{ $ev->date_range }}
                        </td>
                        <td class="px-5 py-3">
                            <div class="font-bold text-gray-800 text-xs">{{ $ev->title }}</div>
                            @if($ev->description)
                            <div class="text-[11px] text-gray-400 truncate max-w-xs">{{ Str::limit($ev->description, 50) }}</div>
                            @endif
                        </td>
                        <td class="px-5 py-3">
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold border
                                @if($ev->type === 'libur') bg-red-50 text-red-700 border-red-200
                                @elseif($ev->type === 'acara') bg-amber-50 text-amber-700 border-amber-200
                                @elseif($ev->type === 'online') bg-blue-50 text-blue-700 border-blue-200
                                @else bg-purple-50 text-purple-700 border-purple-200 @endif">
                                {{ $ev->type_icon }} {{ ucfirst($ev->type) }}
                            </span>
                            @if($ev->is_holiday)
                            <span class="ml-1 text-[10px] text-red-500 font-bold">(Libur)</span>
                            @endif
                        </td>
                        <td class="px-5 py-3 text-gray-600 hidden md:table-cell">
                            {{ $ev->sqrClass?->name ?? 'Semua Kelas' }}
                        </td>
                        <td class="px-5 py-3 hidden lg:table-cell">
                            @if($ev->online_link)
                            <a href="{{ $ev->online_link }}" target="_blank"
                               class="text-blue-600 hover:underline truncate max-w-[140px] block font-medium">{{ $ev->online_link }}</a>
                            @else
                            <span class="text-gray-300">—</span>
                            @endif
                        </td>
                        <td class="px-5 py-3">
                            <div class="flex items-center justify-center gap-2">
                                <button onclick='openEditModal(@json($ev))'
                                        class="px-2.5 py-1.5 rounded-xl bg-blue-50 text-blue-700 hover:bg-blue-100 font-bold text-xs transition flex items-center gap-1">
                                    <i class="fa-solid fa-pen-to-square"></i> Edit
                                </button>
                                <form method="POST" action="{{ route('admin.jadwal.destroy', $ev->id) }}"
                                      onsubmit="return confirm('Hapus event {{ addslashes($ev->title) }}?')">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                            class="px-2.5 py-1.5 rounded-xl bg-red-50 text-red-600 hover:bg-red-100 font-bold text-xs transition flex items-center gap-1">
                                        <i class="fa-solid fa-trash-can"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-5 py-10 text-center text-gray-400 text-xs font-semibold">
                            <i class="fa-regular fa-calendar-xmark text-2xl block mb-2 opacity-50"></i>
                            Belum ada event tercatat di bulan {{ $monthNames[$month] }} {{ $year }}
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- ═══════════════════════════════════════════════════════════
     MODAL: Tambah Event
═══════════════════════════════════════════════════════════ --}}
<div id="addEventModal" class="fixed inset-0 z-[999] bg-black/60 backdrop-blur-sm hidden flex items-center justify-center p-4">
    <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-lg overflow-hidden max-h-[90vh] flex flex-col">
        <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between shrink-0">
            <div>
                <h3 class="text-base font-title font-black text-sqr-green">➕ Tambah Event / Libur Kalender</h3>
                <p class="text-xs text-gray-400 mt-0.5">Isi detail event tunggal atau rentang tanggal (multi-hari)</p>
            </div>
            <button onclick="closeModal('addEventModal')" class="w-8 h-8 rounded-full bg-gray-100 hover:bg-gray-200 flex items-center justify-center text-gray-500 transition">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <form method="POST" action="{{ route('admin.jadwal.store') }}" class="overflow-y-auto">
            @csrf
            @include('admin.jadwal._event_form', ['event' => null, 'classes' => $classes])
            <div class="px-6 py-4 border-t border-gray-100 flex justify-end gap-3 shrink-0">
                <button type="button" onclick="closeModal('addEventModal')"
                        class="px-4 py-2.5 rounded-xl border border-gray-200 text-xs font-bold text-gray-600 hover:bg-gray-50 transition">Batal</button>
                <button type="submit"
                        class="px-6 py-2.5 rounded-xl bg-sqr-green text-white text-xs font-bold hover:bg-sqr-dark transition shadow-md flex items-center gap-1.5">
                    <i class="fa-solid fa-floppy-disk"></i> Simpan Event
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ═══════════════════════════════════════════════════════════
     MODAL: Edit Event
═══════════════════════════════════════════════════════════ --}}
<div id="editEventModal" class="fixed inset-0 z-[999] bg-black/60 backdrop-blur-sm hidden flex items-center justify-center p-4">
    <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-lg overflow-hidden max-h-[90vh] flex flex-col">
        <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between shrink-0">
            <div>
                <h3 class="text-base font-title font-black text-sqr-green">✏️ Edit Event Kalender</h3>
                <p class="text-xs text-gray-400 mt-0.5">Ubah rincian jadwal atau event</p>
            </div>
            <button onclick="closeModal('editEventModal')" class="w-8 h-8 rounded-full bg-gray-100 hover:bg-gray-200 flex items-center justify-center text-gray-500 transition">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <form id="editEventForm" method="POST" class="overflow-y-auto">
            @csrf
            @method('PUT')
            <div class="p-6 space-y-4 text-xs">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block font-bold text-gray-700 mb-1">Tanggal Mulai *</label>
                        <input type="date" id="edit_date" name="date" required
                               class="w-full px-3 py-2.5 rounded-xl border border-gray-200 font-medium focus:ring-2 focus:ring-sqr-green/20 outline-none">
                    </div>
                    <div>
                        <label class="block font-bold text-gray-700 mb-1">Tanggal Selesai (multi-hari)</label>
                        <input type="date" id="edit_date_end" name="date_end"
                               class="w-full px-3 py-2.5 rounded-xl border border-gray-200 font-medium focus:ring-2 focus:ring-sqr-green/20 outline-none">
                    </div>
                </div>
                <div>
                    <label class="block font-bold text-gray-700 mb-1">Judul Event *</label>
                    <input type="text" id="edit_title" name="title" required
                           class="w-full px-3 py-2.5 rounded-xl border border-gray-200 font-medium focus:ring-2 focus:ring-sqr-green/20 outline-none"
                           placeholder="Cth: Libur Kemerdekaan RI">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block font-bold text-gray-700 mb-1">Tipe Event *</label>
                        <select id="edit_type" name="type" onchange="toggleEditOnlineSection()" required
                                class="w-full px-3 py-2.5 rounded-xl border border-gray-200 font-bold focus:ring-2 focus:ring-sqr-green/20 outline-none">
                            <option value="pengumuman">📢 Pengumuman</option>
                            <option value="libur">🔴 Libur</option>
                            <option value="acara">🟡 Acara Khusus</option>
                            <option value="online">🔵 Kelas Online</option>
                        </select>
                    </div>
                    <div>
                        <label class="block font-bold text-gray-700 mb-1">Target Kelas</label>
                        <select id="edit_class_id" name="class_id"
                                class="w-full px-3 py-2.5 rounded-xl border border-gray-200 font-medium focus:ring-2 focus:ring-sqr-green/20 outline-none">
                            <option value="">Semua Kelas</option>
                            @foreach($classes as $cl)
                            <option value="{{ $cl->id }}">{{ $cl->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div id="edit_online_section" class="space-y-3 p-3 bg-blue-50 rounded-2xl border border-blue-100 hidden">
                    <div>
                        <label class="block font-bold text-blue-700 mb-1">🔗 Link Meeting (Zoom / Google Meet)</label>
                        <input type="url" id="edit_online_link" name="online_link"
                               class="w-full px-3 py-2 rounded-xl border border-blue-200 bg-white text-xs outline-none"
                               placeholder="https://meet.google.com/...">
                    </div>
                    <div>
                        <label class="block font-bold text-blue-700 mb-1">⏰ Jam Mulai Kelas Online</label>
                        <input type="time" id="edit_online_start_time" name="online_start_time"
                               class="w-full px-3 py-2 rounded-xl border border-blue-200 bg-white text-xs outline-none">
                    </div>
                </div>
                <div>
                    <label class="block font-bold text-gray-700 mb-1">Deskripsi / Keterangan</label>
                    <textarea id="edit_description" name="description" rows="2"
                              class="w-full px-3 py-2.5 rounded-xl border border-gray-200 font-medium outline-none resize-none"
                              placeholder="Keterangan tambahan..."></textarea>
                </div>
                <label class="flex items-center gap-2 cursor-pointer p-3 rounded-2xl border border-gray-100 hover:bg-gray-50 transition">
                    <input type="checkbox" id="edit_is_holiday" name="is_holiday" value="1"
                           class="w-4 h-4 rounded text-sqr-green border-gray-300 focus:ring-sqr-green">
                    <div>
                        <div class="font-bold text-gray-800">Tandai sebagai Hari Libur</div>
                        <div class="text-[10px] text-gray-400">Santri libur / tidak ada KBM</div>
                    </div>
                </label>
            </div>
            <div class="px-6 py-4 border-t border-gray-100 flex justify-end gap-3 shrink-0">
                <button type="button" onclick="closeModal('editEventModal')"
                        class="px-4 py-2.5 rounded-xl border border-gray-200 text-xs font-bold text-gray-600 hover:bg-gray-50 transition">Batal</button>
                <button type="submit"
                        class="px-6 py-2.5 rounded-xl bg-sqr-green text-white text-xs font-bold hover:bg-sqr-dark transition shadow-md flex items-center gap-1.5">
                    <i class="fa-solid fa-floppy-disk"></i> Perbarui Event
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ═══════════════════════════════════════════════════════════
     MODAL: Pengaturan Jam
═══════════════════════════════════════════════════════════ --}}
<div id="settingsModal" class="fixed inset-0 z-[999] bg-black/60 backdrop-blur-sm hidden flex items-center justify-center p-4">
    <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-md overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between">
            <div>
                <h3 class="text-base font-title font-black text-sqr-green">⚙️ Pengaturan Jam & Hari Libur</h3>
                <p class="text-xs text-gray-400 mt-0.5">Jam operasional dan hari libur mingguan rutin TPQ</p>
            </div>
            <button onclick="closeModal('settingsModal')" class="w-8 h-8 rounded-full bg-gray-100 hover:bg-gray-200 flex items-center justify-center text-gray-500 transition">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <form method="POST" action="{{ route('admin.jadwal.settings') }}">
            @csrf @method('PUT')
            <div class="p-6 space-y-4 text-xs">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block font-bold text-gray-700 mb-1.5">🟢 Jam Masuk *</label>
                        <input type="time" name="jam_masuk" value="{{ $jamMasuk }}" required
                               class="w-full px-3 py-2.5 rounded-xl border border-gray-200 font-bold text-sqr-green outline-none">
                    </div>
                    <div>
                        <label class="block font-bold text-gray-700 mb-1.5">🔴 Jam Pulang *</label>
                        <input type="time" name="jam_pulang" value="{{ $jamPulang }}" required
                               class="w-full px-3 py-2.5 rounded-xl border border-gray-200 font-bold text-sqr-green outline-none">
                    </div>
                </div>
                <div>
                    <label class="block font-bold text-gray-700 mb-1.5">📅 Hari Libur Rutin Mingguan</label>
                    <div class="grid grid-cols-2 gap-2 bg-gray-50 p-3 rounded-2xl border border-gray-100">
                        @foreach(['Ahad (Minggu)' => 0, 'Senin' => 1, 'Selasa' => 2, 'Rabu' => 3, 'Kamis' => 4, "Jum'at" => 5, 'Sabtu' => 6] as $hari => $idx)
                        <label class="flex items-center gap-2 cursor-pointer text-xs font-semibold text-gray-700">
                            <input type="checkbox" name="libur_mingguan[]" value="{{ $idx }}"
                                   {{ in_array($idx, $weeklyOffDays) ? 'checked' : '' }}
                                   class="w-4 h-4 rounded text-sqr-green border-gray-300 focus:ring-sqr-green">
                            <span>{{ $hari }}</span>
                        </label>
                        @endforeach
                    </div>
                    <p class="text-[10px] text-gray-400 mt-1">Centang hari libur rutin (Default: Sabtu & Minggu)</p>
                </div>
                <div class="p-3 rounded-2xl bg-amber-50 border border-amber-100">
                    <p class="text-[11px] text-amber-800 font-semibold leading-relaxed">
                        ⚠️ Perubahan berlaku untuk <strong>seluruh portal</strong> (Wali & Ustadz).
                    </p>
                </div>
            </div>
            <div class="px-6 py-4 border-t border-gray-100 flex justify-end gap-3">
                <button type="button" onclick="closeModal('settingsModal')"
                        class="px-4 py-2.5 rounded-xl border border-gray-200 text-xs font-bold text-gray-600 hover:bg-gray-50 transition">Batal</button>
                <button type="submit"
                        class="px-6 py-2.5 rounded-xl bg-sqr-green text-white text-xs font-bold hover:bg-sqr-dark transition shadow-md flex items-center gap-1.5">
                    <i class="fa-solid fa-floppy-disk"></i> Simpan Pengaturan
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function openAddModal() {
    document.getElementById('addEventModal').classList.remove('hidden');
}

function openAddModalForDate(dateStr) {
    var addDateInput = document.querySelector('#addEventModal input[name="date"]');
    if (addDateInput) {
        addDateInput.value = dateStr;
    }
    openAddModal();
}

function openSettingsModal() {
    document.getElementById('settingsModal').classList.remove('hidden');
}

function closeModal(modalId) {
    document.getElementById(modalId).classList.add('hidden');
}

function openEditModal(ev) {
    document.getElementById('editEventForm').action = '/admin/jadwal/' + ev.id;
    document.getElementById('edit_date').value = ev.date ? ev.date.substring(0, 10) : '';
    document.getElementById('edit_date_end').value = ev.date_end ? ev.date_end.substring(0, 10) : '';
    document.getElementById('edit_title').value = ev.title || '';
    document.getElementById('edit_description').value = ev.description || '';
    document.getElementById('edit_type').value = ev.type || 'pengumuman';
    document.getElementById('edit_class_id').value = ev.class_id || '';
    document.getElementById('edit_is_holiday').checked = !!ev.is_holiday;

    toggleEditOnlineSection();
    document.getElementById('editEventModal').classList.remove('hidden');
}

function toggleEditOnlineSection() {
    var type = document.getElementById('edit_type').value;
    var sec  = document.getElementById('edit_online_section');
    if (type === 'online') {
        sec.classList.remove('hidden');
    } else {
        sec.classList.add('hidden');
    }
}
</script>
@endpush

@endsection
