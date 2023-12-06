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
        $notification_count = Notification::get()->count();
        $notifications = Notification::take(3)->orderBy('id', 'DESC')->get();
        $topic_list = Topic::take(3)->orderBy('id', 'DESC')->get();
        $chapter_list = Chapter::take(5)->orderBy('id', 'DESC')->get();
        $store = StoreInformation::get()->count();

        $response = [
           'topic_list' => $topic_list,
           'topic_count' => $topic->count(),
           'chapter_list' => $chapter_list,
           'chapter_count' => $chapter->count(),
           'class_count' => 0,
           'store_count' => $store,
           'notification_count' => $notification_count,
           'top_notification_list' => $notifications,
           'class_list' => []
        ];

        return response()->json([
            'status' => true,
            'message' => 'Successful!',
            'data' => $response
        ], 200);
    }
}
