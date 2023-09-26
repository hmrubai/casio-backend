<?php

namespace App\Http\Controllers;

use App\Models\ClassInformation;
use App\Models\Chapter;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TopicController extends Controller
{
    public function getTopicList(Request $request)
    {
        $topic = Topic::orderBy('title', 'ASC')->get();

        return response()->json([
            'status' => true,
            'message' => 'Topic List Successful!',
            'data' => $topic
        ], 200);
    }

    public function getTopicListByFilter(Request $request)
    {
        $class_id = $request->class_id ? $request->class_id : 0;
        $chapter_id = $request->chapter_id ? $request->chapter_id : 0;

        $topics = Topic::select('topics.*')
        ->when($class_id, function ($query, $class_id) {
            return $query->where('topics.class_id', $class_id);
        })
        ->when($chapter_id, function ($query, $chapter_id) {
            return $query->where('topics.chapter_id', $chapter_id);
        })
        ->orderBy('topics.title', 'ASC')
        ->get();

        return response()->json([
            'status' => true,
            'message' => 'Topic List Successful!',
            'data' => $topics
        ], 200);
    }

    public function searchTopicList(Request $request)
    {
        $text = $request->text ? $request->text : null;

        $topics = Topic::select('topics.*')
        ->where('topics.title', 'LIKE', '%'.$text.'%')
        ->orWhere('topics.description', 'LIKE', '%'.$text.'%')
        ->orderBy('topics.title', 'ASC')
        ->limit(5)
        ->get();

        return response()->json([
            'status' => true,
            'message' => 'Topic List Successful!',
            'data' => $topics
        ], 200);
    }
}
