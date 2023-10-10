<?php

namespace App\Http\Controllers;

use Exception;
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

    public function saveOrUpdateTopic (Request $request)
    {
        $request_param = json_decode($request->data);

        try {
            $thumbnail_url = null;
            if($request->hasFile('thumbnail')){
                $image = $request->file('thumbnail');
                $time = time();
                $thumbnail_image = "thumbnail_image_" . $time . '.' . $image->getClientOriginalExtension();
                $destination = 'uploads/thumbnail';
                $image->move($destination, $thumbnail_image);
                $thumbnail_url = $destination . '/' . $thumbnail_image;
            }

            $user_id = $request->user()->id;

            if($request_param->id){
                Topic::where('id', $request_param->id)->update([
                    "title" => $request_param->title,
                    "title_bn" => $request_param->title,
                    "description" => $request_param->description,
                    "description_bn" => $request_param->description,
                    "class_id" => $request_param->class_id,
                    "chapter_id" => $request_param->chapter_id,
                    "created_by" => $user_id,
                    "author_name" => $request_param->author_name,
                    "author_details" => $request_param->author_details,
                    "raw_url" => $request_param->raw_url,
                    "s3_url" => $request_param->s3_url,
                    "youtube_url" => $request_param->youtube_url,
                    "download_url" => $request_param->download_url,
                    "thumbnail" => $thumbnail_url,
                    "duration" => $request_param->duration,
                    "rating" => $request_param->rating,
                    "sequence" => $request_param->sequence,
                    "is_active" => $request_param->is_active
                ]);

                return response()->json([
                    'status' => true,
                    'message' => 'Topic has been updated successfully',
                    'data' => []
                ], 200);

            } else {
                $isExist = Topic::where('title', $request_param->title)->where('class_id', $request_param->class_id)->first();
                if (empty($isExist)) {
                    Topic::create([
                        "title" => $request_param->title,
                        "title_bn" => $request_param->title,
                        "description" => $request_param->description,
                        "description_bn" => $request_param->description,
                        "class_id" => $request_param->class_id,
                        "chapter_id" => $request_param->chapter_id,
                        "created_by" => $user_id,
                        "author_name" => $request_param->author_name,
                        "author_details" => $request_param->author_details,
                        "raw_url" => $request_param->raw_url,
                        "s3_url" => $request_param->s3_url,
                        "youtube_url" => $request_param->youtube_url,
                        "download_url" => $request_param->download_url,
                        "thumbnail" => $thumbnail_url,
                        "duration" => $request_param->duration,
                        "rating" => $request_param->rating,
                        "sequence" => $request_param->sequence,
                        "is_active" => $request_param->is_active
                    ]);

                    return response()->json([
                        'status' => true,
                        'message' => 'Topic has been created successfully',
                        'data' => []
                    ], 200);
                }else{
                    return response()->json([
                        'status' => false,
                        'message' => 'Topic already Exist!',
                        'data' => []
                    ], 400);
                }
            }

        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
                'data' => []
            ], 400);
        }
    }

    public function deleteTopic(Request $request)
    {
        if(!$request->id){
            return response()->json([
                'status' => false,
                'message' => 'Please, attach ID',
                'data' => []
            ], 400);
        }

        $topic = Topic::where('id', $request->id)->first();

        if($topic->thumbnail){
            unlink($topic->thumbnail);
        }

        $topic->delete();

        return response()->json([
            'status' => true,
            'message' => 'Topic has been deleted successful',
            'data' => []
        ], 200);
    }
}
