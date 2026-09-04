@extends(auth()->check() ? 'layouts.dashboard' : 'layouts.app')

@section('title', 'Kalender Akademik Saung Quran Rabbani')

@section('content')
@php
    $monthNames = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                   'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
    $dayNames = ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'];

    $firstDayOfMonth = $calStart->copy()->startOfMonth();
    $startGrid = $firstDayOfMonth->copy()->startOfWeek(\Carbon\Carbon::SUNDAY);
    $endGrid   = $calEnd->copy()->endOfWeek(\Carbon\Carbon::SATURDAY);

    $calDays = [];
    $cursor = $startGrid->copy();
    while ($cursor->lte($endGrid)) {
        $calDays[] = $cursor->copy();
        $cursor->addDay();
    }

    $tomorrow = today()->addDay();
    $tomorrowEvents = \App\Models\SchoolEvent::onDate($tomorrow)->get();
@endphp

<style>
.event-pill       { font-size: 10px; padding: 1px 5px; border-radius: 999px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 100%; display: block; }
.event-libur      { background: #fee2e2; color: #b91c1c; }
.event-acara      { background: #fef9c3; color: #854d0e; }
.event-online     { background: #dbeafe; color: #1e40af; }
.event-pengumuman { background: #f3e8ff; color: #6b21a8; }
</style>

<div class="max-w-7xl mx-auto space-y-6 {{ auth()->check() ? '' : 'p-4 sm:p-6 lg:p-8' }}">

    {{-- Hero Header --}}
    <div class="bg-gradient-to-r from-sqr-green via-sqr-dark to-sqr-green text-white rounded-3xl p-6 sm:p-8 shadow-xl relative overflow-hidden">
        <div class="absolute -top-10 -right-10 w-48 h-48 bg-white/5 rounded-full"></div>
        <div class="relative z-10 flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl bg-white/20 text-white flex items-center justify-center text-3xl font-black shrink-0">
                    📅
                </div>
                <div>
                    <span class="bg-sqr-orange text-white text-[10px] font-black px-3 py-1 rounded-full uppercase tracking-wider">
                        Kalender Resmi TPQ Saung Quran Rabbani
                    </span>
                    <h1 class="font-title font-black text-2xl sm:text-3xl text-white mt-1">Kalender Kegiatan & Libur Akademik</h1>
                    <p class="text-xs text-sqr-light-green mt-1">Jadwal kegiatan belajar mengajar, hari libur nasional, dan agenda yayasan</p>
                </div>
            </div>
            <div class="flex items-center gap-2 shrink-0">
                <span class="bg-white/10 text-white text-xs px-4 py-2 rounded-2xl border border-white/20 font-bold">
                    ⏰ Jam Operasional: {{ $jamMasuk }} - {{ $jamPulang }} WIB
                </span>
            </div>
        </div>
    </div>

    {{-- Status Banner Today & Tomorrow --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        {{-- Today Status --}}
        <div class="p-5 rounded-3xl border shadow-sm flex items-center gap-4
            {{ $isSchoolDay ? 'bg-emerald-50 border-emerald-200 text-emerald-900' : 'bg-red-50 border-red-200 text-red-900' }}">
            <div class="text-3xl shrink-0">{{ $isSchoolDay ? '📚' : '🏖️' }}</div>
            <div>
                <div class="text-[10px] font-bold uppercase tracking-wider opacity-70">Status Hari Ini — {{ today()->translatedFormat('l, d F Y') }}</div>
                <div class="font-title font-black text-base mt-0.5">
                    {{ $isSchoolDay ? 'Hari Belajar Aktif (16:00 - 17:30 WIB)' : 'Hari Libur (Tidak Ada KBM)' }}
                </div>
                @if($todayEvents->isNotEmpty())
                <div class="flex flex-wrap gap-1.5 mt-2">
                    @foreach($todayEvents as $ev)
                    <span class="text-[10px] px-2.5 py-0.5 rounded-full font-bold bg-white/80 border border-current shadow-2xs">
                        {{ $ev->type_icon }} {{ $ev->title }}
                    </span>
                    @endforeach
                </div>
                @endif
            </div>
        </div>

        {{-- Tomorrow Info --}}
        @php
            $isTomorrowSchool = \App\Models\SchoolSchedule::isSchoolDay($tomorrow);
        @endphp
        <div class="p-5 rounded-3xl border border-gray-100 bg-white shadow-sm flex items-center gap-4">
            <div class="text-3xl shrink-0">🔮</div>
            <div>
                <div class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Info Besok — {{ $tomorrow->translatedFormat('l, d F Y') }}</div>
                <div class="font-title font-bold text-sm text-gray-800 mt-0.5">
                    {{ $isTomorrowSchool ? '🟢 KBM Masuk Seperti Biasa (16:00 WIB)' : '🔴 Besok Hari Libur' }}
                </div>
                @if($tomorrowEvents->isNotEmpty())
                <div class="flex flex-wrap gap-1.5 mt-2">
                    @foreach($tomorrowEvents as $tEv)
                    <span class="text-[10px] px-2.5 py-0.5 rounded-full font-bold bg-gray-100 text-gray-700">
                        {{ $tEv->type_icon }} {{ $tEv->title }}
                    </span>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Calendar Grid & Upcoming Events --}}
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

        {{-- Calendar Grid --}}
        <div class="xl:col-span-2 bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                @php
                    $prevRouteParams = ['year' => $month == 1 ? $year - 1 : $year, 'month' => $month == 1 ? 12 : $month - 1];
                    $nextRouteParams = ['year' => $month == 12 ? $year + 1 : $year, 'month' => $month == 12 ? 1 : $month + 1];
                @endphp
                <a href="{{ request()->fullUrlWithQuery($prevRouteParams) }}"
                   class="w-9 h-9 rounded-xl border border-gray-200 flex items-center justify-center hover:bg-gray-50 transition text-gray-600">
                    <i class="fa-solid fa-chevron-left text-xs"></i>
                </a>
                <h3 class="text-base font-title font-black text-sqr-green">
                    {{ $monthNames[$month] }} {{ $year }}
                </h3>
                <a href="{{ request()->fullUrlWithQuery($nextRouteParams) }}"
                   class="w-9 h-9 rounded-xl border border-gray-200 flex items-center justify-center hover:bg-gray-50 transition text-gray-600">
                    <i class="fa-solid fa-chevron-right text-xs"></i>
                </a>
            </div>

            <div class="grid grid-cols-7 border-b border-gray-100 bg-gray-50/50">
                @foreach($dayNames as $idx => $day)
                @php
                    $isOffDayHeader = in_array($idx, $weeklyOffDays);
                @endphp
                <div class="text-center py-2.5 text-xs font-bold {{ $isOffDayHeader ? 'text-red-500' : 'text-gray-600' }}">
                    {{ $day }}
                </div>
                @endforeach
            </div>

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
                <div class="min-h-[95px] border-b border-r border-gray-100 p-1.5 relative transition hover:bg-gray-50/60
                    {{ !$isCurrentMonth ? 'opacity-30 bg-gray-50/30' : '' }}
                    {{ $isWeeklyOff && !count($dayEvents) ? 'bg-red-50/30' : '' }}
                    {{ $hasHoliday ? 'bg-red-50/60' : '' }}
                    {{ $isToday ? 'ring-2 ring-inset ring-sqr-green bg-sqr-green/5' : '' }}">
                    <div class="flex items-center justify-between mb-1">
                        <span class="text-xs font-bold {{ $isToday ? 'bg-sqr-green text-white w-5 h-5 rounded-full flex items-center justify-center' : ($isWeeklyOff ? 'text-red-500' : 'text-gray-700') }}">
                            {{ $day->day }}
                        </span>
                    </div>
                    @foreach(collect($dayEvents)->take(2) as $ev)
                    <span class="event-pill event-{{ $ev->type }} mb-0.5 font-semibold">{{ $ev->title }}</span>
                    @endforeach
                    @if(count($dayEvents) > 2)
                    <span class="text-[9px] text-gray-400 font-bold block mt-0.5">+{{ count($dayEvents) - 2 }} lagi</span>
                    @endif
                </div>
                @endforeach
            </div>

            <div class="px-6 py-3 border-t border-gray-100 flex flex-wrap gap-3 bg-gray-50/30">
                <div class="flex items-center gap-1.5 text-xs text-gray-600 font-medium">
                    <span class="w-3 h-3 rounded bg-red-100 border border-red-300"></span> Libur
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
                    <span class="w-3 h-3 rounded bg-red-50 border border-red-200"></span> Libur Mingguan (Sabtu/Minggu)
                </div>
            </div>
        </div>

        {{-- Upcoming Events --}}
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden flex flex-col">
            <div class="px-5 py-4 border-b border-gray-100">
                <h3 class="text-sm font-title font-black text-sqr-green">📋 Agenda Mendatang</h3>
                <p class="text-xs text-gray-400">Rencana kegiatan TPQ SQR</p>
            </div>
            <div class="flex-1 overflow-y-auto divide-y divide-gray-50 max-h-[440px]">
                @forelse($upcomingEvents as $ev)
                <div class="px-5 py-3.5 hover:bg-gray-50/70 transition">
                    <div class="flex items-start gap-3">
                        <div class="text-center shrink-0 w-10">
                            <div class="text-base font-black text-sqr-green leading-none">{{ $ev->date->format('d') }}</div>
                            <div class="text-[9px] font-bold text-gray-400 uppercase mt-0.5">{{ $ev->date->translatedFormat('M') }}</div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="text-xs font-bold text-gray-800 truncate">{{ $ev->title }}</div>
                            @if($ev->description)
                            <div class="text-[10px] text-gray-500 mt-0.5 line-clamp-2">{{ $ev->description }}</div>
                            @endif
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
                        </div>
                    </div>
                </div>
                @empty
                <div class="flex flex-col items-center justify-center py-12 text-gray-400">
                    <i class="fa-regular fa-calendar-xmark text-3xl mb-2 opacity-50"></i>
                    <p class="text-xs font-semibold">Belum ada agenda mendatang</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
