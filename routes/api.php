<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
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

Route::group(['prefix' => 'categories'], function () {
    Route::get('/', [CategoryController::class, 'index'])->middleware('auth:sanctum');
    Route::post('/', [CategoryController::class, 'store'])->middleware('auth:sanctum');
    Route::get('/{category}', [CategoryController::class, 'show'])->middleware('auth:sanctum');
    Route::post('/{category}/update', [CategoryController::class, 'update'])->middleware('auth:sanctum');
    Route::post('/{category}/toggle-preference', [CategoryController::class, 'togglePreference'])->middleware('auth:sanctum');
    Route::delete('/{category}', [CategoryController::class, 'destroy'])->middleware('auth:sanctum');
});

Route::group(['prefix' => 'contents'], function () {
    Route::get('/', [ContentController::class, 'index'])->middleware('auth:sanctum');
    Route::post('/', [ContentController::class, 'store'])->middleware('auth:sanctum');
    Route::get('/{content}', [ContentController::class, 'show'])->middleware('auth:sanctum');
    Route::post('/{content}/update', [ContentController::class, 'update'])->middleware('auth:sanctum');
    Route::delete('/{content}', [ContentController::class, 'destroy'])->middleware('auth:sanctum');
});

Route::group(['prefix' => 'activities', 'middleware' => 'sanctum'], function () {
    Route::post('/toggle', [ActivityController::class, 'toggle']);
    Route::post('/view', [ActivityController::class, 'view']);
});

Route::get('/feed', [FeedController::class, 'index'])->middleware('auth:sanctum');
Route::get('/saved', [FeedController::class, 'saved'])->middleware('auth:sanctum');
Route::get('/search', [FeedController::class, 'search'])->middleware('auth:sanctum');
