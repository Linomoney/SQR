<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Surat Rekomendasi – {{ $santri->full_name }}</title>
<style>
* { margin: 0; padding: 0; box-sizing: border-box; }
body {
    font-family: 'DejaVu Sans', Arial, sans-serif;
    font-size: 10.5pt;
    line-height: 1.4;
    color: #000;
    background: #fff;
    padding: 15px 35px;
}

/* ── KOP SURAT ── */
.kop-table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 2px;
}
.kop-left {
    width: 18%;
    vertical-align: middle;
    text-align: left;
}
.kop-center {
    width: 64%;
    vertical-align: middle;
    text-align: center;
}
.kop-right {
    width: 18%;
    vertical-align: middle;
    text-align: right;
}
.kop-left img {
    max-width: 90px;
    max-height: 75px;
}
.kop-right img {
    max-width: 85px;
    max-height: 75px;
}

.kop-center .yayasan-title {
    font-size: 13.5pt;
    font-weight: 900;
    color: #000;
    letter-spacing: 0.5px;
    margin-bottom: 1px;
}
.kop-center .sqr-title {
    font-size: 12.5pt;
    font-weight: 900;
    color: #000;
    letter-spacing: 0.5px;
    margin-bottom: 2px;
}
.kop-center .address {
    font-size: 8.5pt;
    color: #000;
    line-height: 1.25;
}

.kop-line {
    border-top: 4px solid #000;
    margin-bottom: 18px;
}

/* ── JUDUL SURAT ── */
.title-area {
    text-align: center;
    margin-bottom: 18px;
}
.title-area h1 {
    font-size: 15pt;
    font-weight: 900;
    text-decoration: underline;
    color: #000;
    margin-bottom: 3px;
    letter-spacing: 0.5px;
}
.title-area .no-surat {
    font-size: 11pt;
    font-weight: 900;
    color: #000;
}

/* ── META TABLE (Lampiran & Hal) ── */
.meta-table {
    margin-bottom: 14px;
    font-size: 10.5pt;
}
.meta-table td {
    padding: 1px 0;
}

/* ── SALAM & PEMBUKA ── */
.salutation {
    margin-bottom: 12px;
    font-style: italic;
}
.salutation p {
    margin-bottom: 1px;
}

/* ── DATA TABLES ── */
.data-intro {
    margin-bottom: 2px;
}
.data-table {
    margin-left: 20px;
    margin-top: 2px;
    margin-bottom: 10px;
    border-collapse: collapse;
}
.data-table td {
    padding: 2px 0;
    vertical-align: top;
    font-size: 10.5pt;
}
.data-table td.label-col {
    width: 150px;
}
.data-table td.colon-col {
    width: 15px;
    text-align: center;
}
.data-table td.val-col {
    font-weight: bold;
}

/* ── NARASI ── */
.narrative {
    margin-bottom: 12px;
    text-align: justify;
    line-height: 1.45;
    font-size: 10.5pt;
}
.narrative p {
    margin-bottom: 10px;
}

/* ── PENANDATANGAN ── */
.sig-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 25px;
    page-break-inside: avoid;
}
.sig-td {
    width: 50%;
    vertical-align: top;
    text-align: center;
}
.sig-header {
    font-size: 10.5pt;
    color: #000;
    margin-bottom: 2px;
}
.sig-box {
    height: 70px;
    position: relative;
    text-align: center;
}
.sig-box img.sig-img {
    max-height: 60px;
    max-width: 130px;
    vertical-align: bottom;
}
.sig-box img.stamp-img {
    position: absolute;
    top: -10px;
    left: 50%;
    margin-left: -35px;
    width: 80px;
    height: 80px;
    opacity: 0.7;
    z-index: 10;
}
.sig-name {
    font-size: 11pt;
    font-weight: bold;
    color: #000;
    margin-top: 2px;
}
.sig-role {
    font-size: 10pt;
    color: #000;
}
</style>
</head>
<body>

    @php
        $romanMonths = [1=>'I', 2=>'II', 3=>'III', 4=>'IV', 5=>'V', 6=>'VI', 7=>'VII', 8=>'VIII', 9=>'IX', 10=>'X', 11=>'XI', 12=>'XII'];
        $romanMonth = $romanMonths[(int)now()->format('m')] ?? 'VIII';
        $year = now()->format('Y');

        $logoImg  = $orgSettings['organization_logo_url_base64'] ?? $orgSettings['organization_logo_url'] ?? null;
        $stampImg = $orgSettings['organization_stamp_url_base64'] ?? $orgSettings['organization_stamp_url'] ?? null;
        $sigImg   = $orgSettings['pimpinan_signature_url_base64'] ?? $orgSettings['pimpinan_signature_url'] ?? null;
    @endphp

    <!-- KOP SURAT -->
    <table class="kop-table">
        <tr>
            <td class="kop-left">
                @if(!empty($logoImg))
                <img src="{{ $logoImg }}" alt="Logo SQR">
                @else
                <div style="font-size:30px;">📖</div>
                @endif
            </td>
            <td class="kop-center">
                <div class="yayasan-title">YAYASAN BINA CAHAYA ILMU RABBANI</div>
                <div class="sqr-title">SAUNG QURAN RABBANI</div>
                <div class="address">
                    Jl. Puri Kemang Permai No.85, RT.002/RW.008, Sukatani,<br>
                    Tapos, Kota Depok, Jawa Barat 16461
                </div>
            </td>
            <td class="kop-right">
                @php
                    $yayasanLogoImg = $orgSettings['yayasan_logo_url_base64'] ?? $orgSettings['yayasan_logo_url'] ?? 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787212253/WhatsApp_Image_2024-03-05_at_16.45.18__1_-removebg-preview_1_n7ggrp.png';
                @endphp
                @if(!empty($yayasanLogoImg))
                <img src="{{ $yayasanLogoImg }}" alt="Logo Yayasan">
                @endif
            </td>
        </tr>
    </table>
    <div class="kop-line"></div>

    <!-- JUDUL SURAT -->
    <div class="title-area">
        <h1>SURAT REKOMENDASI</h1>
        <div class="no-surat">No: 01/SR/SQR/{{ $romanMonth }}/{{ $year }}</div>
    </div>

    <!-- METADATA -->
    <table class="meta-table">
        <tr>
            <td style="width:70px;">Lampiran</td>
            <td style="width:15px;text-align:center;">:</td>
            <td>-</td>
        </tr>
        <tr>
            <td>Hal</td>
            <td style="text-align:center;">:</td>
            <td><strong>Rekomendasi</strong></td>
        </tr>
    </table>

    <!-- SALAM -->
    <div class="salutation">
        <p>Bismillahirahmanirahim</p>
        <p>Assalamualaikum warahmatullahi wabarakatuh,</p>
        <p style="font-style:normal;color:#333;margin-top:2px;">di tempat</p>
    </div>

    <!-- PIHAK PERTAMA -->
    <p class="data-intro">Yang bertanda tangan di bawah ini:</p>
    <table class="data-table">
        <tr>
            <td class="label-col">Nama</td>
            <td class="colon-col">:</td>
            <td class="val-col">{{ $lastUstadz?->formatted_name ?? $lastUstadz?->name ?? 'Ust. Tengku Akbar Bustamam' }}</td>
        </tr>
        <tr>
            <td class="label-col">Jabatan</td>
            <td class="colon-col">:</td>
            <td>Pengampu Kelas Tahfiz TPQ Saung Quran Rabbani</td>
        </tr>
        <tr>
            <td class="label-col">Alamat Lembaga</td>
            <td class="colon-col">:</td>
            <td>Jl. Puri Kemang Permai No.85, RT.002/008, Sukatani, Tapos, Kota Depok, Jawa Barat 16461</td>
        </tr>
    </table>

    <!-- SANTRI DATA -->
    <p class="data-intro">Dengan ini memberikan rekomendasi kepada santri kami:</p>
    <table class="data-table">
        <tr>
            <td class="label-col">Nama Santri</td>
            <td class="colon-col">:</td>
            <td class="val-col">{{ $santri->full_name }}</td>
        </tr>
        <tr>
            <td class="label-col">Tempat Tanggal Lahir</td>
            <td class="colon-col">:</td>
            <td>
                {{ $santri->wali?->birth_place ?? 'Depok' }}, {{ $santri->date_of_birth?->translatedFormat('d F Y') ?? ($santri->wali?->birth_date?->translatedFormat('d F Y') ?? '27 Januari 2015') }}
            </td>
        </tr>
        <tr>
            <td class="label-col">Alamat Santri</td>
            <td class="colon-col">:</td>
            <td>
                {{ $santri->wali?->address ?? 'komplek Deppen Jln.Anggrek VI blok G no.16, Harjamukti, Kota Depok, Jawa Barat' }}
            </td>
        </tr>
    </table>

    <!-- NARASI -->
    <div class="narrative">
        <p>
            Bahwa yang bersangkutan adalah benar santri aktif di TPQ Saung Quran Rabbani, Sukatani, Depok. Selama menempuh pendidikan di tempat kami yang bersangkutan menunjukkan akhlak yang baik, disiplin, dan kesungguhan dalam menuntut ilmu.
        </p>
        <p>
            Berdasarkan potensi, kesungguhan, dan karakter positif yang dimiliki, kami meyakini dan memberikan <strong>REKOMENDASI</strong> penuh kepada santri tersebut untuk dapat diterima sebagai santri baru di lembaga pendidikan selanjutnya.
        </p>
        <p>
            Demikian surat rekomendasi ini dibuat dengan sebenarnya untuk dapat dipergunakan sebagaimana mestinya. Terima kasih.
        </p>
    </div>

    <!-- PENANDATANGAN (Kiri: Pengampu, Kanan: Pembina Yayasan + Cap) -->
    <table class="sig-table">
        <tr>
            <!-- Kiri: Ustadz Pengampu -->
            <td class="sig-td">
                <div class="sig-header">Mengetahui,</div>
                <div class="sig-box">
                    @if(!empty($ustadzSigBase64))
                    <img src="{{ $ustadzSigBase64 }}" class="sig-img" alt="TTD Ustadz">
                    @endif
                </div>
                <div class="sig-name">{{ $lastUstadz?->formatted_name ?? $lastUstadz?->name ?? 'Ust. Tengku Akbar Bustamam' }}</div>
                <div class="sig-role">Pengampu</div>
            </td>

            <!-- Kanan: Pembina Yayasan + TTD + Cap -->
            <td class="sig-td">
                <div class="sig-header">Mengetahui,</div>
                <div class="sig-box">
                    @if(!empty($sigImg))
                    <img src="{{ $sigImg }}" class="sig-img" alt="TTD">
                    @endif
                    @if(!empty($stampImg))
                    <img src="{{ $stampImg }}" class="stamp-img" alt="Cap">
                    @endif
                </div>
                <div class="sig-name">{{ $orgSettings['pimpinan_name'] ?? 'Ust. Hendri' }}</div>
                <div class="sig-role">Pembina Yayasan Bina Cahaya Rabbani</div>
            </td>
        </tr>
    </table>

</body>
</html>
