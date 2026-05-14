<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\FeedController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/test', function () {
    return response()->json(['message' => 'Hello, World!']);
});

Route::group(['prefix' => 'categories'], function () {
    Route::get('/', [CategoryController::class, 'index']);
    Route::post('/', [CategoryController::class, 'store']);
    Route::get('/{category}', [CategoryController::class, 'show']);
    Route::post('/{category}/update', [CategoryController::class, 'update']);
    Route::delete('/{category}', [CategoryController::class, 'destroy']);
});

Route::group(['prefix' => 'contents'], function () {
    Route::get('/', [ContentController::class, 'index']);
    Route::post('/', [ContentController::class, 'store']);
    Route::get('/{content}', [ContentController::class, 'show']);
    Route::post('/{content}/update', [ContentController::class, 'update']);
    Route::delete('/{content}', [ContentController::class, 'destroy']);
});

Route::get('/feed', [FeedController::class, 'index']);
Route::get('/saved', [FeedController::class, 'saved']);

Route::post('/activities/toggle', [ActivityController::class, 'toggle']);
Route::post('/activities/view', [ActivityController::class, 'view']);
