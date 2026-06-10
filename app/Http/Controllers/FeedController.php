<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\UserActivity;
use App\Services\FeedRankingService;
use App\Services\TranslationService;
use Illuminate\Http\Request;

class FeedController extends Controller
{
    public function __construct(
        protected FeedRankingService $feedRankingService,
        protected TranslationService $translationService
    ) {}
    public function index(Request $request)
    {
        $user = auth()->user();
        $userId = $user->id();
        $rankedContents = $this->feedRankingService->rank($userId, $request->input('page', 1), $request->input('per_page', 10), $request->input('lang', 'en'));
        return response()->json($rankedContents);
    }

    public function saved(Request $request)
    {
        $user = auth()->user();
        $userId = $user->id;
        $lang = $request->input('lang', 'en');
        $activities = UserActivity::query()
            ->where('user_id', $userId)
            ->where('action', 'save')->get();
        $contentIds = $activities->pluck('content_id');
        $contents = Content::whereIn('id', $contentIds)->paginate(5);
        $activities = UserActivity::query()
            ->where('user_id', $userId)
            ->whereIn('content_id', $contentIds)
            ->get();
        $grouped = $activities->groupBy('content_id');
        $contents->getCollection()->transform(
            function ($content) use ($grouped, $lang) {

                $activitySet =
                    collect($grouped[$content->id] ?? [])
                    ->pluck('action');

                $content->is_liked =
                    $activitySet->contains('like');

                $content->is_saved =
                    $activitySet->contains('save');

                $content->is_viewed =
                    $activitySet->contains('view');

                $translation =
                    $this->translationService
                    ->getTranslatedContent(
                        $content,
                        $lang
                    );

                $content->title =
                    $translation->title;

                $content->body =
                    $translation->body;

                return $content;
            }
        );
        return response()->json($contents);
    }

    public function search(Request $request)
    {
        $user = auth()->user();
        $userId = $user->id;
        $query = $request->input('query');
        $lang = $request->input('lang', 'en');
        $categories = $request->input('categories', []) ?? [];
        if (is_string($categories) && !empty($categories)) {
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
            ->where('user_id', $userId)
            ->whereIn('content_id', $contentIds)
            ->get();
        $grouped = $activities->groupBy('content_id');
        $contents->getCollection()->transform(
            function ($content) use ($grouped, $lang) {

                $activitySet =
                    collect($grouped[$content->id] ?? [])
                    ->pluck('action');

                $content->is_liked =
                    $activitySet->contains('like');

                $content->is_saved =
                    $activitySet->contains('save');

                $content->is_viewed =
                    $activitySet->contains('view');


                $translation =
                    $this->translationService
                    ->getTranslatedContent(
                        $content,
                        $lang
                    );

                $content->title =
                    $translation->title;

                $content->body =
                    $translation->body;
                return $content;
            }
        );
        return response()->json($contents);
    }
}
