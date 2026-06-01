<?php

use App\Http\Controllers\DownloadController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/apk/{filename}', [DownloadController::class, 'apk'])->name('apk.download');
