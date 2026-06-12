<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\FeedController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/test', function () {
    return response()->json(['message' => 'Hello, World!']);
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/user', [AuthController::class, 'user'])->middleware('auth:sanctum');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::group(['prefix' => 'categories', 'middleware' => 'auth:sanctum'], function () {
    Route::get('/', [CategoryController::class, 'index']);
    Route::post('/', [CategoryController::class, 'store']);
    Route::get('/{category}', [CategoryController::class, 'show']);
    Route::post('/{category}/update', [CategoryController::class, 'update']);
    Route::post('/{category}/toggle-preference', [CategoryController::class, 'togglePreference']);
    Route::delete('/{category}', [CategoryController::class, 'destroy']);
});

Route::group(['prefix' => 'contents', 'middleware' => 'auth:sanctum'], function () {
    Route::get('/', [ContentController::class, 'index']);
    Route::post('/', [ContentController::class, 'store']);
    Route::get('/{content}', [ContentController::class, 'show']);
    Route::post('/{content}/update', [ContentController::class, 'update']);
    Route::post('{content}/comment', [CommentController::class, 'store']);
    Route::get('/{content}/comments', [CommentController::class, 'getContentComments']);
    Route::delete('/{content}', [ContentController::class, 'destroy']);
});

Route::group(['prefix' => 'activities', 'middleware' => 'auth:sanctum'], function () {
    Route::get('/', [ActivityController::class, 'index']);
    Route::post('/toggle', [ActivityController::class, 'toggle']);
    Route::post('/view', [ActivityController::class, 'view']);
});

Route::group(['prefix' => 'comments', 'middleware' => 'auth:sanctum'], function () {});

Route::get('/feed', [FeedController::class, 'index'])->middleware('auth:sanctum');
Route::get('/saved', [FeedController::class, 'saved'])->middleware('auth:sanctum');
Route::get('/search', [FeedController::class, 'search'])->middleware('auth:sanctum');
