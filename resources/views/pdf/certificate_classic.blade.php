<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Sertifikat Tahfiz – {{ $santri->full_name }}</title>
<style>
* { margin: 0; padding: 0; box-sizing: border-box; }
body { font-family: 'DejaVu Sans', Arial, sans-serif; background: #fff; color: #1a3a0f; width: 100%; }

.page {
    width: 100%;
    min-height: 550px;
    padding: 0;
    position: relative;
    background: #fff;
    overflow: hidden;
}

/* ── Decorative borders ── */
.outer-border {
    position: absolute;
    top: 8px; left: 8px; right: 8px; bottom: 8px;
    border: 3px double #2d4a22;
    border-radius: 6px;
    z-index: 1;
}
.inner-border {
    position: absolute;
    top: 14px; left: 14px; right: 14px; bottom: 14px;
    border: 1px solid #e67e22;
    border-radius: 4px;
    z-index: 1;
}

/* ── Green header band ── */
.header-band {
    background: #1a3a0f;
    padding: 18px 40px 14px;
    text-align: center;
    position: relative;
    z-index: 2;
}
.header-band .org-name {
    font-size: 11px;
    letter-spacing: 5px;
    text-transform: uppercase;
    color: #a8d5a2;
    font-weight: bold;
    margin-bottom: 4px;
}
.header-band .cert-title {
    font-size: 32px;
    font-weight: 900;
    color: #ffffff;
    letter-spacing: 2px;
    text-transform: uppercase;
}
.header-band .cert-subtitle {
    font-size: 11px;
    color: #c8e6c9;
    letter-spacing: 2px;
    margin-top: 3px;
    font-style: italic;
}

/* ── Arabic calligraphy ── */
.arabic-deco {
    text-align: center;
    font-size: 20px;
    color: #e67e22;
    margin: 10px 0 4px;
    letter-spacing: 4px;
}

/* ── Content area ── */
.content {
    padding: 6px 60px 15px;
    text-align: center;
    position: relative;
    z-index: 2;
}

.given-to-label {
    font-size: 10px;
    color: #888;
    letter-spacing: 3px;
    text-transform: uppercase;
    margin-bottom: 4px;
}

.recipient-name {
    font-size: 28px;
    font-weight: 900;
    color: #2d4a22;
    letter-spacing: 1px;
    border-bottom: 2px solid #e67e22;
    display: inline-block;
    padding: 0 25px 6px;
    margin-bottom: 10px;
}

.body-paragraph {
    font-size: 11.5px;
    color: #555;
    line-height: 1.8;
    margin: 0 auto 10px;
    max-width: 580px;
}

/* ── Achievement box ── */
.achievement-box {
    background: #2d4a22;
    border: 2px solid #e67e22;
    border-radius: 8px;
    padding: 10px 45px;
    display: inline-block;
    margin: 6px 0 12px;
}
.achievement-box .ach-num {
    font-size: 38px;
    font-weight: 900;
    color: #f0a500;
    line-height: 1;
}
.achievement-box .ach-label {
    font-size: 11px;
    color: #c8e6c9;
    letter-spacing: 2px;
    text-transform: uppercase;
    margin-top: 2px;
}

.meta-line {
    font-size: 10.5px;
    color: #666;
    margin-bottom: 10px;
}

/* ── Signatures Table ── */
.sig-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 15px;
}
.sig-td {
    width: 50%;
    vertical-align: top;
    text-align: center;
}
.sig-city { font-size: 10px; color: #666; margin-bottom: 2px; }
.sig-role { font-size: 10px; color: #2d4a22; font-weight: bold; margin-bottom: 2px; }
.sig-box {
    height: 65px;
    position: relative;
    text-align: center;
}
.sig-box img.sig-img {
    max-height: 55px;
    max-width: 130px;
    vertical-align: bottom;
}
.sig-box img.stamp-img {
    position: absolute;
    top: -10px;
    left: 50%;
    margin-left: -38px;
    width: 75px;
    height: 75px;
    opacity: 0.65;
    z-index: 10;
}
.sig-line {
    border-bottom: 1.5px solid #2d4a22;
    width: 70%;
    margin: 2px auto 4px;
}
.sig-name { font-size: 11px; font-weight: bold; color: #2d4a22; }
.sig-title { font-size: 9px; color: #777; margin-top: 1px; }

/* ── Footer band ── */
.footer-band {
    background: #1a3a0f;
    padding: 6px 40px;
    text-align: center;
    position: absolute;
    bottom: 0; left: 0; right: 0;
    z-index: 2;
}
.footer-band p {
    font-size: 8.5px;
    color: #a8d5a2;
    letter-spacing: 1px;
}
</style>
</head>
<body>
<div class="page">
    <div class="outer-border"></div>
    <div class="inner-border"></div>

    @php
        $logoImg  = $orgSettings['organization_logo_url_base64'] ?? $orgSettings['organization_logo_url'] ?? null;
        $sigImg   = $orgSettings['pimpinan_signature_url_base64'] ?? $orgSettings['pimpinan_signature_url'] ?? null;
        $stampImg = $orgSettings['organization_stamp_url_base64'] ?? $orgSettings['organization_stamp_url'] ?? null;
    @endphp

    <!-- Header Band -->
    <div class="header-band">
        @if(!empty($logoImg))
        <img src="{{ $logoImg }}" style="max-height:35px;margin-bottom:4px;" alt="Logo">
        <br>
        @endif
        <div class="org-name">{{ $orgSettings['organization_name'] ?? 'Saung Quran Rabbani' }}</div>
        <div class="cert-title">Sertifikat Tahfiz</div>
        <div class="cert-subtitle">Penghargaan Pencapaian Hafalan Al-Qur'an Al-Karim</div>
    </div>

    <div class="arabic-deco">﷽ &nbsp; ✦ &nbsp; ﷽</div>

    <!-- Main Content -->
    <div class="content">
        <p class="given-to-label">Diberikan dengan penuh kebanggaan kepada</p>
        <div class="recipient-name">{{ $santri->full_name }}</div>

        <p class="body-paragraph">
            Telah berhasil menyelesaikan Program Tahfiz Al-Qur'an Karim<br>
            di <strong>{{ $orgSettings['organization_name'] ?? 'Saung Quran Rabbani' }}</strong>
            dengan capaian hafalan:
        </p>

        <div class="achievement-box">
            <div class="ach-num">{{ $summary['total_juz'] }} JUZ</div>
            <div class="ach-label">Al-Qur'an Al-Karim</div>
        </div>

        <p class="meta-line">
            Kelas: <strong>{{ $santri->sqrClass?->name ?? '-' }}</strong> &nbsp;|&nbsp;
            Total Sesi Belajar: <strong>{{ $summary['total_sessions'] }} sesi</strong> &nbsp;|&nbsp;
            Dikeluarkan: <strong>{{ ($santri->certificate_issued_at ?? now())->translatedFormat('d F Y') }}</strong>
        </p>

        <!-- Signatures Table -->
        <table class="sig-table">
            <tr>
                <td class="sig-td" style="padding-right: 15px;">
                    <p class="sig-city">{{ $orgSettings['organization_city'] ?? 'Bogor' }}, {{ now()->translatedFormat('d F Y') }}</p>
                    <p class="sig-role">{{ $orgSettings['pimpinan_title'] ?? 'Pimpinan Saung Quran Rabbani' }}</p>
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
                    <p class="sig-title">Pimpinan Lembaga</p>
                </td>

                <td class="sig-td" style="padding-left: 15px;">
                    <p class="sig-city">{{ $orgSettings['organization_city'] ?? 'Bogor' }}, {{ now()->translatedFormat('d F Y') }}</p>
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
        <p>{{ $orgSettings['certificate_footer_text'] ?? 'Sertifikat ini dikeluarkan secara resmi oleh Saung Quran Rabbani' }} · {{ now()->format('Y') }}</p>
    </div>
</div>
</body>
</html>
