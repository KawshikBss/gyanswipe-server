<?php

namespace App\Services;

use App\Models\UserCategoryScore;
use Illuminate\Support\Facades\DB;

class CategoryAffinityService
{
    public function update(
        string $deviceId,
        int $categoryId,
        string $type,
        ?int $duration = null,
        ?int $completion = null,
        string $source = 'feed'
    ) {
        $score = 0;

        if ($type === 'view') {

            $score += ($source === 'detail')
                ? 2
                : 1;
        }

        if ($type === 'like') {

            $score += ($source === 'detail')
                ? 5
                : 3;
        }

        if ($type === 'save') {

            $score += ($source === 'detail')
                ? 8
                : 5;
        }

        if (($completion ?? 0) > 80) {
            $score += 3;
        }

        if (!$score) return;

        UserCategoryScore::updateOrCreate(
            [
                'device_id' => $deviceId,
                'category_id' => $categoryId,
            ],
            [
                'score' => DB::raw(
                    "score + {$score}"
                )
            ]
        );
    }
}
