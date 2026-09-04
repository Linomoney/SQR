<?php

namespace App\Http\Controllers\Wali;

use App\Http\Controllers\Controller;
use App\Models\Santri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $isLocked = !$user->is_profile_completed && $user->is_profile_deadline_passed;
        $deadlineDate = $user->profile_deadline_date;
        $santriList = $user->santriAsWali()->get();

        return view('wali.profile.index', compact('user', 'isLocked', 'deadlineDate', 'santriList'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'gender'      => 'required|in:L,P',
            'nik'         => 'required|string|min:16|max:20',
            'no_kk'       => 'required|string|min:16|max:20',
            'phone'       => 'required|string|max:20',
            'birth_place' => 'required|string|max:100',
            'birth_date'  => 'required|date',
            'address'     => 'required|string|max:1000',
            'santri'      => 'nullable|array',
            'santri.*.id' => 'required|exists:santri,id',
            'santri.*.birth_place' => 'required|string|max:100',
            'santri.*.date_of_birth' => 'required|date',
            'santri.*.address'     => 'required|string|max:1000',
        ]);

        $user->name                 = $validated['name'];
        $user->gender               = $validated['gender'];
        $user->nik                  = $validated['nik'];
        $user->no_kk                = $validated['no_kk'];
        $user->phone                = $validated['phone'];
        $user->birth_place          = $validated['birth_place'];
        $user->birth_date           = $validated['birth_date'];
        $user->address              = $validated['address'];
        $user->is_profile_completed = true;
        $user->save();

        // Update each santri biodata under this wali
        if (!empty($validated['santri'])) {
            foreach ($validated['santri'] as $sData) {
                Santri::where('id', $sData['id'])
                    ->where('wali_user_id', $user->id)
                    ->update([
                        'birth_place'   => $sData['birth_place'],
                        'date_of_birth' => $sData['date_of_birth'],
                        'address'       => $sData['address'],
                    ]);
            }
        }

        return redirect()->route('wali.dashboard')->with('success', "✅ Biodata KK & KTP atas nama {$user->name} dan ananda berhasil disimpan!");
    }

    public function updatePassword(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'current_password' => 'required|current_password',
            'password'         => ['required', 'confirmed', Password::min(8)],
        ]);

        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('success', '✅ Password akun Wali Santri berhasil diperbarui.');
    }
}
