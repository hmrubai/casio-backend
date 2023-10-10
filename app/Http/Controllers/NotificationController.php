<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NotificationController extends Controller
{
    public function getNotificationList(Request $request)
    {
        $notification = Notification::orderBy('id', 'DESC')->get();

        return response()->json([
            'status' => true,
            'message' => 'Notification List Successful!',
            'data' => $notification
        ], 200);
    }
    
    public function saveOrUpdateNotification (Request $request)
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
                Notification::where('id', $request_param->id)->update([
                    "title" => $request_param->title,
                    "description" => $request_param->description,
                    "thumbnail" => $thumbnail_url,
                    "is_active" => $request_param->is_active
                ]);

                return response()->json([
                    'status' => true,
                    'message' => 'Notification has been updated successfully',
                    'data' => []
                ], 200);

            } else {
                $isExist = Notification::where('title', $request_param->title)->first();
                if (empty($isExist)) {
                    Notification::create([
                        "title" => $request_param->title,
                        "description" => $request_param->description,
                        "thumbnail" => $thumbnail_url,
                        "is_active" => $request_param->is_active
                    ]);

                    return response()->json([
                        'status' => true,
                        'message' => 'Notification has been created successfully',
                        'data' => []
                    ], 200);
                }else{
                    return response()->json([
                        'status' => false,
                        'message' => 'Notification already Exist!',
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

    public function deleteNotification(Request $request)
    {
        if(!$request->id){
            return response()->json([
                'status' => false,
                'message' => 'Please, attach ID',
                'data' => []
            ], 400);
        }

        $class = Notification::where('id', $request->id)->first();

        if($class->thumbnail){
            unlink($class->thumbnail);
        }

        $class->delete();

        return response()->json([
            'status' => true,
            'message' => 'Notification has been deleted successful',
            'data' => []
        ], 200);
    }
}
