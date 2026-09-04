<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Sertifikat Premium Royal – {{ $santri->full_name }}</title>
<style>
* { margin: 0; padding: 0; box-sizing: border-box; }
body { font-family: 'DejaVu Sans', Arial, sans-serif; background: #fff; }

.page {
    width: 100%;
    min-height: 550px;
    position: relative;
    background: #fff;
    overflow: hidden;
}

.royal-header {
    background: #1a0050;
    padding: 16px 40px 12px;
    text-align: center;
}
.royal-header .rh-label {
    font-size: 8.5px;
    letter-spacing: 6px;
    color: rgba(255,255,255,0.6);
    text-transform: uppercase;
    margin-bottom: 3px;
}
.royal-header .rh-title {
    font-size: 28px;
    font-weight: 900;
    color: #ffffff;
    letter-spacing: 3px;
    text-transform: uppercase;
}
.royal-header .rh-sub {
    font-size: 10px;
    color: rgba(255,255,255,0.55);
    letter-spacing: 2px;
    margin-top: 3px;
    font-style: italic;
}

.content {
    padding: 10px 50px 15px;
    text-align: center;
}

.given-to {
    font-size: 9.5px;
    color: #888;
    letter-spacing: 3px;
    text-transform: uppercase;
    margin: 8px 0 6px;
}

.recipient-name {
    font-size: 26px;
    font-weight: 900;
    color: #2d1b7e;
    letter-spacing: 1px;
    margin-bottom: 8px;
    display: inline-block;
    border-bottom: 2px solid #c9a227;
    padding-bottom: 4px;
}

.body-text {
    font-size: 11px;
    color: #555;
    line-height: 1.7;
    margin-bottom: 10px;
    max-width: 550px;
    margin-left: auto;
    margin-right: auto;
}

/* ── Achievement Table ── */
.ach-table {
    width: 60%;
    margin: 8px auto 12px;
    border-collapse: collapse;
}
.ach-td-dark {
    background: #1e4d2b;
    border: 2px solid #c9a227;
    border-radius: 8px;
    padding: 8px 20px;
    text-align: center;
    color: #fff;
}
.ach-td-dark .num {
    font-size: 30px;
    font-weight: 900;
    color: #f5d97a;
    line-height: 1;
}
.ach-td-dark .lbl {
    font-size: 9px;
    color: #a8d5a2;
    letter-spacing: 2px;
    text-transform: uppercase;
    margin-top: 2px;
}
.ach-td-light {
    background: #f0f7ff;
    border: 1px solid rgba(45,27,126,0.2);
    border-radius: 8px;
    padding: 8px 16px;
    text-align: center;
}
.ach-td-light .num {
    font-size: 24px;
    font-weight: 900;
    color: #2d1b7e;
    line-height: 1;
}
.ach-td-light .lbl {
    font-size: 8.5px;
    color: #777;
    letter-spacing: 1px;
    text-transform: uppercase;
    margin-top: 2px;
}

.meta-text {
    font-size: 9.5px;
    color: #777;
    margin-bottom: 8px;
}

/* ── Signatures Table ── */
.sig-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 10px;
}
.sig-td {
    width: 50%;
    vertical-align: top;
    text-align: center;
}
.sig-city { font-size: 9.5px; color: #777; margin-bottom: 1px; }
.sig-role { font-size: 9.5px; color: #2d1b7e; font-weight: bold; margin-bottom: 2px; }
.sig-box {
    height: 60px;
    position: relative;
    text-align: center;
}
.sig-box img.sig-img {
    max-height: 52px;
    max-width: 120px;
    vertical-align: bottom;
}
.sig-box img.stamp-img {
    position: absolute;
    top: -10px;
    left: 50%;
    margin-left: -35px;
    width: 70px;
    height: 70px;
    opacity: 0.65;
    z-index: 10;
}
.sig-line {
    border-bottom: 1.5px solid #2d1b7e;
    width: 70%;
    margin: 2px auto 4px;
}
.sig-name { font-size: 11px; font-weight: bold; color: #1a1a1a; }
.sig-title { font-size: 9px; color: #888; margin-top: 1px; }

.footer-band {
    position: absolute;
    bottom: 0; left: 0; right: 0;
    height: 30px;
    background: #1a0050;
    text-align: center;
    line-height: 30px;
    z-index: 2;
}
.footer-band p {
    font-size: 8px;
    color: rgba(255,255,255,0.65);
    letter-spacing: 1px;
}
</style>
</head>
<body>
<div class="page">
    @php
        $sigImg   = $orgSettings['pimpinan_signature_url_base64'] ?? $orgSettings['pimpinan_signature_url'] ?? null;
        $stampImg = $orgSettings['organization_stamp_url_base64'] ?? $orgSettings['organization_stamp_url'] ?? null;
    @endphp

    <!-- Royal Header -->
    <div class="royal-header">
        <div class="rh-label">{{ $orgSettings['organization_name'] ?? 'Saung Quran Rabbani' }}</div>
        <div class="rh-title">SERTIFIKAT TAHFIZ</div>
        <div class="rh-sub">Certificate of Excellence in Qur'an Memorization</div>
    </div>

    <!-- Content -->
    <div class="content">
        <div class="given-to">Dengan penuh kebanggaan, diberikan kepada</div>
        <div class="recipient-name">{{ $santri->full_name }}</div>

        <p class="body-text">
            Telah menyelesaikan Program Tahfiz Al-Qur'an Karim dengan dedikasi dan ketekunan luar biasa<br>
            di <strong>{{ $orgSettings['organization_name'] ?? 'Saung Quran Rabbani' }}</strong>
        </p>

        <!-- Achievement Table -->
        <table class="ach-table">
            <tr>
                <td class="ach-td-dark">
                    <div class="num">{{ $summary['total_juz'] }}</div>
                    <div class="lbl">Juz Al-Qur'an</div>
                </td>
                <td style="width:10px;"></td>
                <td class="ach-td-light">
                    <div class="num">{{ $summary['total_sessions'] }}</div>
                    <div class="lbl">Sesi Belajar</div>
                </td>
                <td style="width:10px;"></td>
                <td class="ach-td-light">
                    <div class="num">{{ round($summary['percentage']) }}%</div>
                    <div class="lbl">Pencapaian</div>
                </td>
            </tr>
        </table>

        <p class="meta-text">
            Kelas: <strong>{{ $santri->sqrClass?->name ?? '-' }}</strong> &nbsp;·&nbsp;
            Dikeluarkan: <strong>{{ ($santri->certificate_issued_at ?? now())->translatedFormat('d F Y') }}</strong>
        </p>

        <!-- Signatures Table -->
        <table class="sig-table">
            <tr>
                <td class="sig-td" style="padding-right: 15px;">
                    <p class="sig-city">{{ $orgSettings['organization_city'] ?? 'Depok' }}, {{ now()->translatedFormat('d F Y') }}</p>
                    <p class="sig-role">Pimpinan Lembaga</p>
                    <div class="sig-box">
                        @if(!empty($sigImg))
                        <img src="{{ $sigImg }}" class="sig-img" alt="TTD">
                        @endif
                        @if(!empty($stampImg))
                        <img src="{{ $stampImg }}" class="stamp-img" alt="Cap">
                        @endif
                    </div>
                    <div class="sig-line"></div>
                    <p class="sig-name">{{ $orgSettings['pimpinan_name'] ?? '____________________' }}</p>
                    <p class="sig-title">{{ $orgSettings['pimpinan_title'] ?? 'Pimpinan SQR' }}</p>
                </td>

                <td class="sig-td" style="padding-left: 15px;">
                    <p class="sig-city">{{ $orgSettings['organization_city'] ?? 'Depok' }}, {{ now()->translatedFormat('d F Y') }}</p>
                    <p class="sig-role">Ustadz/Ustadzah Pengampu</p>
                    <div class="sig-box"></div>
                    <div class="sig-line"></div>
                    <p class="sig-name">{{ $lastUstadz?->formatted_name ?? $lastUstadz?->name ?? '____________________' }}</p>
                    <p class="sig-title">Pengampu Kelas {{ $santri->sqrClass?->name ?? 'SQR' }}</p>
                </td>
            </tr>
        </table>
    </div>

    <div class="footer-band">
        <p>{{ $orgSettings['certificate_footer_text'] ?? 'Dokumen resmi Saung Quran Rabbani' }} &nbsp;·&nbsp; {{ now()->format('Y') }}</p>
    </div>
</div>
</body>
</html>
