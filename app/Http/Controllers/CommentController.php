<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Content;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Content $content)
    {
        $validated = $request->validate([
            'parent_id' => 'nullable|exists:comments,id',
            'body' => 'required|string|max:255',
        ]);
        $user = auth()->user();
        $validated['user_id'] = $user->id;
        $validated['content_id'] = $content->id;


        $comment = Comment::create($validated);
        $content->increment('comment_count');

        return response()->json($comment);
    }

    public function getContentComments(Request $request, Content $content)
    {
        $comments = $content->comments()->whereNull('parent_id')->with('replies')->get();
        return response()->json($comments);
    }
}
