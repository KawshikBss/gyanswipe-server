<?php

namespace App\Services;

use App\Models\Content;
use App\Models\UserActivity;
use Illuminate\Support\Facades\DB;

class ActivityService
{
    public function toggle(
        string $deviceId,
        int $contentId,
        string $action,
        float $durationSeconds,
        string $source = 'feed',
    ): array {

        $counterField = match ($action) {
            'like' => 'like_count',
            'save' => 'save_count',
        };

        return DB::transaction(function () use (
            $deviceId,
            $contentId,
            $action,
            $counterField,
            $durationSeconds,
            $source,
        ) {

            $existing = UserActivity::where([
                'device_id' => $deviceId,
                'content_id' => $contentId,
                'action' => $action,
            ])->first();

            $content = Content::findOrFail($contentId);

            if ($existing) {

                $existing->delete();

                $content->decrement($counterField);

                return [
                    'active' => false,
                    'message' => 'Content removed',
                ];
            }

            $completionPercent = null;
            if ($source === 'details') {
                $totalDuration = $content->duration_seconds;
                if ($totalDuration > 0) {
                    $completionPercent = min(100, ($durationSeconds / $totalDuration) * 100);
                }
            }

            UserActivity::create([
                'device_id' => $deviceId,
                'content_id' => $contentId,
                'category_id' => $content->category_id,
                'action' => $action,
                'duration_seconds' => $durationSeconds,
                'completion_percent' => $completionPercent,
                'source' => $source,
            ]);

            app(CategoryAffinityService::class)->update(
                $deviceId,
                $content->category_id,
                $action,
                $durationSeconds,
                $completionPercent,
                $source
            );

            $content->increment($counterField);

            return [
                'active' => true,
                'message' => 'Content ' . $action . 'd',
            ];
        });
    }

    public function trackView(
        string $deviceId,
        int $contentId,
        float $durationSeconds,
        string $source = 'feed',
    ) {

        $activity = UserActivity::where([
            'device_id' => $deviceId,
            'content_id' => $contentId,
            'action' => 'view',
        ])->first();

        if ($activity) {
            $activity->increment('duration_seconds', $durationSeconds);
            return;
        }

        DB::transaction(function () use (
            $deviceId,
            $contentId,
            $durationSeconds,
            $source,
        ) {

            $content = Content::findOrFail($contentId);

            $completionPercent = null;
            if ($source === 'details') {
                $totalDuration = $content->duration_seconds;
                if ($totalDuration > 0) {
                    $completionPercent = min(100, ($durationSeconds / $totalDuration) * 100);
                }
            }

            UserActivity::create([
                'device_id' => $deviceId,
                'content_id' => $contentId,
                'category_id' => $content->category_id,
                'action' => 'view',
                'duration_seconds' => $durationSeconds,
                'completion_percent' => $completionPercent,
                'source' => $source,
            ]);

            app(CategoryAffinityService::class)->update(
                $deviceId,
                $content->category_id,
                'view',
                $durationSeconds,
                $completionPercent,
                $source
            );

            $content->increment('view_count');
        });
    }
}
