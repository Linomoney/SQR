<?php

namespace App\Http\Controllers\Ustadz;

use App\Http\Controllers\Controller;
use App\Models\SqrNotification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $userId = auth()->id();
        $notifications = SqrNotification::where(function ($q) use ($userId) {
            $q->where('user_id', $userId)
              ->orWhere('target_role', 'ustadz')
              ->orWhere('target_role', 'all');
        })->latest()->paginate(15);

        return view('ustadz.notifications.index', compact('notifications'));
    }

    public function markRead(SqrNotification $notification)
    {
        $userId = auth()->id();
        if ($notification->user_id === $userId || in_array($notification->target_role, ['ustadz', 'all'])) {
            $notification->update(['is_read' => true]);
        }
        return back();
    }

    public function markAllRead()
    {
        $userId = auth()->id();
        SqrNotification::where(function ($q) use ($userId) {
            $q->where('user_id', $userId)
              ->orWhere('target_role', 'ustadz')
              ->orWhere('target_role', 'all');
        })->update(['is_read' => true]);

        return back()->with('success', 'Semua notifikasi telah ditandai dibaca.');
    }
}
