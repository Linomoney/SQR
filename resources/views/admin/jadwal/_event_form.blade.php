{{-- Shared event form fields (used in Add modal) --}}
<div class="p-6 space-y-4" x-data="{ eventType: '{{ old('type', 'pengumuman') }}' }">
    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block text-xs font-semibold text-gray-600 mb-1">Tanggal Mulai *</label>
            <input type="date" name="date" value="{{ old('date', date('Y-m-d')) }}" required
                   class="w-full px-3 py-2 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-[#2d4a22]/20 focus:border-[#2d4a22] outline-none transition">
        </div>
        <div>
            <label class="block text-xs font-semibold text-gray-600 mb-1">Tanggal Selesai <span class="text-gray-400">(multi-hari)</span></label>
            <input type="date" name="date_end" value="{{ old('date_end') }}"
                   class="w-full px-3 py-2 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-[#2d4a22]/20 focus:border-[#2d4a22] outline-none transition">
        </div>
    </div>

    <div>
        <label class="block text-xs font-semibold text-gray-600 mb-1">Judul Event *</label>
        <input type="text" name="title" value="{{ old('title') }}" required
               class="w-full px-3 py-2 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-[#2d4a22]/20 focus:border-[#2d4a22] outline-none transition"
               placeholder="Cth: Libur Idul Fitri, Kajian Bulanan...">
    </div>

    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block text-xs font-semibold text-gray-600 mb-1">Tipe Event *</label>
            <select name="type" x-model="eventType" required
                    class="w-full px-3 py-2 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-[#2d4a22]/20 focus:border-[#2d4a22] outline-none transition">
                <option value="pengumuman">📢 Pengumuman</option>
                <option value="libur">🔴 Libur</option>
                <option value="acara">🟡 Acara Khusus</option>
                <option value="online">🔵 Kelas Online</option>
            </select>
        </div>
        <div>
            <label class="block text-xs font-semibold text-gray-600 mb-1">Khusus Kelas</label>
            <select name="class_id"
                    class="w-full px-3 py-2 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-[#2d4a22]/20 focus:border-[#2d4a22] outline-none transition">
                <option value="">Semua Kelas</option>
                @foreach($classes as $cl)
                <option value="{{ $cl->id }}">{{ $cl->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    {{-- Online-specific fields --}}
    <div x-show="eventType === 'online'" x-cloak class="space-y-3 p-3 bg-blue-50 rounded-xl border border-blue-100">
        <div>
            <label class="block text-xs font-semibold text-blue-700 mb-1">🔗 Link Meeting (Zoom / Google Meet) *</label>
            <input type="url" name="online_link" value="{{ old('online_link') }}"
                   class="w-full px-3 py-2 rounded-xl border border-blue-200 text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition bg-white"
                   placeholder="https://meet.google.com/xxx-yyyy-zzz">
        </div>
        <div>
            <label class="block text-xs font-semibold text-blue-700 mb-1">⏰ Jam Mulai Kelas Online</label>
            <input type="time" name="online_start_time" value="{{ old('online_start_time', '08:00') }}"
                   class="w-full px-3 py-2 rounded-xl border border-blue-200 text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition bg-white">
        </div>
    </div>

    <div>
        <label class="block text-xs font-semibold text-gray-600 mb-1">Deskripsi / Keterangan</label>
        <textarea name="description" rows="2"
                  class="w-full px-3 py-2 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-[#2d4a22]/20 focus:border-[#2d4a22] outline-none transition resize-none"
                  placeholder="Keterangan tambahan untuk wali dan ustadz...">{{ old('description') }}</textarea>
    </div>

    <label class="flex items-center gap-2.5 cursor-pointer p-3 rounded-xl border border-gray-100 hover:bg-gray-50 transition">
        <input type="checkbox" name="is_holiday" value="1" {{ old('is_holiday') ? 'checked' : '' }}
               class="w-4 h-4 rounded text-[#2d4a22] border-gray-300 focus:ring-[#2d4a22]">
        <div>
            <div class="text-sm font-semibold text-gray-700">Tandai sebagai Hari Libur</div>
            <div class="text-xs text-gray-400">Santri tidak perlu hadir / tidak ada kelas</div>
        </div>
    </label>
</div>
