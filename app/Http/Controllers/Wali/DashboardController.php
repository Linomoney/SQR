<?php

namespace App\Http\Controllers\Wali;

use App\Http\Controllers\Controller;
use App\Models\Santri;
use App\Models\SchoolEvent;
use App\Models\SchoolSchedule;
use App\Models\SqrNotification;
use App\Models\UstadzAttendance;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user        = auth()->user();
        $santriList  = $user->santriAsWali()->with('sqrClass')->get();
        $unreadCount = $user->sqrNotifications()->unread()->count();
        $classIds    = $santriList->pluck('class_id')->filter()->unique();

        // Get all Ustadz IDs teaching any of the Wali's children's classes
        $allChildrenUstadzIds = \App\Models\User::whereIn('class_id', $classIds)->pluck('id');

        // Attach today's Ustadz attendance specifically to each Santri
        foreach ($santriList as $santri) {
            $classUstadzIds = \App\Models\User::where('class_id', $santri->class_id)->pluck('id');
            $santri->today_attendance = UstadzAttendance::with('ustadz')
                ->whereIn('ustadz_id', $classUstadzIds)
                ->whereDate('date', today())
                ->first();
        }

        // Today's online classes for Wali's children's classes
        $todayOnlineClasses = UstadzAttendance::with(['ustadz'])
            ->whereDate('date', today())
            ->whereIn('status', ['Hadir Online', 'Izin'])
            ->whereNotNull('online_meeting_link')
            ->whereIn('ustadz_id', $allChildrenUstadzIds)
            ->get();

        // Recent broadcast notifications
        $notifications = SqrNotification::forUser($user->id)
            ->latest()
            ->take(5)
            ->get();

        // ── Jadwal & Kalender ──────────────────────────────────────
        $todayEvents       = SchoolEvent::today()->orderBy('type')->get();
        $isSchoolDay       = SchoolSchedule::isSchoolDay(today());
        $jamMasuk          = SchoolSchedule::jamMasuk();
        $jamPulang         = SchoolSchedule::jamPulang();
        $weeklyOffDays     = SchoolSchedule::weeklyOffDays();

        // Events & Attendance for next 7 days (mini calendar strip)
        $next7Days = collect();
        for ($i = 0; $i < 7; $i++) {
            $d = today()->addDays($i);
            $events = SchoolEvent::onDate($d)->get();
            $isOff  = in_array($d->dayOfWeek, $weeklyOffDays, true);
            $hasHoliday = $events->where('is_holiday', true)->count() > 0;

            // Check attendance status on date $d for Wali's children
            $santriStatusesOnDate = collect();
            foreach ($santriList as $santri) {
                $cTeacherIds = \App\Models\User::where('class_id', $santri->class_id)->pluck('id');
                $attOnDate = UstadzAttendance::whereIn('ustadz_id', $cTeacherIds)
                    ->whereDate('date', $d)
                    ->first();

                $santriStatusesOnDate->push([
                    'santri'       => $santri,
                    'status'       => $attOnDate?->status ?? 'None',
                    'is_online'    => $attOnDate?->status === 'Hadir Online',
                    'meeting_link' => $attOnDate?->online_meeting_link,
                ]);
            }

            $next7Days->push([
                'date'             => $d,
                'events'           => $events,
                'is_off'           => $isOff,
                'has_holiday'      => $hasHoliday,
                'is_school'        => !$isOff && !$hasHoliday,
                'is_today'         => $i === 0,
                'santri_statuses'  => $santriStatusesOnDate,
            ]);
        }

        // Today's online events from school_events (admin-created)
        $todayOnlineEvents = SchoolEvent::today()->where('type', 'online')->get();

        // Upcoming events (next 14 days, non-school-day type)
        $upcomingEvents = SchoolEvent::upcoming(14)->get();

        return view('wali.dashboard', compact(
            'santriList', 'unreadCount', 'todayOnlineClasses', 'notifications',
            'todayEvents', 'isSchoolDay', 'jamMasuk', 'jamPulang',
            'next7Days', 'todayOnlineEvents', 'upcomingEvents'
        ));
    }

    public function progress(Santri $santri)
    {
        $this->authorizeWali($santri);
        $santri->load('sqrClass');
        $summary = $santri->progress_summary;
        $progressList = $santri->studentProgress()->with('ustadz')->latest('date')->latest('id')->paginate(15);

        return view('wali.progress', compact('santri', 'summary', 'progressList'));
    }

    public function notifications()
    {
        $user = auth()->user();
        $notifications = SqrNotification::forUser($user->id, 'wali')->latest()->paginate(15);
        return view('wali.notifications', compact('notifications'));
    }

    public function markRead(SqrNotification $notification)
    {
        if ($notification->user_id !== auth()->id() && $notification->user_id !== null) {
            abort(403);
        }
        $notification->update(['is_read' => true]);
        return back();
    }

    private function authorizeWali(Santri $santri): void
    {
        $user = auth()->user();
        if ($user->hasRole('wali') && $santri->wali_user_id !== $user->id) {
            abort(403);
        }
    }
}
