@extends('layouts.dashboard')

@section('title', 'Manajemen Lokasi Cabang SQR & Penugasan Ustadz')

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
#modalPickerMapCanvas {
    height: 180px !important;
    width: 100% !important;
    border-radius: 1rem !important;
    overflow: hidden !important;
    position: relative !important;
    z-index: 1 !important;
}
#modalPickerMapCanvas .leaflet-container {
    height: 100% !important;
    width: 100% !important;
    border-radius: 1rem !important;
}
</style>
@endpush

@section('content')
<div class="space-y-6">

    @if(session('success'))
    <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-bold flex items-center gap-2 shadow-xs">
        <i class="fa-solid fa-circle-check text-emerald-500 text-base"></i>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    @if(session('error'))
    <div class="p-4 rounded-2xl bg-red-50 border border-red-200 text-red-800 text-xs font-bold flex items-center gap-2 shadow-xs">
        <i class="fa-solid fa-triangle-exclamation text-red-500 text-base"></i>
        <span>{{ session('error') }}</span>
    </div>
    @endif

    <!-- Header Banner -->
    <div class="bg-gradient-to-r from-sqr-dark via-sqr-green to-sqr-dark text-white rounded-3xl p-6 sm:p-8 shadow-xl relative overflow-hidden flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
        <div class="flex items-center gap-4 relative z-10">
            <div class="w-14 h-14 rounded-2xl bg-sqr-orange/30 border-2 border-sqr-orange flex items-center justify-center text-sqr-orange font-bold text-3xl shadow-lg shrink-0">
                🏢
            </div>
            <div>
                <span class="bg-white/20 text-white font-black text-[10px] px-3 py-1 rounded-full uppercase tracking-wider">
                    Sistem Multilokasi & Geolocation Cabang SQR
                </span>
                <h1 class="font-title font-black text-xl sm:text-2xl text-white mt-1">Kelola Lokasi Cabang & Penugasan Mengajar Ustadz</h1>
                <p class="text-xs text-white/80 mt-0.5">Setel titik lokasi GPS, tentukan radius presensi (misal: 50m), dan atur lokasi mengajar ustadz</p>
            </div>
        </div>

        <button type="button" onclick="openAddLocationModal()" class="px-5 py-3 rounded-2xl bg-sqr-orange hover:bg-orange-600 text-white font-title font-bold text-xs transition shadow-lg shrink-0 flex items-center gap-2 relative z-10">
            <i class="fa-solid fa-plus text-base"></i> Tambah Cabang SQR Baru
        </button>
    </div>

    <!-- PENUGASAN USTADZ KE CABANG -->
    <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 space-y-4">
        <div class="border-b pb-3 flex items-center justify-between">
            <h3 class="font-title font-bold text-sm text-sqr-green flex items-center gap-2">
                <i class="fa-solid fa-user-gear text-sqr-orange"></i> Penugasan Lokasi Mengajar Ustadz & Ustadzah
            </h3>
            <span class="text-[10px] text-gray-400 font-semibold">Ustadz hanya bisa presensi fisik di lokasi cabangnya</span>
        </div>

        <form method="POST" action="{{ route('admin.locations.assignUstadz') }}" class="grid grid-cols-1 sm:grid-cols-3 gap-4 bg-sqr-bg/40 p-4 rounded-2xl border border-sqr-green/10">
            @csrf
            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">1. Pilih Ustadz / Ustadzah *</label>
                <select name="ustadz_id" required class="w-full bg-white border border-gray-200 rounded-xl p-2.5 text-xs font-bold text-gray-800 outline-none focus:border-sqr-orange">
                    <option value="">-- Pilih Ustadz --</option>
                    @foreach($allUstadz as $u)
                    <option value="{{ $u->id }}">
                        {{ $u->formatted_name }} (Lokasi Saat Ini: {{ $u->location?->name ?? 'Belum Diatur' }})
                    </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">2. Pilih Lokasi Cabang Tempat Mengajar *</label>
                <select name="location_id" required class="w-full bg-white border border-gray-200 rounded-xl p-2.5 text-xs font-bold text-gray-800 outline-none focus:border-sqr-orange">
                    <option value="">-- Pilih Cabang SQR --</option>
                    @foreach($locations as $loc)
                    <option value="{{ $loc->id }}">{{ $loc->name }} ({{ $loc->code }})</option>
                    @endforeach
                </select>
            </div>

            <div class="self-end">
                <button type="submit" class="w-full bg-sqr-green hover:bg-sqr-dark text-white font-bold text-xs py-3 rounded-xl transition shadow-md">
                    <i class="fa-solid fa-check mr-1"></i> Simpan Penugasan Cabang
                </button>
            </div>
        </form>
    </div>

    <!-- LOCATIONS TABLE LIST -->
    <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 space-y-4">
        <h4 class="font-title font-bold text-sm text-sqr-green flex items-center gap-2 border-b pb-3">
            <i class="fa-solid fa-building-columns text-sqr-orange"></i> Daftar Lokasi & Cabang SQR ({{ $locations->count() }} Cabang)
        </h4>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @foreach($locations as $loc)
            <div class="bg-sqr-bg/30 border border-sqr-green/15 rounded-3xl p-5 space-y-3 relative hover:shadow-md transition">
                <div class="flex items-start justify-between">
                    <div>
                        <span class="px-2.5 py-0.5 rounded-full text-[9px] font-black uppercase tracking-wider {{ $loc->code === 'SQR-UTAMA' ? 'bg-sqr-orange text-white' : 'bg-sqr-green text-white' }}">
                            {{ $loc->code }}
                        </span>
                        <h4 class="font-title font-bold text-sm text-sqr-green mt-1">{{ $loc->name }}</h4>
                    </div>
                    <span class="text-xs font-bold px-2 py-0.5 rounded-full {{ $loc->is_active ? 'bg-emerald-100 text-emerald-800' : 'bg-gray-200 text-gray-600' }}">
                        {{ $loc->is_active ? 'Aktif' : 'Non-Aktif' }}
                    </span>
                </div>

                <p class="text-xs text-gray-600 leading-relaxed"><i class="fa-solid fa-location-dot text-sqr-orange mr-1"></i> {{ $loc->address ?? 'Alamat belum diisi' }}</p>

                <div class="p-3 bg-white rounded-2xl border border-gray-100 grid grid-cols-2 gap-2 text-center text-xs">
                    <div>
                        <span class="text-[9px] font-bold text-gray-400 uppercase block">Koordinat GPS</span>
                        <span class="font-bold text-gray-800 text-[11px]">{{ $loc->latitude }}, {{ $loc->longitude }}</span>
                    </div>
                    <div>
                        <span class="text-[9px] font-bold text-gray-400 uppercase block">Radius Presensi</span>
                        <span class="font-black text-sqr-orange text-[11px]">{{ $loc->radius_meters }} Meter</span>
                    </div>
                </div>

                <div class="flex items-center justify-between text-xs pt-1">
                    <span class="text-[11px] font-semibold text-sqr-green">
                        <i class="fa-solid fa-users text-sqr-orange mr-1"></i> {{ $loc->ustadz_list_count }} Ustadz Terdaftar
                    </span>

                    <button type="button" onclick="openEditLocationModal({{ $loc->id }}, '{{ addslashes($loc->name) }}', '{{ addslashes($loc->code) }}', '{{ addslashes($loc->address ?? '') }}', {{ $loc->latitude }}, {{ $loc->longitude }}, {{ $loc->radius_meters }}, {{ $loc->is_active ? 1 : 0 }})"
                            class="bg-white hover:bg-sqr-green hover:text-white text-sqr-green font-bold text-xs px-3 py-1.5 rounded-xl border border-sqr-green/20 transition">
                        <i class="fa-solid fa-pen-to-square"></i> Edit & Atur Peta
                    </button>
                </div>
            </div>
            @endforeach
        </div>
    </div>

</div>

<!-- MODAL ADD / EDIT LOKASI CABANG -->
<div id="locationModal" class="fixed inset-0 z-[9999] bg-black/70 backdrop-blur-sm hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl shadow-2xl max-w-xl w-full p-6 space-y-4 max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between border-b pb-3">
            <h4 id="modalTitle" class="font-title font-bold text-sm text-sqr-green flex items-center gap-2">
                <i class="fa-solid fa-location-dot text-sqr-orange"></i> Tambah Lokasi Cabang SQR
            </h4>
            <button type="button" onclick="closeLocationModal()" class="text-gray-400 hover:text-gray-600 text-lg">×</button>
        </div>

        <form id="locationForm" method="POST" action="{{ route('admin.locations.store') }}" class="space-y-4">
            @csrf
            <div id="methodSpoof"></div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Nama Cabang *</label>
                    <input type="text" name="name" id="modalName" required placeholder="Contoh: SQR Cabang Cimanggis"
                           class="w-full bg-gray-50 border border-gray-200 rounded-xl p-2.5 text-xs font-bold text-gray-800 outline-none focus:border-sqr-orange">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Kode Cabang *</label>
                    <input type="text" name="code" id="modalCode" required placeholder="Contoh: SQR-CIMANGGIS"
                           class="w-full bg-gray-50 border border-gray-200 rounded-xl p-2.5 text-xs font-bold text-gray-800 outline-none focus:border-sqr-orange">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">Alamat Lengkap</label>
                <input type="text" name="address" id="modalAddress" placeholder="Jl. Raya Bogor KM 30..."
                       class="w-full bg-gray-50 border border-gray-200 rounded-xl p-2.5 text-xs text-gray-800 outline-none focus:border-sqr-orange">
            </div>

            <!-- PETA PICKER INTERAKTIF -->
            <div class="space-y-2">
                <div class="flex items-center justify-between">
                    <label class="block text-xs font-bold text-gray-700">📍 Klik/Geser Pin di Peta untuk Setel Koordinat:</label>
                    <button type="button" onclick="fillModalGpsLocation()" class="text-[10px] text-sqr-orange font-bold hover:underline flex items-center gap-1">
                        <i class="fa-solid fa-crosshairs"></i> Gunakan GPS Saya
                    </button>
                </div>
                <div id="modalPickerMapCanvas"></div>
            </div>

            <div class="grid grid-cols-3 gap-3">
                <div>
                    <label class="block text-[10px] font-bold text-gray-500 mb-0.5">Latitude *</label>
                    <input type="text" name="latitude" id="modalLat" onchange="updatePickerMapFromInputs()" required placeholder="-6.397637"
                           class="w-full bg-gray-50 border border-gray-200 rounded-xl p-2.5 text-xs font-bold outline-none focus:border-sqr-orange">
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-gray-500 mb-0.5">Longitude *</label>
                    <input type="text" name="longitude" id="modalLng" onchange="updatePickerMapFromInputs()" required placeholder="106.877478"
                           class="w-full bg-gray-50 border border-gray-200 rounded-xl p-2.5 text-xs font-bold outline-none focus:border-sqr-orange">
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-gray-500 mb-0.5">Radius (Meter) *</label>
                    <input type="number" name="radius_meters" id="modalRadius" onchange="updatePickerMapCircle()" required value="50"
                           class="w-full bg-gray-50 border border-gray-200 rounded-xl p-2.5 text-xs font-bold outline-none focus:border-sqr-orange">
                </div>
            </div>

            <div id="statusField" class="hidden">
                <label class="block text-xs font-bold text-gray-700 mb-1">Status Lokasi</label>
                <select name="is_active" id="modalIsActive" class="w-full bg-gray-50 border border-gray-200 rounded-xl p-2.5 text-xs font-bold">
                    <option value="1">Aktif</option>
                    <option value="0">Non-Aktif</option>
                </select>
            </div>

            <div class="pt-2 flex gap-3">
                <button type="button" onclick="closeLocationModal()" class="w-1/2 bg-gray-100 hover:bg-gray-200 text-gray-600 font-bold text-xs py-3 rounded-xl transition">
                    Batal
                </button>
                <button type="submit" class="w-1/2 bg-sqr-green hover:bg-sqr-dark text-white font-bold text-xs py-3 rounded-xl transition shadow-md">
                    Simpan Lokasi Cabang
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    var modalPickerMap = null;
    var pickerMarker = null;
    var pickerCircle = null;

    function initModalPickerMap(lat, lng, radius) {
        if (!document.getElementById('modalPickerMapCanvas')) return;

        if (!modalPickerMap) {
            modalPickerMap = L.map('modalPickerMapCanvas').setView([lat, lng], 17);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '© OpenStreetMap'
            }).addTo(modalPickerMap);

            pickerMarker = L.marker([lat, lng], { draggable: true }).addTo(modalPickerMap);
            pickerMarker.on('dragend', function(e) {
                var position = pickerMarker.getLatLng();
                document.getElementById('modalLat').value = position.lat.toFixed(6);
                document.getElementById('modalLng').value = position.lng.toFixed(6);
                updatePickerMapCircle();
            });

            modalPickerMap.on('click', function(e) {
                pickerMarker.setLatLng(e.latlng);
                document.getElementById('modalLat').value = e.latlng.lat.toFixed(6);
                document.getElementById('modalLng').value = e.latlng.lng.toFixed(6);
                updatePickerMapCircle();
            });

            pickerCircle = L.circle([lat, lng], {
                color: '#e67e22',
                fillColor: '#f39c12',
                fillOpacity: 0.2,
                radius: radius
            }).addTo(modalPickerMap);
        } else {
            modalPickerMap.setView([lat, lng], 17);
            pickerMarker.setLatLng([lat, lng]);
            pickerCircle.setLatLng([lat, lng]);
            pickerCircle.setRadius(radius);
        }

        setTimeout(function() {
            if (modalPickerMap) modalPickerMap.invalidateSize();
        }, 300);
    }

    function updatePickerMapFromInputs() {
        var lat = parseFloat(document.getElementById('modalLat').value) || -6.397637;
        var lng = parseFloat(document.getElementById('modalLng').value) || 106.877478;
        var radius = parseInt(document.getElementById('modalRadius').value) || 50;

        if (modalPickerMap && pickerMarker && pickerCircle) {
            modalPickerMap.setView([lat, lng], 17);
            pickerMarker.setLatLng([lat, lng]);
            pickerCircle.setLatLng([lat, lng]);
            pickerCircle.setRadius(radius);
        }
    }

    function updatePickerMapCircle() {
        var radius = parseInt(document.getElementById('modalRadius').value) || 50;
        if (pickerCircle) {
            pickerCircle.setRadius(radius);
        }
    }

    function openAddLocationModal() {
        document.getElementById('modalTitle').innerText = 'Tambah Lokasi Cabang SQR Baru';
        document.getElementById('locationForm').action = '{{ route("admin.locations.store") }}';
        document.getElementById('methodSpoof').innerHTML = '';
        document.getElementById('modalName').value = '';
        document.getElementById('modalCode').value = '';
        document.getElementById('modalAddress').value = '';
        document.getElementById('modalLat').value = '-6.397637';
        document.getElementById('modalLng').value = '106.877478';
        document.getElementById('modalRadius').value = '50';
        document.getElementById('statusField').classList.add('hidden');
        document.getElementById('locationModal').classList.remove('hidden');

        initModalPickerMap(-6.397637, 106.877478, 50);
    }

    function openEditLocationModal(id, name, code, address, lat, lng, radius, isActive) {
        document.getElementById('modalTitle').innerText = 'Edit Lokasi Cabang: ' + name;
        document.getElementById('locationForm').action = '{{ url("admin/lokasi") }}/' + id;
        document.getElementById('methodSpoof').innerHTML = '<input type="hidden" name="_method" value="PUT">';
        document.getElementById('modalName').value = name;
        document.getElementById('modalCode').value = code;
        document.getElementById('modalAddress').value = address;
        document.getElementById('modalLat').value = lat;
        document.getElementById('modalLng').value = lng;
        document.getElementById('modalRadius').value = radius;
        document.getElementById('modalIsActive').value = isActive ? '1' : '0';
        document.getElementById('statusField').classList.remove('hidden');
        document.getElementById('locationModal').classList.remove('hidden');

        initModalPickerMap(lat, lng, radius);
    }

    function closeLocationModal() {
        document.getElementById('locationModal').classList.add('hidden');
    }

    function fillModalGpsLocation() {
        if (!navigator.geolocation) {
            alert('Browser Anda tidak mendukung Geolocation GPS');
            return;
        }
        navigator.geolocation.getCurrentPosition(function(pos) {
            document.getElementById('modalLat').value = pos.coords.latitude.toFixed(6);
            document.getElementById('modalLng').value = pos.coords.longitude.toFixed(6);
            updatePickerMapFromInputs();
            alert('Koordinat GPS berhasil diambil dari browser Anda: ' + pos.coords.latitude + ', ' + pos.coords.longitude);
        }, function(err) {
            alert('Gagal mengambil lokasi GPS dari browser: ' + err.message);
        }, { enableHighAccuracy: true });
    }
</script>
@endpush
@endsection
