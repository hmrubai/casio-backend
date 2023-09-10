<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\MasterSettingsController;


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
    // Package 
    //Route::get('package-list', [PackageController::class, 'packageList']);/
});

Route::post('trancate-data', [MasterSettingsController::class, 'trancateData']);

Route::any('{url}', function(){
    return response()->json([
        'status' => false,
        'message' => 'Route Not Found!',
        'data' => []
    ], 404);
})->where('url', '.*');
