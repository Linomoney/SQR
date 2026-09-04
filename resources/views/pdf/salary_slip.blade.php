<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Slip Gaji - {{ $user->name }} - {{ $monthName }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 11px;
            color: #1f2937;
            margin: 0;
            padding: 15px;
        }
        .header {
            border-bottom: 2px solid #1b4332;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }
        .org-title {
            font-size: 14px;
            font-weight: bold;
            color: #1b4332;
            text-transform: uppercase;
        }
        .org-sub {
            font-size: 9px;
            color: #6b7280;
        }
        .slip-title {
            font-size: 16px;
            font-weight: bold;
            color: #e67e22;
            text-align: right;
            text-transform: uppercase;
        }
        .meta-table {
            width: 100%;
            margin-bottom: 15px;
        }
        .meta-table td {
            padding: 3px 0;
            font-size: 10px;
        }
        .table-data {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        .table-data th {
            background-color: #1b4332;
            color: #ffffff;
            font-size: 9px;
            text-transform: uppercase;
            padding: 6px;
            text-align: left;
        }
        .table-data td {
            padding: 6px;
            border-bottom: 1px solid #e5e7eb;
            font-size: 10px;
        }
        .total-row td {
            background-color: #f0f8d3;
            font-weight: bold;
            font-size: 12px;
            color: #1b4332;
            border-top: 2px solid #1b4332;
        }
        .footer-sig {
            width: 100%;
            margin-top: 20px;
        }
        .footer-sig td {
            text-align: center;
            vertical-align: top;
            font-size: 10px;
        }
        .sig-box {
            height: 45px;
        }
        .sig-box img {
            max-height: 40px;
        }
    </style>
</head>
<body>

    <!-- KOP HEADER SLIP GAJI -->
    <table class="header" width="100%">
        <tr>
            <td width="60%">
                <div class="org-title">{{ $orgSettings['organization_name'] ?? 'SAUNG QURAN RABBANI' }}</div>
                <div class="org-sub">YAYASAN BINA CAHAYA ILMU RABBANI · SUKATANI, TAPOS DEPOK</div>
                <div class="org-sub">Jl. Puri Kemang Permai No.85, RT.002/008, Sukatani, Tapos Depok 16461</div>
            </td>
            <td width="40%" style="text-align: right;">
                <div class="slip-title">SLIP GAJI RESMI</div>
                <div style="font-size: 10px; font-weight: bold; color: #374151;">PERIODE: {{ strtoupper($monthName) }}</div>
            </td>
        </tr>
    </table>

    <!-- METADATA USTADZ -->
    <table class="meta-table">
        <tr>
            <td width="15%"><strong>Nama Ustadz</strong></td>
            <td width="35%">: {{ $user->formatted_name }}</td>
            <td width="15%"><strong>Tgl Cetak</strong></td>
            <td width="35%">: {{ date('d F Y') }}</td>
        </tr>
        <tr>
            <td><strong>Email</strong></td>
            <td>: {{ $user->email }}</td>
            <td><strong>Status Honor</strong></td>
            <td>: <strong style="color: #059669;">LUNAS / DITRANSFER</strong></td>
        </tr>
    </table>

    <!-- RINCIAN KOMPONEN GAJI -->
    <table class="table-data">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="45%">Komponen Honorarium / Pendapatan</th>
                <th width="15%" style="text-align: center;">Frekuensi</th>
                <th width="15%" style="text-align: right;">Tarif Satuan</th>
                <th width="20%" style="text-align: right;">Sub-Jumlah (Rp)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>Honorarium Hadir Fisik (Tatap Muka)</td>
                <td style="text-align: center;">{{ $hadirFisikCount }} Hari</td>
                <td style="text-align: right;">Rp {{ number_format($rateFisik, 0, ',', '.') }}</td>
                <td style="text-align: right; font-weight: bold;">Rp {{ number_format($totalFisikPay, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>2</td>
                <td>Honorarium Hadir Daring (Online Zoom/Meet)</td>
                <td style="text-align: center;">{{ $hadirOnlineCount }} Hari</td>
                <td style="text-align: right;">Rp {{ number_format($rateOnline, 0, ',', '.') }}</td>
                <td style="text-align: right; font-weight: bold;">Rp {{ number_format($totalOnlinePay, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>3</td>
                <td>Insentif Tugas Ustadz Pengganti</td>
                <td style="text-align: center;">{{ $substituteCount }} Sesi</td>
                <td style="text-align: right;">Rp {{ number_format($rateSubstitute, 0, ',', '.') }}</td>
                <td style="text-align: right; font-weight: bold;">Rp {{ number_format($totalSubPay, 0, ',', '.') }}</td>
            </tr>
            @if($bonusAmount > 0)
            <tr>
                <td>4</td>
                <td>Bonus / Tunjangan Admin {{ $bonusNote ? "({$bonusNote})" : '' }}</td>
                <td style="text-align: center;">1 Paket</td>
                <td style="text-align: right;">Rp {{ number_format($bonusAmount, 0, ',', '.') }}</td>
                <td style="text-align: right; font-weight: bold;">Rp {{ number_format($bonusAmount, 0, ',', '.') }}</td>
            </tr>
            @endif
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="4" style="text-align: right; padding: 8px;">TOTAL PENERIMAAN GAJI BERSIH:</td>
                <td style="text-align: right; padding: 8px; font-size: 13px;">Rp {{ number_format($grandTotal, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

    <!-- TANDA TANGAN -->
    <table class="footer-sig">
        <tr>
            <td width="50%">
                Penerima,<br><br>
                <div class="sig-box"></div>
                <strong>{{ $user->formatted_name }}</strong><br>
                <span>Ustadz Pengampu TPQ SQR</span>
            </td>
            <td width="50%">
                Mengetahui,<br><br>
                <div class="sig-box">
                    @if(!empty($pimpinanSigBase))
                    <img src="{{ $pimpinanSigBase }}" alt="TTD">
                    @endif
                </div>
                <strong>{{ $orgSettings['pimpinan_name'] ?? 'Ust. Hendri' }}</strong><br>
                <span>Pimpinan / Pembina SQR</span>
            </td>
        </tr>
    </table>

</body>
</html>
