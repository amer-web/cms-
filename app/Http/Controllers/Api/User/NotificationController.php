<?php

namespace App\Http\Controllers\Api\User;

use App\Helper\ResponseMessages;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    use ResponseMessages;
    public function getNotifications()
    {
        $allNotifications = [
            'read' => Auth::guard('api')->user()->readNotifications->take(3),
            'readCount' => Auth::guard('api')->user()->readNotifications->count(),
            'unread' => Auth::guard('api')->user()->unreadNotifications,
            'unreadCount' => Auth::guard('api')->user()->unreadNotifications->count(),
        ];
        return $this->returnDate('notifications', $allNotifications,'success');
    }
    public function markAsRead()
    {
         Auth::guard('api')->user()->unreadNotifications->markAsRead();
         return $this->msgSuccess('success');
    }
}
