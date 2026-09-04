<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrganizationSetting;
use App\Models\Santri;
use App\Models\SqrClass;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class CertificateController extends Controller
{
    /**
     * List all santri with certificate/recommendation eligibility.
     */
    public function index(Request $request)
    {
        $classId = $request->get('class_id');
        $filter  = $request->get('filter', 'all'); // all, eligible_cert, eligible_rec, none

        $query = Santri::with(['sqrClass', 'studentProgress', 'wali'])
            ->where('is_active', true);

        if ($classId) {
            $query->where('class_id', $classId);
        }

        $santriList = $query->orderBy('full_name')->get();

        // Apply filter after loading (need progress computation)
        if ($filter === 'eligible_cert') {
            $santriList = $santriList->filter(fn($s) => $s->isEligibleForCertificate());
        } elseif ($filter === 'eligible_rec') {
            $santriList = $santriList->filter(fn($s) => $s->isEligibleForRecommendation());
        } elseif ($filter === 'none') {
            $santriList = $santriList->filter(fn($s) => !$s->isEligibleForRecommendation());
        }

        $classes = SqrClass::where('is_active', true)->orderBy('class_name')->get();
        $orgSettings = OrganizationSetting::getAllSettings();

        return view('admin.certificates.index', compact('santriList', 'classes', 'orgSettings', 'classId', 'filter'));
    }

    /**
     * Update certificate template for a santri.
     */
    public function updateTemplate(Request $request, Santri $santri)
    {
        $request->validate([
            'certificate_template' => 'required|in:classic,elegant,premium',
        ]);

        $santri->update(['certificate_template' => $request->certificate_template]);

        return back()->with('success', "✅ Template sertifikat {$santri->full_name} berhasil diubah ke: " . ucfirst($request->certificate_template));
    }

    /**
     * Admin download santri certificate PDF.
     */
    public function download(Santri $santri)
    {
        $santri->load('sqrClass', 'studentProgress', 'wali');
        $santri->load('lastUstadz');

        $summary         = $santri->progress_summary;
        $orgSettings     = OrganizationSetting::getAllSettingsForPdf();
        $lastUstadz      = $santri->last_ustadz_user;
        $ustadzSigUrl    = $lastUstadz?->signature_url ?? ($orgSettings['ustadz_signature_url'] ?? null);
        $ustadzSigBase64 = OrganizationSetting::imageToBase64($ustadzSigUrl);

        // Mark issued_at if first time
        if (!$santri->certificate_issued_at && $santri->isEligibleForCertificate()) {
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

    /**
     * Admin download santri recommendation letter PDF.
     */
    public function downloadRecommendation(Santri $santri)
    {
        $santri->load('sqrClass', 'studentProgress', 'wali');
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

    /**
     * Organization / certificate settings page.
     */
    public function settings()
    {
        $orgSettings = OrganizationSetting::getAllSettings();
        $classes     = SqrClass::where('is_active', true)->get();
        return view('admin.certificates.settings', compact('orgSettings', 'classes'));
    }

    /**
     * Save organization settings.
     */
    public function saveSettings(Request $request)
    {
        $request->validate([
            'pimpinan_name'          => 'required|string|max:255',
            'pimpinan_title'         => 'required|string|max:255',
            'organization_name'      => 'required|string|max:255',
            'organization_address'   => 'required|string|max:500',
            'organization_city'      => 'required|string|max:100',
            'organization_phone'     => 'nullable|string|max:50',
            'organization_email'     => 'nullable|email|max:255',
            'pimpinan_signature_url' => 'nullable|url|max:500',
            'ustadz_signature_url'   => 'nullable|url|max:500',
            'organization_stamp_url' => 'nullable|url|max:500',
            'yayasan_logo_url'       => 'nullable|url|max:500',
        ]);

        OrganizationSetting::setMany([
            'pimpinan_name'          => $request->pimpinan_name,
            'pimpinan_title'         => $request->pimpinan_title,
            'organization_name'      => $request->organization_name,
            'organization_subtitle'  => $request->organization_subtitle ?? 'Lembaga Pendidikan Al-Qur\'an Terpadu',
            'organization_address'   => $request->organization_address,
            'organization_city'      => $request->organization_city,
            'organization_phone'     => $request->organization_phone ?? '',
            'organization_email'     => $request->organization_email ?? '',
            'pimpinan_signature_url' => $request->pimpinan_signature_url ?? '',
            'ustadz_signature_url'   => $request->ustadz_signature_url ?? '',
            'organization_stamp_url' => $request->organization_stamp_url ?? '',
            'yayasan_logo_url'       => $request->yayasan_logo_url ?? 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787212253/WhatsApp_Image_2024-03-05_at_16.45.18__1_-removebg-preview_1_n7ggrp.png',
            'certificate_footer_text'=> $request->certificate_footer_text ?? '',
        ]);

        return back()->with('success', '✅ Pengaturan lembaga & tanda tangan berhasil disimpan.');
    }

    /**
     * Update class certificate/recommendation thresholds (from settings page).
     */
    public function updateClassThresholds(Request $request)
    {
        $request->validate([
            'thresholds'                => 'required|array',
            'thresholds.*.class_id'     => 'required|exists:classes,id',
            'thresholds.*.cert_target'  => 'required|integer|min:1|max:100',
            'thresholds.*.rec_target'   => 'required|integer|min:1|max:100',
        ]);

        foreach ($request->thresholds as $th) {
            SqrClass::where('id', $th['class_id'])->update([
                'certificate_target'    => $th['cert_target'],
                'recommendation_target' => $th['rec_target'],
            ]);
        }

        return back()->with('success', '✅ Target threshold sertifikat & rekomendasi per kelas berhasil diperbarui.');
    }
}
