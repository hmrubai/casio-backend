<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FaqController extends Controller
{
    public function getFAQList(Request $request)
    {
        $faq = Faq::orderBy('title', 'ASC')->get();

        return response()->json([
            'status' => true,
            'message' => 'FAQ List Successful!',
            'data' => $faq
        ], 200);
    }
}
