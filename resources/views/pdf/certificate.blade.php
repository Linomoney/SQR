<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sertifikat - {{ $santri->full_name }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'DejaVu Sans', sans-serif; background: #fff; color: #333; }

        .page { width: 100%; min-height: 100vh; padding: 30px 40px; position: relative; }

        .border-ornament {
            position: absolute; inset: 15px;
            border: 3px solid #2d4a22;
            border-radius: 12px;
        }
        .border-ornament-inner {
            position: absolute; inset: 20px;
            border: 1px solid #e67e22;
            border-radius: 10px;
        }

        .content { position: relative; z-index: 2; text-align: center; padding: 50px 80px; }

        .label { font-size: 11px; font-weight: bold; color: #a3c585; letter-spacing: 6px; text-transform: uppercase; margin-bottom: 8px; }
        .title { font-size: 36px; font-weight: 900; color: #2d4a22; margin-bottom: 6px; letter-spacing: 1px; }
        .subtitle { font-size: 14px; color: #666; margin-bottom: 30px; }

        .recipient-label { font-size: 12px; color: #999; margin-bottom: 6px; }
        .recipient-name { font-size: 28px; font-weight: 900; color: #2d4a22; border-bottom: 2px solid #e67e22; display: inline-block; padding-bottom: 6px; margin-bottom: 20px; }

        .body-text { font-size: 13px; color: #555; line-height: 1.8; margin-bottom: 20px; }

        .achievement { background: linear-gradient(135deg, #2d4a22, #3d6030); color: white; border-radius: 12px; padding: 15px 40px; display: inline-block; margin-bottom: 30px; }
        .achievement-num { font-size: 40px; font-weight: 900; color: #e67e22; }
        .achievement-label { font-size: 14px; color: #a3c585; letter-spacing: 2px; }

        .signatures { display: flex; justify-content: space-around; margin-top: 40px; }
        .sign-block { text-align: center; width: 180px; }
        .sign-line { border-bottom: 1px solid #333; margin-bottom: 6px; height: 50px; }
        .sign-name { font-size: 12px; font-weight: bold; color: #333; }
        .sign-role { font-size: 10px; color: #999; }

        .footer { text-align: center; margin-top: 25px; font-size: 10px; color: #999; }

        .quran-icon { font-size: 48px; margin-bottom: 15px; }

        .corner-deco { position: absolute; width: 60px; height: 60px; }
        .corner-deco.tl { top: 30px; left: 30px; border-top: 6px solid #e67e22; border-left: 6px solid #e67e22; border-radius: 8px 0 0 0; }
        .corner-deco.tr { top: 30px; right: 30px; border-top: 6px solid #e67e22; border-right: 6px solid #e67e22; border-radius: 0 8px 0 0; }
        .corner-deco.bl { bottom: 30px; left: 30px; border-bottom: 6px solid #e67e22; border-left: 6px solid #e67e22; border-radius: 0 0 0 8px; }
        .corner-deco.br { bottom: 30px; right: 30px; border-bottom: 6px solid #e67e22; border-right: 6px solid #e67e22; border-radius: 0 0 8px 0; }
    </style>
</head>
<body>
<div class="page">
    <div class="border-ornament"></div>
    <div class="border-ornament-inner"></div>

    {{-- Corner decorations --}}
    <div class="corner-deco tl"></div>
    <div class="corner-deco tr"></div>
    <div class="corner-deco bl"></div>
    <div class="corner-deco br"></div>

    <div class="content">
        <div class="quran-icon">📖</div>

        <div class="label">Saung Quran Rabbani</div>
        <h1 class="title">SERTIFIKAT TAHFIZ</h1>
        <p class="subtitle">Penghargaan Pencapaian Hafalan Al-Qur'an</p>

        <p class="recipient-label">Diberikan kepada:</p>
        <div class="recipient-name">{{ $santri->full_name }}</div>

        <p class="body-text">
            Telah berhasil menyelesaikan program hafalan Al-Qur'an<br>
            di Saung Quran Rabbani dengan capaian:
        </p>

        <div class="achievement">
            <div class="achievement-num">{{ $summary['target_juz'] }} JUZ</div>
            <div class="achievement-label">Al-Qur'an Karim</div>
        </div>

        <p class="body-text">
            Kelas: <strong>{{ $santri->sqrClass?->class_name ?? '-' }}</strong> |
            Total Sesi: <strong>{{ $summary['total_sessions'] }} sesi</strong>
        </p>

        <p style="font-size: 12px; color: #999;">Dikeluarkan di Depok, {{ now()->isoFormat('D MMMM Y') }}</p>

        <div class="signatures">
            <div class="sign-block">
                <div class="sign-line"></div>
                <div class="sign-name">Kepala Lembaga</div>
                <div class="sign-role">Saung Quran Rabbani</div>
            </div>
            <div class="sign-block">
                <div class="sign-line"></div>
                <div class="sign-name">Ustadz/Ustadzah</div>
                <div class="sign-role">Pembimbing Hafalan</div>
            </div>
        </div>
    </div>

    <div class="footer">
        Dokumen ini sah dan dikeluarkan secara resmi oleh Saung Quran Rabbani ·
        {{ now()->format('Y') }}
    </div>
</div>
</body>
</html>
