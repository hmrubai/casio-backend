<?php

namespace App\Http\Controllers;

use App\Models\ClassInformation;
use App\Models\Chapter;
use App\Models\Topic;
use App\Models\OsdList;
use App\Models\StoreInformation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShopController extends Controller
{
    public function getStoreList(Request $request)
    {
        $store = StoreInformation::orderBy('store_name', 'ASC')->get();

        return response()->json([
            'status' => true,
            'message' => 'Store List Successful!',
            'data' => $store
        ], 200);
    }

    public function getOsdList(Request $request)
    {
        $store = OsdList::orderBy('dealer_name', 'ASC')->get();

        return response()->json([
            'status' => true,
            'message' => 'OSD List Successful!',
            'data' => $store
        ], 200);
    }
}
