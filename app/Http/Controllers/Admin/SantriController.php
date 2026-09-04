<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Santri;
use App\Models\SqrClass;
use App\Models\User;
use Illuminate\Http\Request;

class SantriController extends Controller
{
    public function index(Request $request)
    {
        $query = Santri::with(['sqrClass', 'wali']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%");
            });
        }

        if ($request->filled('class_id')) {
            $query->where('class_id', $request->class_id);
        }

        $santri  = $query->latest()->paginate(15);
        $classes = SqrClass::where('is_active', true)->get();

        return view('admin.santri.index', compact('santri', 'classes'));
    }

    public function create()
    {
        $classes = SqrClass::where('is_active', true)->get();
        $walis   = User::role('wali')->orderBy('name')->get();

        return view('admin.santri.form', compact('classes', 'walis'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'fullName'    => 'required|string|max:255',
            'gender'      => 'required|in:L,P,Laki-laki,Perempuan',
            'birthDate'   => 'nullable|date',
            'classId'     => 'nullable|exists:classes,id',
            'waliUserId'  => 'nullable|exists:users,id',
        ]);

        $genderMap = [
            'L' => 'Laki-laki',
            'P' => 'Perempuan',
            'Laki-laki' => 'Laki-laki',
            'Perempuan' => 'Perempuan',
        ];

        Santri::create([
            'full_name'     => $validated['fullName'],
            'gender'        => $genderMap[$validated['gender']] ?? 'Laki-laki',
            'date_of_birth' => $validated['birthDate'] ?? null,
            'class_id'      => $validated['classId'] ?? null,
            'wali_user_id'  => $validated['waliUserId'] ?? null,
            'is_active'     => true,
        ]);

        return redirect()->route('admin.santri.index')->with('success', 'Data santri berhasil ditambahkan.');
    }

    public function show(Santri $santri)
    {
        $santri->load(['sqrClass', 'wali', 'studentProgress.ustadz', 'payments']);
        return view('admin.santri.show', compact('santri'));
    }

    public function edit(Santri $santri)
    {
        $classes = SqrClass::where('is_active', true)->get();
        $walis   = User::role('wali')->orderBy('name')->get();

        return view('admin.santri.form', compact('santri', 'classes', 'walis'));
    }

    public function update(Request $request, Santri $santri)
    {
        $validated = $request->validate([
            'fullName'   => 'required|string|max:255',
            'gender'     => 'required|in:L,P,Laki-laki,Perempuan',
            'birthDate'  => 'nullable|date',
            'classId'    => 'nullable|exists:classes,id',
            'waliUserId' => 'nullable|exists:users,id',
        ]);

        $genderMap = [
            'L' => 'Laki-laki',
            'P' => 'Perempuan',
            'Laki-laki' => 'Laki-laki',
            'Perempuan' => 'Perempuan',
        ];

        $santri->update([
            'full_name'     => $validated['fullName'],
            'gender'        => $genderMap[$validated['gender']] ?? 'Laki-laki',
            'date_of_birth' => $validated['birthDate'] ?? null,
            'class_id'      => $validated['classId'] ?? null,
            'wali_user_id'  => $validated['waliUserId'] ?? null,
        ]);

        return redirect()->route('admin.santri.index')->with('success', 'Data santri berhasil diperbarui.');
    }

    public function destroy(Santri $santri)
    {
        $santri->delete();
        return redirect()->route('admin.santri.index')->with('success', 'Data santri telah dihapus.');
    }
}
