<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\QueryInformation;
use Illuminate\Support\Facades\DB;

class QueryController extends Controller
{
    public function saveQuery (Request $request)
    {
        if(!$request->name){
            return response()->json([
                'status' => false,
                'message' => 'Please, fill the form properly!',
                'data' => []
            ], 409);
        }

        try {
            QueryInformation::create($request->all());
            return response()->json([
                'status' => true,
                'message' => 'Query has been submitted successfully',
                'data' => []
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
                'data' => []
            ], 200);
        }
    }
}
