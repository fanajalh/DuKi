<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $notifications = Notification::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->take(30)
            ->get();

        // Mark all as read
        Notification::where('user_id', $user->id)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return view('notifications.index', compact('notifications', 'user'));
    }

    /**
     * Get unread count (for badge)
     */
    public static function unreadCount()
    {
        if (!Auth::check()) return 0;
        return Notification::where('user_id', Auth::id())
            ->where('is_read', false)
            ->count();
    }
}
