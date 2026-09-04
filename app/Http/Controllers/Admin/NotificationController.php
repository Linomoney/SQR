<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SqrNotification;
use App\Models\User;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        // 1. Notifikasi Khusus Masuk Admin (PPDB Online, SPP Verification)
        $adminNotifications = SqrNotification::forAdmin()->latest()->paginate(10, ['*'], 'admin_page');

        // Automatically mark admin notifications as read when opening notification page
        SqrNotification::forAdmin()->unread()->update(['is_read' => true]);

        // 2. Log Broadcast Notifikasi ke Pengguna/Role (Semua Pengguna, Ustadz, Wali, User Spesifik)
        $broadcastLogs = SqrNotification::with('user')
            ->where(function($q) {
                $q->whereIn('target_role', ['all', 'ustadz', 'wali'])
                  ->orWhereNotNull('user_id');
            })
            ->latest()
            ->paginate(10, ['*'], 'broadcast_page');

        $users = User::orderBy('name')->get();

        return view('admin.notifications.index', compact('adminNotifications', 'broadcastLogs', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'target'  => 'required|string',
            'title'   => 'required|string|max:255',
            'message' => 'required|string',
            'type'    => 'required|string|max:50',
        ]);

        $target = $request->target;
        $userId = null;
        $targetRole = null;

        if ($target === 'all' || $target === 'ustadz' || $target === 'wali') {
            $targetRole = $target;
        } elseif (str_starts_with($target, 'user_')) {
            $userId = (int) str_replace('user_', '', $target);
        }

        SqrNotification::create([
            'user_id'     => $userId,
            'target_role' => $targetRole,
            'title'       => $request->title,
            'message'     => $request->message,
            'type'        => $request->type,
            'is_read'     => false,
        ]);

        return back()->with('success', 'Notifikasi broadcast berhasil dikirimkan!');
    }

    public function markAllRead()
    {
        SqrNotification::forAdmin()->unread()->update(['is_read' => true]);
        return back()->with('success', 'Semua notifikasi admin telah ditandai sebagai dibaca.');
    }

    public function destroy(SqrNotification $notification)
    {
        $notification->delete();
        return back()->with('success', 'Notifikasi telah dihapus.');
    }
}
