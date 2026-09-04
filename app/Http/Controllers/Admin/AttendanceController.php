<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SantriAttendance;
use App\Models\UstadzAttendance;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index()
    {
        $santriAttendance = SantriAttendance::with(['santri', 'sqrClass'])->latest('date')->paginate(15, ['*'], 'santri_page');
        $ustadzAttendance = UstadzAttendance::with('ustadz')->latest('date')->paginate(15, ['*'], 'ustadz_page');

        return view('admin.attendance.index', compact('santriAttendance', 'ustadzAttendance'));
    }

    public function santri()
    {
        $attendance = SantriAttendance::with(['santri', 'sqrClass'])->latest('date')->paginate(20);
        return view('admin.attendance.santri', compact('attendance'));
    }

    public function ustadz()
    {
        $attendance = UstadzAttendance::with('ustadz')->latest('date')->paginate(20);
        return view('admin.attendance.ustadz', compact('attendance'));
    }
}
