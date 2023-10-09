<?php

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\MasterSettingsController;
use App\Http\Controllers\ClassInformationController;
use App\Http\Controllers\ChapterController;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\QueryController;


Route::post('/auth/register', [AuthController::class, 'registerUser']);
Route::post('/auth/login', [AuthController::class, 'loginUser']);
Route::get('country-list', [MasterSettingsController::class, 'countryList']);

Route::middleware(['auth:sanctum'])->group( function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('get-profile', [AuthController::class, 'getProfile']);
    Route::post('profile-update', [AuthController::class, 'updateUser']);

    Route::group(['prefix' => 'admin'], function(){
        //Class
        Route::get('class-list', [ClassInformationController::class, 'getAllClassList']);
        Route::post('class-save-or-update', [ClassInformationController::class, 'saveOrUpdateClass']);
        Route::post('class-delete', [ClassInformationController::class, 'deleteClassInformation']);

        //Chapter 
        Route::get('chapter-list', [ChapterController::class, 'getChapterList']);
        Route::get('chapter-list-by-id/{class_id}', [ChapterController::class, 'getChapterListByClassID']);
    });

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
    Route::post('search-topic', [TopicController::class, 'searchTopicList']);

    //Store
    Route::get('store-list', [ShopController::class, 'getStoreList']);

    //Notification 
    Route::get('notification-list', [NotificationController::class, 'getNotificationList']);

    //FAQ
    Route::get('faq-list', [FaqController::class, 'getFAQList']);

    //Submit Query
    Route::middleware('throttle:submitQuery')->group(function () {
        Route::post('submit-query', [QueryController::class, 'saveQuery']);
    });
    
});

Route::post('trancate-data', [MasterSettingsController::class, 'trancateData']);

Route::any('{url}', function(){
    return response()->json([
        'status' => false,
        'message' => 'Route Not Found!',
        'data' => []
    ], 404);
})->where('url', '.*');
