<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $notifications = $request->user()->unreadNotifications;

        return view('notifications.index', compact('notifications'));
    }

    public function show(Request $request, string $notificationId)
    {
        $notification = $request->user()->notifications()->findOrFail($notificationId);

        return view('notifications.show', compact('notification'));
    }

    public function markRead(Request $request, string $notificationId)
    {
        $notification = $request->user()->notifications()->findOrFail($notificationId);
        $notification->markAsRead();

        return redirect()->route('notifications.index');
    }
}
