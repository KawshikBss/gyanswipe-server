<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\UserActivity;
use Illuminate\Http\Request;

class FeedController extends Controller
{
    public function index(Request $request)
    {
        $contents = Content::where('is_published', true)
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
}
