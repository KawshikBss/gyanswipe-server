<?php

namespace App\Http\Controllers;

use App\Services\ActivityService;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function __construct(
        protected ActivityService $activityService
    ) {}

    public function toggle(Request $request)
    {
        $validated = $request->validate([
            'device_id' => 'required|string',
            'content_id' => 'required|exists:contents,id',
            'action' => 'required|in:like,save',
            'duration_seconds' => 'required|numeric|min:0',
            'source' => 'required|in:feed,details',
        ]);

        $result = $this->activityService->toggle(
            $validated['device_id'],
            $validated['content_id'],
            $validated['action'],
            $validated['duration_seconds'],
            $validated['source']
        );

        return response()->json($result);
    }

    public function view(Request $request)
    {
        $validated = $request->validate([
            'device_id' => 'required|string',
            'content_id' => 'required|exists:contents,id',
            'duration_seconds' => 'required|numeric|min:0',
            'source' => 'required|in:feed,details',
        ]);

        $this->activityService->trackView(
            $validated['device_id'],
            $validated['content_id'],
            $validated['duration_seconds'],
            $validated['source']
        );

        return response()->json([
            'message' => 'View tracked'
        ]);
    }
}
