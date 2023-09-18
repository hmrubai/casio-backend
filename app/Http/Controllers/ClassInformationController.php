<?php

namespace App\Http\Controllers;

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
}
