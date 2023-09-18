<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\MasterSettingsController;
use App\Http\Controllers\ClassInformationController;
use App\Http\Controllers\ChapterController;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\ShopController;


Route::post('/auth/register', [AuthController::class, 'registerUser']);
Route::post('/auth/login', [AuthController::class, 'loginUser']);
Route::get('country-list', [MasterSettingsController::class, 'countryList']);

Route::middleware('auth:sanctum')->group( function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('get-profile', [AuthController::class, 'getProfile']);
    Route::post('profile-update', [AuthController::class, 'updateUser']);

});

Route::group(['prefix' => 'open'], function(){

    //Class
    Route::get('class-list', [ClassInformationController::class, 'getClassList']);


    //Chapter
    Route::get('chapter-list', [ChapterController::class, 'getChapterList']);
    Route::get('chapter-list-by-id/{class_id}', [ChapterController::class, 'getChapterListByClassID']);

    //Topic
    Route::get('topic-list', [TopicController::class, 'getTopicList']);
    Route::post('filter-topic-list', [TopicController::class, 'getTopicListByFilter']);

    //Store
    Route::get('store-list', [ShopController::class, 'getStoreList']);

});

Route::post('trancate-data', [MasterSettingsController::class, 'trancateData']);

Route::any('{url}', function(){
    return response()->json([
        'status' => false,
        'message' => 'Route Not Found!',
        'data' => []
    ], 404);
})->where('url', '.*');
