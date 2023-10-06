<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NotificationController extends Controller
{
    public function getNotificationList(Request $request)
    {
        $notification = Notification::orderBy('title', 'ASC')->get();

        return response()->json([
            'status' => true,
            'message' => 'Notification List Successful!',
            'data' => $notification
        ], 200);
    }
}
