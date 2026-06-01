<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DownloadController extends Controller
{
    public function apk(Request $request, $filename)
    {
        // Prevent path traversal
        $filename = basename($filename);

        // Allow only .apk files
        if (strtolower(pathinfo($filename, PATHINFO_EXTENSION)) !== 'apk') {
            abort(404);
        }

        $path = storage_path('app/private/apks/' . $filename);

        if (!file_exists($path)) {
            abort(404);
        }

        return response()->download($path, $filename, [
            'Content-Type' => 'application/vnd.android.package-archive',
        ]);
    }
}
