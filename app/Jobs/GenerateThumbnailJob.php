<?php

namespace App\Jobs;

use App\Models\Content;
use App\Services\ImageGenerationService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class GenerateThumbnailJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public Content $content
    ) {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(
        ImageGenerationService $imageService
    ): void {

        $body = $this->content->body;

        $prompt =
            $body['thumbnail_prompt']
            ?? null;

        if (!$prompt) {
            return;
        }

        try {

            $url =
                $imageService
                ->generateAndStoreImage(
                    $prompt,
                    'thumbnails'
                );

            $this->content->update([
                'thumbnail' => $url,
            ]);
        } catch (\Exception $e) {

            logger()->error(
                $e->getMessage()
            );
        }
    }
}
