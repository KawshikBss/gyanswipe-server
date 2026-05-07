<?php

namespace App\Http\Controllers;

use App\Models\Content;
use Illuminate\Http\Request;

class FeedController extends Controller
{
    public function index()
    {
        $contents = Content::where('is_published', true)
            ->orderBy('published_at', 'desc')
            ->paginate(3);
        return response()->json($contents);
    }
}
