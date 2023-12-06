<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\ClassInformation;
use App\Models\Chapter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChapterController extends Controller
{
    public function getChapterList(Request $request)
    {
        $chapter = Chapter::select('chapters.*', 'class_information.name as class_name')
        ->leftJoin('class_information', 'class_information.id', 'chapters.class_id')
        ->orderBy('chapters.name', 'ASC')
        ->get();

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

        $chapter = Chapter::select('chapters.*', 'class_information.name as class_name')
        ->leftJoin('class_information', 'class_information.id', 'chapters.class_id')
        ->where('chapters.class_id', $class_id)
        ->orderBy('chapters.name', 'ASC')
        ->get();

        return response()->json([
            'status' => true,
            'message' => 'Chapter List Successful!',
            'data' => $chapter
        ], 200);
    }

    public function saveOrUpdateChapter (Request $request)
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
                Chapter::where('id', $request_param->id)->update([
                    "name" => $request_param->name,
                    "name_bn" => $request_param->name_bn,
                    "description" => $request_param->description,
                    "description_bn" => $request_param->description_bn,
                    "class_id" => $request_param->class_id,
                    "created_by" => $user_id,
                    "thumbnail" => $thumbnail_url,
                    "is_active" => $request_param->is_active
                ]);

                return response()->json([
                    'status' => true,
                    'message' => 'Chapter has been updated successfully',
                    'data' => []
                ], 200);

            } else {
                $isExist = Chapter::where('name', $request_param->name)->where('class_id', $request_param->class_id)->first();
                if (empty($isExist)) {
                    Chapter::create([
                        "name" => $request_param->name,
                        "name_bn" => $request_param->name_bn,
                        "description" => $request_param->description,
                        "description_bn" => $request_param->description_bn,
                        "class_id" => $request_param->class_id,
                        "created_by" => $user_id,
                        "thumbnail" => $thumbnail_url,
                        "is_active" => $request_param->is_active
                    ]);

                    return response()->json([
                        'status' => true,
                        'message' => 'Chapter has been created successfully',
                        'data' => []
                    ], 200);
                }else{
                    return response()->json([
                        'status' => false,
                        'message' => 'Chapter already Exist!',
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

    public function deleteChapterInformation(Request $request)
    {
        if(!$request->id){
            return response()->json([
                'status' => false,
                'message' => 'Please, attach ID',
                'data' => []
            ], 400);
        }

        $chapter = Chapter::where('id', $request->id)->first();

        if($chapter->thumbnail){
            unlink($chapter->thumbnail);
        }

        $chapter->delete();

        return response()->json([
            'status' => true,
            'message' => 'Chapter has been deleted successful',
            'data' => []
        ], 200);
    }
}

