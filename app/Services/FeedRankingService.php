<?php

namespace App\Services;

use App\Models\Content;
use App\Models\UserActivity;
use App\Models\UserCategoryScore;
use App\Models\UserPreferredCategory;

class FeedRankingService
{
    public function rank(
        string $deviceId,
        int $page = 1,
        int $perPage = 10
    ) {
        // USER CATEGORY INTERESTS
        $categoryScores =
            UserCategoryScore::where(
                'device_id',
                $deviceId
            )
            ->pluck('score', 'category_id')
            ->toArray();

        // SEEN CONTENTS
        $userActivities =
            UserActivity::where(
                'device_id',
                $deviceId
            )
            ->get();

        $likedIds = $userActivities
            ->where('action', 'like')
            ->pluck('content_id')
            ->flip();

        $savedIds = $userActivities
            ->where('action', 'save')
            ->pluck('content_id')
            ->flip();

        $viewedIds = $userActivities
            ->where('action', 'view')
            ->pluck('content_id')
            ->flip()
            ->toArray();

        $preferredCategoryIds =
            UserPreferredCategory::where(
                'device_id',
                $deviceId
            )
            ->pluck('category_id')
            ->flip()
            ->toArray();

        // FETCH CANDIDATES
        $contents = Content::query()
            ->where('is_published', true)

            // avoid seen contents
            // ->whereNotIn('id', $seenContentIds)

            // recent pool
            ->latest()

            ->limit(100)

            ->get();

        // CALCULATE SCORES
        $ranked = $contents->map(function (
            $content
        ) use (
            $deviceId,
            $categoryScores,
            $likedIds,
            $savedIds,
            $viewedIds,
            $preferredCategoryIds
        ) {

            $content->ranking_score =
                $this->calculateScore(
                    $deviceId,
                    $content,
                    $categoryScores,
                    $viewedIds,
                    $preferredCategoryIds
                );

            $content->is_liked =
                isset($likedIds[$content->id]);

            $content->is_saved =
                isset($savedIds[$content->id]);

            $content->is_viewed =
                isset($viewedIds[$content->id]);

            return $content;
        });

        $ranked = $ranked
            ->sortByDesc('ranking_score')
            ->values();

        $offset = ($page - 1) * $perPage;

        $paginated = $ranked
            ->slice($offset, $perPage)
            ->values();

        return [
            'data' => $paginated,
            'current_page' => $page,
            'per_page' => $perPage,
            'total' => $ranked->count(),
            'last_page' => (int) ceil($ranked->count() / $perPage),
            'has_more' =>
            $ranked->count() >
                ($offset + $perPage),
        ];

        // SORT
        /* return $ranked
            ->sortByDesc('ranking_score')
            ->values(); */
    }

    private function calculateScore(
        string $deviceId,
        Content $content,
        array $categoryScores,
        array $viewedIds,
        array $preferredCategoryIds
    ): float {

        $score = 0;

        // CATEGORY AFFINITY
        $score +=
            $categoryScores[$content->category_id] ?? 0;

        // POPULARITY
        $score +=
            sqrt($content->like_count) * 4;

        $score +=
            sqrt($content->save_count) * 6;

        $score +=
            sqrt($content->view_count) * 1.5;

        // RATING
        $score +=
            ($content->rating * 5);

        if (
            isset(
                $preferredCategoryIds[$content->category_id]
            )
        ) {
            $score += 15;
        }

        // FRESHNESS
        $hoursOld =
            now()->diffInHours(
                $content->created_at
            );

        $freshness =
            max(0, 72 - $hoursOld);

        $score += $freshness;
        if (isset($viewedIds[$content->id])) {
            $score -= 25;
        }

        // EXPLORATION BONUS
        $score += crc32(
            $content->id . $deviceId
        ) % 10;

        return $score;
    }
}
