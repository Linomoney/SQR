<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SqrClass;
use App\Models\Santri;
use App\Models\User;
use Illuminate\Http\Request;

class SqrClassController extends Controller
{
    public function index()
    {
        $classes = SqrClass::withCount(['activeSantri'])->get();
        $allUstadz = User::role('ustadz')->get();

        return view('admin.classes.index', compact('classes', 'allUstadz'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'class_name'            => 'required|string|max:255',
            'description'           => 'nullable|string',
            'quota'                 => 'required|integer|min:1',
            'start_time'            => 'nullable|string|max:10',
            'end_time'              => 'nullable|string|max:10',
            'attendance_start_time' => 'nullable|string|max:10',
            'attendance_end_time'   => 'nullable|string|max:10',
            'is_active'             => 'nullable|boolean',
            'ustadz_id'             => 'nullable|exists:users,id',
        ]);

        $sqrClass = SqrClass::create([
            'class_name'            => $request->class_name,
            'description'           => $request->description,
            'quota'                 => $request->quota,
            'start_time'            => $request->start_time ?? '16:00',
            'end_time'              => $request->end_time ?? '18:00',
            'attendance_start_time' => $request->attendance_start_time ?? '15:30',
            'attendance_end_time'   => $request->attendance_end_time ?? '16:15',
            'is_active'             => $request->has('is_active') ? true : false,
        ]);

        if ($request->filled('ustadz_id')) {
            // Unassign previous class_id for this ustadz
            User::where('class_id', $sqrClass->id)->update(['class_id' => null]);
            // Assign selected ustadz to this new class
            User::where('id', $request->ustadz_id)->update(['class_id' => $sqrClass->id]);
        }

        return redirect()->route('admin.classes.index')->with('success', 'Kelas SQR baru berhasil ditambahkan!');
    }

    public function show(SqrClass $class)
    {
        $class->load(['activeSantri.wali']);
        $allClasses = SqrClass::where('id', '!=', $class->id)->get();
        $allSantri  = Santri::where('is_active', true)->orderBy('full_name')->get();
        $allUstadz  = User::role('ustadz')->get();

        return view('admin.classes.show', compact('class', 'allClasses', 'allSantri', 'allUstadz'));
    }

    public function update(Request $request, SqrClass $class)
    {
        $request->validate([
            'class_name'            => 'required|string|max:255',
            'description'           => 'nullable|string',
            'quota'                 => 'required|integer|min:1',
            'start_time'            => 'nullable|string|max:10',
            'end_time'              => 'nullable|string|max:10',
            'attendance_start_time' => 'nullable|string|max:10',
            'attendance_end_time'   => 'nullable|string|max:10',
            'ustadz_id'             => 'nullable',
        ]);

        $class->update([
            'class_name'            => $request->class_name,
            'description'           => $request->description,
            'quota'                 => $request->quota,
            'start_time'            => $request->start_time ?? $class->start_time ?? '16:00',
            'end_time'              => $request->end_time ?? $class->end_time ?? '18:00',
            'attendance_start_time' => $request->attendance_start_time ?? $class->attendance_start_time ?? '15:30',
            'attendance_end_time'   => $request->attendance_end_time ?? $class->attendance_end_time ?? '16:15',
            'is_active'             => $request->has('is_active') ? true : false,
        ]);

        // Handle Ustadz assignment update
        if ($request->has('ustadz_id')) {
            // Remove previous assignment for this class
            User::where('class_id', $class->id)->update(['class_id' => null]);

            if (!empty($request->ustadz_id)) {
                User::where('id', $request->ustadz_id)->update(['class_id' => $class->id]);
            }
        }

        return redirect()->route('admin.classes.index')->with('success', 'Informasi kelas & penugasan ustadz berhasil diperbarui!');
    }

    public function destroy(SqrClass $class)
    {
        if ($class->activeSantri()->count() > 0) {
            return back()->withErrors(['class' => 'Gagal menghapus! Masih ada santri aktif terdaftar pada kelas ini. Pindahkan santri terlebih dahulu.']);
        }

        // Unassign any ustadz from this deleted class
        User::where('class_id', $class->id)->update(['class_id' => null]);

        $class->delete();
        return redirect()->route('admin.classes.index')->with('success', 'Kelas berhasil dihapus!');
    }

    public function moveSantri(Request $request, SqrClass $class)
    {
        $request->validate([
            'santri_ids'      => 'required|array|min:1',
            'target_class_id' => 'required|exists:classes,id',
        ]);

        $targetClass = SqrClass::findOrFail($request->target_class_id);

        // Check target class remaining quota
        $santriCount = count($request->santri_ids);
        if ($targetClass->remaining_quota < $santriCount) {
            return back()->withErrors(['quota' => "Gagal memindahkan santri! Sisa kuota kelas {$targetClass->class_name} hanya {$targetClass->remaining_quota} bangku."]);
        }

        Santri::whereIn('id', $request->santri_ids)->update([
            'class_id' => $targetClass->id
        ]);

        return redirect()->back()->with('success', "Berhasil memindahkan {$santriCount} santri ke kelas {$targetClass->class_name} (Naik/Pindah Kelas)!");
    }
}
