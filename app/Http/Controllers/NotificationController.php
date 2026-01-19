<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $notifications = $request->user()->unreadNotifications()->latest()->paginate(5);

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

    public function unread(Request $request)
    {
        $notifications = $request->user()->unreadNotifications()->latest()->take(10)->get();

        return response()->json([
            'count' => $request->user()->unreadNotifications()->count(),
            'notifications' => $notifications->map(function ($notification) {
                $title = $notification->data['title'] ?? 'Уведомление';
                $message = $notification->data['message'] ?? ($notification->data['thing_name'] ?? '');

                return [
                    'id' => $notification->id,
                    'title' => $title,
                    'message' => $message,
                    'created_at' => $notification->created_at->diffForHumans(),
                ];
            })->values(),
        ]);
    }
}
