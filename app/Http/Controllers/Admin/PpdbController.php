<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ppdb;
use App\Models\SqrClass;
use Illuminate\Http\Request;

class PpdbController extends Controller
{
    public function index(Request $request)
    {
        $query = Ppdb::with('kelasDiminati');

        // Status Filter
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Class Filter
        if ($request->filled('class_id') && $request->class_id !== 'all') {
            $query->where('kelas_diminati', $request->class_id);
        }

        // Search Filter
        if ($request->filled('search')) {
            $q = $request->search;
            $query->where(function ($q2) use ($q) {
                $q2->where('nama_lengkap', 'like', "%{$q}%")
                   ->orWhere('nama_ayah', 'like', "%{$q}%")
                   ->orWhere('nama_ibu', 'like', "%{$q}%")
                   ->orWhere('no_hp_ayah', 'like', "%{$q}%")
                   ->orWhere('no_hp_ibu', 'like', "%{$q}%")
                   ->orWhere('email', 'like', "%{$q}%");
            });
        }

        // Sorting
        $sort = $request->input('sort', 'latest');
        if ($sort === 'oldest') {
            $query->oldest();
        } elseif ($sort === 'name_asc') {
            $query->orderBy('nama_lengkap', 'asc');
        } elseif ($sort === 'name_desc') {
            $query->orderBy('nama_lengkap', 'desc');
        } else {
            $query->latest();
        }

        $ppdbList = $query->paginate(15)->withQueryString();
        $classes  = SqrClass::all();

        $stats = [
            'total'    => Ppdb::count(),
            'pending'  => Ppdb::where('status', 'Pending')->count(),
            'diterima' => Ppdb::where('status', 'Diterima')->count(),
            'ditolak'  => Ppdb::where('status', 'Ditolak')->count(),
        ];

        return view('admin.ppdb.index', compact('ppdbList', 'classes', 'stats', 'sort'));
    }

    public function show(Ppdb $ppdb)
    {
        $ppdb->load('kelasDiminati');
        return view('admin.ppdb.show', compact('ppdb'));
    }

    public function updateStatus(Request $request, Ppdb $ppdb)
    {
        $request->validate([
            'status'        => 'required|in:Pending,Diterima,Ditolak',
            'catatan_admin' => 'nullable|string|max:500',
        ]);

        $ppdb->update([
            'status'        => $request->status,
            'catatan_admin' => $request->catatan_admin,
        ]);

        return back()->with('success', "Status pendaftaran {$ppdb->nama_lengkap} berhasil diubah ke {$request->status}.");
    }

    public function destroy(Ppdb $ppdb)
    {
        $name = $ppdb->nama_lengkap;
        $ppdb->delete();
        return redirect()->route('admin.ppdb.index')->with('success', "Data PPDB {$name} berhasil dihapus.");
    }
}
