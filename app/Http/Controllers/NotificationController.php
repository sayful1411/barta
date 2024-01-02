<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function showAllNotification()
    {
        auth()->user()->unreadNotifications()->update(['read_at' => now()]);
        $notifications = auth()->user()->notifications()->get();
        return view('pages.notification', compact('notifications'));
    }
}
