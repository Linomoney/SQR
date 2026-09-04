<?php

namespace App\Http\Controllers\Wali;

use App\Http\Controllers\Controller;
use App\Models\OrganizationSetting;
use App\Models\Santri;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class CertificateController extends Controller
{
    public function show(Santri $santri)
    {
        $this->authorizeWali($santri);

        $santri->load('sqrClass', 'studentProgress');
        $summary     = $santri->progress_summary;
        $orgSettings = OrganizationSetting::getAllSettings();
        $lastUstadz  = $santri->last_ustadz_user;

        return view('wali.awards.certificate', compact('santri', 'summary', 'orgSettings', 'lastUstadz'));
    }

    public function download(Santri $santri)
    {
        $this->authorizeWali($santri);

        if (!$santri->isEligibleForCertificate()) {
            return back()->withErrors(['msg' => "Ananda {$santri->full_name} belum memenuhi syarat pencapaian {$santri->certificate_target}% hafalan untuk mendapatkan sertifikat."]);
        }

        $santri->load('sqrClass', 'wali', 'studentProgress');
        $summary         = $santri->progress_summary;
        $orgSettings     = OrganizationSetting::getAllSettingsForPdf();
        $lastUstadz      = $santri->last_ustadz_user;
        $ustadzSigUrl    = $lastUstadz?->signature_url ?? ($orgSettings['ustadz_signature_url'] ?? null);
        $ustadzSigBase64 = OrganizationSetting::imageToBase64($ustadzSigUrl);

        // Mark certificate issued date on first download
        if (!$santri->certificate_issued_at) {
            $santri->update(['certificate_issued_at' => now()]);
        }

        $template = match($santri->certificate_template ?? 'classic') {
            'elegant' => 'pdf.certificate_elegant',
            'premium' => 'pdf.certificate_premium',
            default   => 'pdf.certificate_classic',
        };

        $pdf = Pdf::loadView($template, compact('santri', 'summary', 'orgSettings', 'lastUstadz', 'ustadzSigBase64'))
            ->setPaper('a4', 'landscape')
            ->setOption('dpi', 150)
            ->setOption('isHtml5ParserEnabled', true)
            ->setOption('isRemoteEnabled', true);

        return $pdf->download("Sertifikat-SQR-{$santri->full_name}.pdf");
    }

    private function authorizeWali(Santri $santri): void
    {
        $user = auth()->user();
        if ($user->hasRole('wali') && $santri->wali_user_id !== $user->id) {
            abort(403, 'Anda tidak berhak mengakses data santri ini.');
        }
    }
}
