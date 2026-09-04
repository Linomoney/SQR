<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SqrLocation;
use App\Models\User;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function index()
    {
        $locations = SqrLocation::withCount(['ustadzList', 'classes'])->get();
        $allUstadz  = User::role('ustadz')->where('is_active', true)->get();

        return view('admin.locations.index', compact('locations', 'allUstadz'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'code'          => 'required|string|max:50|unique:sqr_locations,code',
            'address'       => 'nullable|string|max:500',
            'latitude'      => 'required|numeric',
            'longitude'     => 'required|numeric',
            'radius_meters' => 'required|integer|min:10|max:5000',
        ]);

        SqrLocation::create($validated);

        return back()->with('success', '✅ Lokasi Cabang SQR baru berhasil ditambahkan!');
    }

    public function update(Request $request, SqrLocation $location)
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'code'          => 'required|string|max:50|unique:sqr_locations,code,' . $location->id,
            'address'       => 'nullable|string|max:500',
            'latitude'      => 'required|numeric',
            'longitude'     => 'required|numeric',
            'radius_meters' => 'required|integer|min:10|max:5000',
            'is_active'     => 'required|boolean',
        ]);

        $location->update($validated);

        return back()->with('success', "✅ Data Lokasi Cabang {$location->name} berhasil diperbarui!");
    }

    public function assignUstadz(Request $request)
    {
        $validated = $request->validate([
            'ustadz_id'   => 'required|exists:users,id',
            'location_id' => 'required|exists:sqr_locations,id',
        ]);

        $ustadz   = User::findOrFail($validated['ustadz_id']);
        $location = SqrLocation::findOrFail($validated['location_id']);

        $ustadz->update(['location_id' => $location->id]);

        return back()->with('success', "✅ {$ustadz->formatted_name} berhasil ditugaskan mengajar di lokasi {$location->name}!");
    }

    public function destroy(SqrLocation $location)
    {
        if ($location->code === 'SQR-UTAMA') {
            return back()->with('error', '⛔ Lokasi SQR Utama tidak dapat dihapus.');
        }

        $location->delete();

        return back()->with('success', '✅ Lokasi cabang berhasil dihapus.');
    }
}
