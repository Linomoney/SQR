@extends('layouts.dashboard')

@section('title', 'Presensi Santri & Ustadz')

@section('content')
<div class="space-y-8">
    <!-- Presensi Ustadz -->
    <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100">
        <div class="border-b pb-4 mb-4">
            <h3 class="font-title font-bold text-base text-sqr-green flex items-center gap-2">
                <i class="fa-solid fa-user-check text-sqr-orange"></i> Rekap Presensi Ustadz / Pengajar
            </h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-sqr-bg/50 text-sqr-green font-title text-[10px] uppercase">
                    <tr><th class="p-3">Tanggal</th><th class="p-3">Nama Ustadz</th><th class="p-3">Status</th><th class="p-3">Catatan</th></tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($ustadzAttendance as $ua)
                    <tr>
                        <td class="p-3 font-semibold text-gray-600">{{ $ua->date?->format('d M Y') }}</td>
                        <td class="p-3 font-bold text-gray-800">{{ $ua->ustadz?->name }}</td>
                        <td class="p-3">
                            <span class="px-2.5 py-0.5 rounded-full text-[9px] font-bold uppercase {{ $ua->status === 'Hadir' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                                {{ $ua->status }}
                            </span>
                        </td>
                        <td class="p-3 text-gray-500 italic">{{ $ua->notes ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="p-6 text-center text-gray-400">Belum ada rekapan presensi ustadz.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">{{ $ustadzAttendance->links() }}</div>
    </div>

    <!-- Presensi Santri -->
    <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100">
        <div class="border-b pb-4 mb-4">
            <h3 class="font-title font-bold text-base text-sqr-green flex items-center gap-2">
                <i class="fa-solid fa-graduation-cap text-sqr-orange"></i> Rekap Presensi Kehadiran Santri
            </h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-sqr-bg/50 text-sqr-green font-title text-[10px] uppercase">
                    <tr><th class="p-3">Tanggal</th><th class="p-3">Nama Santri</th><th class="p-3">Kelas</th><th class="p-3">Status Kehadiran</th></tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($santriAttendance as $sa)
                    <tr>
                        <td class="p-3 font-semibold text-gray-600">{{ $sa->date?->format('d M Y') }}</td>
                        <td class="p-3 font-bold text-gray-800">{{ $sa->santri?->fullName }}</td>
                        <td class="p-3 font-semibold text-sqr-green">{{ $sa->sqrClass?->name }}</td>
                        <td class="p-3">
                            <span class="px-2.5 py-0.5 rounded-full text-[9px] font-bold uppercase {{ $sa->status === 'Hadir' ? 'bg-emerald-100 text-emerald-800' : ($sa->status === 'Alpa' ? 'bg-red-100 text-red-800' : 'bg-amber-100 text-amber-800') }}">
                                {{ $sa->status }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="p-6 text-center text-gray-400">Belum ada rekapan presensi santri.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">{{ $santriAttendance->links() }}</div>
    </div>
</div>
@endsection
