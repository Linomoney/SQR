@extends('layouts.dashboard')

@section('title', 'Verifikasi Transfer SPP')

@section('content')
<div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 mb-6">
    <div class="border-b pb-4 mb-5">
        <h3 class="font-title font-bold text-lg text-sqr-green">Verifikasi Bukti Transfer SPP Santri</h3>
        <p class="text-xs text-gray-500">Periksa bukti transfer pembayaran dari Wali Santri untuk menyetujui atau menolak status pembayaran</p>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left text-xs">
            <thead class="bg-sqr-bg/50 text-sqr-green font-title uppercase tracking-wider text-[10px]">
                <tr>
                    <th class="p-3.5 rounded-l-xl">Tanggal</th>
                    <th class="p-3.5">Santri</th>
                    <th class="p-3.5">Bulan</th>
                    <th class="p-3.5">Jumlah (Rp)</th>
                    <th class="p-3.5">Bukti Transfer</th>
                    <th class="p-3.5">Status</th>
                    <th class="p-3.5 text-center rounded-r-xl">Aksi Verifikasi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($verifications as $v)
                <tr class="hover:bg-gray-50/80 transition">
                    <td class="p-3.5 font-semibold text-gray-600">{{ $v->created_at->format('d M Y H:i') }}</td>
                    <td class="p-3.5 font-bold text-gray-800">{{ $v->payment?->santri?->fullName ?? '-' }}</td>
                    <td class="p-3.5 font-bold text-sqr-orange">{{ $v->payment?->month ?? '-' }}</td>
                    <td class="p-3.5 font-bold text-sqr-green">Rp {{ number_format($v->payment?->amount ?? 0, 0, ',', '.') }}</td>
                    <td class="p-3.5">
                        @if($v->proof_url)
                        <a href="{{ $v->proof_url }}" target="_blank" class="text-blue-600 font-bold hover:underline flex items-center gap-1">
                            <i class="fa-solid fa-image"></i> Lihat Bukti
                        </a>
                        @else
                        <span class="text-gray-400">Tidak ada</span>
                        @endif
                    </td>
                    <td class="p-3.5">
                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase {{ $v->status === 'Approved' ? 'bg-emerald-100 text-emerald-800' : ($v->status === 'Rejected' ? 'bg-red-100 text-red-800' : 'bg-amber-100 text-amber-800') }}">
                            {{ $v->status }}
                        </span>
                    </td>
                    <td class="p-3.5 text-center">
                        @if($v->status === 'Pending')
                        <div class="flex items-center justify-center gap-2">
                            <form method="POST" action="{{ route('admin.verifikasi.approve', $v) }}">
                                @csrf @method('PATCH')
                                <button type="submit" class="px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-[10px] rounded-xl transition shadow-sm">
                                    <i class="fa-solid fa-check mr-1"></i> Setujui
                                </button>
                            </form>
                            <button onclick="openRejectModal({{ $v->id }})" class="px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white font-bold text-[10px] rounded-xl transition shadow-sm">
                                <i class="fa-solid fa-times mr-1"></i> Tolak
                            </button>
                        </div>
                        @else
                        <span class="text-[10px] text-gray-400 italic">Terverifikasi oleh {{ $v->user?->name ?? 'Admin' }}</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="p-8 text-center text-gray-400">Belum ada pengajuan verifikasi SPP.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $verifications->links() }}
    </div>
</div>

<!-- Modal Reject -->
<div id="rejectModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl p-6 max-w-sm w-full shadow-2xl">
        <h4 class="font-title font-bold text-base text-red-600 mb-2">Tolak Verifikasi SPP</h4>
        <p class="text-xs text-gray-500 mb-4">Berikan alasan penolakan agar Wali Santri dapat memperbaikinya.</p>
        <form id="rejectForm" method="POST" action="">
            @csrf @method('PATCH')
            <textarea name="notes" required rows="3" class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-xs outline-none focus:border-red-500 mb-4" placeholder="Alasan penolakan (misal: Bukti buram/nominal tidak sesuai)..."></textarea>
            <div class="flex gap-2">
                <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-bold text-xs py-2.5 rounded-xl transition">
                    Tolak Verifikasi
                </button>
                <button type="button" onclick="closeRejectModal()" class="w-full bg-gray-100 text-gray-600 font-bold text-xs py-2.5 rounded-xl transition">
                    Batal
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function openRejectModal(id) {
        document.getElementById('rejectForm').action = '/admin/verifikasi-spp/' + id + '/reject';
        document.getElementById('rejectModal').classList.remove('hidden');
    }
    function closeRejectModal() {
        document.getElementById('rejectModal').classList.add('hidden');
    }
</script>
@endpush
@endsection
