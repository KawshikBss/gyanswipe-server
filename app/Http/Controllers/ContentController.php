<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\UserActivity;
use Illuminate\Http\Request;

class ContentController extends Controller
{
    public function index()
    {
        $contents = Content::paginate(10);
        return response()->json($contents);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:contents',
            'body' => 'required|array',
            'thumbnail' => 'nullable|image|max:2048',
            'category_id' => 'required|exists:categories,id',
            'type' => 'required|string|max:50',
            'duration_seconds' => 'nullable|numeric',
            'rating' => 'nullable|numeric|min:0|max:5',
            'is_published' => 'boolean',
            'published_at' => 'nullable|date',
        ]);

        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('thumbnails', 'public');
            $data["thumbnail"] = $path;
        }

        $content = Content::create($data);

        return response()->json($content, 201);
    }

    public function show(Request $request, Content $content)
    {
        $activities = UserActivity::query()
            ->where('device_id', $request->device_id)
            ->where('content_id', $content->id)
            ->get();
        $activitySet = $activities->pluck('action');
        $content->is_liked = $activitySet->contains('like');
        $content->is_saved = $activitySet->contains('save');
        $content->is_viewed = $activitySet->contains('view');
        return response()->json($content);
    }

    public function update(Request $request, Content $content)
    {
        $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'slug' => 'sometimes|required|string|max:255|unique:contents,slug,' . $content->id,
            'body' => 'sometimes|required|array',
            'thumbnail' => 'nullable|image|max:2048',
            'category_id' => 'sometimes|required|exists:categories,id',
            'type' => 'sometimes|required|string|max:50',
            'duration_seconds' => 'nullable|numeric',
            'rating' => 'nullable|numeric|min:0|max:5',
            'is_published' => 'boolean',
            'published_at' => 'nullable|date',
        ]);

        if ($request->has('title')) {
            $content->title = $request->title;
        }
        if ($request->has('slug')) {
            $content->slug = $request->slug;
        }
        if ($request->has('body')) {
            $content->body = $request->body;
        }
        if ($request->has('category_id')) {
            $content->category_id = $request->category_id;
        }
        if ($request->has('type')) {
            $content->type = $request->type;
        }
        if ($request->has('duration_seconds')) {
            $content->duration_seconds = $request->duration_seconds;
        }
        if ($request->has('rating')) {
            $content->rating = $request->rating;
        }
        if ($request->has('is_published')) {
            $content->is_published = $request->is_published;
        }
        if ($request->has('published_at')) {
            $content->published_at = $request->published_at;
        }
        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('thumbnails', 'public');
            $content->thumbnail = $path;
        }

        $content->save();

        return response()->json($content);
    }

    public function destroy(Content $content)
    {
        $content->delete();
        return response()->json(['message' => 'Content deleted successfully'], 204);
    }
}
