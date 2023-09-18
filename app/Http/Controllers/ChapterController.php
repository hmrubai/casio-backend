<?php

namespace App\Http\Controllers;

use App\Models\ClassInformation;
use App\Models\Chapter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChapterController extends Controller
{
    public function getChapterList(Request $request)
    {
        $chapter = Chapter::orderBy('name', 'ASC')->get();

        return response()->json([
            'status' => true,
            'message' => 'Chapter List Successful!',
            'data' => $chapter
        ], 200);
    }

    public function getChapterListByClassID(Request $request)
    {
        $class_id = $request->class_id ? $request->class_id : 0;
        if(!$class_id) {
            return response()->json([
                'status' => false,
                'message' => 'Please, Attach class ID!',
                'data' => []
            ], 422);
        }

        $chapter = Chapter::where('class_id', $class_id)->orderBy('name', 'ASC')->get();

        return response()->json([
            'status' => true,
            'message' => 'Chapter List Successful!',
            'data' => $chapter
        ], 200);
    }
}
