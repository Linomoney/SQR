<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrganizationSetting;
use Illuminate\Http\Request;

class MaintenanceController extends Controller
{
    /**
     * Toggle maintenance mode ON or OFF.
     */
    public function toggle(Request $request)
    {
        $request->validate([
            'maintenance_mode'    => 'required|boolean',
            'maintenance_message' => 'nullable|string|max:500',
        ]);

        OrganizationSetting::set('maintenance_mode', $request->boolean('maintenance_mode') ? '1' : '0');
        OrganizationSetting::set('maintenance_message', $request->maintenance_message ?? '');

        $status = $request->boolean('maintenance_mode') ? 'aktif' : 'dinonaktifkan';

        return back()->with('success', "Mode pemeliharaan berhasil {$status}.");
    }

    /**
     * Get current maintenance status as JSON (for admin AJAX polling).
     */
    public function status()
    {
        return response()->json([
            'maintenance_mode'    => (bool) OrganizationSetting::get('maintenance_mode', '0'),
            'maintenance_message' => OrganizationSetting::get('maintenance_message', ''),
        ]);
    }
}
