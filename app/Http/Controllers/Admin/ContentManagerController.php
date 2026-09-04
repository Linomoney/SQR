<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContentManager;
use Illuminate\Http\Request;

class ContentManagerController extends Controller
{
    public function index()
    {
        $contents = ContentManager::all()->pluck('value', 'key');

        // Parse JSON fields
        $faqList = json_decode($contents->get('faq_list', '[]'), true) ?? [];
        $laporanDonasi = json_decode($contents->get('laporan_donasi', '[]'), true) ?? [];

        return view('admin.content.index', compact('contents', 'faqList', 'laporanDonasi'));
    }

    /**
     * Save all content in one go (legacy / fallback)
     */
    public function store(Request $request)
    {
        $inputs = $request->except(['_token', 'section']);
        foreach ($inputs as $key => $value) {
            ContentManager::updateOrCreate(
                ['key' => $key],
                ['value' => $value ?? '', 'updated_by' => auth()->id()]
            );
        }
        return back()->with('success', 'Konten website berhasil diperbarui.');
    }

    /**
     * Save a specific section of content fields
     */
    public function storeSection(Request $request)
    {
        $section = $request->input('section', 'umum');
        $inputs  = $request->except(['_token', 'section']);

        foreach ($inputs as $key => $value) {
            ContentManager::updateOrCreate(
                ['key' => $key],
                ['value' => $value ?? '', 'updated_by' => auth()->id()]
            );
        }

        $sectionLabels = [
            'hero'     => 'Hero & Statistik',
            'sanlat'   => 'Informasi Sanlat',
            'kajian'   => 'Kajian Tematik',
            'jumat'    => 'Jumat Berbagi & Donasi',
            'sosmed'   => 'Media Sosial',
            'kontak'   => 'Kontak & Alamat',
        ];
        $label = $sectionLabels[$section] ?? ucfirst($section);

        return back()->with('success', "Section \"$label\" berhasil disimpan.");
    }

    /**
     * Add or update FAQ item
     */
    public function storeFaq(Request $request)
    {
        $request->validate([
            'faq_question' => 'required|string|max:500',
            'faq_answer'   => 'required|string|max:2000',
        ]);

        $record   = ContentManager::where('key', 'faq_list')->first();
        $faqList  = $record ? (json_decode($record->value, true) ?? []) : [];

        $index = $request->input('faq_index');
        $item  = [
            'question' => $request->input('faq_question'),
            'answer'   => $request->input('faq_answer'),
        ];

        if (is_numeric($index) && isset($faqList[(int)$index])) {
            $faqList[(int)$index] = $item;
        } else {
            $faqList[] = $item;
        }

        ContentManager::updateOrCreate(
            ['key' => 'faq_list'],
            ['value' => json_encode($faqList, JSON_UNESCAPED_UNICODE), 'updated_by' => auth()->id()]
        );

        return back()->with('success', 'FAQ berhasil disimpan.');
    }

    /**
     * Delete FAQ item by index
     */
    public function destroyFaq(int $index)
    {
        $record  = ContentManager::where('key', 'faq_list')->first();
        $faqList = $record ? (json_decode($record->value, true) ?? []) : [];

        if (isset($faqList[$index])) {
            array_splice($faqList, $index, 1);
            $record->update([
                'value'      => json_encode(array_values($faqList), JSON_UNESCAPED_UNICODE),
                'updated_by' => auth()->id(),
            ]);
        }

        return back()->with('success', 'FAQ berhasil dihapus.');
    }

    /**
     * Add or update Laporan Donasi Jumat Berbagi entry
     */
    public function storeLaporanDonasi(Request $request)
    {
        $request->validate([
            'laporan_bulan'        => 'required|string|max:100',
            'laporan_total_masuk'  => 'required|string|max:100',
            'laporan_total_keluar' => 'required|string|max:100',
            'laporan_saldo'        => 'required|string|max:100',
            'laporan_detail'       => 'nullable|string',
        ]);

        $record  = ContentManager::where('key', 'laporan_donasi')->first();
        $laporan = $record ? (json_decode($record->value, true) ?? []) : [];

        $index = $request->input('laporan_index');

        // Parse detail rows: format "label|nominal\nlabel2|nominal2"
        $detailRaw = $request->input('laporan_detail', '');
        $detailRows = [];
        foreach (explode("\n", $detailRaw) as $line) {
            $line = trim($line);
            if ($line) {
                $parts = explode('|', $line, 2);
                $detailRows[] = ['label' => trim($parts[0] ?? ''), 'nominal' => trim($parts[1] ?? '')];
            }
        }

        $item = [
            'bulan'        => $request->input('laporan_bulan'),
            'total_masuk'  => $request->input('laporan_total_masuk'),
            'total_keluar' => $request->input('laporan_total_keluar'),
            'saldo'        => $request->input('laporan_saldo'),
            'detail'       => $detailRows,
        ];

        if (is_numeric($index) && isset($laporan[(int)$index])) {
            $laporan[(int)$index] = $item;
        } else {
            array_unshift($laporan, $item); // newest first
        }

        ContentManager::updateOrCreate(
            ['key' => 'laporan_donasi'],
            ['value' => json_encode($laporan, JSON_UNESCAPED_UNICODE), 'updated_by' => auth()->id()]
        );

        return back()->with('success', 'Laporan donasi berhasil disimpan.');
    }

    /**
     * Delete laporan donasi entry by index
     */
    public function destroyLaporanDonasi(int $index)
    {
        $record  = ContentManager::where('key', 'laporan_donasi')->first();
        $laporan = $record ? (json_decode($record->value, true) ?? []) : [];

        if (isset($laporan[$index])) {
            array_splice($laporan, $index, 1);
            $record->update([
                'value'      => json_encode(array_values($laporan), JSON_UNESCAPED_UNICODE),
                'updated_by' => auth()->id(),
            ]);
        }

        return back()->with('success', 'Laporan donasi berhasil dihapus.');
    }
}
