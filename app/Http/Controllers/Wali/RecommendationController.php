<?php

namespace App\Http\Controllers\Wali;

use App\Http\Controllers\Controller;
use App\Models\OrganizationSetting;
use App\Models\Santri;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class RecommendationController extends Controller
{
    public function show(Santri $santri)
    {
        $this->authorizeWali($santri);
        $santri->load('sqrClass', 'wali', 'studentProgress');
        $summary     = $santri->progress_summary;
        $orgSettings = OrganizationSetting::getAllSettings();
        $lastUstadz  = $santri->last_ustadz_user;

        return view('wali.awards.recommendation', compact('santri', 'summary', 'orgSettings', 'lastUstadz'));
    }

    public function download(Santri $santri)
    {
        $this->authorizeWali($santri);

        if (!$santri->can_download_recommendation) {
            return back()->with('error', "Ananda {$santri->full_name} belum memenuhi syarat pencapaian minimal {$santri->recommendation_target}% hafalan untuk mendapatkan Surat Rekomendasi.");
        }

        $santri->load('sqrClass', 'wali', 'studentProgress');
        $summary         = $santri->progress_summary;
        $orgSettings     = OrganizationSetting::getAllSettingsForPdf();
        $lastUstadz      = $santri->last_ustadz_user;
        $ustadzSigUrl    = $lastUstadz?->signature_url ?? ($orgSettings['ustadz_signature_url'] ?? null);
        $ustadzSigBase64 = OrganizationSetting::imageToBase64($ustadzSigUrl);

        $pdf = Pdf::loadView('pdf.recommendation', compact('santri', 'summary', 'orgSettings', 'lastUstadz', 'ustadzSigBase64'))
            ->setPaper('a4', 'portrait')
            ->setOption('dpi', 150)
            ->setOption('isHtml5ParserEnabled', true)
            ->setOption('isRemoteEnabled', true);

        return $pdf->download("Surat-Rekomendasi-SQR-{$santri->nis}.pdf");
    }

    private function authorizeWali(Santri $santri): void
    {
        $user = auth()->user();
        if ($user->hasRole('wali') && $santri->wali_user_id !== $user->id) {
            abort(403, 'Akses ditolak.');
        }
    }
}
