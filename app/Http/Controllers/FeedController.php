<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\UserActivity;
use App\Models\UserPreferredCategory;
use Illuminate\Http\Request;

class FeedController extends Controller
{
    public function index(Request $request)
    {
        $userPreferredCategories = UserPreferredCategory::where('device_id', $request->device_id)->pluck('category_id')->toArray();
        $contents = Content::where('is_published', true)->when(
            count($userPreferredCategories),
            fn($q) =>
            $q->whereIn(
                'category_id',
                $userPreferredCategories
            )
        )
            ->orderBy('published_at', 'desc')
            ->paginate(3);
        $contentIds = $contents->pluck('id');
        $activities = UserActivity::query()
            ->where('device_id', $request->device_id)
            ->whereIn('content_id', $contentIds)
            ->get();
        $grouped = $activities->groupBy('content_id');
        $contents->getCollection()->transform(
            function ($content) use ($grouped) {

                $activitySet =
                    collect($grouped[$content->id] ?? [])
                    ->pluck('action');

                $content->is_liked =
                    $activitySet->contains('like');

                $content->is_saved =
                    $activitySet->contains('save');

                $content->is_viewed =
                    $activitySet->contains('view');

                return $content;
            }
        );
        return response()->json($contents);
    }

    public function saved(Request $request)
    {
        $activities = UserActivity::query()
            ->where('device_id', $request->device_id)
            ->where('action', 'save')->get();
        $contentIds = $activities->pluck('content_id');
        $contents = Content::whereIn('id', $contentIds)->paginate(5);
        $activities = UserActivity::query()
            ->where('device_id', $request->device_id)
            ->whereIn('content_id', $contentIds)
            ->get();
        $grouped = $activities->groupBy('content_id');
        $contents->getCollection()->transform(
            function ($content) use ($grouped) {

                $activitySet =
                    collect($grouped[$content->id] ?? [])
                    ->pluck('action');

                $content->is_liked =
                    $activitySet->contains('like');

                $content->is_saved =
                    $activitySet->contains('save');

                $content->is_viewed =
                    $activitySet->contains('view');

                return $content;
            }
        );
        return response()->json($contents);
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $categories = $request->input('categories', []);
        if (is_string($categories)) {
            $categories = explode(',', $categories);
        }
        $contents = Content::where('is_published', true)->when(
            count($categories),
            fn($q) =>
            $q->whereIn(
                'category_id',
                $categories
            )
        )->where(function ($q) use ($query) {
            $q->where('title', 'like', "%$query%");
        })
            ->orderBy('published_at', 'desc')
            ->paginate(5);
        $contentIds = $contents->pluck('id');
        $activities = UserActivity::query()
            ->where('device_id', $request->device_id)
            ->whereIn('content_id', $contentIds)
            ->get();
        $grouped = $activities->groupBy('content_id');
        $contents->getCollection()->transform(
            function ($content) use ($grouped) {

                $activitySet =
                    collect($grouped[$content->id] ?? [])
                    ->pluck('action');

                $content->is_liked =
                    $activitySet->contains('like');

                $content->is_saved =
                    $activitySet->contains('save');

                $content->is_viewed =
                    $activitySet->contains('view');

                return $content;
            }
        );
        return response()->json($contents);
    }
}
