<?php

namespace App\Http\Controllers\Ustadz;

use App\Http\Controllers\Controller;
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

        return view('ustadz.profile.index', compact('user', 'isLocked', 'deadlineDate'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'gender'        => 'required|in:L,P',
            'nik'           => 'required|string|min:16|max:20',
            'no_kk'         => 'required|string|min:16|max:20',
            'phone'         => 'required|string|max:20',
            'birth_place'   => 'required|string|max:100',
            'birth_date'    => 'required|date',
            'address'       => 'required|string|max:1000',
            'education'     => 'nullable|string|max:100',
            'photo_url'     => 'nullable|url|max:500',
            'signature_url' => 'nullable|url|max:500',
        ]);

        $user->name                 = $validated['name'];
        $user->gender               = $validated['gender'];
        $user->nik                  = $validated['nik'];
        $user->no_kk                = $validated['no_kk'];
        $user->phone                = $validated['phone'];
        $user->birth_place          = $validated['birth_place'];
        $user->birth_date           = $validated['birth_date'];
        $user->address              = $validated['address'];
        $user->education            = $validated['education'] ?? null;
        if (!empty($validated['photo_url'])) {
            $user->photo_url        = $validated['photo_url'];
        }
        if (array_key_exists('signature_url', $validated)) {
            $user->signature_url    = $validated['signature_url'];
        }
        $user->is_profile_completed = true;
        $user->save();

        return redirect()->route('ustadz.dashboard')->with('success', "✅ Biodata KTP & KK atas nama {$user->formatted_name} berhasil disimpan! Akses sistem Anda kini aktif penuh.");
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

        return back()->with('success', '✅ Password akun Ustadz/Ustadzah berhasil diperbarui.');
    }
}
