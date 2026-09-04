<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Sertifikat Elegant Gold – {{ $santri->full_name }}</title>
<style>
* { margin: 0; padding: 0; box-sizing: border-box; }
body { font-family: 'DejaVu Sans', Arial, sans-serif; background: #0d1b0a; color: #fff; }

.page {
    width: 100%;
    min-height: 550px;
    position: relative;
    background: #0d1b0a;
    overflow: hidden;
}

.gold-border-outer {
    position: absolute;
    top: 6px; left: 6px; right: 6px; bottom: 6px;
    border: 2px solid #c9a227;
    border-radius: 6px;
    z-index: 1;
}
.gold-border-inner {
    position: absolute;
    top: 12px; left: 12px; right: 12px; bottom: 12px;
    border: 1px solid rgba(201,162,39,0.4);
    border-radius: 4px;
    z-index: 1;
}

.content {
    padding: 22px 40px 15px;
    position: relative;
    z-index: 3;
    text-align: center;
}

.top-emblem {
    font-size: 32px;
    margin-bottom: 4px;
    color: #f5d97a;
}

.label-sertifikat {
    font-size: 9px;
    letter-spacing: 6px;
    text-transform: uppercase;
    color: #c9a227;
    margin-bottom: 2px;
}

.title-main {
    font-size: 34px;
    font-weight: 900;
    color: #f5d97a;
    letter-spacing: 2px;
    margin-bottom: 2px;
}
.title-sub {
    font-size: 10px;
    color: rgba(255,255,255,0.6);
    letter-spacing: 3px;
    margin-bottom: 12px;
    font-style: italic;
}

.gold-divider {
    height: 1px;
    background: #c9a227;
    margin: 8px auto;
    width: 75%;
}

.given-to {
    font-size: 9.5px;
    color: rgba(255,255,255,0.5);
    letter-spacing: 3px;
    text-transform: uppercase;
    margin: 10px 0 4px;
}

.recipient-name {
    font-size: 26px;
    font-weight: 900;
    color: #ffffff;
    margin-bottom: 10px;
    letter-spacing: 1px;
}

.body-text {
    font-size: 11px;
    color: rgba(255,255,255,0.7);
    line-height: 1.7;
    margin-bottom: 10px;
}

.achievement-box {
    display: inline-block;
    border: 2px solid #c9a227;
    border-radius: 50px;
    padding: 8px 30px;
    background: rgba(201,162,39,0.15);
    margin: 4px 0 10px;
}
.achievement-box .num {
    font-size: 28px;
    font-weight: 900;
    color: #f5d97a;
}
.achievement-box .unit {
    font-size: 10px;
    color: #c9a227;
    letter-spacing: 2px;
    text-transform: uppercase;
    margin-left: 6px;
}

.meta-text {
    font-size: 9.5px;
    color: rgba(255,255,255,0.5);
    margin-bottom: 10px;
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
.sig-role-label {
    font-size: 9px;
    color: #c9a227;
    letter-spacing: 2px;
    text-transform: uppercase;
    margin-bottom: 2px;
}
.sig-box {
    height: 60px;
    position: relative;
    text-align: center;
}
.sig-box img.sig-img {
    max-height: 52px;
    max-width: 120px;
    vertical-align: bottom;
    filter: invert(1);
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
    border-bottom: 1px solid rgba(201,162,39,0.6);
    width: 70%;
    margin: 2px auto 4px;
}
.sig-name {
    font-size: 10.5px;
    font-weight: bold;
    color: #fff;
}
.sig-title {
    font-size: 8.5px;
    color: rgba(255,255,255,0.4);
    margin-top: 1px;
}

.bottom-strip {
    position: absolute;
    bottom: 0; left: 0; right: 0;
    background: rgba(201,162,39,0.15);
    border-top: 1px solid rgba(201,162,39,0.3);
    padding: 6px 40px;
    text-align: center;
    z-index: 3;
}
.bottom-strip p {
    font-size: 8px;
    color: rgba(201,162,39,0.7);
    letter-spacing: 1px;
}
</style>
</head>
<body>
<div class="page">
    <div class="gold-border-outer"></div>
    <div class="gold-border-inner"></div>

    @php
        $sigImg   = $orgSettings['pimpinan_signature_url_base64'] ?? $orgSettings['pimpinan_signature_url'] ?? null;
        $stampImg = $orgSettings['organization_stamp_url_base64'] ?? $orgSettings['organization_stamp_url'] ?? null;
    @endphp

    <div class="content">
        <div class="top-emblem">☪</div>
        <div class="label-sertifikat">{{ $orgSettings['organization_name'] ?? 'Saung Quran Rabbani' }}</div>
        <div class="title-main">SERTIFIKAT TAHFIZ</div>
        <div class="title-sub">Certificate of Qur'an Memorization Achievement</div>

        <div class="gold-divider"></div>

        <div class="given-to">With great honor, presented to</div>
        <div class="recipient-name">{{ $santri->full_name }}</div>

        <p class="body-text">
            Telah menyelesaikan program hafalan Al-Qur'an Karim dengan dedikasi dan ketekunan luar biasa<br>
            di <strong style="color:#f5d97a;">{{ $orgSettings['organization_name'] ?? 'Saung Quran Rabbani' }}</strong>
        </p>

        <div class="achievement-box">
            <span class="num">{{ $summary['total_juz'] }}</span>
            <span class="unit">Juz Al-Qur'an</span>
        </div>

        <p class="meta-text">
            Kelas: {{ $santri->sqrClass?->name ?? '-' }} &nbsp;·&nbsp;
            {{ $summary['total_sessions'] }} Sesi Belajar &nbsp;·&nbsp;
            {{ ($santri->certificate_issued_at ?? now())->translatedFormat('d F Y') }}
        </p>

        <div class="gold-divider"></div>

        <table class="sig-table">
            <tr>
                <td class="sig-td" style="padding-right: 15px;">
                    <div class="sig-role-label">Pimpinan Lembaga</div>
                    <div class="sig-box">
                        @if(!empty($sigImg))
                        <img src="{{ $sigImg }}" class="sig-img" alt="TTD">
                        @endif
                        @if(!empty($stampImg))
                        <img src="{{ $stampImg }}" class="stamp-img" alt="Cap">
                        @endif
                    </div>
                    <div class="sig-line"></div>
                    <div class="sig-name">{{ $orgSettings['pimpinan_name'] ?? '____________________' }}</div>
                    <div class="sig-title">{{ $orgSettings['pimpinan_title'] ?? 'Pimpinan SQR' }}</div>
                </td>
                <td class="sig-td" style="padding-left: 15px;">
                    <div class="sig-role-label">Ustadz Pengampu</div>
                    <div class="sig-box"></div>
                    <div class="sig-line"></div>
                    <div class="sig-name">{{ $lastUstadz?->formatted_name ?? $lastUstadz?->name ?? '____________________' }}</div>
                    <div class="sig-title">Pengampu {{ $santri->sqrClass?->name ?? 'Kelas SQR' }}</div>
                </td>
            </tr>
        </table>
    </div>

    <div class="bottom-strip">
        <p>{{ $orgSettings['certificate_footer_text'] ?? 'Sertifikat resmi Saung Quran Rabbani' }} &nbsp;·&nbsp; {{ now()->format('Y') }}</p>
    </div>
</div>
</body>
</html>
