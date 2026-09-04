<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Ppdb;
use App\Models\SqrClass;
use Illuminate\Http\Request;

class PpdbController extends Controller
{
    public function create()
    {
        $classes          = SqrClass::all();
        $pekerjaanOptions = \App\Models\Ppdb::$pekerjaanOptions;
        $penghasilanOptions = \App\Models\Ppdb::$penghasilanOptions;

        return view('public.ppdb', compact('classes', 'pekerjaanOptions', 'penghasilanOptions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_ayah'          => 'nullable|string|max:100',
            'nama_ibu'           => 'nullable|string|max:100',
            'pekerjaan_ayah'     => 'nullable|string',
            'pekerjaan_ibu'      => 'nullable|string',
            'no_hp_ayah'         => 'nullable|string|max:20',
            'no_hp_ibu'          => 'nullable|string|max:20',
            'penghasilan_bulanan'=> 'nullable|string',
            'nama_lengkap'       => 'required|string|max:100',
            'tempat_lahir'       => 'nullable|string|max:100',
            'tanggal_lahir'      => 'nullable|date',
            'anak_ke'            => 'nullable|integer|min:1',
            'jumlah_saudara'     => 'nullable|integer|min:0',
            'sekolah_asal'       => 'nullable|string|max:100',
            'gender'             => 'required|in:Laki-laki,Perempuan',
            'email'              => 'nullable|email|max:100',
            'no_telephone'       => 'nullable|string|max:20',
            'alamat'             => 'nullable|string',
            'rt'                 => 'nullable|string|max:5',
            'rw'                 => 'nullable|string|max:5',
            'desa_kelurahan'     => 'nullable|string|max:100',
            'kota'               => 'nullable|string|max:100',
            'kelas_diminati'     => 'nullable|exists:classes,id',
        ]);

        // ── Validasi Kuota Kelas ────────────────────────────────
        if (!empty($validated['kelas_diminati'])) {
            $class = SqrClass::find($validated['kelas_diminati']);
            if ($class && $class->isQuotaFull()) {
                return back()
                    ->withInput()
                    ->withErrors(['kelas_diminati' => "Maaf, kelas {$class->class_name} sudah penuh (kuota {$class->quota} santri). Silakan pilih kelas lain."]);
            }
        }

        $ppdb = Ppdb::create($validated);

        // ── Trigger Admin Notification ─────────────────────────
        $className = 'Saung Quran';
        if (!empty($validated['kelas_diminati'])) {
            $c = SqrClass::find($validated['kelas_diminati']);
            if ($c) $className = $c->class_name;
        }

        \App\Models\SqrNotification::create([
            'user_id'     => null,
            'target_role' => 'admin',
            'title'       => 'Pendaftaran PPDB Baru: ' . $ppdb->nama_lengkap,
            'message'     => "Calon santri {$ppdb->nama_lengkap} ({$ppdb->gender}) mendaftar PPDB online pada kelas {$className}. No. HP Wali: " . ($ppdb->no_hp_ayah ?? $ppdb->no_hp_ibu ?? $ppdb->no_telephone ?? '-'),
            'type'        => 'ppdb',
            'is_read'     => false,
        ]);

        return redirect()->route('ppdb.success')
            ->with('success', 'Pendaftaran berhasil dikirim! Kami akan segera menghubungi Anda.');
    }

    public function success()
    {
        return view('public.ppdb-success');
    }
}
