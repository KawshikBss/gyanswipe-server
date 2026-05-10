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
        ]);

        $result = $this->activityService->toggle(
            $validated['device_id'],
            $validated['content_id'],
            $validated['action']
        );

        return response()->json($result);
    }

    public function view(Request $request)
    {
        $validated = $request->validate([
            'device_id' => 'required|string',
            'content_id' => 'required|exists:contents,id',
        ]);

        $this->activityService->trackView(
            $validated['device_id'],
            $validated['content_id']
        );

        return response()->json([
            'message' => 'View tracked'
        ]);
    }
}
