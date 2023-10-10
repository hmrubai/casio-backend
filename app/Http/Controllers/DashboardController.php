<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Topic;
use App\Models\Chapter;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\ClassInformation;
use App\Models\StoreInformation;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function getDashbaordSummary(Request $request)
    {
        $topic = Topic::all();
        $chapter = Chapter::all();
        $class_list = ClassInformation::all();
        $notification_count = Notification::get()->count();
        $notifications = Notification::take(3)->orderBy('id', 'DESC')->get();
        $store = StoreInformation::get()->count();

        $response = [
           'topic_count' => $topic->count(),
           'chapter_count' => $chapter->count(),
           'class_count' => $class_list->count(),
           'store_count' => $store,
           'notification_count' => $notification_count,
           'top_notification_list' => $notifications,
           'class_list' => $class_list
        ];

        return response()->json([
            'status' => true,
            'message' => 'Successful!',
            'data' => $response
        ], 200);
    }
}
