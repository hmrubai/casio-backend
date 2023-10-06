<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\ClassInformation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClassInformationController extends Controller
{
    public function getClassList(Request $request)
    {
        $class = ClassInformation::orderBy('name', 'ASC')->get();

        return response()->json([
            'status' => true,
            'message' => 'Class List Successful!',
            'data' => $class
        ], 200);
    }

    public function getAllClassList(Request $request)
    {
        $class = ClassInformation::orderBy('name', 'ASC')->get();

        return response()->json([
            'status' => true,
            'message' => 'Class List Successful!',
            'data' => $class
        ], 200);
    }

    public function saveOrUpdateClass (Request $request)
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
                ClassInformation::where('id', $request_param->id)->update([
                    "name" => $request_param->name,
                    "name_bn" => $request_param->name_bn,
                    "description" => $request_param->description,
                    "description_bn" => $request_param->description_bn,
                    "created_by" => $user_id,
                    "thumbnail" => $thumbnail_url,
                    "is_active" => $request_param->is_active
                ]);

                return response()->json([
                    'status' => true,
                    'message' => 'Class has been updated successfully',
                    'data' => []
                ], 200);

            } else {
                $isExist = ClassInformation::where('name', $request_param->name)->first();
                if (empty($isExist)) {
                    ClassInformation::create([
                        "name" => $request_param->name,
                        "name_bn" => $request_param->name_bn,
                        "description" => $request_param->description,
                        "description_bn" => $request_param->description_bn,
                        "created_by" => $user_id,
                        "thumbnail" => $thumbnail_url,
                        "is_active" => $request_param->is_active
                    ]);

                    return response()->json([
                        'status' => true,
                        'message' => 'Class has been created successfully',
                        'data' => []
                    ], 200);
                }else{
                    return response()->json([
                        'status' => false,
                        'message' => 'Class already Exist!',
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

    public function deleteClassInformation(Request $request)
    {
        if(!$request->id){
            return response()->json([
                'status' => false,
                'message' => 'Please, attach ID',
                'data' => []
            ], 400);
        }

        $class = ClassInformation::where('id', $request->id)->first();

        if($class->thumbnail){
            unlink($class->thumbnail);
        }

        $class->delete();

        return response()->json([
            'status' => true,
            'message' => 'Class has been deleted successful',
            'data' => []
        ], 200);
    }
}
