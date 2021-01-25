<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class NotificationsUserController extends Controller
{
    public function getNotifications()
    {

        return [
            'read' => Auth::user()->readNotifications->take(3),
            'readcount' => Auth::user()->readNotifications->count(),
            'unread' => Auth::user()->unreadNotifications,
            'unreadcount' => Auth::user()->unreadNotifications->count(),
        ];
    }

    public function markAsRead()
    {
        return Auth::user()->unreadNotifications->markAsRead();
    }


}
