<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            color: #1F2937;
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }
        .header-title {
            background-color: #1E4D2B;
            color: #FFFFFF;
            font-size: 16pt;
            font-weight: bold;
            text-align: center;
            padding: 14px;
        }
        .header-subtitle {
            background-color: #2D4A22;
            color: #E5E7EB;
            font-size: 10pt;
            text-align: center;
            padding: 6px;
        }
        .meta-label {
            font-weight: bold;
            color: #1E4D2B;
            background-color: #F0FDF4;
            padding: 8px 12px;
            font-size: 9.5pt;
            border: 1px solid #DCFCE7;
        }
        .meta-val {
            background-color: #FFFFFF;
            padding: 8px 12px;
            font-size: 9.5pt;
            border: 1px solid #E5E7EB;
        }
        th {
            background-color: #1E4D2B;
            color: #FFFFFF;
            font-weight: bold;
            font-size: 10pt;
            padding: 12px 14px;
            border: 1px solid #14361E;
            text-align: center;
            vertical-align: middle;
            white-space: nowrap;
        }
        td {
            padding: 10px 14px;
            border: 1px solid #E5E7EB;
            font-size: 9.5pt;
            vertical-align: middle;
            white-space: nowrap;
        }
        .row-even {
            background-color: #F9FAFB;
        }
        .row-odd {
            background-color: #FFFFFF;
        }
        .text-center { text-align: center; }
        .text-left { text-align: left; }
        
        /* Status Badges */
        .status-hadir {
            background-color: #DEF7EC;
            color: #03543F;
            font-weight: bold;
            text-align: center;
        }
        .status-hadir-online {
            background-color: #F3E8FF;
            color: #6B21A8;
            font-weight: bold;
            text-align: center;
        }
        .status-izin {
            background-color: #E1EFFE;
            color: #1E429F;
            font-weight: bold;
            text-align: center;
        }
        .status-sakit {
            background-color: #FEF08A;
            color: #713F12;
            font-weight: bold;
            text-align: center;
        }
        .status-alpa {
            background-color: #FDE8E8;
            color: #9B1C1C;
            font-weight: bold;
            text-align: center;
        }
        
        .footer-summary {
            background-color: #F0FDF4;
            font-weight: bold;
            color: #1E4D2B;
            padding: 12px;
            border: 1px solid #DCFCE7;
            font-size: 10pt;
        }
    </style>
</head>
<body>

<table>
    <!-- TITLE HEADER -->
    <tr>
        <td colspan="9" class="header-title">SAUNG QURAN RABBANI (SQR)</td>
    </tr>
    <tr>
        <td colspan="9" class="header-subtitle">LAPORAN REKAPITULASI PRESENSI & KEHADIRAN SANTRI</td>
    </tr>
    <tr><td colspan="9" style="height: 10px;"></td></tr>

    <!-- METADATA BLOCK -->
    <tr>
        <td class="meta-label">Kelas SQR:</td>
        <td class="meta-val" colspan="3"><strong>{{ $sqrClass ? $sqrClass->name : 'Semua Kelas SQR' }}</strong></td>
        <td class="meta-label">Tanggal Cetak:</td>
        <td class="meta-val" colspan="4">{{ $printedAt }} WIB</td>
    </tr>
    <tr>
        <td class="meta-label">Periode Rekap:</td>
        <td class="meta-val" colspan="3"><strong>{{ $periodText }}</strong></td>
        <td class="meta-label">Total Record:</td>
        <td class="meta-val" colspan="4"><strong>{{ $records->count() }} Data Presensi Santri</strong></td>
    </tr>
    <tr><td colspan="9" style="height: 15px;"></td></tr>

    <!-- MAIN TABLE HEADERS -->
    <thead>
        <tr>
            <th style="width: 50px;">NO</th>
            <th style="width: 120px;">TANGGAL</th>
            <th style="width: 110px;">NIS SANTRI</th>
            <th style="width: 240px;">NAMA LENGKAP SANTRI</th>
            <th style="width: 200px;">KELAS SQR</th>
            <th style="width: 140px;">STATUS KEHADIRAN</th>
            <th style="width: 280px;">CATATAN KETERANGAN</th>
            <th style="width: 200px;">USTADZ PENGABSEN</th>
            <th style="width: 200px;">USTADZ PENGGANTI</th>
        </tr>
    </thead>
    <tbody>
        @forelse($records as $index => $row)
        @php
            $rowClass = ($index % 2 === 0) ? 'row-even' : 'row-odd';
            $statusClass = match($row->status) {
                'Hadir'        => 'status-hadir',
                'Hadir Online' => 'status-hadir-online',
                'Izin'         => 'status-izin',
                'Sakit'        => 'status-sakit',
                default        => 'status-alpa',
            };
        @endphp
        <tr class="{{ $rowClass }}">
            <td class="text-center">{{ $index + 1 }}</td>
            <td class="text-center">{{ $row->date?->format('d/m/Y') }}</td>
            <td class="text-center font-mono">SQR-{{ sprintf('%04d', $row->santri_id) }}</td>
            <td class="text-left font-bold">{{ $row->santri?->full_name ?? '-' }}</td>
            <td class="text-left">{{ $row->sqrClass?->name ?? '-' }}</td>
            <td class="{{ $statusClass }}">{{ $row->status }}</td>
            <td class="text-left">{{ $row->notes ?? '-' }}</td>
            <td class="text-left">{{ $row->recordedBy?->formatted_name ?? $row->recordedBy?->name ?? 'Admin' }}</td>
            <td class="text-left">{{ $row->substituteUstadz?->formatted_name ?? $row->substituteUstadz?->name ?? '-' }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="9" class="text-center" style="padding: 20px; color: #9CA3AF;">
                Tidak ada record data presensi ditemukan untuk kriteria filter ini.
            </td>
        </tr>
        @endforelse
    </tbody>

    <!-- REKAP SUMMARY FOOTER -->
    @if($records->isNotEmpty())
    <tr><td colspan="9" style="height: 15px;"></td></tr>
    <tr>
        <td colspan="9" class="footer-summary">
            REKAPITULASI TOTAL: 
            🟢 Hadir: {{ $records->where('status', 'Hadir')->count() }} · 
            💻 Hadir Online: {{ $records->where('status', 'Hadir Online')->count() }} · 
            🔵 Izin: {{ $records->where('status', 'Izin')->count() }} · 
            🟡 Sakit: {{ $records->where('status', 'Sakit')->count() }} · 
            🔴 Alpa: {{ $records->where('status', 'Alpa')->count() }}
        </td>
    </tr>
    @endif
</table>

</body>
</html>
