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
        string $action
    ): array {

        $counterField = match ($action) {
            'like' => 'like_count',
            'save' => 'save_count',
        };

        return DB::transaction(function () use (
            $deviceId,
            $contentId,
            $action,
            $counterField
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
                $content['is_' . $action . 'd'] = false;

                return [
                    'active' => false,
                    'message' => ucfirst($action) . ' removed',
                    'updated' => $content
                ];
            }

            UserActivity::create([
                'device_id' => $deviceId,
                'content_id' => $contentId,
                'action' => $action,
            ]);

            $content->increment($counterField);
            $content['is_' . $action . 'd'] = true;

            return [
                'active' => true,
                'message' => ucfirst($action) . ' added',
                'updated' => $content
            ];
        });
    }

    public function trackView(
        string $deviceId,
        int $contentId
    ): void {

        $alreadyViewed = UserActivity::where([
            'device_id' => $deviceId,
            'content_id' => $contentId,
            'action' => 'view',
        ])->exists();

        if ($alreadyViewed) {
            return;
        }

        DB::transaction(function () use (
            $deviceId,
            $contentId
        ) {

            UserActivity::create([
                'device_id' => $deviceId,
                'content_id' => $contentId,
                'action' => 'view',
            ]);

            Content::where('id', $contentId)
                ->increment('view_count');
        });
    }
}
