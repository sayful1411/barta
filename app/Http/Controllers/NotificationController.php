<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function showAllNotification()
    {
        auth()->user()->unreadNotifications()->update(['read_at' => now()]);
        return view('pages.notification');
    }

    // public function unreadNotifications()
    // {
    //     $unreadNotification = auth()->user()->unreadNotifications()->get();
    //     dd($unreadNotification);
    // }
}
